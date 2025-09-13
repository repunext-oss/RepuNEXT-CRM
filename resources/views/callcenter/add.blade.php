@extends('admin.admin_master')
@section('admin')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Call Center List</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / callcenter / List
                        </span>
                    </h3>
                </div>
                <div class="card-body pt-5 pb-0">
                    <form method="post" action="{{ route('callcenter.store') }}" name="myform">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-4 fv-row">
                                <label class="required fw-bold fs-6 mb-2">Name</label>
                                <input type="text" class="form-control" name="Name" required placeholder="Enter Name" 
                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || 
                                        (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)">
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label for="mobile" class="required fw-bold fs-6 mb-2">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" required placeholder="Enter Mobile Number" 
                                    pattern="^[6-9]\d{9}$" title="Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9">
                                <span id="numloc" class="text-danger"></span>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label for="mobile" class=" fw-bold fs-6 mb-2">Mobile 2</label>
                                <input type="text" class="form-control" id="mobile2" name="mobile2" required placeholder="Enter Mobile Number" 
                                    pattern="^[6-9]\d{9}$" title="Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9">
                                <span id="numloc" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Enquiry Date</label>
                                <input type="date" class="form-control" name="Enquiry_Date">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Email address</label>
                                <input type="email" class="form-control" name="Email" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Company Name</label>
                                <input type="text" class="form-control" name="Company_Name" placeholder="Enter Company Name">
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Service</label>
                                <select id="status" class="form-select" name="Service">
                                    <option value="" selected disabled>Choose...</option>
                                    <option value="Animation">🎬 Animation</option>
                                    <option value="Content Writing">✍️ Content Writing</option>
                                    <option value="Web Design">🎨 Web Design</option>
                                    <option value="Graphic Design">🖌️ Graphic Design</option>
                                    <option value="SEO">🔍 SEO</option>
                                    <option value="Web Application">💻 Web Application</option>
                                    <option value="App Development">📱 App Development</option>
                                    <option value="Virus Removal">🛡️ Virus Removal</option>
                                    <option value="E-commerce">🛒 E-commerce</option>
                                    <option value="Social Media">📢 Social Media</option>
                                    <option value="Digital Marketing">📈 Digital Marketing</option>
                                    <option value="Video Editing">🎞️ Video Editing</option>
                                    <option value="Video Explainer">📹 Video Explainer</option>
                                    <option value="Branding">🏷️ Branding</option>
                                    <option value="Web Security">🔐 Web Security</option>
                                    <option value="Google Map Citation">🗺️ Google Map Citation</option>
                                    <option value="Domain Ranking">🌐 Domain Ranking</option>
                                    <option value="Mail Setup">📧 Mail Setup</option>
                                    <option value="Website Transfer">🔄 Website Transfer</option>
                                    <option value="Hosting Setup">🖥️ Hosting Setup</option>
                                    <option value="Photography">📸 Photography</option>
                                </select>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Source</label>
                                <select id="status" class="form-select" name="Source" required>
                                    <option value="JustDial">📞 JustDial</option>
                                    <option value="IndiaMart">🏬 India Mart</option>
                                    <option value="Alibaba">🌍 Alibaba</option>
                                    <option value="Sulekha">📖 Sulekha</option>
                                    <option value="ChatGpt">🤖 ChatGPT</option>
                                    <option value="Google">🔍 Google</option>
                                    <option value="Reference">👥 Reference</option>
                                    <option value="Exhibition">🎪 Exhibition</option>
                                    <option value="Field Sales [Area]">🚀 Field Sales [Area]</option>
                                    <option value="Others">➕ Others</option>
                                </select>
                            </div>
                        </div>

                        
                        <div class="row">
                                    <div class="col-lg-4 fv-row">
                                        <label class="fw-bold fs-6 mb-2">FollowUp1</label>
                                        <input type="date" class="form-control" name="followup1" required placeholder="followup1">
                                    </div>
                                    <div class="col-lg-4 fv-row">
                                        <label class=" fw-bold fs-6 mb-2">FollowUp2</label>
                                        <input type="date" class="form-control" name="followup2" required placeholder="followup2">
                                    </div>
                                    <div class="col-lg-4 fv-row">
                                        <label class="fw-bold fs-6 mb-2">FollowUp3</label>
                                        <input type="date" class="form-control" name="followup3" required placeholder="followup3">
                                    </div>
                           
                                </div></br>
                        <div class="row mb-3">
                       
                            <div class="col-lg-5 fv-row">
                                <label class="fw-bold fs-6 mb-2">Location</label>
                                <input type="text" class="form-control" name="Location" placeholder="Enter Location">
                            </div>
                            <div class="col-lg-5 fv-row">
                                <label class="fw-bold fs-6 mb-2">Area</label>
                                <input type="text" class="form-control" name="Area" placeholder="Enter Area">
                            </div>
                            <div class="col-lg-2 fv-row">
                                <label class="fw-bold fs-6 mb-2">Status</label>
                                <select id="status" class="form-select" name="Status" required>
                                    <option value="" selected disabled>Choose...</option>
                                    <option value="Hot">Hot</option>
                                    <option value="Warm">Warm</option>
                                    <option value="Cold">Cold</option>
                                    <option value="Dead">Dead</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-1">
                                <input type="submit" value="Submit" name="submit" class="btn btn-primary" />
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
    function validateForm() {
        const mobileInput = document.getElementById('mobile');
        const mobileValue = mobileInput.value;
        const numLoc = document.getElementById('numloc');
        const mobileRegex = /^[6-9]\d{9}$/;

        if (!mobileRegex.test(mobileValue)) {
            numLoc.textContent = 'Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.';
            return false;
        }

        numLoc.textContent = ''; // Clear error
        return true;
    }
</script>

@endsection
