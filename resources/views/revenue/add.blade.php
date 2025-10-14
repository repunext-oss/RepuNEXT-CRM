

@extends('admin.admin_master')
@section('admin')
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
						<div class="row">
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Type</label>
								<label class="me-6"><input type="radio" name="type" value="revenue" ...> Revenue</label>
                                <label class="me-6"><input type="radio" name="type" value="expense" ...> Expense</label>

							</div>  
              <div class="col-lg-4 fv-row">
                            <label for="website_name" class="col-lg-12 col-form-label fw-bold fs-6">Name</label>
                            <input
                              id="website_name"
                              name="website_name"
                              type="text"
                              class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                              placeholder="e.g., enter a name"
                              value="{{ old('website_name') }}"
                              maxlength="191">
                          </div>
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Category</label>
                                    <select name="category" id="category"
                                            class="form-select form-select-lg form-select-solid mb-3 mb-lg-0" required>
                                    <option value="" selected disabled>— Select category —</option>
                                    </select>
                            </div>
                            
					              	</div> 
            

                        <div class="row">  
                        	<div class="col-lg-6 fv-row">
								   <label class="col-lg-12 col-form-label fw-bold fs-6">Subcategory</label>
                                    <select name="subcategory" id="subcategory"
                                            class="form-select form-select-lg form-select-solid mb-3 mb-lg-0" required disabled>
                                    <option value="" selected disabled>— Select subcategory —</option>
                                    </select>
                            </div>
                            <div class="col-lg-6 fv-row"> 
                                 <label for="amount" class="col-lg-12 col-form-label required fw-bold fs-6">Amount</label>
                                 <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 " id="amount" type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0" placeholder="0.00" required>
                            </div>
						</div> 
						<br> 
						<div class="card-footer d-flex justify-content-end py-6 px-9" >
							<!-- <a href="{{route('revenue-expense.index')}}" class="btn btn-light-success me-2"> Cancel </a> -->
							<button type="submit" class="btn btn-primary">Add</button>  
						</div> 
					</form> 
				</div>
			</div>
		</div>
	</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Map of Types → Categories → Subcategories
  const DATA = {
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

  const typeRadios = document.querySelectorAll('input[name="type"]');
  const categorySel = document.getElementById('category');
  const subcategorySel = document.getElementById('subcategory');

  const oldType = @json(old('type'));
  const oldCategory = @json(old('category'));
  const oldSubcategory = @json(old('subcategory'));

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

  function populateCategories(type, selectedCategory = null) {
    clearSelect(categorySel, '— Select category —', false);
    clearSelect(subcategorySel, '— Select subcategory —', true);

    if (!type || !DATA[type]) return;

    Object.keys(DATA[type]).forEach(cat => {
      const o = document.createElement('option');
      o.value = cat;
      o.textContent = cat;
      if (selectedCategory && selectedCategory === cat) o.selected = true;
      categorySel.appendChild(o);
    });

    // If a category is already selected (e.g., after validation error), populate its subcategories
    if (selectedCategory) {
      populateSubcategories(type, selectedCategory, oldSubcategory);
    }
  }

  function populateSubcategories(type, category, selectedSubcategory = null) {
    const list = (DATA[type] && DATA[type][category]) ? DATA[type][category] : [];
    clearSelect(subcategorySel, list.length ? '— Select subcategory —' : '— Not applicable —', list.length === 0);

    if (list.length === 0) {
      subcategorySel.required = false; // no subcategory to choose
      return;
    }

    subcategorySel.required = true;
    subcategorySel.disabled = false;
    list.forEach(sc => {
      const o = document.createElement('option');
      o.value = sc;
      o.textContent = sc;
      if (selectedSubcategory && selectedSubcategory === sc) o.selected = true;
      subcategorySel.appendChild(o);
    });
  }

  // Radio change → (re)populate categories
  typeRadios.forEach(r => {
    r.addEventListener('change', (e) => {
      populateCategories(e.target.value);
    });
  });

  // Category change → (re)populate subcategories
  categorySel.addEventListener('change', function () {
    const chosenType = [...typeRadios].find(r => r.checked)?.value;
    populateSubcategories(chosenType, this.value);
  });

  // Initial load: restore old() or wait for user to select
  if (oldType) {
    // Ensure the matching radio is checked if not already
    const radio = [...typeRadios].find(r => r.value === oldType);
    if (radio) radio.checked = true;
    populateCategories(oldType, oldCategory);
  }
});
</script>
@endsection

 