<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class RevenueController extends Controller
{
   
      public function index(Request $request)
    {
        // Validate incoming dates
        $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        // Normalize to Carbon and make inclusive
        $start = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : null;

        $end = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : ($start ? Carbon::parse($request->start_date)->endOfDay() : null);

        $revenues = Revenue::query()
            ->when($start && $end, fn ($q) => $q->whereBetween('created_at', [$start, $end]))
            ->orderByDesc('created_at')
            ->get();

        $expenses = Expense::query()
            ->when($start && $end, fn ($q) => $q->whereBetween('created_at', [$start, $end]))
            ->orderByDesc('created_at')
            ->get();

        $totalRevenue = $revenues->sum('amount');
        $totalExpense = $expenses->sum('amount');

        return view('revenue.list', compact(
            'revenues',
            'expenses',
            'totalRevenue',
            'totalExpense'
        ));
    }


    public function create()
    {
        return view('revenue.add');
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'type'            => 'required|in:revenue,expense',
        'category'        => 'required|string|max:255',
        'subcategory'     => 'nullable|string|max:255',
        'amount'          => 'required|numeric|min:0',
        'entry_date'      => 'required|date',
        'website_name'    => 'nullable|string|max:191',
        'payment_method'  => 'nullable|string|max:255',
    ]);

    // Parse the entry date
    $timestamp = Carbon::parse($validated['entry_date']);

    // Normalize subcategory (treat placeholder as null)
    $subcategory = $validated['subcategory'] ?? null;
    if ($subcategory === '— Not applicable —') {
        $subcategory = null;
    }

    // Common fields (without website_name; that maps to r_name/e_name)
    $base = [
        'category'       => $validated['category'],
        'subcategory'    => $subcategory,
        'amount'         => $validated['amount'],
        'payment_method' => $validated['payment_method'] ?? null,
        'entry_date'     => $validated['entry_date'],
        'created_at'     => $timestamp,
        'updated_at'     => $timestamp,
    ];

    if ($validated['type'] === 'revenue') {
        $data = $base + ['r_name' => $validated['website_name'] ?? null];
        $revenue = new Revenue($data);
        $revenue->save();
    } else { // expense
        $data = $base + ['e_name' => $validated['website_name'] ?? null];
        $expense = new Expense($data);
        $expense->save();
    }

    return redirect()
        ->route('revenue-expense.index')
        ->with('success', ucfirst($validated['type']) . ' added successfully!');
}


    /**
     * Store a newly created resource in storage.
     */
 

    /**
     * Display the specified resource.
     */
    public function show(Revenue $revenue)
    {
        return view('revenue.view', compact('revenue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revenue $revenue)
    {
        return view('revenue.edit', compact('revenue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Revenue $revenue)
    {
        $validated = $request->validate([
            'category'        => 'required|string|max:255',
            'subcategory'     => 'nullable|string|max:255',
            'amount'          => 'required|numeric|min:0',
            'entry_date'      => 'required|date',
            'r_name'          => 'nullable|string|max:191',
            'payment_method'  => 'nullable|string|max:255',
        ]);

        // Normalize subcategory (treat placeholder as null)
        $subcategory = $validated['subcategory'] ?? null;
        if ($subcategory === '— Not applicable —') {
            $subcategory = null;
        }

        $revenue->update([
            'category'       => $validated['category'],
            'subcategory'    => $subcategory,
            'amount'         => $validated['amount'],
            'payment_method' => $validated['payment_method'] ?? null,
            'entry_date'     => $validated['entry_date'],
            'r_name'         => $validated['r_name'] ?? null,
        ]);

        return redirect()
            ->route('revenue-expense.index')
            ->with('success', 'Revenue updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revenue $revenue)
    {
        $revenue->delete();
        
        return redirect()
            ->route('revenue-expense.index')
            ->with('success', 'Revenue deleted successfully!');
    }
    /**
     * Export revenue and expense data in various formats
     */
    public function export(Request $request, $format = 'excel')
    {
        // Validate incoming dates
        $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        // Get filtered data
        $data = $this->getExportData($request);

        // Route to appropriate export method
        switch (strtolower($format)) {
            case 'csv':
                return $this->exportCsv($data);
            case 'pdf':
                return $this->exportPdf($data);
            case 'excel':
            default:
                return $this->exportExcel($data);
        }
    }

    /**
     * Get export data with date filtering
     */
    private function getExportData($request)
    {
        // Normalize to Carbon and make inclusive
        $start = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : null;

        $end = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : ($start ? Carbon::parse($request->start_date)->endOfDay() : null);

        $revenues = Revenue::query()
            ->when($start && $end, fn ($q) => $q->whereBetween('created_at', [$start, $end]))
            ->orderByDesc('created_at')
            ->get();

        $expenses = Expense::query()
            ->when($start && $end, fn ($q) => $q->whereBetween('created_at', [$start, $end]))
            ->orderByDesc('created_at')
            ->get();

        $totalRevenue = $revenues->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $net = $totalRevenue - $totalExpense;

        $dateRange = '';
        if ($start && $end) {
            $dateRange = $start->format('d-m-Y') . ' to ' . $end->format('d-m-Y');
        } else {
            $dateRange = 'All Time';
        }

        return [
            'revenues' => $revenues,
            'expenses' => $expenses,
            'totalRevenue' => $totalRevenue,
            'totalExpense' => $totalExpense,
            'net' => $net,
            'dateRange' => $dateRange,
            'start' => $start,
            'end' => $end
        ];
    }

    /**
     * Export data as CSV
     */
    private function exportCsv($data)
    {
        $filename = 'revenue_expense_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 support
            fwrite($file, "\xEF\xBB\xBF");
            
            // Header
            fputcsv($file, ['Revenue & Expense Report']);
            fputcsv($file, ['Date Range: ' . $data['dateRange']]);
            fputcsv($file, ['Generated: ' . now()->format('d-m-Y H:i:s')]);
            fputcsv($file, []); // Empty line
            
            // Summary
            fputcsv($file, ['SUMMARY']);
            fputcsv($file, ['Total Revenue', '₹' . number_format($data['totalRevenue'], 2)]);
            fputcsv($file, ['Total Expenses', '₹' . number_format($data['totalExpense'], 2)]);
            fputcsv($file, ['Net ' . ($data['net'] >= 0 ? 'Income' : 'Loss'), '₹' . number_format($data['net'], 2)]);
            fputcsv($file, []); // Empty line
            
            // Revenue Section
            fputcsv($file, ['REVENUE RECORDS']);
            fputcsv($file, ['#', 'Name', 'Category', 'Subcategory', 'Payment Method', 'Amount', 'Date']);
            $i = 1;
            foreach ($data['revenues'] as $revenue) {
                fputcsv($file, [
                    $i++,
                    $revenue->r_name ?? '',
                    $revenue->category,
                    $revenue->subcategory ?? '',
                    $revenue->payment_method ?? '',
                    '₹' . number_format($revenue->amount, 2),
                    $revenue->entry_date ? \Carbon\Carbon::parse($revenue->entry_date)->format('d-m-Y') : $revenue->created_at->format('d-m-Y')
                ]);
            }
            fputcsv($file, []); // Empty line
            
            // Expense Section
            fputcsv($file, ['EXPENSE RECORDS']);
            fputcsv($file, ['#', 'Name', 'Category', 'Subcategory', 'Payment Method', 'Amount', 'Date']);
            $i = 1;
            foreach ($data['expenses'] as $expense) {
                fputcsv($file, [
                    $i++,
                    $expense->e_name ?? '',
                    $expense->category,
                    $expense->subcategory ?? '',
                    $expense->payment_method ?? '',
                    '₹' . number_format($expense->amount, 2),
                    $expense->entry_date ? \Carbon\Carbon::parse($expense->entry_date)->format('d-m-Y') : $expense->created_at->format('d-m-Y')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data as Excel
     */
    private function exportExcel($data)
    {
        $filename = 'revenue_expense_' . now()->format('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
            'Pragma' => 'public',
        ];

        // Generate Excel content
        $excelContent = $this->generateExcelContent($data);
        
        // Add BOM for UTF-8 support in Excel
        $bom = "\xEF\xBB\xBF";
        return response($bom . $excelContent, 200, $headers);
    }

    /**
     * Generate Excel content using HTML format
     */
    private function generateExcelContent($data)
    {
        // Create a more compatible Excel format using HTML table
        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        $html .= '<head>';
        $html .= '<meta charset="utf-8">';
        $html .= '<meta name="ExcelCreated" content="' . now()->format('Y-m-d H:i:s') . '">';
        $html .= '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Revenue & Expense Report</x:Name><x:WorksheetOptions><x:DefaultRowHeight>285</x:DefaultRowHeight></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
        $html .= '<style>';
        $html .= 'table { border-collapse: collapse; width: 100%; }';
        $html .= 'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }';
        $html .= 'th { background-color: #f2f2f2; font-weight: bold; }';
        $html .= '.title { font-size: 16px; font-weight: bold; text-align: center; }';
        $html .= '.summary { background-color: #e7f3ff; }';
        $html .= '.currency { text-align: right; }';
        $html .= '</style>';
        $html .= '</head>';
        $html .= '<body>';
        
        // Title
        $html .= '<table>';
        $html .= '<tr><td colspan="7" class="title">Revenue & Expense Report</td></tr>';
        $html .= '<tr><td colspan="7">Date Range: ' . htmlspecialchars($data['dateRange']) . '</td></tr>';
        $html .= '<tr><td colspan="7">Generated: ' . now()->format('d-m-Y H:i:s') . '</td></tr>';
        $html .= '<tr><td colspan="7">&nbsp;</td></tr>';
        
        // Summary Section
        $html .= '<tr class="summary"><td colspan="7"><strong>SUMMARY</strong></td></tr>';
        $html .= '<tr><td>Total Revenue</td><td class="currency">₹' . number_format($data['totalRevenue'], 2) . '</td><td colspan="5">&nbsp;</td></tr>';
        $html .= '<tr><td>Total Expenses</td><td class="currency">₹' . number_format($data['totalExpense'], 2) . '</td><td colspan="5">&nbsp;</td></tr>';
        $html .= '<tr><td>Net ' . ($data['net'] >= 0 ? 'Income' : 'Loss') . '</td><td class="currency">₹' . number_format(abs($data['net']), 2) . '</td><td colspan="5">&nbsp;</td></tr>';
        $html .= '<tr><td colspan="7">&nbsp;</td></tr>';
        
        // Revenue Section
        $html .= '<tr><td colspan="7"><strong>REVENUE RECORDS</strong></td></tr>';
        $html .= '<tr>';
        $html .= '<th>#</th>';
        $html .= '<th>Name</th>';
        $html .= '<th>Category</th>';
        $html .= '<th>Subcategory</th>';
        $html .= '<th>Payment Method</th>';
        $html .= '<th>Amount</th>';
        $html .= '<th>Date</th>';
        $html .= '</tr>';
        
        $i = 1;
        foreach ($data['revenues'] as $revenue) {
            $html .= '<tr>';
            $html .= '<td>' . $i++ . '</td>';
            $html .= '<td>' . htmlspecialchars($revenue->r_name ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($revenue->category) . '</td>';
            $html .= '<td>' . htmlspecialchars($revenue->subcategory ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($revenue->payment_method ?? '') . '</td>';
            $html .= '<td class="currency">₹' . number_format($revenue->amount, 2) . '</td>';
            $html .= '<td>' . ($revenue->entry_date ? \Carbon\Carbon::parse($revenue->entry_date)->format('d-m-Y') : $revenue->created_at->format('d-m-Y')) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '<tr><td colspan="7">&nbsp;</td></tr>';
        
        // Expense Section
        $html .= '<tr><td colspan="7"><strong>EXPENSE RECORDS</strong></td></tr>';
        $html .= '<tr>';
        $html .= '<th>#</th>';
        $html .= '<th>Name</th>';
        $html .= '<th>Category</th>';
        $html .= '<th>Subcategory</th>';
        $html .= '<th>Payment Method</th>';
        $html .= '<th>Amount</th>';
        $html .= '<th>Date</th>';
        $html .= '</tr>';
        
        $i = 1;
        foreach ($data['expenses'] as $expense) {
            $html .= '<tr>';
            $html .= '<td>' . $i++ . '</td>';
            $html .= '<td>' . htmlspecialchars($expense->e_name ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($expense->category) . '</td>';
            $html .= '<td>' . htmlspecialchars($expense->subcategory ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($expense->payment_method ?? '') . '</td>';
            $html .= '<td class="currency">₹' . number_format($expense->amount, 2) . '</td>';
            $html .= '<td>' . ($expense->entry_date ? \Carbon\Carbon::parse($expense->entry_date)->format('d-m-Y') : $expense->created_at->format('d-m-Y')) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $html .= '</body>';
        $html .= '</html>';
        
        return $html;
    }

    /**
     * Export data as PDF (HTML format for printing)
     */
    private function exportPdf($data)
    {
        $filename = 'revenue_expense_' . now()->format('Y-m-d_H-i-s') . '.html';
        
        $html = view('revenue.export-pdf', [
            'revenues' => $data['revenues'],
            'expenses' => $data['expenses'],
            'totalRevenue' => $data['totalRevenue'],
            'totalExpense' => $data['totalExpense'],
            'net' => $data['net'],
            'dateRange' => $data['dateRange']
        ])->render();

        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ];

        // Return HTML that can be printed as PDF or saved as HTML
        return response($html, 200, $headers);
    }
}
