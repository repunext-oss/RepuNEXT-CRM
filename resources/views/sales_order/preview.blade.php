@extends('admin.admin_master')
@section('admin')
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
    .sales-order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        font-size: 20px;
        white-space: nowrap;
        margin-top: 20px;
    }

    .text-muted-custom {
        color: #808080 !important;
        font-weight: 600;
    }

    .text-bold-black {
        color: #000000 !important;
        font-weight: bold;
    }

    .table th {
        color: #808080 !important;
        font-weight: 700;
    }

    .table td {
        color: #808080 !important;
        font-weight: 600;
    }

    .divider {
        border-top: 1px solid #000;
        margin: 10px 0;
    }

    .totals-section {
        display: flex;
        justify-content: space-between;
        padding: 15px 20px;
        font-weight: bold;
        font-size: 16px;
    }

    .table thead {
        border-top: 1px solid #000;
    }

    .table thead tr {
        border-bottom: 1px solid #000;
    }

    .address-section {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .address-card {
        width: 45%;
        padding: 15px;
        border-radius: 0;
        background: none;
        box-shadow: none;
    }

    .address-card h5 {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .address-card p {
        margin: 0;
        color: #333;
    }

    .address-card:first-child {
        margin-left: 20px;
    }
    
    .divider1 {
        display: block; 
        width: 100%;
        height: 2px;
        background-color: #808080; 
        margin: 0 5px;
    }

    .divider3 {
        display: block; 
        width: 100%;
        height: 2px;
        background-color: #808080; 
        margin: 0 5px;
    }

    .address-section {
        display: none;
    }

    /* Print-specific styles */
    @media print {
    * {
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box;
    }

    html, body {
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        width: 100%;
    }

    .totals-section, .divider1, .card-footer {
        display: none !important;
    }

    body * {
        visibility: hidden;
    }    

    #invoiceContent, #invoiceContent * {
        visibility: visible;
    }

    #sales-order-print-header {
        display: block !important;
        visibility: visible !important;
        margin-bottom: 5px !important;

    }

    body #invoiceContent .sales-order-header {
        display: none !important;
    }

    #printHeader {
        display: block !important;
        visibility: visible !important;
        position: center;
        width: 100%;
        margin-bottom: 1px !important;
        padding-bottom: 3px !important;
        border-bottom: none !important;
    }

    #printHeader * {
        visibility: visible;
    }

    .header-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
        margin: 0 auto;
        padding: 2px !important;
    }

    .header-table td {
        border: 1px solid black;
        padding: 4px !important;
        text-align: center;
        font-size: 11px;

    }

    .company-logo img {
        height: 80px;
        margin: 0 auto;
        text-align: center;
    }

    .company-name {
        font-size: 12px;
        font-family: 'Merriweather';
        color: black;
        text-align: center;
        padding: 3px;
    }

    .company_email {
        font-family: 'Merriweather';
        font-size: 10px;
        text-align: center;
    }

    #invoiceContent {
        width: 100% !important;  
        margin: 0 auto !important; 
        padding: 3px !important;
        border: 1px solid black; 
    }

    .invoice-details {
        width: 100%;
        margin-bottom: 5px;
        padding: 4px;
        font-size: 12px;
        text-align: left;
        border-bottom: 1px solid black;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        margin-bottom: 10px !important; 
    }

    .invoice-table th, .invoice-table td {
        border: 1px solid #000;
        padding: 6px !important;
        font-size: 11px;
        text-align: center;
    }

    .total-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        margin-bottom: 2px !important;
    }

    .total-table td {
        border: 1px solid #000;
        padding: 4px !important;
        text-align: right;
        font-weight: bold;
        font-size: 11px;
    }

    .total-table td:first-child {
        text-align: left;
    }

    .amount-table {
        width: 100%;
        margin-top: 5px;
        border-collapse: collapse;
    }

    .amount-table td {
        border: 1px solid #000;
        padding: 5px !important;
        font-weight: bold;
        font-size: 11px;
    }

    #printTotals {
        display: block !important;
        visibility: visible !important;
        margin: 0;
        margin-top: 5px;
        padding: 0;
        border: none;
        background-color: transparent;
    }

    .address-section {
        display: flex;
        justify-content: space-between;
        align-items: start;
    }
    
    .address-card {
        width: 50%;
        font-size: 11px;
    }
    
    .address-card h5 {
        font-size: 11px; 
    }
    
    #sales-order-print-header {
        margin-top: 5px;
        width: 50%;
        text-align: right;
        font-size: 11px;
    }
    
    #sales-order-print-header span {
        display: block;
        margin-bottom: 2px;
        font-size: 11px;
    }
    
    .terms-box {
        margin-top: 10px;
        padding: 10px;
        background-color: #fff; 
        color: #000; 
        border-radius: 0; 
        border: 1px solid #000; 
        font-size: 11px;
        text-align: center; 
        width: fit-content;
        float: right;
    }
    
    .terms-box strong {
        display: block;
        font-size: 11px;
        margin-bottom: 2px;
        text-decoration: underline; 
    }
    
    .terms-box span {
        display: block;
        font-size: 11px;
    }

    #bankCertificationSection {
        margin-top: 10px !important;
        width: 100%;
        display: block !important;
        visibility: visible;
        font-size: 11px;
    }

    .bank-certification-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
        margin-top: 5px;
    }

    .bank-certification-table td {
        border: 1px solid black;
        padding: 4px !important;
        vertical-align: top;
        font-size: 10px;
    }

    .bank-details {
        width: 30%;
        padding: 5px;
        
    }

    .certification-details {
        width: 40%;
        text-align: center;
        padding: 5px;
        font-size: 10px;
    }

    .signature-details {
        width: 30%;
        text-align: center;
        padding: 5px;
    }

    .signature-details strong {
        display: block;
        margin-bottom: 3px;
    }

    .signature-details span {
        display: block;
        font-style: italic;
    }

    #printInvoiceHeader {
        display: block !important;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px; 
        padding-bottom: 30px; 
        border-bottom: 1px solid black;
        position: relative;
        margin-bottom: 50px !important; 
    }
    
    #printInvoiceHeader h2 {
        margin: 0 auto;
        font-size: 18px;
        font-family: 'Merriweather';
        font-weight: bold;
        text-align: center;
        flex-grow: 1;
    }

    .no {
        font-size: 12px;
        font-weight: bold; 
        margin-left: auto; 
    }

    .invoice-no {
        font-size: 13px; 
        font-weight: bold;
        position: absolute;
        right: 130px; 
        top: 50%;
        transform: translateY(-50%);
    }
    
    .full-width-line {
        width: 100%;
        height: 2px;
        background-color: black;
        margin-top: 10px; 
    }
}

