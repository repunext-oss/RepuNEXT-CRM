@extends('admin.admin_master')

@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card"> 
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">View Social Media </span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Social Media
                        </span>
                    </h3> 
                </div>                    
                    <div class="card-body border-0 pt-0">  
                        <div class="row">
                        <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Company Name</label>
                                <input type="text" name="sm_company" id="sm_company" 
                                    value="{{ $repn->sm_company }}" 
                                    required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"/>
                            </div> 
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Media Name</label>
                                <input type="text" name="sm_name" id="sm_name" 
                                    value="{{ $repn->sm_name }}" 
                                    required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"/>
                            </div> 
                        	<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Landing Page</label>
								<input type="url" name="sm_link" id="sm_link" 
									value="{{$repn->sm_link}}" 
									 required 
									class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"/>
							</div>
                        </div>   
                        <div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-6 col-form-label required fw-bold fs-6">User</label>
								<input type="text" name="sm_user" id="sm_user" 
									value="{{$repn->sm_user}}" 
									 required 
									class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"/>
							</div>  
						
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-6 col-form-label required fw-bold fs-6">Password</label>
                                <input type="text" name="sm_password" id="sm_password" 
                                    value="{{ $repn->sm_password }}" placeholder="Password" 
                                    required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"/>
                            </div> 
                        </div>   
                    </div>

                    <!-- Footer -->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('list.smedia') }}" class="btn btn-light-success me-2">Back</a>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
