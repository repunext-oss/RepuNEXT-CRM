@extends('admin.admin_master')
@section('admin')

<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Add</span>
                        <span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Sales / Order</span>
                    </h3>
                </div>
                <div class="card-body pt-5 pb-0">
                    <form id="addform" method="POST" action="{{ route('store.salesorder') }}">
                        @csrf
                        <div class="row mb-7"> 
                            <div class="col-lg-3 fv-row">
                                <label class="fw-bold fs-6 mb-2">Invoice Number</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $newInvoiceNumber ?? '') }}" readonly>
                            </div>
                            <div class="col-lg-3 fv-row">
                                <label class="required fw-bold fs-6 mb-2">Date</label>
                                <input type="date" class="form-control" id="date" name="date">
                            </div>
                            <div class="col-lg-3 fv-row">
                                <label class="required fw-bold fs-6 mb-2">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
                                <small id="company_name_error" class="text-danger"></small>
                            </div>
                            <div class="col-lg-3 fv-row">
                                <label class="fw-bold fs-6 mb-2">Phone Number</label>
                                <input type="text" class="form-control" id="customer_phone_number" name="customer_phone_number" minlength="10" maxlength="10" required>
                                <small id="customer_phone_number_error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="row mb-7"> 
                            <div class="col-lg-3 fv-row">
                                <label class="fw-bold fs-6 mb-2">Email ID</label>
                                <input type="email" class="form-control" id="customer_emailid" name="customer_emailid" required>
                                <small id="customer_emailid_error" class="text-danger"></small>
                            </div>
                            <div class="col-lg-3 fv-row">
                                <label class="fw-bold fs-6 mb-2">Customer Status</label>
                                <select class="form-control" name="customer_status">
                                    <option value="" selected disabled>Choose Customer Status</option>
                                    <option value="New">New</option>
                                    <option value="Retained">Retained</option>
                               </select>
                            </div>
                            <div class="col-lg-3 fv-row">
                                <label class="fw-bold fs-6 mb-2">Payment Mode</label>
                                <select class="form-control" name="payment_mode">
                                    <option value="" selected disabled>Choose Payment Mode</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Net Banking">Net Banking</option>
                                </select>
                            </div>
                            <div class="col-lg-3 fv-row">
                                <label class=" fw-bold fs-6 mb-2">Terms Of Payment and Delivery</label>
                                <textarea class="form-control" name="terms_of_payment_and_delivery" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row mb-5"> 
                            <div class="col-lg-4 fv-row">
                                <label class="required fw-bold fs-6 mb-2">Address</label>
                                <textarea class="form-control" name="address" rows="2"></textarea>
                            </div>
                            <div class="col-lg-5 fv-row">
                                <label class="required fw-bold fs-6 mb-2">GST Number</label>
                                <input type="text" class="form-control" id="gst_number" name="gst_number" required>
                                <small id="gst_number_error" class="text-danger"></small>
                            </div>
                            <div class="col-lg-3 fv-row">
                                <label class="required fw-bold fs-6 mb-2">GST Status</label>
                                <div class="d-flex">
                                    <div class="form-check me-20">
                                        <input class="form-check-input gst-status mt-4" type="radio" id="gst_state" name="gst_status" value="0" required>
                                        <label class="form-check-label mt-4" for="gst_state">State</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input gst-status mt-4" type="radio" id="gst_central" name="gst_status" value="1" required>
                                        <label class="form-check-label mt-4" for="gst_central">Central</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="text-dark mb-0">Product Details</h4>
                            <button type="button" id="addProduct" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div id="productTable">
                            <div class="row g-2 align-items-center productRow">
                                <div class="col-lg-3 mb-3">
                                    <label class="required fw-bold fs-6 mb-2">Description</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name[]" placeholder="Enter Description" required>
                                    <small id="product_name_error" class="text-danger"></small>
                                </div>
                                <div class="col-lg-2 mb-3">
                                    <label class="fw-bold fs-6 mb-2">Month</label>
                                    <input type="text" class="form-control" name="month[]" placeholder="Month">
                                </div>
                                <div class="col-lg-1 mb-3">
                                    <label class="fw-bold fs-6 mb-2">Qty</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity[]" placeholder="Qty" value=1>
                                    <small id="qty_error" class="text-danger"></small>
                                </div>
                                <div class="col-lg-2 mb-3">
                                    <label class="required fw-bold fs-6 mb-2">Price</label>
                                    <input type="number" class="form-control" id="rate" name="rate[]" placeholder="Price" required>
                                    <small id="rate_error" class="text-danger"></small>
                                </div>
                                <div class="col-lg-1 mb-3">
                                    <label class="fw-bold fs-6 mb-2">Disc (%)</label>
                                    <input type="number" class="form-control discount" id="discount" name="discount[]" placeholder="Disc" value=0>
                                    <small id="discount_error" class="text-danger"></small>
                                </div>
                                <div class="col-lg-2 mb-3">
                                    <label class="fw-bold fs-6 mb-2">Total</label>
                                    <input type="text" class="form-control total_amount" id="total_amount" name="total_amount[]" placeholder="Total" readonly>
                                </div>
                                <div class="col-lg-1 d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-sm btn-danger removeProduct mt-3 ms-12">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-end align-items-center">
                                <div class="col-lg-2 me-3 gst-state-fields" style="display: none;">
                                    <label class="fw-bold fs-6 mb-2">CGST%</label>
                                    <input type="text" class="form-control" id="cgst" name="cgst" value="9%" readonly>
                                </div>
                                <div class="col-lg-2 me-3 gst-state-fields" style="display: none;">
                                    <label class="fw-bold fs-6 mb-2">CGST AMT</label>
                                    <input type="text" class="form-control" id="cgst_amt" name="cgst_amt" readonly>
                                </div>
                                <div class="col-lg-2 me-3 gst-state-fields" style="display: none;">
                                    <label class="fw-bold fs-6 mb-2">SGST%</label>
                                    <input type="text" class="form-control" id="sgst" name="sgst" value="9%" readonly>
                                </div>
                                <div class="col-lg-2 me-3 gst-state-fields" style="display: none;">
                                    <label class="fw-bold fs-6 mb-2">SGST AMT</label>
                                    <input type="text" class="form-control" id="sgst_amt" name="sgst_amt" readonly>
                                </div>
                                <div class="col-lg-2 me-3 gst-central-fields" style="display: none;">
                                    <label class="fw-bold fs-6 mb-2">IGST%</label>
                                    <input type="text" class="form-control" id="igst" name="igst" value="18%" readonly>
                                </div>
                                <div class="col-lg-2 me-3 gst-central-fields" style="display: none;">
                                    <label class="fw-bold fs-6 mb-2">IGST AMT</label>
                                    <input type="text" class="form-control" id="igst_amt" name="igst_amt" readonly>
                                </div>
                                <div class="col-lg-2">
                                    <label class="fw-bold fs-6 mb-2">Grand Total</label>
                                    <input type="text" class="form-control" id="grand_total" name="grand_total" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row mt-5 mb-5">
                            <div class="col d-flex justify-content-end">
                                <a href="{{ route('list.salesorder') }}" class="btn btn-light-success me-2">Cancel</a>
                                <input type="submit" value="Submit" class="btn btn-primary me-2" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

