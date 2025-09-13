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
}
