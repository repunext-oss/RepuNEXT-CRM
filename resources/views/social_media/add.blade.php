@extends('admin.admin_master')

@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Add Social Media</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Social Media
                        </span>
                    </h3>
                </div>
                
                <div class="card-body border-0 pt-0">
                    <form action="{{ route('store.smedia') }}" method="POST" class="form" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-4 fv-row">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Company Name</label>
                                <input type="text" name="sm_company" id="sm_company" placeholder="Enter a Company Name" 
                                    required 
                                    class="form-control form-control-lg mb-3" />
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label fw-bold fs-6 required">Media Name</label>
                                <input type="text" name="sm_name" id="sm_name" placeholder="Social Media Name" 
                                    required 
                                    class="form-control form-control-lg mb-3" />
                            </div>   
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label fw-bold fs-6 required">Landing Page</label>
                                <input type="url" name="sm_link" id="sm_link" placeholder="Enter a valid URL" required class="form-control form-control-lg mb-3"/>
                            </div> 
                        </div>
                           
                        <div class="row">
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">User</label>
                                <input type="text" name="sm_user" id="sm_user" placeholder="Enter User Name" 
                                    required 
                                    class="form-control form-control-lg form-control mb-3 mb-lg-0" />
                            </div>  
        
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Password</label>
                                <input type="text" name="sm_password" id="sm_password" placeholder="Enter Password" 
                                    required 
                                    class="form-control form-control-lg form-control mb-3 mb-lg-0" />
                            </div> 
                        </div>   

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('list.smedia') }}" class="btn btn-light-success me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>  
                        </div> 
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection
