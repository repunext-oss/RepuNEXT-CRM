
@extends('admin.admin_master')
@section('admin')
<?php $rolerawdata = session('userRoles', []);?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">  
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div id="kt_content_container" class="container-xxl"> 
			<div class="row">    
				<div class="col-md-12">   
					<div class="card mb-5 mb-xl-10"> 
                        <div class="card-header border-0 pt-5">              
                            <h3 class="card-title align-items-start flex-column">
                                <a href="{{route('dashboard')}}"><span class="card-label fw-bold fs-3 mb-1"> Edit</span> </a>
                                <span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> /  User</span>
                            </h3>    
                        </div>    
						<div id="kt_account_settings_profile_details" class="collapse show">
							<form action="{{ route('update.user') }}" method="post" class="form" enctype="multipart/form-data">@csrf
								<div class="card-body border-top p-8">
									<div class="row mb-7">
										<div class="col-md-3">
											<label class="d-block fw-bold fs-6 mb-5">Profile Photo</label>
											<input type="hidden" name="id" value="{{$usersdetails->id}}" >
											<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
												<div class="image-input-wrapper w-125px h-125px" style="background-image:url({{(!empty($usersdetails->profile_image))? url('upload/admin-images/'.$usersdetails->profile_image):url('upload/default.jpg')  }});	">
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
											<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
										</div>
										<div class="col-9">
											<label class="required fw-bold fs-6 mb-2">Full Name</label>
											<div class="row mb-7">
												<div class="col-md-2">
												<select name="honorific" id="" class="form-control form-control-solid">
														<option value="Mr.">Mr.</option>
														<option value="Ms.">Ms.</option>
														<option value="Mrs.">Mrs.</option>
													</select>
												</div>
												<div class="col-md-10">
													<input type="text" name="name"  class="form-control form-control-solid mb-3 mb-lg-0" value="{{$usersdetails->name}}" required/>
												</div>
											</div>
											<label class="required fw-bold fs-6 mb-2">Phone </label>
											<div class="row">
												<div class="col-md-2">
													<input type="text" name="phone"  class="form-control form-control-solid mb-3 mb-lg-0" value="+91" required/>
												</div>
												<div class="col-md-10">
													<input type="text" name="phone"  class="form-control form-control-solid mb-3 mb-lg-0" value="{{$usersdetails->phone}}" required/>
												</div>
											</div>	
											
										</div>
									</div>
									<div class="row">
										<div class="col-4">
											<div class="fv-row mb-7">
												<label class="required fw-bold fs-6 mb-2">Email</label>
												<input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control form-control-solid mb-3 mb-lg-0" value="{{$usersdetails->email}}"  required/>
											</div>
										</div>
										<div class="col-4">
											<div class="fv-row mb-7">
												<label class="required fw-bold fs-6 mb-2">User Name</label>
												<input type="text"  name="username"  value="{{ $usersdetails->username }}" required class=" form-control form-control-lg form-control-solid"/>
											</div>
										</div>
										<div class="col-lg-4 fv-row">
											<label class="required fw-bold fs-6 mb-2">Role</label>
											
											<select name="role" id="role" value="{{$usersdetails->role}}" class="form-control form-control-lg form-control-solid"  selected> 
												@foreach ($roledetails as $roledetail)
												<?php echo Auth::user()->role; echo $roledetail->role_name;?>
													@if($roledetail->role_name !="Admin" && $roledetail->role_name != Auth::user()->role ) 
														<option value="{{$roledetail->role_name}}" selected> {{ucwords($roledetail->role_name);}}</option>
													@endif  
												@endforeach
											</select>
										</div>
										
									</div>
									
									
								</div>   
								<div class="card-footer d-flex justify-content-end py-6 px-9">
									<a href="{{route('list.user')}}" class="btn btn-light btn-active-light-primary me-2"> Cancel </a>
									<button type="submit" class="btn btn-primary"> Save Changes </button>
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









 
 