function validateField(id, pattern, errorMsg) {
    const field = document.getElementById(id);
    const errorField = document.getElementById(id + "_error");

    field.addEventListener("input", () => {
        const isValid = pattern.test(field.value);
        errorField.innerText = isValid ? "" : errorMsg;
        field.style.border = isValid ? "1px solid #ced4da" : "1px solid red";
    });
}

const validations = {
    company_name: { pattern: /^[A-Za-z ]+$/, error: "Only letters and spaces allowed" },
    customer_emailid: { pattern: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/, error: "Enter a valid email" },
    customer_phone_number: { pattern: /^[6-9]\d{9}$/, error: "Enter a valid 10-digit phone number" },
    product_name: { pattern: /^[A-Za-z0-9 ]+$/, error: "Only letters, numbers, and spaces allowed" },
    quantity: { pattern: /^[1-9][0-9]*$/, error: "Enter a valid quantity" },
    rate: { pattern: /^\d+(\.\d{1,2})?$/, error: "Enter a valid rate" },
    discount: { pattern: /^\d+(\.\d{1,2})?$/, error: "Enter a valid discount percentage" },
    gst_number: { pattern: /^[a-zA-Z0-9]+$/, error: "Enter a valid GST number"}
};

for (let field in validations) {
    validateField(field, validations[field].pattern, validations[field].error);
}

document.getElementById("addform").addEventListener("submit", function (event) {
    let isValidForm = true;

    for (let field in validations) {
        const inputField = document.getElementById(field);
        const isValid = validations[field].pattern.test(inputField.value);

        if (!isValid) {
            isValidForm = false;
            swal({
                title: `Invalid ${field.replace(/_/g, " ")}`,
                text: validations[field].error,
                type: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK"
            });
        }
    }

    if (!isValidForm) event.preventDefault();
});

