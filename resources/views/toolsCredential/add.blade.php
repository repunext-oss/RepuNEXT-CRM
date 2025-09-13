@extends('admin.admin_master')

@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Add Tool Credentials</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Tools / Tools Credtionals
                        </span>
                    </h3>
                </div>
                
                <div class="card-body border-0 pt-0">
                    <form action="{{ route('store.toolcred') }}" method="POST" class="form" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Tool Name</label>
                                <input type="text" name="tool_name" id="tool_name" placeholder="Tool Name" 
                                     required 
                                    class="form-control form-control-lg form-control mb-3 mb-lg-0" />
                            </div>  

                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">ToolType ID</label>
                                <select name="tooltype_id" id="tooltype_id" 
                                    class="form-select mb-3 form-control select2" 
                                    data-placeholder="Select a Tooltype" data-allow-clear="true" required>
                                    <option value="" disabled selected>Select an Tooltype</option>`
                                    @foreach($tooltype as $tooltypes)
                                        <option value="{{ $tooltypes->id }}" {{ old('tooltype_id') == $tooltypes->id ? 'selected' : '' }}>
                                            {{ $tooltypes->tooltype_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label for="link_to_sm" class="col-lg-12 col-form-label fw-bold fs-6">Link To SM</label>
                                <select name="link_to_sm" id="link_to_sm" class="form-select mb-3 select2" data-placeholder="Select an option" data-allow-clear="true" required>
                                    <option value="" disabled selected>Select an option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                        </div>   

                        <div class="row">
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Link</label>
                                <input type="url" name="link" id="link" placeholder="Enter a valid URL" 
                                    required 
                                    class="form-control form-control-lg form-control mb-3 mb-lg-0" />
                            </div>

                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">User</label>
                                <input type="text" name="user" id="user" placeholder="User" 
                                    required 
                                    class="form-control form-control-lg form-control mb-3 mb-lg-0" />
                            </div>  
        
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Password</label>
                                <input type="text" name="password" id="password" placeholder="Password" 
                                    required 
                                    class="form-control form-control-lg form-control mb-3 mb-lg-0" />
                            </div> 
                        </div>   

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('list.toolcred') }}" class="btn btn-light-success me-2">Cancel</a>
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