#printHeader {
    display: none;
}

#printTotals {
    display: none;
    margin-top: 20px !important;
}

#bankCertificationSection {
    display: none; 
}

.fw-bold.fs-4.mt-2.d-block.ms-n3 {
    visibility: visible !important;
    position: absolute;
    top: 0;
    left: 20px;
    font-size: 24px;
    font-weight: bold;
    text-align: left;
}

.sales-order-header {
    display: flex;
    justify-content: space-between;
    gap: 40px;
    flex-wrap: wrap;
}

.sales-order-header div {
    display: flex;
    gap: 5px;
    font-size: 12px;
    color: #808080 !important;
}

.sales-order-header .text-muted-custom,
.sales-order-header .text-bold-black {
    font-size: 12px !important;
    color: #808080 !important;
}

.totals-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px !important;
    font-weight: bold !important;
    width: 100%;
    padding: 5px 0;
}

.totals-section div {
    font-size: 12px !important;
    white-space: nowrap;
    margin: 0 5px;
    font-weight: bold !important;
    color: #808080 !important;
}

.totals-section div:last-child {
    font-size: 12px !important;
    font-weight: bold !important;
    color: black !important;
}

#editBtn {
    position: absolute;
    right: 20px;
    top: 120px;
    padding: 8px 15px; 
    font-size: 14px; 
    border-radius: 6px; 
    margin-bottom:20px;
}

