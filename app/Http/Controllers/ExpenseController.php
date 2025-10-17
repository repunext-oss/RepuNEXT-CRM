<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::orderByDesc('created_at')->get();
        return view('expense.list', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expense.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'        => 'required|string|max:255',
            'subcategory'     => 'nullable|string|max:255',
            'amount'          => 'required|numeric|min:0',
            'entry_date'      => 'required|date',
            'e_name'          => 'nullable|string|max:191',
            'payment_method'  => 'nullable|string|max:255',
        ]);

        // Normalize subcategory (treat placeholder as null)
        $subcategory = $validated['subcategory'] ?? null;
        if ($subcategory === '— Not applicable —') {
            $subcategory = null;
        }

        $expense = Expense::create([
            'category'       => $validated['category'],
            'subcategory'    => $subcategory,
            'amount'         => $validated['amount'],
            'payment_method' => $validated['payment_method'] ?? null,
            'entry_date'     => $validated['entry_date'],
            'e_name'         => $validated['e_name'] ?? null,
        ]);

        return redirect()
            ->route('expense.index')
            ->with('success', 'Expense added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('expense.view', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return view('expense.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'category'        => 'required|string|max:255',
            'subcategory'     => 'nullable|string|max:255',
            'amount'          => 'required|numeric|min:0',
            'entry_date'      => 'required|date',
            'e_name'          => 'nullable|string|max:191',
            'payment_method'  => 'nullable|string|max:255',
        ]);

        // Normalize subcategory (treat placeholder as null)
        $subcategory = $validated['subcategory'] ?? null;
        if ($subcategory === '— Not applicable —') {
            $subcategory = null;
        }

        $expense->update([
            'category'       => $validated['category'],
            'subcategory'    => $subcategory,
            'amount'         => $validated['amount'],
            'payment_method' => $validated['payment_method'] ?? null,
            'entry_date'     => $validated['entry_date'],
            'e_name'         => $validated['e_name'] ?? null,
        ]);

        return redirect()
            ->route('expense.index')
            ->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        
        return redirect()
            ->route('expense.index')
            ->with('success', 'Expense deleted successfully!');
    }
}