document.addEventListener("DOMContentLoaded", function () {
    function calculateGST() {
    let productRows = document.querySelectorAll(".productRow");

    let totalAmount = 0;
    let totalCGST = 0;
    let totalSGST = 0;
    let totalIGST = 0;
    let totalGSTAmount = 0;
    let grandTotal = 0;

    let gstStatus = document.querySelector("input[name='gst_status']:checked")?.value;

    productRows.forEach(row => {
        let rate = parseFloat(row.querySelector("[name='rate[]']").value) || 0;
        let quantity = parseInt(row.querySelector("[name='quantity[]']").value) || 1;
        let discount = parseFloat(row.querySelector("[name='discount[]']").value) || 0;

        let discountAmount = (rate * quantity) * (discount / 100);
        let taxableAmount = (rate * quantity) - discountAmount;

        totalAmount += taxableAmount; 

        row.querySelector("[name='total_amount[]']").value = taxableAmount.toFixed(2);

        let cgstAmount = 0, sgstAmount = 0, igstAmount = 0;

        if (gstStatus === "0") { 
            cgstAmount = (taxableAmount * 9) / 100;
            sgstAmount = (taxableAmount * 9) / 100;
            totalCGST += cgstAmount;
            totalSGST += sgstAmount;
            totalGSTAmount += (cgstAmount + sgstAmount);
        } else if (gstStatus === "1") { 
            igstAmount = (taxableAmount * 18) / 100;
            totalIGST += igstAmount;
            totalGSTAmount += igstAmount;
        }
    });

    grandTotal = totalAmount + totalGSTAmount;

    document.getElementById("cgst_amt").value = totalCGST.toFixed(2);
    document.getElementById("sgst_amt").value = totalSGST.toFixed(2);
    document.getElementById("igst_amt").value = totalIGST.toFixed(2);
    document.getElementById("grand_total").value = grandTotal.toFixed(2);
}

    document.addEventListener("input", function (event) {
        if (event.target.matches("[name='rate[]'], [name='gst[]'], [name='quantity[]'], [name='discount[]']")) {
            calculateGST();
        }
    });

    document.querySelectorAll(".gst-status").forEach(radio => {
        radio.addEventListener("change", calculateGST);
    });

    $("#productTable").on("click", ".removeProduct", function () {
    $(this).closest(".productRow").remove();
    setTimeout(calculateGST, 100); 
});

    calculateGST(); 
});

$(document).ready(function () {
    $("#addProduct").click(function () {  
        let newRow = `
        <div class="row g-2 align-items-center productRow mt-1">
            <div class="col-lg-3"><input type="text" class="form-control" name="product_name[]" placeholder="Enter Description" required></div>
            <div class="col-lg-2"><input type="text" class="form-control" name="month[]" placeholder="Month" required></div>
            <div class="col-lg-1"><input type="number" class="form-control" name="quantity[]" placeholder="Qty" min="1" value="1" required></div>
            <div class="col-lg-2"><input type="number" class="form-control" name="rate[]" placeholder="Price" min="1" required></div>
            <div class="col-lg-1"><input type="number" class="form-control" name="discount[]" placeholder="Disc" min="0" value="0" required></div>
            <div class="col-lg-2"><input type="text" class="form-control" name="total_amount[]" placeholder="Total" readonly></div>
            <div class="col-lg-1 d-flex align-items-center justify-content-center">
                <button type="button" class="btn btn-sm btn-danger removeProduct ms-12"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;

        $("#productTable").append(newRow);
        calculateGST();
    });

    $("#productTable").on("input", "input[name^='quantity'], input[name^='rate'], input[name^='discount']", function () {
    calculateGST();
});

});

document.addEventListener("DOMContentLoaded", function () {
    const gstStateFields = document.querySelectorAll(".gst-state-fields");
    const gstCentralFields = document.querySelectorAll(".gst-central-fields");

    function toggleGSTFields() {
        const selectedGST = document.querySelector('input[name="gst_status"]:checked')?.value;

        if (selectedGST === "0") {
            gstStateFields.forEach(field => field.style.display = "block");
            gstCentralFields.forEach(field => field.style.display = "none");
        } else if (selectedGST === "1") {
            gstStateFields.forEach(field => field.style.display = "none");
            gstCentralFields.forEach(field => field.style.display = "block"); 
        }
    }

    document.querySelectorAll('.gst-status').forEach(radio => {
        radio.addEventListener("change", toggleGSTFields);
    });

    toggleGSTFields(); 
});

</script>

@endsection
