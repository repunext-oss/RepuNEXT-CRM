@extends('admin.admin_master')
@section('admin')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Edit</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Call Center / List
                        </span>
                    </h3>
                </div>
                <div class="card-body pt-5 pb-0">
                <form action="{{ route('callcenter.update') }}" method="post" class="form" enctype="multipart/form-data">
                        @csrf
                       
                        <div class="row mb-3">
                            <div class="col-lg-4 fv-row">
                                <label class="required fw-bold fs-6 mb-2">Name</label>
                                <input type="text" class="form-control" name="Name" value="{{ $d->Name }}" required>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="required fw-bold fs-6 mb-2">Mobile</label>
                                <input type="text" class="form-control" name="mobile" value="{{ $d->mobile }}" required>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Mobile 2</label>
                                <input type="text" class="form-control" name="mobile2" value="{{ $d->mobile2 }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Enquiry Date</label>
                                <input type="date" class="form-control" name="Enquiry_Date" value="{{ $d->Enquiry_Date }}">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Email address</label>
                                <input type="email" class="form-control" name="Email" value="{{ $d->Email }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Company Name</label>
                                <input type="text" class="form-control" name="Company_Name" value="{{ $d->Company_Name }}">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Service</label>
                                <select id="status" class="form-select" name="Service">
                                    <option value="Animation" {{ $d->Service == 'Animation' ? 'selected' : '' }}>🎬 Animation</option>
                                    <option value="Content Writing" {{ $d->Service == 'Content Writing' ? 'selected' : '' }}>✍️ Content Writing</option>
                                    <option value="Web Design" {{ $d->Service == 'Web Design' ? 'selected' : '' }}>🎨 Web Design</option>
                                    <option value="Graphic Design" {{ $d->Service == 'Graphic Design' ? 'selected' : '' }}>🖌️ Graphic Design</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">FollowUp1</label>
                                <input type="date" class="form-control" name="followup1" value="{{ $d->followup1 }}" required>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">FollowUp2</label>
                                <input type="date" class="form-control" name="followup2" value="{{ $d->followup2 }}" required>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">FollowUp3</label>
                                <input type="date" class="form-control" name="followup3" value="{{ $d->followup3 }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Source</label>
                                <select id="status" class="form-select" name="Source">
                                    <option value="JustDial" {{ $d->Source == 'JustDial' ? 'selected' : '' }}>📞 JustDial</option>
                                    <option value="IndiaMart" {{ $d->Source == 'IndiaMart' ? 'selected' : '' }}>🏬 India Mart</option>
                                </select>
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Status</label>
                                <select id="status" class="form-select" name="Status">
                                    <option value="Hot" {{ $d->Status == 'Hot' ? 'selected' : '' }}>Hot</option>
                                    <option value="Warm" {{ $d->Status == 'Warm' ? 'selected' : '' }}>Warm</option>
                                </select>
                            </div>
                        </div>
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
