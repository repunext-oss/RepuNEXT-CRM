@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Add Enquiries</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Enquiry </span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
					<form action="{{ route('store.support') }}" method="post" class="form" enctype="multipart/form-data">
						@csrf
						<div class="row mb-3"> 
                            <div class="col-lg-4 fv-row">
                                <input type="hidden" name="userid" value="{{ $loginUserId}}">
                                <label class="required fw-bold fs-6 mb-2">Name</label>
                                <input type="text" class="form-control" name="Name" required placeholder="Enter Name" 
                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || 
                                        (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)">
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label for="mobile" class= "required fw-bold fs-6 mb-2">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" required placeholder="Enter Mobile Number" 
                                    pattern="^[6-9]\d{9}$" title="Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9">
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Mobile 2</label>
                                <input type="text" class="form-control" id="mobile2" name="mobile2" placeholder="Enter Mobile Number" 
                                    pattern="^[6-9]\d{9}$" title="Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Email address</label>
                                <input type="email" class="form-control" name="Email" placeholder="Enter Email">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Company Name</label>
                                <input type="text" class="form-control" name="Company_Name" placeholder="Enter Company Name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2 required">Enquiry Date</label>
                                <input type="date" class="form-control" name="Enquiry_Date">
                            </div>

                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2 required">Service</label>
                            <select name="Service[]" id="service" class="form-select mb-3 form-control select2"  multiple="multiple">
                                @php
                                    $selectedValues = old('Service', isset($selectedData) ? explode(",", $selectedData->Service ?? '') : []);
                                @endphp

                                <option value="" >Choose...</option>
                                <option value="Animation" @if(in_array('Animation', $selectedValues)) selected @endif>🎬 Animation</option>
                                <option value="Content Writing" @if(in_array('Content Writing', $selectedValues)) selected @endif>✍️ Content Writing</option>
                                <option value="Web Design" @if(in_array('Web Design', $selectedValues)) selected @endif>🎨 Web Design</option>
                                <option value="Graphic Design" @if(in_array('Graphic Design', $selectedValues)) selected @endif>🖌️ Graphic Design</option>
                                <option value="SEO" @if(in_array('SEO', $selectedValues)) selected @endif>🔍 SEO</option>
                                <option value="Web Application" @if(in_array('Web Application', $selectedValues)) selected @endif>💻 Web Application</option>
                                <option value="App Development" @if(in_array('App Development', $selectedValues)) selected @endif>📱 App Development</option>
                                <option value="Virus Removal" @if(in_array('Virus Removal', $selectedValues)) selected @endif>🛡️ Virus Removal</option>
                                <option value="E-commerce" @if(in_array('E-commerce', $selectedValues)) selected @endif>🛒 E-commerce</option>
                                <option value="Social Media" @if(in_array('Social Media', $selectedValues)) selected @endif>📢 Social Media</option>
                                <option value="Digital Marketing" @if(in_array('Digital Marketing', $selectedValues)) selected @endif>📈 Digital Marketing</option>
                                <option value="Video Editing" @if(in_array('Video Editing', $selectedValues)) selected @endif>🎞️ Video Editing</option>
                                <option value="Video Explainer" @if(in_array('Video Explainer', $selectedValues)) selected @endif>📹 Video Explainer</option>
                                <option value="Branding" @if(in_array('Branding', $selectedValues)) selected @endif>🏷️ Branding</option>
                                <option value="Web Security" @if(in_array('Web Security', $selectedValues)) selected @endif>🔐 Web Security</option>
                                <option value="Google Map Citation" @if(in_array('Google Map Citation', $selectedValues)) selected @endif>🗺️ Google Map Citation</option>
                                <option value="Domain Ranking" @if(in_array('Domain Ranking', $selectedValues)) selected @endif>🌐 Domain Ranking</option>
                                <option value="Mail Setup" @if(in_array('Mail Setup', $selectedValues)) selected @endif>📧 Mail Setup</option>
                                <option value="Website Transfer" @if(in_array('Website Transfer', $selectedValues)) selected @endif>🔄 Website Transfer</option>
                                <option value="Hosting Setup" @if(in_array('Hosting Setup', $selectedValues)) selected @endif>🖥️ Hosting Setup</option>
                                <option value="Photography" @if(in_array('Photography', $selectedValues)) selected @endif>📸 Photography</option>
                            </select>
                        </div>

                        <div class="col-lg-4 fv-row">
                            <label class="fw-bold fs-6 mb-2 required">Source</label>
                            <select class="form-select" name="Source">
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

                        <div class="row mb-3">
                            <div class="col-lg-5 fv-row">
                                <label class="required fw-bold fs-6 mb-2" for="location">Location</label>
                                <input type="text" class="form-control" id="location" name="Location" placeholder="Enter Location" required>
                            </div>

                            <div class="col-lg-5 fv-row">
                                <label class="fw-bold fs-6 mb-2" for="area">Area</label>
                                <input type="text" class="form-control" id="area" name="Area" placeholder="Enter Area">
                            </div>

                            <div class="col-lg-2 fv-row">
                                <label class="required fw-bold fs-6 mb-2" for="status">Status</label>
                                <select class="form-select" id="status" name="Status" aria-label="Select Status" required>
                                    <option value="" selected disabled>Choose...</option>
                                    <option value="Hot">Hot</option>
                                    <option value="Warm">Warm</option>
                                    <option value="Cold">Cold</option>
                                    <option value="Dead">Dead</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12 fv-row">
                                <label class="fw-bold fs-6 mb-2" for="Describe">Description</label>
                                <textarea class="form-control" id="Describe" name="Describe" rows="4" placeholder="Enter Description"></textarea>
                            </div>
                        </div>



						<div class="card-footer d-flex justify-content-end py-6 px-9">
							<a href="{{route('list.support')}}" class="btn btn-light-success me-2"> Cancel </a>
							<button type="submit" class="btn btn-primary">Save</button>  
						</div> 
					</form> 
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#service').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });
</script>
@endsection
