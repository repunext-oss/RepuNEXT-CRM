@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div id="kt_content_container" class="container-xxl">
			<div class="row">
			<div class="col-md-12"> 
				<div class="card mb-5 mb-xl-10">
					<div class="card-header border-0 pt-6">
						<div class="d-flex align-items-center" id="kt_header_wrapper">
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-20 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_wrapper'}">
								<h1 class="text-dark fw-bold my-1 fs-3 lh-1">Role Management</h1>
								<ul class="breadcrumb fw-semibold fs-8 my-1">
									<li class="breadcrumb-item text-muted">
										<a href="{route('dashboard')}}" class="text-muted">Home</a>
									</li>
									<li class="breadcrumb-item text-muted"> Role </li>
									<li class="breadcrumb-item text-muted"> List </li>
								</ul>
							</div>
						</div>
						<a href="#" class="btn btn-primary align-self-center" style="float: right;" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">Add Role</a>
						
					</div>
					<br>
				</div>
				</div>
			</div>
		</div>
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div id="kt_content_container" class="container-xxl">
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9"> 
				@foreach ($roles as $rolelist) 
				<div class="col-md-4"> 
					<div class="card card-flush h-md-100"> 
						<div class="card-header">
							<div class="card-title">
								<h2>{{ucwords($rolelist->role_name);}}</h2>
							</div>
						</div>
						<div class="card-body pt-1">
							<div class="d-flex flex-column text-gray-600">
							@if($rolelist->role=="kt_roles_select_all")
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>All Admin Controls</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Dealers</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Service Provider</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Pilots</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Farmers</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Master</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create User Management</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Role Management</div>
							@endif
							<?php $rolelists=explode(",",$rolelist->role);?>
								@if(in_array("dealers_read",$rolelists, TRUE)||in_array(" dealers_write",$rolelists, TRUE)||in_array(" dealers_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>
									@if(in_array("dealers_read",$rolelists, TRUE))
										Read Dealers,
									@endif
									@if(in_array("dealers_write",$rolelists, TRUE))
										Write Dealers,
									@endif
									@if(in_array("dealers_create",$rolelists, TRUE))
										Create Dealers
									@endif
								</div>
								@endif
								@if(in_array("service_provider_read",$rolelists, TRUE)||in_array("service_provider_write",$rolelists, TRUE)||in_array("service_provider_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>
									@if(in_array("service_provider_read",$rolelists, TRUE))
										Read Service Provider,
									@endif
									@if(in_array("service_provider_write",$rolelists, TRUE))
										Write Service Provider,
									@endif
									@if(in_array("service_provider_create",$rolelists, TRUE))
										Create Service Provider
									@endif
								</div>
								@endif
								@if(in_array("pilots_read",$rolelists, TRUE)||in_array("pilots_write",$rolelists, TRUE)||in_array("pilots_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>
									@if(in_array("pilots_read",$rolelists, TRUE))
										Read Pilots,
									@endif
									@if(in_array("pilots_write",$rolelists, TRUE))
										Write Pilots,
									@endif
									@if(in_array("pilots_create",$rolelists, TRUE))
										Create Pilots
									@endif
								</div>
								@endif
								@if(in_array("farmers_read",$rolelists, TRUE)||in_array("farmers_write",$rolelists, TRUE)||in_array("farmers_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("farmers_read",$rolelists, TRUE))
										Read Farmers,
									@endif
									@if(in_array("farmers_write",$rolelists, TRUE))
										Write Farmers,
									@endif
									@if(in_array("farmers_create",$rolelists, TRUE))
										Create Farmers
									@endif
								</div>
								@endif
								@if(in_array("master_read",$rolelists, TRUE)||in_array(" master_write",$rolelists, TRUE)||in_array(" master_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("master_read",$rolelists, TRUE))
										Read Master,
									@endif
									@if(in_array("master_write",$rolelists, TRUE))
										Write Master,
									@endif
									@if(in_array("master_create",$rolelists, TRUE))
										Create Master
									@endif
								</div>
								@endif
								@if(in_array("user_management_read",$rolelists, TRUE)||in_array("user_management_write",$rolelists, TRUE)||in_array("user_management_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("user_management_read",$rolelists, TRUE))
										Read User Management,
									@endif
									@if(in_array("user_management_write",$rolelists, TRUE))
										Write User Management,
									@endif
									@if(in_array("user_management_create",$rolelists, TRUE))
										Create User Management
									@endif
								</div>
								@endif
								@if(in_array(" role_management_read",$rolelists, TRUE)||in_array(" role_management_write",$rolelists, TRUE)||in_array(" role_management_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("role_management_read",$rolelists, TRUE))
										Role Management Read,
									@endif
									@if(in_array("role_management_write",$rolelists, TRUE))
										Role Management Write,
									@endif
									@if(in_array("role_management_create",$rolelists, TRUE))
										Role Management Create,
									@endif
								</div>
								@endif
								@if(in_array("coe_read",$rolelists, TRUE)||in_array("coe_write",$rolelists, TRUE)||in_array("coe_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("coe_read",$rolelists, TRUE))
										COE Management Read,
									@endif
									@if(in_array("coe_write",$rolelists, TRUE))
										COE Management Write,
									@endif
									@if(in_array("coe_create",$rolelists, TRUE))
										COE Management Create,
									@endif
								</div>
								@endif
								@if(in_array("student_read",$rolelists, TRUE)||in_array("student_write",$rolelists, TRUE)||in_array("student_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("student_read",$rolelists, TRUE))
										Student Management Read,
									@endif
									@if(in_array("student_write",$rolelists, TRUE))
										Student Management Write,
									@endif
									@if(in_array("student_create",$rolelists, TRUE))
										Student Management Create,
									@endif
								</div>
								@endif
								@if(in_array("cms_read",$rolelists, TRUE)||in_array("cms_write",$rolelists, TRUE)||in_array("cms_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("cms_read",$rolelists, TRUE))
										CMS Management Read,
									@endif
									@if(in_array("cms_write",$rolelists, TRUE))
										CMS Management Write,
									@endif
									@if(in_array("cms_create",$rolelists, TRUE))
										CMS Management Create,
									@endif
								</div>
								@endif
								@if(in_array("lms_read",$rolelists, TRUE)||in_array("lms_write",$rolelists, TRUE)||in_array("lms_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("lms_read",$rolelists, TRUE))
										LMS Management Read,
									@endif
									@if(in_array("lms_write",$rolelists, TRUE))
										LMS Management Write,
									@endif
									@if(in_array("lms_create",$rolelists, TRUE))
										LMS Management Create,
									@endif
								</div>
								@endif
								@if(in_array("training_read",$rolelists, TRUE)||in_array("training_write",$rolelists, TRUE)||in_array("training_create",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("training_read",$rolelists, TRUE))
										Student Training Read,
									@endif
									@if(in_array("training_write",$rolelists, TRUE))
										Student Training Write,
									@endif
									@if(in_array("training_create",$rolelists, TRUE))
										Student Training Create,
									@endif
								</div>
								@endif


							</div>
						</div> 

						<div class="card-footer flex-wrap pt-0">
							<div class="ro-ed-lt"> 
								<form method="POST" class="btn" action="{{route('edit.rolelist')}}">
									@csrf
									<input type="hidden" value="{{$rolelist->id}}" name="id">
									<button type="submit" class="btn btn-light btn-active-primary my-1 me-2" data-bs-target="#kt_modal_update_role" >Edit Role</button> 
								</form> 
							</div>
							@if($rolelist->role_name!="Coe Admin" && $rolelist->role_name!="Admin")
							<div class="ro-ed-rt"> 
								<form method="POST" class="btn" action="{{route('delete.rolelist')}}">
									@csrf
									<input type="hidden" value="{{$rolelist->id}}" name="id">
									<button type="submit" class="btn btn-light btn-active-light-primary my-1" onclick="deleterole()">Delete Role</button>
								</form> 
							</div> 
							@endif
						</div>
					</div>
				</div>
				@endforeach
			</div>
			<!--end::Row-->
			<!--begin::Modals-->
			<!--begin::Modal - Add role-->
			<div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true"> 	<!--begin::Modal dialog-->
				<div class="modal-dialog modal-dialog-centered mw-750px">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header">
							<!--begin::Modal title-->
							<h2 class="fw-bolder">Add a Role</h2>
							<!--end::Modal title-->
							<!--begin::Close--> 
							<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
								<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
								</span>
							<!--end::Svg Icon-->
							</div>
							<!--end::Close-->
						</div>
						<!--end::Modal header-->
						<!--begin::Modal body-->
						<div class="modal-body scroll-y mx-lg-5 my-7">
							<!--begin::Form-->
							<form  class="form" action="{{route('store.rolelist')}}" method="POST">
							@csrf
								<!--begin::Scroll-->
								<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
									<!--begin::Input group-->
									<div class="fv-row mb-10">
										<!--begin::Label-->
										<label class="fs-5 fw-bolder form-label mb-2">
										<span class="required">Role name</span>
										</label>
										<!--end::Label-->
										<!--begin::Input-->
										<input class="form-control form-control-solid" placeholder="Enter a role name" name="role_name" required />
										<!--end::Input-->
									</div>
									<!--end::Input group-->
									<!--begin::Permissions-->
									<div class="fv-row">
									<!--begin::Label-->
										<label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
										<!--end::Label-->
										<!--begin::Table wrapper-->
										<div class="table-responsive">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5">
												<!--begin::Table body-->
											<tbody class="text-gray-600 fw-bold">
													<!--begin::Table row-->
												<tr>
													<td class="text-gray-800">Administrator Access
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allows a full access to the system"></i></td>
													<td>
														<!--begin::Checkbox-->
														<label class="form-check form-check-custom form-check-solid me-9">
															<input class="form-check-input" type="checkbox" value="kt_roles_select_all" id="kt_roles_select_all" name="kt_roles_select_all" />
															<span class="form-check-label" for="kt_roles_select_all">Select all</span>
														</label>
														<!--end::Checkbox-->
													</td>
												</tr>
									<tr>
										<td class="text-gray-800">Dealers</td>
										<!--end::Label--> <!--begin::Options-->
										<td> <!--begin::Wrapper-->
											<div class="d-flex">
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="dealers_read" name="dealers_read" />
													<span class="form-check-label">Read</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="dealers_write" name="dealers_write" />
													<span class="form-check-label">Write</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="dealers_create" name="dealers_create" />
													<span class="form-check-label">Create</span>
												</label>
												<!--end::Checkbox-->
											</div>
										<!--end::Wrapper-->
										</td>
										<!--end::Options-->
									</tr>
									<tr> <!--begin::Label-->
										<td class="text-gray-800">Service Provider</td>
										<!--end::Label--> <!--begin::Options-->
										<td> <!--begin::Wrapper-->
											<div class="d-flex">
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="service_provider_read" name="service_provider_read" />
													<span class="form-check-label">Read</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="service_provider_write" name="service_provider_write" />
													<span class="form-check-label">Write</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="service_provider_create" name="service_provider_create" />
													<span class="form-check-label">Create</span>
												</label>
												<!--end::Checkbox-->
											</div>
										<!--end::Wrapper-->
										</td>
										<!--end::Options-->
									</tr>
									<tr> <!--begin::Label-->
										<td class="text-gray-800">Pilots</td>
										<!--end::Label--> <!--begin::Options-->
										<td> <!--begin::Wrapper-->
											<div class="d-flex">
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="pilots_read" name="pilots_read" />
													<span class="form-check-label">Read</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="pilots_write" name="pilots_write" />
													<span class="form-check-label">Write</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="pilots_create" name="pilots_create" />
													<span class="form-check-label">Create</span>
												</label>
												<!--end::Checkbox-->
											</div>
										<!--end::Wrapper-->
										</td>
										<!--end::Options-->
									</tr>
									<tr> <!--begin::Label-->
										<td class="text-gray-800">Farmers</td>
										<!--end::Label--> <!--begin::Options-->
										<td> <!--begin::Wrapper-->
											<div class="d-flex">
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="farmers_read" name="farmers_read" />
													<span class="form-check-label">Read</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="farmers_write" name="farmers_write" />
													<span class="form-check-label">Write</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="farmers_create" name="farmers_create" />
													<span class="form-check-label">Create</span>
												</label> <!--end::Checkbox-->
											</div> <!--end::Wrapper-->
										</td> <!--end::Options-->
									</tr>
									<tr> <!--begin::Label-->
										<td class="text-gray-800">Master</td>
										<!--end::Label--> <!--begin::Options-->
										<td> <!--begin::Wrapper-->
											<div class="d-flex">
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="master_read" name="master_read" />
													<span class="form-check-label">Read</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="master_write" name="master_write" />
													<span class="form-check-label">Write</span>
												</label>
												<!--end::Checkbox-->
												<!--begin::Checkbox-->
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="master_create" name="master_create" />
													<span class="form-check-label">Create</span>
												</label>
												<!--end::Checkbox-->
											</div>
										<!--end::Wrapper-->
										</td>
										<!--end::Options-->
									</tr>
									<tr> <!--begin::Label-->
										<td class="text-gray-800">User Management</td>
										<!--end::Label--> <!--begin::Options-->
										<td> <!--begin::Wrapper-->
											<div class="d-flex">
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="user_management_read" name="user_management_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="user_management_write" name="user_management_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="user_management_create" name="user_management_create" />
													<span class="form-check-label">Create</span>
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-gray-800">Role Management</td>
										<td> 
											<div class="d-flex">
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="role_management_read" name="role_management_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="role_management_write" name="role_management_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="role_management_create" name="role_management_create" />
													<span class="form-check-label">Create</span>
												</label>
											</div>
										</td>
									</tr>
									<tr> 
										<td class="text-gray-800">COE Management</td>
										<td>
											<div class="d-flex">
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="coe_read" name="coe_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="coe_write" name="coe_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="coe_create" name="coe_create" />
													<span class="form-check-label">Create</span>
												</label>
											</div>
										</td>
									</tr>
									<tr> 
										<td class="text-gray-800">Student Management</td>
										<td> 
											<div class="d-flex">
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="student_read" name="student_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="student_write" name="student_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="student_create" name="student_create" />
													<span class="form-check-label">Create</span>
												</label>
											</div>
										</td>
									</tr>
									<tr> 
										<td class="text-gray-800">LMS</td>
										<td> 
											<div class="d-flex">
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="lms_read" name="lms_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="lms_write" name="lms_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="lms_create" name="lms_create" />
													<span class="form-check-label">Create</span>
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-gray-800">CMS</td>
										<td> 
											<div class="d-flex">
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="cms_read" name="cms_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="cms_write" name="cms_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="cms_create" name="cms_create" />
													<span class="form-check-label">Create</span>
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td class="text-gray-800">Student Training </td>
										<td> 
											<div class="d-flex">
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="training_read" name="training_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
													<input class="form-check-input" type="checkbox" value="training_write" name="training_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="training_create" name="training_create" />
													<span class="form-check-label">Create</span>
												</label>
											</div>
										</td>
									</tr>
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="text-center pt-15">
						<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
						<button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit" name="addrolesubmit">
						<span class="indicator-label">Submit</span>
						<span class="indicator-progress">Please wait...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
						</button>
					</div>
				</form>
			</div>
			</div>
			</div>
			</div>
		</div>
	</div>
</div>
@endsection