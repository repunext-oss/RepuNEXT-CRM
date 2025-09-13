@extends('admin.admin_master')

@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card"> 
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">View Enquiry </span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Enquiry
                        </span>
                    </h3> 
                </div>                    
                    <div class="card-body border-0 pt-0">  
					<div class="row mb-3">
                            <div class="col-lg-4 fv-row">
							<input type="text" name="id" value="{{ $repn->id }}" hidden>   
                                <label class="fw-bold fs-6 mb-2">Name</label>
                                <input type="text" class="form-control" name="Name" value="{{  $repn->Name }}" required placeholder="Enter Name" 
                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || 
                                        (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)">
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $repn->Mobile }}" 
                                    pattern="^[6-9]\d{9}$" title="Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9">
                            </div>


                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Mobile 2</label>
                                <input type="text" class="form-control" id="mobile2" name="mobile2" value="{{ $repn->mobile2 }}" placeholder="Enter Mobile Number" 
                                    pattern="^[6-9]\d{9}$" title="Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Enquiry Date</label>
                                <input type="date" class="form-control" name="Enquiry_Date" value="{{  $repn->Enquiry_Date }}">
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="fw-bold fs-6 mb-2">Email address</label>
                                <input type="email" class="form-control" name="Email" value="{{  $repn->Email }}" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Company Name</label>
                                <input type="text" class="form-control" name="Company_Name" value="{{  $repn->Company_Name }}" placeholder="Enter Company Name">
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Service</label>
                                <select class="form-select" name="Service">
                                    <option value="" disabled>Choose...</option>
                                    <option value="Animation" @if( $repn->Service == 'Animation') selected @endif>🎬 Animation</option>
                                    <option value="Content Writing" @if( $repn->Service == 'Content Writing') selected @endif>✍️ Content Writing</option>
                                    <option value="Web Design" @if( $repn->Service == 'Web Design') selected @endif>🎨 Web Design</option>
                                    <option value="Graphic Design" @if( $repn->Service == 'Graphic Design') selected @endif>🖌️ Graphic Design</option>
                                    <option value="SEO" @if( $repn->Service == 'SEO') selected @endif>🔍 SEO</option>
                                    <option value="Web Application" @if( $repn->Service == 'Web Application') selected @endif>💻 Web Application</option>
                                    <option value="App Development" @if( $repn->Service == 'App Development') selected @endif>📱 App Development</option>
                                    <option value="Virus Removal" @if( $repn->Service == 'Virus Removal') selected @endif>🛡️ Virus Removal</option>
                                    <option value="E-commerce" @if( $repn->Service == 'E-commerce') selected @endif>🛒 E-commerce</option>
                                    <option value="Social Media" @if( $repn->Service == 'Social Media') selected @endif>📢 Social Media</option>
                                    <option value="Digital Marketing" @if( $repn->Service == 'Digital Marketing') selected @endif>📈 Digital Marketing</option>
                                    <option value="Video Editing" @if( $repn->Service == 'Video Editing') selected @endif>🎞️ Video Editing</option>
                                    <option value="Video Explainer" @if( $repn->Service == 'Video Explainer') selected @endif>📹 Video Explainer</option>
                                    <option value="Branding" @if( $repn->Service == 'Branding') selected @endif>🏷️ Branding</option>
                                    <option value="Web Security" @if( $repn->Service == 'Web Security') selected @endif>🔐 Web Security</option>
                                    <option value="Google Map Citation" @if( $repn->Service == 'Google Map Citation') selected @endif>🗺️ Google Map Citation</option>
                                    <option value="Domain Ranking" @if( $repn->Service == 'Domain Ranking') selected @endif>🌐 Domain Ranking</option>
                                    <option value="Mail Setup" @if( $repn->Service == 'Mail Setup') selected @endif>📧 Mail Setup</option>
                                    <option value="Website Transfer" @if( $repn->Service == 'Website Transfer') selected @endif>🔄 Website Transfer</option>
                                    <option value="Hosting Setup" @if( $repn->Service == 'Hosting Setup') selected @endif>🖥️ Hosting Setup</option>
                                    <option value="Photography" @if( $repn->Service == 'Photography') selected @endif>📸 Photography</option>
                                </select>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <label class="fw-bold fs-6 mb-2">Source</label>
                                <select class="form-select" name="Source">
                                    <option value="JustDial" @if( $repn->Source == 'JustDial') selected @endif>📞 JustDial</option>
                                    <option value="IndiaMart" @if( $repn->Source == 'IndiaMart') selected @endif>🏬 India Mart</option>
                                    <option value="Alibaba" @if( $repn->Source == 'Alibaba') selected @endif>🌍 Alibaba</option>
                                    <option value="Sulekha" @if( $repn->Source == 'Sulekha') selected @endif>📖 Sulekha</option>
                                    <option value="ChatGpt" @if( $repn->Source == 'ChatGpt') selected @endif>🤖 ChatGPT</option>
                                    <option value="Google" @if( $repn->Source == 'Google') selected @endif>🔍 Google</option>
                                    <option value="Reference" @if( $repn->Source == 'Reference') selected @endif>👥 Reference</option>
                                    <option value="Exhibition" @if( $repn->Source == 'Exhibition') selected @endif>🎪 Exhibition</option>
                                    <option value="Field Sales [Area]" @if( $repn->Source == 'Field Sales [Area]') selected @endif>🚀 Field Sales [Area]</option>
                                    <option value="Others" @if( $repn->Source == 'Others') selected @endif>➕ Others</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-5 fv-row">
                                <label class="fw-bold fs-6 mb-2">Location</label>
                                <input type="text" class="form-control" name="location" value="{{  $repn->location }}" placeholder="Enter Location" required>
                            </div>
                            <div class="col-lg-5 fv-row">
                                <label class="fw-bold fs-6 mb-2">Area</label>
                                <input type="text" class="form-control" name="Area" value="{{  $repn->Area }}" placeholder="Enter Area">
                            </div>
                            <div class="col-lg-2 fv-row">
                                <label class="fw-bold fs-6 mb-2">Status</label>
                                <select class="form-select" name="Status">
                                    <option value="" disabled>Choose...</option>
                                    <option value="Hot" @if( $repn->Status == 'Hot') selected @endif>Hot</option>
                                    <option value="Warm" @if( $repn->Status == 'Warm') selected @endif>Warm</option>
                                    <option value="Cold" @if( $repn->Status == 'Cold') selected @endif>Cold</option>
                                    <option value="Dead" @if( $repn->Status == 'Dead') selected @endif>Dead</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12 fv-row">
                                <label class="fw-bold fs-6 mb-2" for="Describe">Description</label>
                                <textarea class="form-control" id="Describe" name="Describe" rows="4" placeholder="Enter Description">{{ $repn->Describe ?? '' }}</textarea>
                            </div>
                        </div>


                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('list.support') }}" class="btn btn-light-success me-2">Back</a>
                       
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