#savebtn {
    position: absolute;
    right: 20px;
    top: 120px;
    padding: 8px 15px; 
    font-size: 14px; 
    border-radius: 6px; 
    margin-bottom:20px;
}

#printInvoiceHeader {
    display: none;
}

#sales-order-print-header {
    display: none; 
}
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Preview</span>
                        <span class="text-muted-custom fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted-custom text-hover-primary">Home</a> / Sales / Order
                        </span>
                        <br><br>
                    </h3>
                </div>
                <br>
                <button class="btn btn-warning" id="editBtn">Edit</button>
                <div id="printHeader">
                    <table class="header-table">
                        <tr>
                            <td class="company-logo">
                                <img src="{{ asset('backend/assets/media/logos/print_logo.jpg') }}" alt="Company Logo">
                            </td>
                            <td class="company-name">
                                <strong>REPUNEXT</strong><br>
                                D.No. 24, Plot 41A,6th Main Road, <br>
                                Ram Nagar North Extention,<br>
                                Velachery, Chennai – 600042,<br>
                                Phone: [+91 95001 555 23 / 24] <br>
                                Landline: 044 486 555 23
                            </td>
                            <td class="company_email">
                                Email: info@repunext.com <br>
                                Website: www.repunext.com
                            </td>
                        </tr>
                    </table>
                </div>
                <form method="POST" action="{{ route('update.salesorder', ['id' => $salesOrder->id]) }}">
                    @csrf
                    <div id="invoiceContent">
                        <input type="hidden" id="no" name="no" value="{{ $SalesOrderProformaInvoice->first()->no ?? $formattedNo }}">
                        <div id="printInvoiceHeader">
                            <h2>PROFORMA INVOICE</h2>
                            <div class="no">Ref No: {{ $SalesOrderProformaInvoice->first()->no ?? $formattedNo }}</div>
                        </div>
                        <div class="full-width-line"></div>
                        <div class="address-section">
                            <div class="address-card">
                                <h5>BILLING TO</h5>
                                <p>{{ $salesOrder->company_name }}</p>
                                <p>{{ $salesOrder->address }}</p>
                                <p>{{ $salesOrder->customer_phone_number }}</p>
                                <br>
                                <span><strong>GST IN:</strong> {{ $salesOrder->gst_number }} </span>
                            </div>
                            <div id="sales-order-print-header">
                                <span><strong>Invoice Number:</strong> RN/D/12/{{ str_pad($salesOrder->invoice_number, 3, '0', STR_PAD_LEFT) }}</span>
                                <br>
                                <span><strong>Date:</strong> {{ date('d-m-Y', strtotime($salesOrder->date)) }}</span>
                                <br>
                                <span><strong>GST IN:</strong> 33ARFPP5003N1ZR</span>
                                <br>
                                <br>
                                <div class="terms-box">
                                    <strong>Terms of Payment & Delivery</strong><br>
                                    {{ optional($SalesOrderProformaInvoice->where('salereferenceid', $salesOrder->id)->first())->terms_of_payment_and_delivery }}
                                </div>

                            </div>
                            <hr>
                        </div>
                        <br>
                        <div class="sales-order-header">
                            <div>
                                <span class="text-muted-custom">Invoice Number:</span>
                                <span class="text-bold-black">RN/D/12/{{ str_pad($salesOrder->invoice_number, 3, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div>
                                <span class="text-muted-custom">Date:</span>
                                <span class="text-bold-black">{{ date('d-m-Y', strtotime($salesOrder->date)) }}</span>
                            </div>
                            <div>
                                <span class="text-muted-custom">Company Name:</span>
                                <span class="text-bold-black">{{ $salesOrder->company_name }}</span>
                            </div>
                            <div>
                                <span class="text-muted-custom">Customer Contact:</span>
                                <span class="text-bold-black">{{ $salesOrder->customer_phone_number }}</span>
                            </div>
                        </div>
                        <br>
                        <div class="card-body border-0 pt-0">
                            <table class="table table-bordered mt-3 text-center">
                                <thead>
                                    <tr class="text-muted-custom">
                                        <th>S.No</th>
                                        <th>Description</th>
                                        <th>Month</th>
                                        <th>QTY</th>
                                        <th>Price</th>
                                        @if($SalesOrderProformaInvoice->where('discount', '>', 0)->count() > 0)
                                        <th>Disc</th>
                                        @endif
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($SalesOrderProformaInvoice  as $key => $item)
                                    <tr class="text-muted-custom-product">
                                        <td>{{ $key + 1 }}</td>
                                        <input type="hidden" name="salereferenceid" value="{{ $item->salereferenceid }}">
                                        <input type="hidden" name="gst_status" value="{{ $item->gst_status }}">
                                        <td><input type="text" class="descr" name="product_name[]" value="{{ $item->product_name }}" readonly></td>
                                        <td><input type="text" class="month" name="month[]" value="{{ $item->month }}" readonly></td>
                                        <td><input type="number" class="editable-input qty" name="quantity[]" value="{{ $item->quantity }}" readonly></td>
                                        <td><input type="number" class="editable-input rate" name="rate[]" value="{{ $item->rate }}" readonly></td>
                                        @if($item->discount > 0)
                                        <td><input type="number" class="editable-input discount" name="discount[]" value="{{ $item->discount }}"></td>
                                        @endif
                                        <td class="total-amount" name="total_amount[]">₹{{ $item->total_amount }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="divider1"></div>
                            <div class="totals-section">
                                <div class="text-muted-custom">Sub Total: ₹<span id="sub-total">{{ number_format($SalesOrderProformaInvoice->sum('total_amount'), 2) }}</span></div>
                                @if(optional($SalesOrderProformaInvoice->where('salereferenceid', $salesOrder->id)->first())->gst_status == 0)
                                <div class="text-muted-custom">CGST (9%): ₹<span id="cgst-total">{{ number_format($SalesOrderProformaInvoice->sum('total_amount') * 9 / 100, 2) }}</span></div>
                                <div class="text-muted-custom">SGST (9%): ₹<span id="sgst-total">{{ number_format($SalesOrderProformaInvoice->sum('total_amount') * 9 / 100, 2) }}</span></div>
                                @else
                                <div class="text-muted-custom">IGST (18%): ₹<span id="igst-total">{{ number_format($SalesOrderProformaInvoice->sum('total_amount') * 18 / 100, 2) }}</span></div>
                                @endif
                                <div class="text-bold-black" id="grand-total-db-section"><span id="grand-total-db" class="fw-bold fs-7 text-primary">Grand Total:₹{{ number_format(optional($SalesOrderProformaInvoice->where('salereferenceid', $salesOrder->id)->whereNotNull('grandtotal_amount')->first())->grandtotal_amount, 2) }}</span></div>
                                <div class="text-bold-black" id="grand-total-section" style="display: none;">Grand Total:<span id="grand-total">0.00</span></div>
                            </div>
                            <button type="submit" id="savebtn" class="btn btn-primary" style="display: none;">Save</button>
                        </form>
                        <div class="divider3"></div>
                        <div id="printTotals" class="print-totals-section">
                            <table class="total-table">
                                <tr>
                                    <td><strong>Sub Total:</strong></td>
                                    <td><strong>₹{{ number_format($SalesOrderProformaInvoice->sum('total_amount'), 2) }}</strong></td>
                                </tr>
                            </table>
                            <table class="amount-table">
                                <tr>
                                    <td colspan="4">Total Invoice Amount in INR:</td>
                                    @if(optional($SalesOrderProformaInvoice->where('salereferenceid', $salesOrder->id)->first())->gst_status == 0)
                                    <td>SGST</td>
                                    <td>9%</td>
                                    <td>₹{{ number_format($SalesOrderProformaInvoice->sum('total_amount') * 9 / 100, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>CGST</td>
                                    <td>9%</td>
                                    <td>₹{{ number_format($SalesOrderProformaInvoice->sum('total_amount') * 9 / 100, 2) }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="4"></td>
                                    <td>IGST</td>
                                    <td>18%</td>
                                    <td>₹{{ number_format($SalesOrderProformaInvoice->sum('total_amount') * 18 / 100, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="5"><strong>Net Total Amount INR:</strong></td>
                                    <td></td>
                                    <td colspan="2" style="text-align: right;"><strong id="net-total">₹{{ optional($SalesOrderProformaInvoice->where('salereferenceid', $salesOrder->id)->whereNotNull('grandtotal_amount')->first())->grandtotal_amount}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="7" style="background-color: #e0ebf5; padding: 10px; text-align: left;">
                                        <strong>Total Invoice Amount in Words:</strong> 
                                        <span id="amount-in-words"></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="bankCertificationSection">
                            <table class="bank-certification-table">
                                <tr>
                                    <td class="bank-details" rowspan="2">
                                        <strong>Bank Details</strong>
                                        <hr><br>
                                        <p>M/S REPUNEXT</p>
                                        <p>Current A/C No: 50200050527113</p>
                                        <p>Bank: HDFC  Branch: Velachery</p>
                                        <p>IFSC CODE: HDFC0000444</p>
                                        <p>SWIFT CODE: HDFCINBBCHE</p>
                                    </td>
                                    <td class="certification-details">
                                        <strong>Certified in Quality Management System</strong><br>
                                        ISO 9001 : 2015 <br><br>
                                        <strong>Certified in Information Technology & Service Management</strong><br>
                                        ISO 20000-1 : 2011 <br><br>
                                        <strong>MSME Certificate</strong><br>
                                        <span>UDYAM-TN-02-0014358</span>
                                    </td>
                                    <td class="signature-details">
                                        <strong>Certified that the particulars given above are true and correct</strong>
                                        <hr>
                                        <strong>For</strong><br><br>
                                        <strong>Authorised Signatory</strong>
                                        <hr>
                                        <br><br>
                                        <strong>(Company Seal)</strong>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('list.salesorder') }}" class="btn btn-light-success me-2">Back</a>
                    <button class="btn btn-primary" onclick="window.print()">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function convertNumberToWords(amount) {
        if (isNaN(amount) || amount < 0) return 'Invalid amount';

        const words = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
            'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
            'Seventeen', 'Eighteen', 'Nineteen'],
            tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'],
            units = ['', 'Thousand', 'Lakh', 'Crore'];

        function convert(num, index = 0) {
            if (num === 0) return index === 0 ? 'Zero' : '';
            let chunk = num % 1000, wordsChunk = chunk ? (chunk >= 100 ? words[Math.floor(chunk / 100)] + ' Hundred ' : '') +
                (chunk % 100 < 20 ? words[chunk % 100] : tens[Math.floor(chunk % 100 / 10)] + ' ' + words[chunk % 10]) : '';
            return convert(Math.floor(num / 1000), index + 1) + (wordsChunk ? ' ' + wordsChunk + ' ' + units[index] : '');
        }

        let integerPart = Math.floor(amount), decimalPart = Math.round((amount - integerPart) * 100),
            result = (convert(integerPart) + ' Rupees' + (decimalPart ? ' and ' + convert(decimalPart) + ' Paise' : '')).trim();

        return result.charAt(0).toUpperCase() + result.slice(1);
    }

    document.addEventListener("DOMContentLoaded", () => {
        let totalAmountElement = document.getElementById("net-total"),
            wordsElement = document.getElementById('amount-in-words');

        function updateAmountInWords() {
            let totalAmount = parseFloat((totalAmountElement?.innerText || '').replace(/[₹,]/g, '').trim());
            wordsElement.innerText = isNaN(totalAmount) ? "Error: Invalid Amount" : convertNumberToWords(totalAmount);
        }

        new MutationObserver(updateAmountInWords).observe(totalAmountElement, { childList: true, subtree: true });
        updateAmountInWords();
    });

    document.addEventListener("DOMContentLoaded", function () {
        function calculateGST() {
    let productRows = document.querySelectorAll(".text-muted-custom-product");

    if (productRows.length === 0) {
        console.error("No product rows found.");
        return;
    }

    let totalAmount = 0;
    let totalCGST = 0;
    let totalSGST = 0;
    let totalIGST = 0;
    let totalGSTAmount = 0;
    let grandTotal = 0;

    productRows.forEach(row => {
        let rateInput = row.querySelector("[name='rate[]']");
        let quantityInput = row.querySelector("[name='quantity[]']");
        let discountInput = row.querySelector("[name='discount[]']");
        let gstStatusInput = row.querySelector("input[name='gst_status']");
        
        if (!rateInput || !quantityInput || !gstStatusInput) {
            console.error("Missing input in row:", row);
            return;
        }

        let rate = parseFloat(rateInput.value) || 0;
        let quantity = parseInt(quantityInput.value) || 1;
        let discount = parseFloat(discountInput?.value || 0);
        let gstStatus = gstStatusInput.value;

        let discountAmount = (rate * quantity) * (discount / 100);
        let taxableAmount = (rate * quantity) - discountAmount;

        totalAmount += taxableAmount;

        let totalAmountCell = row.querySelector(".total-amount");
        if (totalAmountCell) {
            totalAmountCell.textContent = `₹${taxableAmount.toFixed(2)}`;
        }

        if (gstStatus === "0") { 
            let cgstAmount = (taxableAmount * 9) / 100;
            let sgstAmount = (taxableAmount * 9) / 100;
            totalCGST += cgstAmount;
            totalSGST += sgstAmount;
            totalGSTAmount += (cgstAmount + sgstAmount);
        } else if (gstStatus === "1") { 
            let igstAmount = (taxableAmount * 18) / 100;
            totalIGST += igstAmount;
            totalGSTAmount += igstAmount;
        }
    });

    grandTotal = totalAmount + totalGSTAmount;

    if (document.getElementById("sub-total")) {
        document.getElementById("sub-total").textContent = totalAmount.toFixed(2);
    }
    if (document.getElementById("cgst-total")) {
        document.getElementById("cgst-total").textContent = totalCGST.toFixed(2);
    }
    if (document.getElementById("sgst-total")) {
        document.getElementById("sgst-total").textContent = totalSGST.toFixed(2);
    }
    if (document.getElementById("igst-total")) {
        document.getElementById("igst-total").textContent = totalIGST.toFixed(2);
    }

    let grandTotalElement = document.getElementById("grand-total");
    if (grandTotalElement) {
        grandTotalElement.textContent = `₹${grandTotal.toFixed(2)}`;
    } else {
        console.error("Grand Total element not found.");
    }
}
    document.addEventListener("input", function (event) {
        if (event.target.classList.contains("editable-input")) {
            calculateGST();
        }
    });

});
  
// Edit Mode Functionality
document.getElementById("editBtn").addEventListener("click", function () {
    let inputs = document.querySelectorAll(".editable-input, .qty, .rate, .discount");
    let editBtn = document.getElementById("editBtn");
    let saveBtn = document.getElementById("savebtn");

    document.getElementById("grand-total-db-section").style.display = "none";
    document.getElementById("grand-total-section").style.display = "block";

    inputs.forEach(input => {
        input.removeAttribute("readonly");
        input.style.border = "1px solid #ccc";
    });

    editBtn.style.display = "none";
    saveBtn.style.display = "inline-block";

    setTimeout(() => {
        calculateGST();
    }, 100);
});

</script>

@endsection
