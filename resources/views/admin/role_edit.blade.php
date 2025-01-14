
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
										<tr>
											<td class="text-gray-800">User Management</td>
											<td>
												<div class="d-flex">
													<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
														<input class="form-check-input" type="checkbox" value="user_management_read" name="user_management_read" @if(in_array("user_management_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
														<input class="form-check-input" type="checkbox" value="user_management_write" name="user_management_write" @if(in_array("user_management_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="user_management_create" name="user_management_create" @if(in_array("user_management_create",$editrole, TRUE)) checked @endif/>
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
														<input class="form-check-input" type="checkbox" value="role_management_read" name="role_management_read" @if(in_array("role_management_read",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Read</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
														<input class="form-check-input" type="checkbox" value="role_management_write" name="role_management_write" @if(in_array("role_management_write",$editrole, TRUE)) checked @endif/>
														<span class="form-check-label">Write</span>
													</label>
													<label class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="role_management_create" name="role_management_create" @if(in_array("role_management_create",$editrole, TRUE)) checked @endif/>
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
					@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
