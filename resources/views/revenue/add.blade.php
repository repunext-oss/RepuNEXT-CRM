

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
						<span class="card-label fw-bold fs-3 mb-1">Add</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> </span>
					</h3> 
				</div>
                
                @if ($errors->any())
                    <div class="error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
				<div class="card-body border-0 pt-0"> 
					<form action="{{ route('revenue.store') }}" method="post" class="form" enctype="multipart/form-data">
						@csrf
						
						<!-- Basic Information Section -->
						<div class="form-section">
							<div class="form-section-title">Basic Information</div>
							<div class="row g-4">
								<div class="col-lg-6">
									<label class="form-label required">Type</label>
									<div class="d-flex gap-4">
										<div class="form-check">
											<input class="form-check-input" type="radio" name="type" value="revenue" id="type_revenue" {{ old('type') == 'revenue' ? 'checked' : '' }}>
											<label class="form-check-label fw-semibold" for="type_revenue">Revenue</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="type" value="expense" id="type_expense" {{ old('type') == 'expense' ? 'checked' : '' }}>
											<label class="form-check-label fw-semibold" for="type_expense">Expense</label>
										</div>
									</div>
								</div>
								
								<div class="col-lg-6">
									<label for="website_name" class="form-label">Name</label>
									<input
										id="website_name"
										name="website_name"
										type="text"
										class="form-control"
										placeholder="e.g., enter a name"
										value="{{ old('website_name') }}"
										maxlength="191">
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
									<select name="subcategory" id="subcategory" class="form-select" required disabled>
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
										value="{{ old('amount') }}" 
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
									<label class="form-label required">Select Payment Method</label>
									<div id="payment-method-container" class="d-flex flex-wrap gap-3">
										<!-- Payment method options will be populated by JavaScript -->
									</div>
								</div>
							</div>
						</div>
						
						<!-- Form Actions -->
						<div class="d-flex justify-content-end mt-6">
							<button type="submit" class="btn btn-primary btn-lg px-6">
								<span class="svg-icon svg-icon-2 me-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
										<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"/>
									</svg>
								</span>
								Add Entry
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
    },
    expense: {
      "Administrative Expense": ["Office Rent & Utilities", "Office Stationaries", "Office Pantry", "Employee Accessories", "Repair & Maintenances", "Petty Cash"],
      "Marketing Expense": ["Travel Conveyance", "ATL Activities (Brand & Market reach)", "BTL Activities (Lead Generation)", "Classified Portals", "Auto Dialer", "Awards"],
      "HR Expense": ["Employee Salary", "Contract / Consultant Salary", "Bonus & Incentives", "Employment Welfare Program", "HR Software Monitoring"],
      "Office Asset": ["Electronics Equipments", "Electrical Equipments", "Furniture", "Others"],
      "Software License Expense": ["Software Licenses", "Subscriptions"],
      "Professional Services": ["Accounting", "Legal", "Banking"],
      "Tax Payments": ["GST Payment", "Income Tax Payment"],
      "Interest Payments": ["Interest Payments"]
    }
  };

  // Payment method options
  const PAYMENT_METHODS = {
    revenue: [
      { value: 'Cash', label: 'Cash' },
      { value: 'Repunext Acc', label: 'Repunext Acc' },
      { value: 'Repunext LLP Acc', label: 'Repunext LLP Acc' },
      { value: 'Normal Acc', label: 'Normal Acc' }
    ],
    expense: [
      { value: 'Cash', label: 'Cash' },
      { value: 'RepuNEXT Acc', label: 'RepuNEXT Acc' },
      { value: 'RepuNEXT LLP Acc', label: 'RepuNEXT LLP Acc' },
      { value: 'Normal Acc', label: 'Normal Acc' },
      { value: 'Credit Card', label: 'Credit Card' }
    ]
  };

  // ========================================
  // DOM ELEMENTS
  // ========================================
  
  const typeRadios = document.querySelectorAll('input[name="type"]');
  const categorySel = document.getElementById('category');
  const subcategorySel = document.getElementById('subcategory');
  const paymentMethodContainer = document.getElementById('payment-method-container');

  // ========================================
  // OLD VALUES (for form restoration)
  // ========================================
  
  const oldType = @json(old('type'));
  const oldCategory = @json(old('category'));
  const oldSubcategory = @json(old('subcategory'));
  const oldPaymentMethod = @json(old('payment_method'));

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
   * Populate categories based on selected type
   * @param {string} type - Revenue or Expense
   * @param {string} selectedCategory - Previously selected category
   */
  function populateCategories(type, selectedCategory = null) {
    clearSelect(categorySel, '— Select category —', false);
    clearSelect(subcategorySel, '— Select subcategory —', true);

    if (!type || !CATEGORIES_DATA[type]) return;

    Object.keys(CATEGORIES_DATA[type]).forEach(cat => {
      const option = document.createElement('option');
      option.value = cat;
      option.textContent = cat;
      if (selectedCategory && selectedCategory === cat) option.selected = true;
      categorySel.appendChild(option);
    });

    // If a category is already selected (e.g., after validation error), populate its subcategories
    if (selectedCategory) {
      populateSubcategories(type, selectedCategory, oldSubcategory);
    }
  }

  /**
   * Populate subcategories based on selected category
   * @param {string} type - Revenue or Expense
   * @param {string} category - Selected category
   * @param {string} selectedSubcategory - Previously selected subcategory
   */
  function populateSubcategories(type, category, selectedSubcategory = null) {
    const subcategories = (CATEGORIES_DATA[type] && CATEGORIES_DATA[type][category]) ? CATEGORIES_DATA[type][category] : [];
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
   * Populate payment methods based on selected type
   * @param {string} type - Revenue or Expense
   * @param {string} selectedPaymentMethod - Previously selected payment method
   */
  function populatePaymentMethods(type, selectedPaymentMethod = null) {
    paymentMethodContainer.innerHTML = '';
    
    if (!type || !PAYMENT_METHODS[type]) return;

    const methods = PAYMENT_METHODS[type];

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
      input.required = true;
      
      if (selectedPaymentMethod && selectedPaymentMethod === method.value) {
        input.checked = true;
        formCheck.style.backgroundColor = '#e3f2fd';
        formCheck.style.borderColor = '#009ef7';
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
   * Handle type radio button changes
   */
  typeRadios.forEach(radio => {
    radio.addEventListener('change', (e) => {
      const selectedType = e.target.value;
      populateCategories(selectedType);
      populatePaymentMethods(selectedType);
    });
  });

  /**
   * Handle category selection changes
   */
  categorySel.addEventListener('change', function () {
    const selectedType = [...typeRadios].find(r => r.checked)?.value;
    populateSubcategories(selectedType, this.value);
  });

  // ========================================
  // INITIALIZATION
  // ========================================
  
  /**
   * Initialize form with old values if available (for form restoration after validation errors)
   */
  function initializeForm() {
    if (oldType) {
      // Ensure the matching radio is checked
      const radio = [...typeRadios].find(r => r.value === oldType);
      if (radio) radio.checked = true;
      
      // Populate form fields with old values
      populateCategories(oldType, oldCategory);
      populatePaymentMethods(oldType, oldPaymentMethod);
    }
  }

  // Initialize the form
  initializeForm();
});
</script>
@endsection

 