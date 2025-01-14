@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<!--begin::Container-->
		<div id="kt_content_container" class="container-xxl">
			<!--begin::Navbar-->
			<div class="card mb-5 mb-xl-10">
				<div class="card-header border-0 pt-6">
						<div class="d-flex align-items-center" id="kt_header_wrapper">
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-20 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_wrapper'}">
								<h1 class="text-dark fw-bold my-1 fs-3 lh-1">Profile Details</h1>
								<ul class="breadcrumb fw-semibold fs-8 my-1">
									<li class="breadcrumb-item text-muted">
										<a href="{route('dashboard')}}" class="text-muted">Home</a>
									</li>
									<li class="breadcrumb-item text-muted">Profile </li>
								</ul>
							</div>
						</div>
						
					</div>
				<!--begin::Card header-->
				<!--begin::Content-->
				<div id="kt_account_settings_profile_details" class="collapse show">
					<!--begin::Form-->
					<form action="{{route('store.profile')}}" method="post" class="form" enctype="multipart/form-data">
						@csrf
					<!--begin::Card body-->
					<div class="card-body border-top p-9">
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label fw-bold fs-6">Profile Photo</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8">
								<!--begin::Image input-->
								<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{asset('upload/default.jpg')}})">
									<!--begin::Preview existing avatar-->
									<div class="image-input-wrapper w-125px h-125px" style="background-image:url({{(!empty($editData->profile_image))? url('upload/admin-images/'.$editData->profile_image):url('upload/default.jpg')  }});	">
									</div>
								<!--end::Preview existing avatar-->
								<!--begin::Label-->
								<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Profile Photo">
									<i class="bi bi-pencil-fill fs-7"></i>
									<!--begin::Inputs-->
									<input type="file" name="profile_image" accept=".png, .jpg, .jpeg" />
									<input type="hidden" name="avatar_remove" />
									<!--end::Inputs-->
								</label>
								<!--end::Label-->
								<!--begin::Cancel-->
								<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Profile Photo">
									<i class="bi bi-x fs-2"></i>
								</span>
								<!--end::Cancel-->
								<!--begin::Remove-->
								<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Profile Photo">
									<i class="bi bi-x fs-2"></i>
								</span>
								<!--end::Remove-->
								</div>
								<!--end::Image input-->
								<!--begin::Hint-->
								<div class="form-text">Allowed file types: png, jpg, jpeg.
								</div>
								<!--end::Hint-->
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label required fw-bold fs-6">Full Name</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8">
								<!--begin::Row-->
								<div class="row">
									<!--begin::Col-->
									<div class="col-lg-12 fv-row">
										<div class="row">
                                            <div class="col-md-2">
                                                <select name="honorific" id="" class="form-control form-control-solid">
                                                    <option value="Mr.">Mr.</option>
                                                    <option value="Ms.">Ms.</option>
                                                    <option value="Mrs.">Mrs.</option>
                                                </select>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Name" value="{{$editData->name}}" />
                                            </div>
                                        </div>
                                    </div>
									<!--end::Col-->
								</div>
								<!--end::Row-->
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label required fw-bold fs-6">Username</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row">
								<input type="text" name="username" class="form-control form-control-lg form-control-solid" placeholder="User Name " value="{{$editData->username}}" readonly />
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row">
								<input type="email" name="email " class="form-control form-control-lg form-control-solid" value="{{$editData->email}}" />
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label fw-bold fs-6">
								<span class="required">Contact Phone</span>
								<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
							</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row">
								<input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" maxlength="10" value="{{$editData->phone}}" />
							</div>
							<!--end::Col-->
						</div>
					</div>
					<!--end::Card body-->
					<!--begin::Actions-->
					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<!-- <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancel</button> -->
						<button type="submit" class="btn btn-primary" >Save Changes</button>
					</div>
					<!--end::Actions-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Content-->
			</div>
			<div class="card mb-5 mb-xl-10">
				<!--begin::Card header-->
				<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
					<div class="card-title m-0">
						<h3 class="fw-bolder m-0">Sign-in Method</h3>
					</div>
				</div>
				<!--end::Card header-->
				<!--begin::Content-->
				<div id="kt_account_settings_signin_method" class="collapse show">
					<!--begin::Card body-->
					<div class="card-body border-top p-9">
						<!--begin::Email Address-->
						<div class="d-flex flex-wrap align-items-center">
							<!--begin::Label-->
							<div id="kt_signin_email">
								<div class="fs-6 fw-bolder mb-1">Email Address</div>
								<div class="fw-bold text-gray-600">{{$editData->email}}</div>
							</div>
							<!--end::Label-->
							<!--begin::Edit-->
							<div id="kt_signin_email_edit" class="flex-row-fluid d-none">
								<!--begin::Form-->
								<form class="form" action="{{route('update.email')}}" method="POST">
								@csrf
									<div class="row mb-6">
										<div class="col-lg-6 mb-4 mb-lg-0">
											<div class="fv-row mb-0">
												<label for="emailaddress" class="form-label fs-6 fw-bolder mb-3">Enter New Email Address</label>
												<input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress" placeholder="Email Address" name="email" value="{{$editData->email}}" required />
											</div>
										</div>
										<div class="col-lg-6">
											<div class="fv-row mb-0">
												<label for="password" class="form-label fs-6 fw-bolder mb-3">Confirm Password</label>
												<input type="password" class="form-control form-control-lg form-control-solid" name="password" required/>
											</div>
										</div>
									</div>
									<div class="d-flex">
										<button id="kt_signin_submit" type="submit" class="btn btn-primary me-2 px-6">Update Email</button>
										<button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
									</div>
								</form>
								<!--end::Form-->
							</div>
							<!--end::Edit-->
							<!--begin::Action-->
							<div id="kt_signin_email_button" class="ms-auto">
								<button class="btn btn-light btn-active-light-primary">Change Email</button>
							</div>
							<!--end::Action-->
						</div>
						<!--end::Email Address-->
						<!--begin::Separator-->
						<div class="separator separator-dashed my-6"></div>
						<!--end::Separator-->
						<!--begin::Password-->
						<div class="d-flex flex-wrap align-items-center mb-10">
							<!--begin::Label-->
							<div id="kt_signin_password">
								<div class="fs-6 fw-bolder mb-1">Password</div>
								<div class="fw-bold text-gray-600">************</div>
							</div>
							<!--end::Label-->
							<!--begin::Edit-->
							<div id="kt_signin_password_edit" class="flex-row-fluid d-none">
								<!--begin::Form-->
								<form class="form" action="{{route('update.password')}}" method="POST">
								@csrf
									<div class="row mb-1">
										<div class="col-lg-4">
											<div class="fv-row mb-0">
												<label for="currentpassword" class="form-label fs-6 fw-bolder mb-3">Current Password</label>
	 											<input type="text" class="form-control form-control-lg form-control-solid"  pattern=".{8,}" maxlength="15" name="currentpassword" id="currentpassword" required />
											</div>
										</div>
										<div class="col-lg-4">
											<div class="fv-row mb-0">
												<label for="newpassword" class="form-label fs-6 fw-bolder mb-3">New Password</label>
												<input type="text" class="form-control form-control-lg form-control-solid"  pattern=".{8,}" maxlength="15" name="newpassword" id="newpassword" required/>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="fv-row mb-0">
												<label for="confirmpassword" class="form-label fs-6 fw-bolder mb-3">Confirm New Password</label>
												<input type="text" class="form-control form-control-lg form-control-solid"  pattern=".{8,}" maxlength="15" name="confirmpassword" id="confirmpassword" required/>
											</div>
										</div>
									</div>
									<div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>
									<div class="d-flex">
										<button id="kt_password_submit" type="submit" class="btn btn-primary me-2 px-6">Update Password</button>
										<button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
									</div>
								</form>
								<!--end::Form-->
							</div>
							<!--end::Edit-->
							<!--begin::Action-->
							<div id="kt_signin_password_button" class="ms-auto">
								<button class="btn btn-light btn-active-light-primary">Reset Password</button>
							</div>
							<!--end::Action-->
						</div>
						<!--end::Password-->
					</div>
					<!--end::Card body-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Post-->
	</div>
</div>
@endsection
