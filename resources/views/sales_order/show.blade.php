@extends('admin.admin_master')
@section('admin')

<style>
    .sales-order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        font-size: 16px;
        white-space: nowrap;
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
        margin-left:10px !important;
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
    @page {
        size: A4;
        margin: 0.1cm;
    }

    * {
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box;
    }

    html, body {
        width: 210mm;
        max-width: 210mm;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
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
        width: 100%;
        margin-bottom: 0 !important;
        margin-top: 0 !important;
        padding-bottom: 0 !important;
        border-bottom: none !important;
    }

    #printHeader * {
        visibility: visible;
    }

    .header-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
        margin: 0 !important;
        padding: 0 !important;
        table-layout: fixed;
    }

    .header-table td {
        border: 1px solid black;
        padding: 1mm !important;
        font-size: 9px;
        vertical-align: middle;
        height: 80px;
    }

    .header-table td:first-child {
        width: 25%;
        text-align: center;
    }

    .header-table td:nth-child(2) {
        width: 55%;
        text-align: center;
        padding-left: 1mm !important;
        padding-right: 1mm !important;
    }

    .header-table td:last-child {
        width: 20%;
        text-align: right;
        padding-right: 1mm !important;
    }

    .company-logo {
        text-align: center;
        vertical-align: middle;
        height: 100%;
    }

    .company-logo img {
        height: 50px;
        text-align: center;
        vertical-align: middle;
        max-width: 50px;
        margin: 0 auto;
        display: block;
        object-fit: contain;
    }

    .company-name {
        font-size: 16px !important;
        font-family: 'Merriweather';
        color: black;
        text-align: center;
        line-height: 1.1;
        padding: 0;
        margin: 0;
        vertical-align: middle;
    }

    .company_email {
        font-family: 'Merriweather';
        font-size: 16px !important;
        text-align: center !important;
        line-height: 1.1;
        margin: 0;
        padding: 0;
        vertical-align: middle;
    }

    #printInvoiceHeader {
        display: flex !important;
        justify-content: center;
        align-items: center;
        margin-top: 1mm !important; 
        padding-bottom: 1mm !important; 
        border-bottom: 1px solid black;
        margin-bottom: 3mm !important;
    }

    #printInvoiceHeader h2 {
        margin: 0 auto;
        font-size: 18px;
        font-family: 'Merriweather';
        text-align: center;
    }

    #invoiceContent {
        width: 100% !important;
        margin: 0 !important;
        padding: 0.2mm !important;
        border: 1px solid black;
        max-width: none !important;
        box-sizing: border-box;
        min-height: auto;
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
        margin: 0 !important;
    }

    .invoice-table th, .invoice-table td {
        border: 1px solid #000;
        padding: 0.5mm !important;
        font-size: 9px;
        text-align: center;
    }

    .total-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0 !important;
    }

    .total-table td {
        border: 1px solid #000;
        padding: 0.5mm !important;
        text-align: right;
        font-weight: bold;
        font-size: 9px;
    }

    .total-table td:first-child {
        text-align: left;
    }

    /* Full space utilization */
    body {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        height: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .card {
        width: 100% !important;
        margin: 0 !important;
        border: none !important;
    }

    .card-body {
        padding: 0.5mm !important;
        width: 100% !important;
    }
    
    /* Remove top spacing for print */
    .card-header {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    
    .container-xxl {
        margin-top: 0 !important;
        padding-top: 0 !important;
        @
    }
    
    .content, #kt_content, #kt_post {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .table {
        width: 100% !important;
        margin: 0 !important;
    }

    .table th, .table td {
        width: auto !important;
    }

    .table th:nth-child(1) { width: 8% !important; }
    .table th:nth-child(2) { width: 35% !important; }
    .table th:nth-child(3) { width: 12% !important; }
    .table th:nth-child(4) { width: 10% !important; }
    .table th:nth-child(5) { width: 15% !important; }
    .table th:nth-child(6) { width: 10% !important; }
    .table th:nth-child(7) { width: 10% !important; }

    /* Page break control */
    .page-break-inside-avoid {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .page-break-before-avoid {
        page-break-before: avoid !important;
        break-before: avoid !important;
    }

    .page-break-after-avoid {
        page-break-after: avoid !important;
        break-after: avoid !important;
    }

    /* Compact spacing for single page */
    .invoice-details {
        margin-bottom: 2px !important;
        padding: 1px !important;
    }

    .divider1, .divider3 {
        height: 1px !important;
        margin: 1px 0 !important;
    }

    .totals-section {
        padding: 2px 0 !important;
        margin: 0 !important;
    }

    .bank-certification-table {
        margin-top: 2px !important;
        padding: 1px !important;
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
        margin-top: 5px;
        padding: 0;
        border: none;
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
        margin-right: 10px !important;
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
        margin-top: 5px;
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

#printInvoiceHeader {
    display: none;
}
    
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header pt-1">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">View</span>
                        <span class="text-muted-custom fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted-custom text-hover-primary">Home</a> / Sales / Order
                        </span>
                        <br><br>
                        
                    </h3>
                </div>
                <br>
                <div id="printHeader">
                    <table class="header-table">
                        <tr>
                            <td class="company-logo">
                                <img src="{{ asset('backend/assets/media/logos/logo2.png') }}" alt="RepuNext Logo" style="max-width: 60%; height: auto; display: block; margin: 0 auto;">
                            </td>
                            <td class="company-name">
                                <h2>REPUNEXT LLP</h2>
                                Plot No. 22 and 23, 2nd Floor, 2nd Main Road,<br>
                                V.G.P. Selva Nagar, <br>
                                Velachery, Chennai – 600042,<br>                            
                                Phone: [+91 95001 555 23 / 24 / 90 / 91] <br>
                                Landline : 044 486 555 23
                            </td>
                            <td class="company_email">
                                Email: info@repunext.com <br>
                                Website: www.repunext.com
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="invoiceContent">
                <div id="printInvoiceHeader">
            <h2>INVOICE</h2>
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
                                <span><strong>Invoice Number:</strong> RN/D/12/{{ str_pad($salesOrder->invoice_number, 3, '0', STR_PAD_LEFT) }} | </span>
                                <span><strong>Date:</strong> {{ date('d-m-Y', strtotime($salesOrder->date)) }} | </span>
                                <span><strong>GST IN:</strong> 33ARFPP5003N1ZR</span>
                                <br><br>
                                <div class="terms-box">
                                    <strong>Terms of Payment & Delivery</strong><br>
                                    {{ $salesOrder->terms_of_payment_and_delivery }}
                                </div>
                        </div>
                    </div>
                    <br>
                    <div class="sales-order-header">
                        <div>
                            <span class="text-muted-custom">Invoice Number:</span>
                            <span class="text-bold-black">RN/D/12/{{ str_pad($salesOrder->invoice_number, 3, '0', STR_PAD_LEFT) }}
                            </span>
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
                        @php
                            $hasDiscount = $salesOrder->salesOrderDetails->whereNotNull('discount')->count() > 0;
                        @endphp
                        
                        
                        <table class="table table-bordered mt-0 text-center">
                            <thead>
                                <tr class="text-muted-custom">
                                    <th>S.No</th>
                                    <th>Description</th>
                                    <th>Month</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    @if($hasDiscount)
                                    <th>Disc</th>
                                    @endif
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salesOrder->salesOrderDetails as $index => $item)
                                    <tr class="text-muted-custom">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->month }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹{{ $item->rate }}</td>
                                        @if($hasDiscount)
                                        <td>{{ $item->discount ? $item->discount . '%' : '' }}</td>
                                        @endif
                                        <td>₹{{ $item->total_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="divider1"></div>
                        <div class="totals-section">
                            <div class="text-muted-custom">Sub Total: ₹{{ number_format($salesOrder->salesOrderDetails->sum('total_amount'), 2) }}</div>
                            @if(optional($salesOrder->salesOrderDetails->where('salereferenceid', $salesOrder->id)->first())->gst_status == 0)
                            <div class="text-muted-custom">SGST (9%): ₹{{ number_format($salesOrder->salesOrderDetails->sum('total_amount') * 9 / 100, 2) }}</div>
                            <div class="text-muted-custom">CGST (9%): ₹{{ number_format($salesOrder->salesOrderDetails->sum('total_amount') * 9 / 100, 2) }}</div>
                            @else
                            <div class="text-muted-custom">IGST (18%): ₹{{ number_format($salesOrder->salesOrderDetails->sum('total_amount') * 18 / 100, 2) }}</div>
                            @endif
                            <div>Grand Total: <span class="fw-bold fs-6 text-primary">₹{{ $salesOrder->grandtotal_amount }}
                            </span></div>
                        </div>
                        <div class="divider3"></div>
                        <div id="printTotals" class="print-totals-section">
                            <table class="total-table">
                                <tr>
                                    <td><strong>Sub Total:</strong></td>
                                    <td><strong>₹{{ number_format($salesOrder->salesOrderDetails->sum('total_amount'), 2) }}</strong></td>
                                </tr>
                            </table>
                            <table class="amount-table">
                                <tr>
                                    <td colspan="4">Total Invoice Amount in INR:</td>
                                    @if(optional($salesOrder->salesOrderDetails->where('salereferenceid', $salesOrder->id)->first())->gst_status == 0)
                                    <td>SGST</td>
                                    <td>9%</td>
                                    <td>₹{{ number_format($salesOrder->salesOrderDetails->sum('total_amount') * 9 / 100, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td >CGST</td>
                                    <td>9%</td>
                                    <td>₹{{ number_format($salesOrder->salesOrderDetails->sum('total_amount') * 9 / 100, 2) }}
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="4"></td>
                                    <td>IGST</td>
                                    <td>18%</td>
                                    <td>₹{{ number_format($salesOrder->salesOrderDetails->sum('total_amount') * 18 / 100, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="5"><strong>Net Total Amount INR:</strong></td>
                                    <td colspan="2" style="text-align: right;"><strong id="net-total">₹{{ $salesOrder->grandtotal_amount }}
                                    </strong></td>
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
                                        <p> HDFC Bank: Praveen Dilip S</p>
                                        <p>Current A/C No: 50100 17489 4841</p>
                                        <p>Bank: HDFC  Branch: Velachery</p>
                                        <p>IFSC CODE: HDFC 0000 010</p>
                                        <p>MG Road, Besant Nagar, Chennai - 600090, Tamil Nadu Or Google Pay/Bhim
                                        9884454104</p>
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
</script>

@endsection
