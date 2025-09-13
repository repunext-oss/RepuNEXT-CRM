<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\SalesOrderProformaInvoice;
use Carbon\Carbon;


class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repn = SalesOrder::where('isdeleted', 0)->orderBy('id', 'DESC')->get();
        return view('sales_order.list', compact('repn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastInvoice = SalesOrder::latest()->value('invoice_number');
        if ($lastInvoice) {
            preg_match('/(\d+)$/', $lastInvoice, $matches);
            $lastNumericPart = isset($matches[1]) ? (int) $matches[1] : 100;
            $newNumericPart = $lastNumericPart + 1;
        } else {
            $newNumericPart = 100; 
        }
        
        $newInvoiceNumber = "RN/D/12/" . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
        return view('sales_order.add', compact('newInvoiceNumber'));
    }

/**
 * Store a newly created resource in storage.
 */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
            'invoice_number' => 'required|string|regex:/^[A-Za-z0-9\/\-_]+$/|max:255',
            'date' => 'required|date',
            'customer_emailid' => 'nullable|email',
            'customer_phone_number' => 'nullable|regex:/^[6-9]\d{9}$/',
            'payment_mode' => 'nullable|string',
            'address' => 'required|string',
            'terms_of_payment_and_delivery' => 'nullable|string',
            'customer_status' => 'nullable|string',
            'product_name' => 'required|array',
            'product_name.*' => 'required|string|regex:/^[A-Za-z0-9 ]+$/',
            'month' => 'nullable|array',
            'month.*' => 'nullable|string|regex:/^[A-Za-z0-9 ]+$/',
            'quantity' => 'nullable|array',
            'quantity.*' => 'nullable|numeric|min:1',
            'rate' => 'required|array',
            'rate.*' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'nullable|array',
            'discount.*' => 'nullable|numeric|min:0|max:100',
            'gst_number' => 'required|regex:/^[a-zA-Z0-9]+$/',
            'gst_status' => 'required|in:0,1',
        ]);
        
        $numericInvoice = (int) substr($validatedData['invoice_number'], -3);
        $grandTotal = 0;
        $totalGSTAmount = 0;
        $gstStatus = $validatedData['gst_status'];
        
        $saleOrder = SalesOrder::create([
            'company_name' => $validatedData['company_name'],
            'invoice_number' => $numericInvoice,
            'date' => $validatedData['date'],
            'customer_emailid' => $validatedData['customer_emailid'],
            'customer_phone_number' => $validatedData['customer_phone_number'],
            'payment_mode' => $validatedData['payment_mode'],
            'address' => $validatedData['address'],
            'customer_status' => $validatedData['customer_status'],
            'gst_number' => $validatedData['gst_number'],
            'terms_of_payment_and_delivery' => $validatedData['terms_of_payment_and_delivery'],
        ]);
        
        $lastInvoice = SalesOrderProformaInvoice::latest()->first();
        
        if ($lastInvoice && preg_match('/RN\/\d{2}\/(\d{2})/', $lastInvoice->no, $matches)) {
            $lastNumber = (int) $matches[1];
            $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT); 
        } else {
            $newNumber = '01'; 
        }
        
        $formattedNo = "RN/00/{$newNumber}";

        $totalSGSTAmount = 0;
        $totalCGSTAmount = 0;
        $totalIGSTAmount = 0;
        
        foreach ($validatedData['product_name'] as $index => $productName) {
            $quantity = $validatedData['quantity'][$index] ?? 1;
            $rate = $validatedData['rate'][$index];
            $discount = $validatedData['discount'][$index] ?? 0;
            $month = $validatedData['month'][$index] ?? null;
            $discountAmount = ($rate * $quantity) * ($discount / 100);
            $taxableAmount = ($rate * $quantity) - $discountAmount;
            $cgst = 0;
            $sgst = 0;
            $igst = 0;
            
            if ($gstStatus == 0) { 
                $cgst = ($taxableAmount * 9) / 100;
                $sgst = ($taxableAmount * 9) / 100;
            } else if ($gstStatus == 1) { 
                $igst = ($taxableAmount * 18) / 100;
            }
            
            $totalSGSTAmount += $sgst;
            $totalCGSTAmount += $cgst;
            $totalIGSTAmount += $igst;
            $totalGSTAmount += ($cgst + $sgst + $igst);
            $grandTotal += $taxableAmount;
            
            SalesOrderDetail::create([
                'salereferenceid' => $saleOrder->id,
                'product_name' => $productName,
                'quantity' => $quantity,
                'rate' => $rate,
                'discount' => $discount,
                'total_amount' => $taxableAmount,
                'gst_status' => $gstStatus,
                'cgst_amount' => $cgst,
                'sgst_amount' => $sgst,
                'igst_amount' => $igst,
                'month' => $month,
            ]);
            
            $SalesOrderProformaInvoice = SalesOrderProformaInvoice::create([
                'salereferenceid' => $saleOrder->id,
                'no' => $formattedNo,
                'product_name' => $productName,
                'quantity' => $quantity,
                'rate' => $rate,
                'discount' => $discount,
                'total_amount' => $taxableAmount,
                'gst_status' => $gstStatus,
                'cgst_amount' => $cgst,
                'sgst_amount' => $sgst,
                'igst_amount' => $igst,
                'month' => $month,
                'terms_of_payment_and_delivery' => $validatedData['terms_of_payment_and_delivery'],
            ]);
        }
        
        $grandTotal += $totalGSTAmount;
        
        $saleOrder->update([
            'grandtotal_amount' => $grandTotal,
            'total_cgst' => $totalCGSTAmount,
            'total_sgst' => $totalSGSTAmount,
            'total_igst' => $totalIGSTAmount,
        ]);

        $SalesOrderProformaInvoice->update([
            'grandtotal_amount' => $grandTotal,
            'total_cgst' => $totalCGSTAmount,
            'total_sgst' => $totalSGSTAmount,
            'total_igst' => $totalIGSTAmount,
        ]);
        
        return redirect()->route('list.salesorder')->with([
            'message' => 'Sale order created successfully',
            'alert-type' => 'success'
        ]);
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $salesOrder = SalesOrder::with('salesOrderDetails')->findOrFail($id);
        return view('sales_order.show', compact('salesOrder'));
    }
    
    
    public function preview($id)
    {
        $salesOrder = SalesOrder::findOrFail($id);
        $SalesOrderProformaInvoice = SalesOrderProformaInvoice::where('salereferenceid', $salesOrder->id)->get();
        return view('sales_order.preview', compact('salesOrder', 'SalesOrderProformaInvoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id)
     {
        
        $validatedData = $request->validate([
            'product_name' => 'required|array',
            'product_name.*' => 'required|string|regex:/^[A-Za-z0-9 ]+$/',
            'month' => 'nullable|array',
            'month.*' => 'nullable|string|regex:/^[A-Za-z0-9 ]+$/',
            'quantity' => 'nullable|array',
            'quantity.*' => 'nullable|numeric|min:1',
            'rate' => 'required|array',
            'rate.*' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'nullable|array',
            'discount.*' => 'nullable|numeric|min:0|max:100',
            'gst_status' => 'required|in:0,1',
        ]);
        
        $saleOrder = SalesOrder::findOrFail($id);
        $grandTotal = 0;
        $totalGSTAmount = 0;
        $gstStatus = $validatedData['gst_status'];

        $totalSGSTAmount = 0;
        $totalCGSTAmount = 0;
        $totalIGSTAmount = 0;
        
        foreach ($validatedData['product_name'] as $index => $productName) {
            $quantity = $validatedData['quantity'][$index] ?? 1;
            $rate = $validatedData['rate'][$index];
            $discount = $validatedData['discount'][$index] ?? 0;
            $month = $validatedData['month'][$index] ?? null;
            $discountAmount = ($rate * $quantity) * ($discount / 100);
            $taxableAmount = ($rate * $quantity) - $discountAmount;
            
            $cgst = 0;
            $sgst = 0;
            $igst = 0;
            
            if ($gstStatus == 0) { 
                $cgst = ($taxableAmount * 9) / 100;
                $sgst = ($taxableAmount * 9) / 100;
            } else if ($gstStatus == 1) { 
                $igst = ($taxableAmount * 18) / 100;
            }
            
            $totalSGSTAmount += $sgst;
            $totalCGSTAmount += $cgst;
            $totalIGSTAmount += $igst;
            $totalGSTAmount += ($cgst + $sgst + $igst);
            $grandTotal += $taxableAmount;
            
            SalesOrderDetail::where([
                ['salereferenceid', '=', $saleOrder->id],
                ['product_name', '=', $productName] 
                ])->update([
                    'quantity' => $quantity,
                    'rate' => $rate,
                    'discount' => $discount,
                    'total_amount' => $taxableAmount,
                    'gst_status' => $gstStatus,
                    'month' => $month,
                ]);
                
                SalesOrderProformaInvoice::where([
                    ['salereferenceid', '=', $saleOrder->id],
                    ['product_name', '=', $productName] 
                    ])->update([
                        'quantity' => $quantity,
                        'rate' => $rate,
                        'discount' => $discount,
                        'total_amount' => $taxableAmount,
                        'gst_status' => $gstStatus,
                        'month' => $month,
                    ]);
                }
                
                $grandTotal += $totalGSTAmount;
                
                $saleOrder->update([
                    'grandtotal_amount' => $grandTotal,
                ]);
                
                SalesOrderProformaInvoice::where('salereferenceid', $saleOrder->id)->update([
                    'grandtotal_amount' => $grandTotal,
                ]);
                
                return redirect()->route('preview.salesorder', ['id' => $id])->with([
                    'message' => 'Sale order updated successfully',
                    'alert-type' => 'success'
                ]);
            }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $saleOrder = SalesOrder::find($id);
        if (!$saleOrder) {
            return response()->json(['error' => 'Sale Order not found!'], 404);
        }
        $saleOrder->isdeleted = "1";
        $saleOrder->save();
        SalesOrderDetail::where('salereferenceid', $id)->update(['isdeleted' => "1"]);
        return response()->json(['success' => 'Sale Order and its details have been soft deleted!']);
    }

    
    public function status(Request $request)
    {
        $saleOrder = SalesOrder::find($request->id);
        if (!$saleOrder) {
            return response()->json(['success' => false, 'message' => 'Sale Order not found']);
        }
        $saleOrder->status = $request->statusval;
        $saleOrder->save();
        SalesOrderDetail::where('salereferenceid', $request->id)->update(['status' => $request->statusval]);
        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

}
