@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header ">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Add</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / User</span>
					</h3>  
				</div>
			</div>
		
		<form action="{{route('store.userlist')}}" method="post" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row pt-5" >
			@csrf
			<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
				<div class="card card-flush py-4">
					<div class="card-header"> 
						<div class="card-title">
							<h2>Profile Image</h2>
						</div>	
					</div>
					<div class="card-body text-center pt-0">
						<div class="image-input image-input-outline image-input-placeholder mb-3" data-kt-image-input="true" style="background-image: url({{asset('upload/product-images/default-product.svg')}});">
							<div class="image-input-wrapper w-150px h-150px" style="background-image:url({{(!empty($ayur->product_image))? url('upload/product-images/'.$ayur->product_image):url('upload/default-product.svg');}});">
							</div>
							<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
								<i class="bi bi-pencil-fill fs-7"></i>
								<input type="file" name="profile_image" accept=".png, .jpg, .jpeg" />
								<input type="hidden" name="avatar_remove" />
							</label>
							<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
								<i class="bi bi-x fs-2"></i>
							</span>
							<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
								<i class="bi bi-x fs-2"></i>
							</span>
						</div>
						<div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
					</div>
				</div>
				<div class="card card-flush py-4">
					<div class="card-header">
						<div class="card-title">
							<h2>Status</h2>
						</div>
					</div> 
					<div class="card-body pt-0"> 
						<select class="form-select mb-2 form-control" name="status" data-control="select2" data-hide-search="true" data-placeholder="Select an option" >
							<option></option> 
							<option value="0" >Inactive</option> 
							<option value="1" selected="selected">Active</option>
						</select> 
						<div class="text-muted fs-7">Set the product status.</div>  
					</div> 
				</div>   
			</div> 


			<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">  
				<div class="tab-content"> 
					<div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
						<div class="d-flex flex-column gap-7 gap-lg-10"> 
							<div class="card card-flush py-4">  
								<div class="card-body pt-0"> 
									<div class="row ">
										<div class="col-lg-3">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Employee Code</label>
											<input type="text" name="employee_id" required class="form-control form-control-lg  mb-3 mb-lg-0" placeholder="Product code" value="RN{{substr(((10000)),1)}}"  />
										</div> 
										<div class="col-lg-5">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Employee Name</label>
											<input type="text" name="name" required class="form-control mb-2 mb-lg-0" placeholder="Employee Name" />
											<!-- <div class="text-muted fs-7">A product name is required and recommended to be unique. Example: Product Name and Unit</div> -->
										</div> 
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Job Designation</label>
											<input type="text" name="job_title" required class="form-control form-control-lg  mb-3 mb-lg-0" placeholder="Job Title" />
										</div> 
									</div>
									<div class="row ">
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">User Name</label>
											<input type="text" name="username" required class="form-control mb-2 mb-lg-0" placeholder="User Name" />
											<!-- <div class="text-muted fs-7">A product name is required and recommended to be unique. Example: Product Name and Unit</div> -->
										</div> 
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Password</label>
											<input type="text" name="password" required class="form-control mb-2 mb-lg-0" placeholder="Password" value="Welcome@321!"/>
											<!-- <div class="text-muted fs-7">A product name is required and recommended to be unique. Example: Product Name and Unit</div> -->
										</div> 
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Email</label>
											<input type="text" name="email" required class="form-control mb-2 mb-lg-0" placeholder="Email" />
											<!-- <div class="text-muted fs-7">A product name is required and recommended to be unique. Example: Product Name and Unit</div> -->
										</div>   
									</div>
									<div class="row ">
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Phone</label>
											<input type="text" name="phone" required class="form-control mb-2 mb-lg-0" placeholder="Phone no" />
											<!-- <div class="text-muted fs-7">A product name is required and recommended to be unique. Example: Product Name and Unit</div> -->
										</div>
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Date of Birth</label>
											<input type="date" name="dob" required class="form-control mb-2 mb-lg-0" placeholder="DOB" />
											<!-- <div class="text-muted fs-7">A product name is required and recommended to be unique. Example: Product Name and Unit</div> -->
										</div>
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Date of Joining</label>
											<input type="date" name="doj" required class="form-control mb-2 mb-lg-0" placeholder="DOJ" />
											<!-- <div class="text-muted fs-7">A product name is required and recommended to be unique. Example: Product Name and Unit</div> -->
										</div>
									</div>	 
									<div class="row ">
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Grade</label>
											<input type="text" name="grade" required class="form-control mb-2 mb-lg-0" placeholder="Grade" />
											<!-- <div class="text-muted fs-7">A product name is required and recommended to be unique. Example: Product Name and Unit</div> -->
										</div>
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Level</label>
											<input type="text" name="level" required class="form-control mb-2 mb-lg-0" placeholder="Level" />
											<!-- <div class="text-muted fs-7">A product name is required and recommended to be unique. Example: Product Name and Unit</div> -->
										</div>
										<div class="col-lg-4">
											<label class="col-lg-12 col-form-label required fw-bold fs-6">Role</label>
											<select name="role" class="form-control form-control-solid mb-3 mb-lg-0">
												@foreach ($roledetails as $roledetail)
													<option>{{ucwords($roledetail->role_name);}}</option>
												@endforeach
											</select>
										</div> 
									</div>	 
									<div class="row mt-5">
										<div class="col-lg-12 mt-5">
											<div class="d-flex justify-content-end">
												<a href="{{route('list.user')}}" class="btn btn-light-success me-2"> Cancel </a>
												<button type="submit" class="btn btn-primary">Save</button>  
											</div>
										</div> 
									</div>	  
								</div> 
							</div>  
						</div>
					</div>  
				</div>   
			</div> 
		</form> 
		</div>
	</div>
</div>
@endsection
