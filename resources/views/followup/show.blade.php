@extends('admin.admin_master')
@section('admin')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">

            <div class="card">
                <div class="card-header pt-5 d-flex justify-content-between align-items-center">
                    <h3 class="card-title d-flex flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">View</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Followup Detail
                        </span>
                    </h3>
                    <a href="{{ route('list.followup') }}" class="btn btn-light-success">Back</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 fv-row">
                            <input type="hidden" name="id" value="{{ $repn->id }}">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">Enquiry Reference ID</label>
                            <select name="Enquiry_ref_id" id="Enquiry_ref_id" class="form-select mb-3 form-control" data-control="select2" disabled>
                                <option value="" disabled>Choose...</option>
                                @foreach($support as $supports)
                                    <option value="{{ $supports->id }}" 
                                        data-mobile="{{ $supports->Mobile }}" 
                                        data-enquiry-date="{{ $supports->Enquiry_Date }}"
                                        data-email="{{ $supports->Email }}"
                                        data-company="{{ $supports->Company_Name }}"
                                        data-service="{{ $supports->Service }}"
                                        data-source="{{ $supports->Source }}"
                                        data-location="{{ $supports->location }}"
                                        data-area="{{ $supports->Area }}"
                                        data-status="{{ $supports->Status }}"
                                        {{ $repn->Enquiry_ref_id == $supports->id ? 'selected' : '' }}>
                                        {{ $supports->Name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 fv-row">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">Date</label>
                            <input type="date" name="date" id="date" value="{{ old('date', $repn->date) }}"disabled
                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                        </div>

                        <div class="col-lg-4 fv-row">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">Status</label>
                            <select class="form-select" name="Status" disabled>
                                <option value="" disabled>Choose...</option>
                                <option value="Completed" {{ $repn->Status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Pending" {{ $repn->Status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 fv-row">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">Description</label>
                            <textarea name="description" id="description" disabled 
                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">{{ old('description', $repn->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">View More Details</span>
                    </h3>
                </div>

                <div class="card-body">
                   <div class="row mb-1">
                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" 
                                value="{{ $repn->Enquiry_ref_id ? $support->where('id', $repn->Enquiry_ref_id)->first()->Mobile ?? '' : '' }}" 
                                pattern="^[6-9]\d{9}$" title="Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9" disabled>
                        </div>

                
                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2">Enquiry Date</label>
                            <input type="date" class="form-control" id="enquiry_date" name="Enquiry_Date" 
                                value="{{ $repn->Enquiry_ref_id ? $support->where('id', $repn->Enquiry_ref_id)->first()->Enquiry_Date ?? '' : '' }}" disabled>
                        </div>

                  
                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2">Email Address</label>
                            <input type="email" class="form-control" id="email" name="Email" 
                                value="{{ $repn->Enquiry_ref_id ? $support->where('id', $repn->Enquiry_ref_id)->first()->Email ?? '' : '' }}" 
                                placeholder="No Value" disabled>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="Company_Name" 
                                value="{{ $repn->Enquiry_ref_id ? $support->where('id', $repn->Enquiry_ref_id)->first()->Company_Name ?? '' : '' }}" 
                                placeholder="No Value" disabled>
                        </div>

                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2">Service</label>
                            <input type="text" class="form-control" id="service" name="Service" 
                                value="{{ $repn->Enquiry_ref_id ? $support->where('id', $repn->Enquiry_ref_id)->first()->Service ?? '' : '' }}" disabled>
                        </div>

                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2">Source</label>
                            <input type="text" class="form-control" id="source" name="Source" 
                                value="{{ $repn->Enquiry_ref_id ? $support->where('id', $repn->Enquiry_ref_id)->first()->Source ?? '' : '' }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2">Location</label>
                            <input type="text" class="form-control" id="location" name="location" 
                                value="{{ $repn->Enquiry_ref_id ? $support->where('id', $repn->Enquiry_ref_id)->first()->location ?? '' : '' }}" 
                                placeholder="Enter Location" required disabled>
                        </div>

                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-4 mb-2">Area</label>
                            <input type="text" class="form-control" id="area" name="Area" placeholder="No Value"
                                value="{{ $repn->Enquiry_ref_id ? $support->where('id', $repn->Enquiry_ref_id)->first()->Area ?? '' : '' }}" disabled>
                        </div>

                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2">Status</label>
                            <input type="text" class="form-control" id="status" name="Status"  placeholder="No Value"
                                value="{{ $repn->Enquiry_ref_id ? $support->where('id', $repn->Enquiry_ref_id)->first()->Status ?? '' : '' }}" disabled>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
