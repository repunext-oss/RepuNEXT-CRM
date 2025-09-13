@extends('admin.admin_master')

@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Add SubDomain Detail</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Domain / SubDomain List
                        </span>
                    </h3>
                </div>
                
                <div class="card-body border-0 pt-0">
                    <form action="{{ route('store.sddetail') }}" method="POST" class="form" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">SubDomain Name</label>
                                <input type="text" name="subdomain_name" id="subdomain_name" placeholder="SubDomain Name" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>  
       
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Host</label>
                                <select name="host_id" id="host_id" class="form-select mb-3 form-control select2"
                                    data-placeholder="Select a Host" data-allow-clear="true">
                                    @foreach($host as $hosts) 
                                        <option value="{{ $hosts->id }}">{{ $hosts->host_name}}</option>
                                    @endforeach
                                </select>
                            </div> 
                        </div>   

                        <div class="row">
                            <!-- Type Selection -->
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Type</label>
                                <select name="type_name" id="type_name" class="form-select mb-3 form-control select2"
                                    data-placeholder="Select a Type" data-allow-clear="true">
                                    @foreach($type as $types) 
                                        <option value="{{ $types->id }}">{{ $types->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>  

                            <!-- Backend User -->
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Backend Username</label>
                                <input type="text" name="backend_user" id="backend_user" placeholder="Backend user" 
                                    required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>  
                                                   
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Backend Password</label>
                                <input type="text" name="backend_password" id="backend_password" placeholder="Backend password" 
                                    required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div> 
                        </div>   

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('list.sddetail') }}" class="btn btn-light-success me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>  
                        </div> 
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Select2 JS for Dropdowns -->
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection
@endsection
