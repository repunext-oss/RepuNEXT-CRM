@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered mw-650px">
			<div class="modal-content">
				<div class="modal-header" id="kt_modal_add_user_header">
					<h2 class="fw-bolder">Add User</h2>
					<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
						<span class="svg-icon svg-icon-1">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
							</svg>
						</span>
					</div>
				</div>
				<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
				<form  class="form" action="{{route('store.userlist')}}" method="POST" enctype='multipart/form-data'>
					@csrf
						<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
						
							<div class="fv-row mb-7">
								<label class="d-block fw-bold fs-6 mb-5">Profile Photo</label>
								<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
									
									<div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/300-6.jpg);"></div>
									
									<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
									<i class="bi bi-pencil-fill fs-7"></i>
									<input type="file" name="profile_image" accept=".png, .jpg, .jpeg" required />
									<input type="hidden" name="avatar_remove" />
									</label>
									<!--end::Label-->
									<!--begin::Cancel-->
									<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
										<i class="bi bi-x fs-2"></i>
									</span>
									<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
										<i class="bi bi-x fs-2"></i>
									</span>
								</div>
								<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
							</div>
							<div class="row">
								<div class="col-6">
									<label class="required fw-bold fs-6 mb-2">Full Name</label>
									<div class="row">
										<div class="col-md-3">
										<select name="honorific" id="" class="form-control form-control-solid">
												<option value="Mr.">Mr.</option>
												<option value="Ms.">Ms.</option>
												<option value="Mrs.">Mrs.</option>
											</select>
										</div>
										<div class="col-md-9">
											<input type="text" name="name" onkeydown="return((event.keyCode >= 65 && event.keyCode <= 120) || (event.keyCode==32) || (event.keyCode==8) || (event.keyCode==46));" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full Name" required/>
										</div>
									</div>
									<!-- <div class="fv-row mb-7">
										<label class="required fw-bold fs-6 mb-2">Full Name</label>
										<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" required/>
									</div> -->
								</div>
								<div class="col-6">
									<div class="fv-row mb-7">
										<label class="required fw-bold fs-6 mb-2">Email</label>
										<input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com"  required/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="row">
										<label class="required fw-bold fs-6 mb-2">Phone</label>
										<div class="fv-row col-4">
											<input type="text" value="+91" class="form-control form-control-solid" readonly/>
										</div>
										<div class="fv-row col-8">
												<input type="phone" name="phone" maxlength="10" onkeypress="return onlyNumberKey(event)" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="phone" min="10" max="10" required/>

										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="fv-row mb-7">
										<!--begin::Label-->
										<label class="required fw-bold fs-6 mb-2">Username</label>
										<!--end::Label-->
										<!--begin::Input-->
										<input type="text" name="username" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Username" required/>
										<!--end::Input-->
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="fv-row mb-7">
										<!--begin::Label-->
										<label class="required fw-bold fs-6 mb-2">Password</label>
										<!--end::Label-->
										<!--begin::Input-->
										<input type="password" name="password" maxlength="15" pattern=".{8,}"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" required/>
										<!--end::Input-->
										<input type="hidden" name="status" class="form-control form-control-solid mb-3 mb-lg-0"  required/>
										<div class="form-text mb-5">Password must be at least 8 characters</div>
									</div>
								</div>
								<div class="col-6">
									<div class="fv-row mb-7">
										<!--begin::Label-->
										<label class="required fw-bold fs-6 mb-2">Role</label>
										<select name="role" class="form-control form-control-solid mb-3 mb-lg-0">
											@foreach ($roledetails as $roledetail)
												<option>{{ucwords($roledetail->role_name);}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="text-center pt-15">
								<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
								<button type="submit" name="user_submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div id="kt_content_container" class="container-xxl">
			<div class="card">
				<div class="card-header border-0 pt-6">   
					<h3 class="card-title align-items-start flex-column">           
						<a href="/list/user">            
							<span class="card-label fw-bold fs-3 mb-1"> List
							</span>
						</a>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / User
							 </span>
					</h3>  
					<div class="card-toolbar">
						<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
								<span class="svg-icon svg-icon-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
										<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
									</svg>
								</span>Add User</button>     
						</div>
					</div>        
				</div>  
				<div class="card-body border-top pt-0">
				<table class="table border rounded gy-5 gs-7 dataTable no-footer" id="emailTable">
						<thead>   
							<tr class="tfw-bold text-muted bg-light">   
								<th >#</th>
								<th class="min-w-125px">Full User</th>
								<th class="min-w-125px">User Name</th>
								<th class="min-w-125px">Role</th>
								<th class="min-w-125px">Status</th>
								<th class="min-w-125px">Joined Date</th>
								<th class="text-end ">Actions</th>
							</tr>
						</thead>
						<tbody class="text-gray-600 fw-bold">
						<?php $j=0;?>
							@foreach ($usersdetails as $userdetail)
							<tr>
								<td>{{$j+=1;}}</td>
								<td class="d-flex align-items-center">
									<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
											<div class="symbol-label">
												<img src="{{(!empty($userdetail->profile_image))? url('upload/admin-images/'.$userdetail->profile_image):url('upload/default.jpg');}}" alt="{{ucwords($userdetail->name);}}" class="w-100" />
											</div>
									</div>
									<div class="d-flex flex-column">{{ucwords($userdetail->honorific);}} {{ucwords($userdetail->name);}}
										<span>{{ucwords($userdetail->email);}}</span>
									</div>
								</td>
								<td>{{$userdetail->username}}</td>
								<td>
									<div class="badge badge-light fw-bolder">{{ucwords($userdetail->role);}}</div>
								</td>
								<td>
									@if($userdetail->status=="0")
										Enabled
									@else
										Disabled
									@endif
								</td>
								<td>{{ucwords($userdetail->created_at);}}</td>
								<td class="text-end">

									<form method="POST" class="btn" action="{{route('delete.userlist')}}">
									@csrf
									<input type="hidden" value="{{$userdetail->id}}" name="id">
									@if(ucwords($userdetail->role)!="Admin")
									<button type="submit" class="btn btn-danger my-1" onclick="deleteuser()"><i class="fa fa-trash" aria-hidden="true"></i></button>
									@endif
								</form>
								</td>
							</tr>
							@endforeach
						</tbody> 
					</table> 
				</div> 
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready( function () {   
            $('#emailTable').DataTable({ 
				dom: 'frtip',   
			} ); 
		});
	function onlyNumberKey(evt) {
		  var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		  if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
			  return false;
		  return true;
	  }
	  function onlyAlphaKey(evt) {
		  var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		  if (ASCIICode > 31 && (ASCIICode < 65 || ASCIICode > 90) && (ASCIICode < 97 || ASCIICode > 122))
			  return false;
		  return true;
	  }
</script>
@endsection
