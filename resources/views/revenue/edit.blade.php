@extends('admin.admin_master')
@section('admin')
<style>
    .form-label {
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: #5e6278;
    }
    
    .form-check {
        margin-bottom: 0;
    }
    
    .form-check-inline {
        margin-right: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .form-check-input {
        margin-top: 0.25rem;
        margin-right: 0.5rem;
    }
    
    .form-control, .form-select {
        height: 48px;
        border-radius: 0.475rem;
        border: 1px solid #e1e3ea;
        transition: all 0.15s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #009ef7;
        box-shadow: 0 0 0 0.2rem rgba(0, 158, 247, 0.25);
    }
    
    #payment-method-container {
        min-height: 48px;
        align-items: flex-start;
        padding-top: 0.5rem;
    }
    
    .card-body {
        padding: 2.5rem;
    }
    
    .form-section {
        background: #f8f9fa;
        border-radius: 0.475rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #181c32;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e1e3ea;
    }
    
    .row.g-4 {
        --bs-gutter-x: 2rem;
        --bs-gutter-y: 1.5rem;
    }
    
    .btn-primary {
        background-color: #009ef7;
        border-color: #009ef7;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 0.475rem;
    }
    
    .btn-primary:hover {
        background-color: #0087d1;
        border-color: #0087d1;
    }
    
    .required::after {
        content: " *";
        color: #f1416c;
        font-weight: bold;
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Edit Revenue</span>
						<span class="text-muted fw-semibold fs-7">
							<a href="{{route('revenue-expense.index')}}" class="text-muted text-hover-primary">Revenue & Expense</a> /
							<a href="{{route('revenue.show', $revenue)}}" class="text-muted text-hover-primary">View</a> /
							<span class="text-primary">Edit</span>
						</span>
					</h3> 
				</div>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
				<div class="card-body border-0 pt-0"> 
					<form action="{{ route('revenue.update', $revenue) }}" method="post" class="form" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						
						<!-- Basic Information Section -->
						<div class="form-section">
							<div class="form-section-title">Basic Information</div>
							<div class="row g-4">
								<div class="col-lg-4">
									<label for="r_name" class="form-label">Name</label>
									<input
										id="r_name"
										name="r_name"
										type="text"
										class="form-control"
										placeholder="e.g., enter a name"
										value="{{ old('r_name', $revenue->r_name) }}"
										maxlength="191">
								</div>
								
								<div class="col-lg-4">
									<label for="entry_date" class="form-label required">Entry Date</label>
									<input
										id="entry_date"
										name="entry_date"
										type="date"
										class="form-control"
										value="{{ old('entry_date', $revenue->entry_date) }}"
										required>
								</div>
							</div>
						</div>

						<!-- Category & Amount Section -->
						<div class="form-section">
							<div class="form-section-title">Category & Amount Details</div>
							<div class="row g-4">
								<div class="col-lg-4">
									<label class="form-label required">Category</label>
									<select name="category" id="category" class="form-select" required>
										<option value="" selected disabled>— Select category —</option>
									</select>
								</div>
								
								<div class="col-lg-4">
									<label class="form-label">Subcategory</label>
									<select name="subcategory" id="subcategory" class="form-select">
										<option value="" selected disabled>— Select subcategory —</option>
									</select>
								</div>
								
								<div class="col-lg-4">
									<label for="amount" class="form-label required">Amount</label>
									<input 
										class="form-control" 
										id="amount" 
										type="number" 
										name="amount" 
										value="{{ old('amount', $revenue->amount) }}" 
										step="0.01" 
										min="0" 
										placeholder="0.00" 
										required>
								</div>
							</div>
						</div>

						<!-- Payment Method Section -->
						<div class="form-section">
							<div class="form-section-title">Payment Method</div>
							<div class="row">
								<div class="col-12">
									<label class="form-label">Select Payment Method</label>
									<input type="hidden" name="payment_method" value="" id="payment_method_hidden">
									<div id="payment-method-container" class="d-flex flex-wrap gap-3">
										<!-- Payment method options will be populated by JavaScript -->
									</div>
								</div>
							</div>
						</div>
						
						<!-- Form Actions -->
						<div class="d-flex justify-content-end mt-6 gap-3">
							<a href="{{ route('revenue.show', $revenue) }}" class="btn btn-light btn-lg px-6">
								Cancel
							</a>
							<button type="submit" class="btn btn-primary btn-lg px-6">
								<span class="svg-icon svg-icon-2 me-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M17.5 11H6.5L4 13.5L6.5 16H17.5L20 13.5L17.5 11Z" fill="currentColor"/>
										<path d="M12 2L15.09 8.26L22 9L17 14L18.18 21L12 17.77L5.82 21L7 14L2 9L8.91 8.26L12 2Z" fill="currentColor"/>
									</svg>
								</span>
								Update Revenue
							</button>
						</div> 
					</form> 
				</div>
			</div>
		</div>
	</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // ========================================
  // CONFIGURATION DATA
  // ========================================
  
  // Categories and Subcategories mapping
  const CATEGORIES_DATA = {
    revenue: {
      "Retainer Revenue": ["Digital Marketing", "Website Hosting", "Website Maintenance", "SEO Services", "Social Media"],
      "Project Revenue": ["Website Designing", "Outsource Work", "Photoshoot", "Video Editing", "Podcast"],
      "Consulting Revenue": ["Brand Consulting", "Technical Consulting"],
      "Rent Revenue": ["Photoshoot", "Podcast"],
      "Training Revenue": ["nil"] // no subcategories
    }
  };

  // Payment method options for revenue
  const PAYMENT_METHODS = {
    revenue: [
      { value: 'Cash', label: 'Cash' },
      { value: 'Repunext Acc', label: 'Repunext Acc' },
      { value: 'Repunext LLP Acc', label: 'Repunext LLP Acc' },
      { value: 'Normal Acc', label: 'Normal Acc' }
    ]
  };

  // ========================================
  // DOM ELEMENTS
  // ========================================
  
  const categorySel = document.getElementById('category');
  const subcategorySel = document.getElementById('subcategory');
  const paymentMethodContainer = document.getElementById('payment-method-container');

  // ========================================
  // CURRENT VALUES
  // ========================================
  
  const currentCategory = @json($revenue->category);
  const currentSubcategory = @json($revenue->subcategory);
  const currentPaymentMethod = @json($revenue->payment_method);

  // ========================================
  // UTILITY FUNCTIONS
  // ========================================
  
  /**
   * Clear and reset a select element
   * @param {HTMLSelectElement} select - The select element to clear
   * @param {string} placeholder - Placeholder text
   * @param {boolean} disabled - Whether to disable the select
   */
  function clearSelect(select, placeholder, disabled = false) {
    select.innerHTML = '';
    const opt = document.createElement('option');
    opt.value = '';
    opt.textContent = placeholder;
    opt.disabled = true;
    opt.selected = true;
    select.appendChild(opt);
    select.disabled = disabled;
  }

  // ========================================
  // CATEGORY MANAGEMENT FUNCTIONS
  // ========================================
  
  /**
   * Populate categories for revenue
   * @param {string} selectedCategory - Previously selected category
   */
  function populateCategories(selectedCategory = null) {
    clearSelect(categorySel, '— Select category —', false);
    clearSelect(subcategorySel, '— Select subcategory —', true);

    Object.keys(CATEGORIES_DATA.revenue).forEach(cat => {
      const option = document.createElement('option');
      option.value = cat;
      option.textContent = cat;
      if (selectedCategory && selectedCategory === cat) option.selected = true;
      categorySel.appendChild(option);
    });

    // If a category is already selected, populate its subcategories
    if (selectedCategory) {
      populateSubcategories(selectedCategory, currentSubcategory);
    }
  }

  /**
   * Populate subcategories based on selected category
   * @param {string} category - Selected category
   * @param {string} selectedSubcategory - Previously selected subcategory
   */
  function populateSubcategories(category, selectedSubcategory = null) {
    const subcategories = CATEGORIES_DATA.revenue[category] || [];
    clearSelect(subcategorySel, subcategories.length ? '— Select subcategory —' : '— Not applicable —', subcategories.length === 0);

    if (subcategories.length === 0) {
      subcategorySel.required = false; // no subcategory to choose
      return;
    }

    subcategorySel.required = true;
    subcategorySel.disabled = false;
    subcategories.forEach(subcat => {
      const option = document.createElement('option');
      option.value = subcat;
      option.textContent = subcat;
      if (selectedSubcategory && selectedSubcategory === subcat) option.selected = true;
      subcategorySel.appendChild(option);
    });
  }

  // ========================================
  // PAYMENT METHOD FUNCTIONS
  // ========================================
  
  /**
   * Populate payment methods for revenue
   * @param {string} selectedPaymentMethod - Previously selected payment method
   */
  function populatePaymentMethods(selectedPaymentMethod = null) {
    paymentMethodContainer.innerHTML = '';
    
    const methods = PAYMENT_METHODS.revenue;

    // Create a grid container for better layout
    const gridContainer = document.createElement('div');
    gridContainer.className = 'row g-3';
    
    methods.forEach((method, index) => {
      const colDiv = document.createElement('div');
      colDiv.className = 'col-lg-4 col-md-6';
      
      const formCheck = document.createElement('div');
      formCheck.className = 'form-check form-check-custom form-check-solid p-3 border rounded';
      formCheck.style.backgroundColor = '#f8f9fa';
      formCheck.style.transition = 'all 0.2s ease';
      
      const input = document.createElement('input');
      input.type = 'radio';
      input.name = 'payment_method';
      input.value = method.value;
      input.id = `payment_${method.value.replace(/\s+/g, '_').toLowerCase()}`;
      input.className = 'form-check-input';
      input.required = false;
      
      if (selectedPaymentMethod && selectedPaymentMethod === method.value) {
        input.checked = true;
        formCheck.style.backgroundColor = '#e3f2fd';
        formCheck.style.borderColor = '#009ef7';
        // Remove the hidden input since we have a pre-selected value
        const hiddenInput = document.getElementById('payment_method_hidden');
        if (hiddenInput) {
          hiddenInput.remove();
        }
      }
      
      const label = document.createElement('label');
      label.className = 'form-check-label fw-semibold w-100';
      label.htmlFor = input.id;
      label.textContent = method.label;
      label.style.cursor = 'pointer';
      
      // Add hover effect
      formCheck.addEventListener('mouseenter', function() {
        if (!input.checked) {
          this.style.backgroundColor = '#e9ecef';
        }
      });
      
      formCheck.addEventListener('mouseleave', function() {
        if (!input.checked) {
          this.style.backgroundColor = '#f8f9fa';
        }
      });
      
      // Add click effect
      formCheck.addEventListener('click', function() {
        input.checked = true;
        // Remove the hidden input since we have a selection
        const hiddenInput = document.getElementById('payment_method_hidden');
        if (hiddenInput) {
          hiddenInput.remove();
        }
        // Reset all other options
        document.querySelectorAll('#payment-method-container .form-check').forEach(check => {
          check.style.backgroundColor = '#f8f9fa';
          check.style.borderColor = '#e1e3ea';
        });
        // Highlight selected
        this.style.backgroundColor = '#e3f2fd';
        this.style.borderColor = '#009ef7';
      });
      
      formCheck.appendChild(input);
      formCheck.appendChild(label);
      colDiv.appendChild(formCheck);
      gridContainer.appendChild(colDiv);
    });
    
    paymentMethodContainer.appendChild(gridContainer);
  }

  // ========================================
  // EVENT LISTENERS
  // ========================================
  
  /**
   * Handle category selection changes
   */
  categorySel.addEventListener('change', function () {
    populateSubcategories(this.value);
  });

  // ========================================
  // INITIALIZATION
  // ========================================
  
  /**
   * Initialize form with current values
   */
  function initializeForm() {
    populateCategories(currentCategory);
    populatePaymentMethods(currentPaymentMethod);
  }

  // Initialize the form
  initializeForm();
});
</script>
@endsection
