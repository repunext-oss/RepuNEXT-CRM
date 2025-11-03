
@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div id="kt_content_container" class="container-xxl">
			<div class="col-md-12">
				<div class="card "> 
					<div class="card-header">
						<div class="d-flex align-items-center" id="kt_header_wrapper">
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-20 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_wrapper'}">
								<h1 class="text-dark fw-bold my-1 fs-3 lh-1">Role Edit</h1>
								<ul class="breadcrumb fw-semibold fs-8 my-1">
									<li class="breadcrumb-item text-muted">
										<a href="{route('dashboard')}}" class="text-muted">Home</a>
									</li>
									<li class="breadcrumb-item text-muted"> Role </li>
									<li class="breadcrumb-item text-muted"> Edit </li>
								</ul>
							</div>
						</div> 
					</div>
					<div class="card-body pt-1">
						@foreach ($editrole as $editroles) 
						<form class="form" action="{{route('update.rolelist')}}" method="POST">
						@csrf 
						<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
							<div class="fv-row mb-10">
								<label class="fs-5 fw-bolder form-label mb-2">
									<span class="required">Role name</span> </label>
									<input type="text" class="form-control form-control-solid" value="{{$editroles->role_name}}" name="role_name" />
									<input type="hidden"  value="{{$editroles->id}}" name="role_id" />
							</div>
							<div class="fv-row"> 
								<label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
								<div class="table-responsive">
									<table class="table align-middle table-row-dashed fs-6 gy-5">
										<tbody class="text-gray-600 fw-bold">
										<tr>
											<td class="text-gray-800">Administrator Access
												<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allows a full access to the system"></i></td>
											<td>
												<label class="form-check form-check-custom form-check-solid me-9">
													<input class="form-check-input" type="checkbox" value="kt_roles_select_all" id="kt_roles_select_all" name="kt_roles_select_all"@if($editroles->role=="kt_roles_select_all")checked @endif />
													<span class="form-check-label" for="kt_roles_select_all">Select all</span>
												</label>
											</td>
										</tr>
											<?php $editrole=explode(",",$editroles->role);?>
											<!-- User Management -->
											<tr>
											<td class="text-gray-800">User Management</td>
											<td>
												<div class="d-flex justify-content-between">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="user_management_all" name="user_management_all" @if(in_array("user_management_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="user_management_read" name="user_management_read" @if(in_array("user_management_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="user_management_write" name="user_management_write" @if(in_array("user_management_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="user_management_create" name="user_management_create" @if(in_array("user_management_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="user_management_delete" name="user_management_delete" @if(in_array("user_management_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
										
										<!-- Role Management -->
										<tr>
											<td class="text-gray-800">Role Management</td>
											<td>
												<div class="d-flex justify-content-between">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="role_management_all" name="role_management_all" @if(in_array("role_management_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="role_management_read" name="role_management_read" @if(in_array("role_management_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="role_management_write" name="role_management_write" @if(in_array("role_management_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="role_management_create" name="role_management_create" @if(in_array("role_management_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="role_management_delete" name="role_management_delete" @if(in_array("role_management_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Call Center Management -->
										<tr>
											<td class="text-gray-800">Enquiry List</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="enquiry_all" name="enquiry_all" @if(in_array("enquiry_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="enquiry_read" name="enquiry_read" @if(in_array("enquiry_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="enquiry_write" name="enquiry_write" @if(in_array("enquiry_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="enquiry_create" name="enquiry_create" @if(in_array("enquiry_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="enquiry_delete" name="enquiry_delete" @if(in_array("enquiry_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
										<!-- Followup List -->

										<tr>
											<td class="text-gray-800">Followup List</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="followup_all" name="followup_all" @if(in_array("followup_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="followup_read" name="followup_read" @if(in_array("followup_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="followup_write" name="followup_write" @if(in_array("followup_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="followup_create" name="followup_create" @if(in_array("followup_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="followup_delete" name="followup_delete" @if(in_array("followup_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Leave -->

										<tr>
											<td class="text-gray-800">Leave</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="leave_all" name="leave_all" @if(in_array("leave_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="leave_read" name="leave_read" @if(in_array("leave_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="leave_write" name="leave_write" @if(in_array("leave_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="leave_create" name="leave_create" @if(in_array("leave_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="leave_delete" name="leave_delete" @if(in_array("leave_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
										
										<!-- Task Management -->
										<!-- Goal Sheet -->
										<tr>
											<td class="text-gray-800">GoalSheet Category</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_category_all" name="goalsheet_category_all" @if(in_array("goalsheet_category_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_category_read" name="goalsheet_category_read" @if(in_array("goalsheet_category_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_category_write" name="goalsheet_category_write" @if(in_array("goalsheet_category_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_category_create" name="goalsheet_category_create" @if(in_array("goalsheet_category_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_category_delete" name="goalsheet_category_delete" @if(in_array("goalsheet_category_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
										<!-- Goal Sheet-->
										<tr>
											<td class="text-gray-800">Goal Sheet</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_all" name="goalsheet_all" @if(in_array("goalsheet_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_read" name="goalsheet_read" @if(in_array("goalsheet_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_write" name="goalsheet_write" @if(in_array("goalsheet_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_create" name="goalsheet_create" @if(in_array("goalsheet_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="goalsheet_delete" name="goalsheet_delete" @if(in_array("goalsheet_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Project Management -->
										 <!-- project -->
										 <tr>
											<td class="text-gray-800">Project List</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="project_all" name="project_all" @if(in_array("project_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="project_read" name="project_read" @if(in_array("project_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="project_write" name="project_write" @if(in_array("project_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="project_create" name="project_create" @if(in_array("project_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="project_delete" name="project_delete" @if(in_array("project_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Service List -->
										<tr>
											<td class="text-gray-800">Service List</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="service_all" name="service_all" @if(in_array("service_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="service_read" name="service_read" @if(in_array("service_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="service_write" name="service_write" @if(in_array("service_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="service_create" name="service_create" @if(in_array("service_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="service_delete" name="service_delete" @if(in_array("service_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Domain Management -->
										<tr>
										<tr>
											<td class="text-gray-800">Domain Management</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="domain_all" name="domain_all" @if(in_array("domain_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="domain_read" name="domain_read" @if(in_array("domain_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="domain_write" name="domain_write" @if(in_array("domain_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="domain_create" name="domain_create" @if(in_array("domain_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="domain_delete" name="domain_delete" @if(in_array("domain_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Tools Management -->
										<tr>
											<td class="text-gray-800">Tools & Resources List</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tool_all" name="tool_all" @if(in_array("tool_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tool_read" name="tool_read" @if(in_array("tool_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tool_write" name="tool_write" @if(in_array("tool_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tool_create" name="tool_create" @if(in_array("tool_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tool_delete" name="tool_delete" @if(in_array("tool_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
										<!-- Tools Login Credentials -->
										<tr>
											<td class="text-gray-800">Tools Login Credentials</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="toolc_all" name="toolc_all" @if(in_array("toolc_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="toolc_read" name="toolc_read" @if(in_array("toolc_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="toolc_write" name="toolc_write" @if(in_array("toolc_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="toolc_create" name="toolc_create" @if(in_array("toolc_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="toolc_delete" name="toolc_delete" @if(in_array("toolc_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- TimeSheet -->
										<tr>
											<td class="text-gray-800">Timesheet</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_all" name="timesheet_all" @if(in_array("timesheet_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_read" name="timesheet_read" @if(in_array("timesheet_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_write" name="timesheet_write" @if(in_array("timesheet_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_create" name="timesheet_create" @if(in_array("timesheet_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_delete" name="timesheet_delete" @if(in_array("timesheet_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- TimeSheet Category -->
										<tr>
											<td class="text-gray-800">TimeSheet Category</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_category_all" name="timesheet_category_all" @if(in_array("timesheet_category_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_category_read" name="timesheet_category_read" @if(in_array("timesheet_category_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_category_write" name="timesheet_category_write" @if(in_array("timesheet_category_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_category_create" name="timesheet_category_create" @if(in_array("timesheet_category_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="timesheet_category_delete" name="timesheet_category_delete" @if(in_array("timesheet_category_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
 
										

										


										<!-- SubDomain List -->
										<tr>
											<td class="text-gray-800">SubDomain List</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="subdomain_all" name="subdomain_all" @if(in_array("subdomain_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
											 			<input class="form-check-input" type="checkbox" value="subdomain_read" name="subdomain_read" @if(in_array("subdomain_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="subdomain_write" name="subdomain_write" @if(in_array("subdomain_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="subdomain_create" name="subdomain_create" @if(in_array("subdomain_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="subdomain_delete" name="subdomain_delete" @if(in_array("subdomain_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Social Media -->
										<tr>
											<td class="text-gray-800">Social Media</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sm_all" name="sm_all" @if(in_array("sm_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sm_read" name="sm_read" @if(in_array("sm_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sm_write" name="sm_write" @if(in_array("sm_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sm_create" name="sm_create" @if(in_array("sm_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sm_delete" name="sm_delete" @if(in_array("sm_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Knowledge Management -->
										<tr>
											<td class="text-gray-800">Training Videos</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tvideo_all" name="tvideo_all" @if(in_array("tvideo_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tvideo_read" name="tvideo_read" @if(in_array("tvideo_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tvideo_write" name="tvideo_write" @if(in_array("tvideo_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tvideo_create" name="tvideo_create" @if(in_array("tvideo_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="tvideo_delete" name="tvideo_delete" @if(in_array("tvideo_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<tr>
											<td class="text-gray-800">Corporate Videos</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="cvideo_all" name="cvideo_all" @if(in_array("cvideo_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="cvideo_read" name="cvideo_read" @if(in_array("cvideo_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="cvideo_write" name="cvideo_write" @if(in_array("cvideo_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="cvideo_create" name="cvideo_create" @if(in_array("cvideo_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="cvideo_delete" name="cvideo_delete" @if(in_array("cvideo_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>   
										
										<!-- Chat Management -->
										 <tr>
											<td class="text-gray-800">Chat Management</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="chat_all" name="chat_all" @if(in_array("chat_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="chat_read" name="chat_read" @if(in_array("chat_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="chat_write" name="chat_write" @if(in_array("chat_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="chat_create" name="chat_create" @if(in_array("chat_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="chat_delete" name="chat_delete" @if(in_array("chat_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
										
										<!-- sale Management -->
										 <tr>
											<td class="text-gray-800">Sale Management</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sale_all" name="sale_all" @if(in_array("sale_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sale_read" name="sale_read" @if(in_array("sale_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sale_write" name="sale_write" @if(in_array("sale_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sale_create" name="sale_create" @if(in_array("sale_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="sale_delete" name="sale_delete" @if(in_array("sale_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Studio Booking -->
										 <tr>
											<td class="text-gray-800">Studio Booking</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="studio_booking_all" name="studio_booking_all" @if(in_array("studio_booking_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="studio_booking_read" name="studio_booking_read" @if(in_array("studio_booking_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="studio_booking_write" name="studio_booking_write" @if(in_array("studio_booking_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="studio_booking_create" name="studio_booking_create" @if(in_array("studio_booking_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="studio_booking_delete" name="studio_booking_delete" @if(in_array("studio_booking_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Person Availability -->
										 <tr>
											<td class="text-gray-800">Person Availability</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="person_availability_all" name="person_availability_all" @if(in_array("person_availability_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="person_availability_read" name="person_availability_read" @if(in_array("person_availability_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="person_availability_write" name="person_availability_write" @if(in_array("person_availability_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="person_availability_create" name="person_availability_create" @if(in_array("person_availability_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="person_availability_delete" name="person_availability_delete" @if(in_array("person_availability_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
										<!-- Revenue Expense -->
										<tr>
											<td class="text-gray-800">Revenue Expense</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="revenue_expense_all" name="revenue_expense_all" @if(in_array("revenue_expense_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="revenue_expense_read" name="revenue_expense_read" @if(in_array("revenue_expense_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="revenue_expense_write" name="revenue_expense_write" @if(in_array("revenue_expense_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="revenue_expense_create" name="revenue_expense_create" @if(in_array("revenue_expense_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="revenue_expense_delete" name="revenue_expense_delete" @if(in_array("revenue_expense_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Repunext Board -->
										 <tr>
											<td class="text-gray-800">RepuNEXT Board</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="repunext_board_all" name="repunext_board_all" @if(in_array("repunext_board_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="repunext_board_read" name="repunext_board_read" @if(in_array("repunext_board_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="repunext_board_write" name="repunext_board_write" @if(in_array("repunext_board_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="repunext_board_create" name="repunext_board_create" @if(in_array("repunext_board_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="repunext_board_delete" name="repunext_board_delete" @if(in_array("repunext_board_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>

										<!-- Backlog -->
										 <tr>
											<td class="text-gray-800">Backlog</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="backlog_all" name="backlog_all" @if(in_array("backlog_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="backlog_read" name="backlog_read" @if(in_array("backlog_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="backlog_write" name="backlog_write" @if(in_array("backlog_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="backlog_create" name="backlog_create" @if(in_array("backlog_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="backlog_delete" name="backlog_delete" @if(in_array("backlog_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
										<!-- ai Management -->
										<tr>
											<td class="text-gray-800">Ai Management</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="ai_all" name="ai_all" @if(in_array("ai_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="ai_read" name="ai_read" @if(in_array("ai_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="ai_write" name="ai_write" @if(in_array("ai_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="ai_create" name="ai_create" @if(in_array("ai_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="ai_delete" name="ai_delete" @if(in_array("ai_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
													</label>
												</div>
											</td>
										</tr>
										<!-- host Management -->
										 <tr>
											<td class="text-gray-800">Host Management</td>
											<td>
												<div class="d-flex justify-content-between w-100">
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="host_all" name="host_all" @if(in_array("host_all",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">All</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="host_read" name="host_read" @if(in_array("host_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="host_write" name="host_write" @if(in_array("host_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="host_create" name="host_create" @if(in_array("host_create",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Create</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="host_delete" name="host_delete" @if(in_array("host_delete",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Delete</span>
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
							<!-- <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button> -->
							<a href="{{route('list.role')}}" class="btn btn-light-success me-2"> Discard </a>
							<button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit" name="addrolesubmit">
							<span class="indicator-label">Submit</span>
							<span class="indicator-progress">Please wait...	
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							</button>
						</div>
						</form>
					@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
