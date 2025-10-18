<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Response;

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
            'type' => 'required|in:revenue,expense',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'nullable|date',
        ]);

        $timestamp = $validated['date'] ?? now();

        if ($validated['type'] === 'revenue') {
            $revenue = new Revenue();
            $revenue->category = $validated['category'];
            $revenue->subcategory = $validated['subcategory'] ?? null;
            $revenue->amount = $validated['amount'];
            $revenue->created_at = $timestamp;
            $revenue->save();
        } else {
            $expense = new Expense();
            $expense->category = $validated['category'];
            $expense->subcategory = $validated['subcategory'] ?? null;
            $expense->amount = $validated['amount'];
            $expense->created_at = $timestamp;
            $expense->save();
        }

        return redirect()->route('revenue-expense.index')->with('success', ucfirst($validated['type']) . ' added successfully!');
    }



    /**
     * Store a newly created resource in storage.
     */
 

    /**
     * Display the specified resource.
     */
    public function show(Revenue $revenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Revenue $revenue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revenue $revenue)
    {
        //
    }

    public function export(Request $request, $format = 'excel')
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
        $net = $totalRevenue - $totalExpense;

        $dateRange = '';
        if ($start && $end) {
            $dateRange = $start->format('d-m-Y') . ' to ' . $end->format('d-m-Y');
        } else {
            $dateRange = 'All Time';
        }

        switch ($format) {
            case 'csv':
                return $this->exportCsv($revenues, $expenses, $totalRevenue, $totalExpense, $net, $dateRange);
            case 'pdf':
                return $this->exportPdf($revenues, $expenses, $totalRevenue, $totalExpense, $net, $dateRange);
            case 'excel':
            default:
                return $this->exportExcel($revenues, $expenses, $totalRevenue, $totalExpense, $net, $dateRange);
        }
    }

    private function exportCsv($revenues, $expenses, $totalRevenue, $totalExpense, $net, $dateRange)
    {
        $filename = 'revenue_expense_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($revenues, $expenses, $totalRevenue, $totalExpense, $net, $dateRange) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Revenue & Expense Report']);
            fputcsv($file, ['Date Range: ' . $dateRange]);
            fputcsv($file, ['Generated: ' . now()->format('d-m-Y H:i:s')]);
            fputcsv($file, []); // Empty line
            
            // Summary
            fputcsv($file, ['SUMMARY']);
            fputcsv($file, ['Total Revenue', '$' . number_format($totalRevenue, 2)]);
            fputcsv($file, ['Total Expenses', '$' . number_format($totalExpense, 2)]);
            fputcsv($file, ['Net ' . ($net >= 0 ? 'Income' : 'Loss'), '$' . number_format($net, 2)]);
            fputcsv($file, []); // Empty line
            
            // Revenue Section
            fputcsv($file, ['REVENUE RECORDS']);
            fputcsv($file, ['#', 'Category', 'Subcategory', 'Amount', 'Date']);
            $i = 1;
            foreach ($revenues as $revenue) {
                fputcsv($file, [
                    $i++,
                    $revenue->category,
                    $revenue->subcategory ?? '',
                    '$' . number_format($revenue->amount, 2),
                    $revenue->created_at->format('d-m-Y')
                ]);
            }
            fputcsv($file, []); // Empty line
            
            // Expense Section
            fputcsv($file, ['EXPENSE RECORDS']);
            fputcsv($file, ['#', 'Category', 'Subcategory', 'Amount', 'Date']);
            $i = 1;
            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $i++,
                    $expense->category,
                    $expense->subcategory ?? '',
                    '$' . number_format($expense->amount, 2),
                    $expense->created_at->format('d-m-Y')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportExcel($revenues, $expenses, $totalRevenue, $totalExpense, $net, $dateRange)
    {
        $filename = 'revenue_expense_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // For now, return CSV format as Excel (you can install PhpSpreadsheet for proper Excel)
        return $this->exportCsv($revenues, $expenses, $totalRevenue, $totalExpense, $net, $dateRange);
    }

    private function exportPdf($revenues, $expenses, $totalRevenue, $totalExpense, $net, $dateRange)
    {
        $filename = 'revenue_expense_' . now()->format('Y-m-d_H-i-s') . '.html';
        
        $html = view('revenue.export-pdf', compact(
            'revenues', 'expenses', 'totalRevenue', 'totalExpense', 'net', 'dateRange'
        ))->render();

        $headers = [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Return HTML that can be printed as PDF or saved as HTML
        return response($html, 200, $headers);
    }
}
