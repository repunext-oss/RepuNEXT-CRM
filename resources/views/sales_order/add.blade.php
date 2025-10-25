@extends('admin.admin_master')
@section('admin')

<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .product-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .product-table th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 12px 8px;
        text-align: center;
        border: 1px solid #dee2e6;
        font-size: 14px;
    }
    
    .product-table td {
        padding: 8px;
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }
    
    .product-table input {
        border: 1px solid #ced4da;
        padding: 8px 12px;
        width: 100%;
        font-size: 14px;
        border-radius: 4px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .product-table input:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .product-table input[readonly] {
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }
    
    .product-table .sno-column {
        width: 60px;
        text-align: center;
        font-weight: 600;
        background-color: #f8f9fa;
    }
    
    .product-table .description-column {
        width: 30%;
    }
    
    .product-table .month-column {
        width: 15%;
    }
    
    .product-table .qty-column {
        width: 10%;
        text-align: center;
    }
    
    .product-table .price-column {
        width: 15%;
        text-align: right;
    }
    
    .product-table .total-column {
        width: 15%;
        text-align: right;
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .product-table .action-column {
        width: 80px;
        text-align: center;
    }
    
    .remove-btn {
        background-color: #dc3545;
        border: none;
        color: white;
        padding: 6px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: background-color 0.15s ease-in-out;
    }
    
    .remove-btn:hover {
        background-color: #c82333;
    }
    
    .add-product-btn {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 15px;
        transition: background-color 0.15s ease-in-out;
    }
    
    .add-product-btn:hover {
        background-color: #0056b3;
    }
    
    .totals-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
        margin-top: 20px;
        border: 1px solid #dee2e6;
    }
    
    .totals-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        font-size: 16px;
    }
    
    .totals-row:last-child {
        border-top: 2px solid #dee2e6;
        padding-top: 10px;
        margin-top: 10px;
        font-weight: bold;
        font-size: 18px;
    }
    
    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }
</style>
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
                            <button type="button" id="addProduct" class="add-product-btn">
                                <i class="fas fa-plus"></i> Add Product
                            </button>
                        </div>
                        
                        <table class="product-table" id="productTable">
                            <thead>
                                <tr>
                                    <th class="sno-column">S.No</th>
                                    <th class="description-column">Description</th>
                                    <th class="month-column">Month</th>
                                    <th class="qty-column">QTY</th>
                                    <th class="price-column">Price</th>
                                    <th class="total-column">Total</th>
                                    <th class="action-column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="productRow">
                                    <td class="sno-column">1</td>
                                    <td class="description-column">
                                        <input type="text" class="form-control" id="product_name" name="product_name[]" placeholder="Enter Description" required>
                                        <small id="product_name_error" class="error-message"></small>
                                    </td>
                                    <td class="month-column">
                                        <input type="text" class="form-control" name="month[]" placeholder="Month">
                                    </td>
                                    <td class="qty-column">
                                        <input type="number" class="form-control" id="quantity" name="quantity[]" placeholder="Qty" value="1" min="1">
                                        <small id="qty_error" class="error-message"></small>
                                    </td>
                                    <td class="price-column">
                                        <input type="number" class="form-control" id="rate" name="rate[]" placeholder="Price" required step="0.01">
                                        <small id="rate_error" class="error-message"></small>
                                    </td>
                                    <td class="total-column">
                                        <span class="total_amount">₹0.00</span>
                                        <input type="hidden" name="total_amount[]" class="total_amount_input">
                                    </td>
                                    <td class="action-column">
                                        <button type="button" class="remove-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="totals-section">
                            <div class="totals-row">
                                <span>Sub Total:</span>
                                <span id="sub_total">₹0.00</span>
                            </div>
                            
                            <!-- GST State Fields -->
                            <div class="totals-row gst-state-fields" style="display: none;">
                                <span>CGST (9%):</span>
                                <span id="cgst_amt">₹0.00</span>
                            </div>
                            <div class="totals-row gst-state-fields" style="display: none;">
                                <span>SGST (9%):</span>
                                <span id="sgst_amt">₹0.00</span>
                            </div>
                            
                            <!-- GST Central Fields -->
                            <div class="totals-row gst-central-fields" style="display: none;">
                                <span>IGST (18%):</span>
                                <span id="igst_amt">₹0.00</span>
                            </div>
                            
                            <div class="totals-row">
                                <span>Grand Total:</span>
                                <span id="grand_total">₹0.00</span>
                                <input type="hidden" id="grand_total_input" name="grand_total">
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
    discount: { pattern: /^(\d+(\.\d{1,2})?)?$/, error: "Enter a valid discount percentage" },
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

        // Skip empty rows
        if (rate === 0 && quantity === 0) {
            return;
        }

        let taxableAmount = rate * quantity;
        totalAmount += taxableAmount; 

        // Update the display and hidden input
        let totalSpan = row.querySelector(".total_amount");
        let totalInput = row.querySelector(".total_amount_input");
        if (totalSpan && totalInput) {
            totalSpan.textContent = "₹" + taxableAmount.toFixed(2);
            totalInput.value = taxableAmount.toFixed(2);
        }

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

    // Update summary display
    document.getElementById("sub_total").textContent = "₹" + totalAmount.toFixed(2);
    document.getElementById("cgst_amt").textContent = "₹" + totalCGST.toFixed(2);
    document.getElementById("sgst_amt").textContent = "₹" + totalSGST.toFixed(2);
    document.getElementById("igst_amt").textContent = "₹" + totalIGST.toFixed(2);
    document.getElementById("grand_total").textContent = "₹" + grandTotal.toFixed(2);
    document.getElementById("grand_total_input").value = grandTotal.toFixed(2);
}

    document.addEventListener("input", function (event) {
        if (event.target.matches("[name='rate[]'], [name='gst[]'], [name='quantity[]'], [name='discount[]']")) {
            calculateGST();
        }
    });

    document.querySelectorAll(".gst-status").forEach(radio => {
        radio.addEventListener("change", calculateGST);
    });


    calculateGST(); 
});

$(document).ready(function () {
    let rowCounter = 1;

    $("#addProduct").click(function () {  
        rowCounter++;
        let newRow = `
        <tr class="productRow">
            <td class="sno-column">${rowCounter}</td>
            <td class="description-column">
                <input type="text" class="form-control" name="product_name[]" placeholder="Enter Description" required>
            </td>
            <td class="month-column">
                <input type="text" class="form-control" name="month[]" placeholder="Month">
            </td>
            <td class="qty-column">
                <input type="number" class="form-control" name="quantity[]" placeholder="Qty" min="1" value="1">
            </td>
            <td class="price-column">
                <input type="number" class="form-control" name="rate[]" placeholder="Price" min="0" step="0.01">
            </td>
            <td class="total-column">
                <span class="total_amount">₹0.00</span>
                <input type="hidden" name="total_amount[]" class="total_amount_input">
            </td>
            <td class="action-column">
                <button type="button" class="remove-btn">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>`;

        $("#productTable tbody").append(newRow);
        calculateGST();
    });

    $("#productTable").on("input", "input[name^='quantity'], input[name^='rate']", function () {
        calculateGST();
    });

    $("#productTable").on("click", ".remove-btn", function () {
        $(this).closest(".productRow").remove();
        updateRowNumbers();
        calculateGST();
    });
});

function updateRowNumbers() {
    $("#productTable tbody .productRow").each(function(index) {
        $(this).find("td:first").text(index + 1);
    });
}

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
