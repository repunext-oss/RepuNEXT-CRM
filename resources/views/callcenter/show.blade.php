@extends('admin.admin_master')
@section('admin')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">View</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Call Center / List
                        </span>
                    </h3>
                </div>
                <div class="card-body pt-5 pb-0">

                        @csrf
                       

                        <!-- Name and Mobile -->
                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label for="name" class="  fw-bold fs-6 mb-2">Name</label>
                                <input type="text" class="form-control" id="name" name="Name"    readonly placeholder="Enter Name" value="{{ $d->Name }}" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label for="mobile" class="  fw-bold fs-6 mb-2">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="Mobile"    readonly placeholder="Enter Mobile Number" value="{{ $d->Mobile }}">
                                <span id="numloc" class="text-danger"></span>
                            </div>
                        </div><br>

                        <!-- Enquiry Date and Email -->
                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label for="enquiry_date" class="  fw-bold fs-6 mb-2">Enquiry Date</label>
                                <input type="date" class="form-control" id="enquiry_date" name="Enquiry_Date"   value="{{ $d->Enquiry_Date }}">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label for="email" class="  fw-bold fs-6 mb-2">Email Address</label>
                                <input type="email" class="form-control" id="email" name="Email"    readonly placeholder="Enter Email" value="{{ $d->Email }}">
                            </div>
                        </div><br>

                        <!-- Company Name and Follow-Up -->
                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label for="company_name" class="  fw-bold fs-6 mb-2">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="Company_Name"    readonly placeholder="Enter Company Name" value="{{ $d->Company_Name }}">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label for="followup" class="  fw-bold fs-6 mb-2">Follow-Up</label>
                                <input type="text" class="form-control" id="followup" name="FollowUp"   value="{{ $d->FollowUp }}">
                            </div>
                        </div><br>

                        <!-- Follow-Up Date and Service -->
                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label for="followupdate" class="  fw-bold fs-6 mb-2">Follow-Up Date</label>
                                <input type="date" class="form-control" id="followupdate" name="followupdate"   value="{{ $d->followupdate }}">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label for="service" class="  fw-bold fs-6 mb-2">Service</label>
                                <input type="text" class="form-control" id="service" name="Service"    readonly placeholder="Enter Service" value="{{ $d->Service }}">
                            </div>
                        </div><br>

                        <!-- Source and Status -->
                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label for="source" class="  fw-bold fs-6 mb-2">Source</label>
                                <input type="text" class="form-control" id="source" name="Source"    readonly placeholder="Enter Source" value="{{ $d->Source }}">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label for="status" class="  fw-bold fs-6 mb-2">Status</label>
                                <select id="status" class="form-select" name="Status"  >
                                    <option value="" disabled>Choose...</option>
                                    <option value="Hot" {{ $d->Status === 'Hot' ? 'selected' : '' }}>Hot</option>
                                    <option value="Warm" {{ $d->Status === 'Warm' ? 'selected' : '' }}>Warm</option>
                                    <option value="Cold" {{ $d->Status === 'Cold' ? 'selected' : '' }}>Cold</option>
                                    <option value="Dead" {{ $d->Status === 'Dead' ? 'selected' : '' }}>Dead</option>
                                </select>
                            </div>
                        </div><br>

                        <!-- Submit and Cancel Buttons -->
                        <div class="row">
                            <div class="col-1">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="col-1">
                                <a href="{{ route('callcenter.callcenter') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function validate() {
        const mobileInput = document.getElementById('mobile');
        const numLoc = document.getElementById('numloc');
        const mobileRegex = /^[6-9]\d{9}$/;

        if (!mobileRegex.test(mobileInput.value)) {
            numLoc.textContent = "Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.";
            return false;
        }

        numLoc.textContent = ""; // Clear error message
        return true;
    }
</script>

@endsection
