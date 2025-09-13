<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Repunext</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{asset('backend/assets/media/logos/favicon.ico')}}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" ></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
		<style>
			.ui-datepicker-trigger{ float: right; margin-top: -30px; z-index: auto; padding-right: 9px; cursor: pointer; }
			.form-control { border: 1px solid #b9b9b9 !important; }
			#kt_toolbar{ padding: 15px 15px 30px 15px !important; }
			td{vertical-align: middle;}
		</style>
	</head>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Add Intern</span>
						<!-- <span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> </span> -->
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
					<form action="{{ route('store.intern') }}" method="post" class="form" enctype="multipart/form-data">
						@csrf

						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Name</label>
								<input type="text" name="Name" id="Name"  placeholder="Name" required class="form-control form-control-lg form-control mb-3 mb-lg-0 "/>
							</div>  
							 <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Phone Number</label>
                                <input type="text" class="form-control" id="Mobile" name="Mobile" placeholder="Mobile" minlength="10" maxlength="10" required>
                                <small id="Mobile" class="text-danger"></small>
                            </div>						
						</div> 

						<div class="row">  
							<div class="col-lg-3 fv-row">
								<label class="required fw-bold fs-6 mb-2">StartDate</label>
								<input type="date" class="form-control form-control-lg mb-3 mb-lg-0" id="Startdate" name="Startdate">
							</div>
							<div class="col-lg-3 fv-row">
								<label class="required fw-bold fs-6 mb-2">EndDate</label>
								<input type="date" class="form-control form-control-lg mb-3 mb-lg-0" id="Enddate" name="Enddate">
							</div>

							<div class="col-lg-3 fv-row">
								<label class="fw-bold fs-6 mb-2">Duration</label>
								<select class="form-control form-control-lg form-control mb-3 mb-lg-0 " name="Duration">
                                    <option value="" selected disabled>Choose Source </option>
                                    <option value="7">7 Days</option>
                                    <option value="10">10 Days</option>
                                    <option value="15">15 Days</option>
                                    <option value="30">30 Days</option>
									<option value="60">2 Months</option>
									<option value="90">3 Months</option>
									<option value="180">6 Months</option>
                                </select>
							</div>

							<div class="col-lg-3 fv-row">
                                <label class="fw-bold fs-6 mb-2">Slot</label>
                                <select class="form-control form-control-lg form-control mb-3 mb-lg-0 " name="Slot">
                                    <option value="" selected disabled>Choose Slot Timing </option>
                                    <option value="Slot1">Slot1 9:00Am to 11:00Am</option>
                                    <option value="Slot2">Slot2 11:00Am to 01:00Pm</option>
                                    <option value="Slot3">Slot3 01:00Pm to 03:00Pm</option>
                                    <option value="Slot4">Slot4 03:00Pm to 05:00Pm</option>
									<option value="Slot5">Slot5 05:00Pm to 07:00Pm</option>
									<option value="Slot6">Slot6 10:00Am to 05:00Pm</option>
                                </select>
                            </div>
						</div>
						<div class= "row">
							<div class="col-lg-8 fv-row">
								<label class="col-lg-12 fw-bold fs-6 mb-2">Course</label>
									<select class="form-control form-control-lg form-control mb-3 mb-lg-0 " name="Course">
										<option value="" selected disabled>Choose Course </option>
										<option value="Web Development">Web Development</option>
										<option value="Software Development">Software Development</option>
										<option value="Web Application">Web Application</option>
										<option value="Full Stack ">Full Stack </option>
										<option value="UI UX Design">UI UX Design</option>
										<option value="HR & Admin">HR & Admin</option>
										<option value="Finance & Accounting">Finance & Accounting</option>
										<option value="Prompt Engineering">Prompt Engineering</option>
										<option value="Soft skills">Soft skills</option>
										<option value="SEO">SEO</option>
										<option value="Graphic Design">Graphic Design</option>
										<option value="Photography">Photography</option>
										<option value="Video Editing">Video Editing</option>
										<option value="Animation">Animation</option>
										<option value="Social Media">Social Media</option>
										<option value="Digital Marketing">Digital Marketing</option>
										<option value="Entrepreneurship">Entrepreneurship</option>
										<option value="Content Writer">Content Writer</option>
										<option value="Branding">Branding</option>
									</select>
							</div> 	
							<div class="col-lg-4 fv-row">
								<label class="fw-bold fs-6 mb-2">Source</label>
								<select class="form-control form-control-lg form-control mb-3 mb-lg-0 " name="Source">
                                    <option value="" selected disabled>Choose Source </option>
                                    <option value="Reference">Reference</option>
                                    <option value="Facebook Ads">Facebook Ads</option>
                                    <option value="Google Ads">Google Ads</option>
                                    <option value="Flute board">Flute board</option>
									<option value="Chatgpt">Chatgpt</option>
									<option value="Google">Google</option>
									<option value="Map">Map</option>
									<option value="Other">Other</option>
                                </select>
							</div> 	
						</div>
						<!-- <div class="row">  
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Letter</label>
								<select class="form-control-lg form-control mb-3 mb-lg-0 " name="Letter">
                                    <option value="" selected disabled>Letter Given </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
							</div> 	
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Certificate</label>
								<select class=" form-control-lg form-control mb-3 mb-lg-0 " name="Certificate">
                                    <option value="" selected disabled>Certificate Given </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
							</div> 
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Documentation</label>
								<select class="form-control form-control-lg form-control mb-3 mb-lg-0 " name="Documentation">
                                    <option value="" selected disabled>Documentation Given  </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
							</div>	
						</div> -->
						<div class="row">  
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-4">Collage Name</label>
								<input type="text" name="Collage" id="Collage"  placeholder="Collage" required class="form-control form-control-lg form-control mb-3 mb-lg-0 "/>
							</div>
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-4">Department</label>
								<select name="Department" id="Department" required class="form-select form-select-lg mb-3 mb-lg-0">
									<option value="">Select Department</option>
									<option value="Computer Science">Computer Science</option>
									<option value="Information Technology">Information Technology</option>
									<option value="Electronics and Communication">Electronics and Communication</option>
									<option value="Electrical and Electronics">Electrical and Electronics</option>
									<option value="Mechanical Engineering">Mechanical Engineering</option>
									<option value="Civil Engineering">Civil Engineering</option>
									<option value="Biomedical Engineering">Biomedical Engineering</option>
									<option value="Biotechnology">Biotechnology</option>
									<option value="Chemical Engineering">Chemical Engineering</option>
									<option value="Automobile Engineering">Automobile Engineering</option>
									<option value="Aerospace Engineering">Aerospace Engineering</option>
									<option value="Mechatronics">Mechatronics</option>
									<option value="Artificial Intelligence">Artificial Intelligence</option>
									<option value="Data Science">Data Science</option>
									<option value="Cybersecurity">Cybersecurity</option>
									<option value="Physics">Physics</option>
									<option value="Chemistry">Chemistry</option>
									<option value="Mathematics">Mathematics</option>
									<option value="English">English</option>
									<option value="Commerce">Commerce</option>
									<option value="Economics">Economics</option>
									<option value="Business Administration">Business Administration</option>
									<option value="MBA">MBA</option>
									<option value="MCA">MCA</option>
									<option value="Architecture">Architecture</option>
									<option value="Fashion Design">Fashion Design</option>
									<option value="Visual Communication">Visual Communication</option>
									<option value="Psychology">Psychology</option>
									<option value="Sociology">Sociology</option>
									<option value="History">History</option>
									<option value="Political Science">Political Science</option>
									<option value="Hotel Management">Hotel Management</option>
								</select>
							</div>

							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-4">Year</label>
								<select name="year" id="year" required class="form-select form-select-lg mb-3 mb-lg-0">
									<option value="">Select Year</option>
									<option value="UG - 1st Year">UG - 1st Year</option>
									<option value="UG - 2nd Year">UG - 2nd Year</option>
									<option value="UG - 3rd Year">UG - 3rd Year</option>
									<option value="UG - 4th Year">UG - 4th Year</option>
									<option value="PG - 1st Year">PG - 1st Year</option>
									<option value="PG - 2nd Year">PG - 2nd Year</option>
								</select>
							</div>

							 	
						</div>
						<div class="row">  
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Type</label>
								<select class="form-control form-control-lg form-control mb-3 mb-lg-0 " name="Type">
                                    <option value="" selected disabled>Choose Type  </option>
                                    <option value="Intenship">Intenship</option>
                                    <option value="Course">Course</option>
                                </select>
							</div> 	
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Area</label>
								<input type="text" name="Area" id="Area"  placeholder="Eg: Velachery" required class="form-control form-control-lg form-control mb-3 mb-lg-0 "/>
							</div> 
							<div class="col-lg-4 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">City</label>
								<input type="text" name="City" id="City"  placeholder="Eg: Chennai" required class="form-control form-control-lg form-control mb-3 mb-lg-0 "/>
							</div> 		
							<!-- <div class="col-lg-3 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Amount</label>
								<input type="password" name="Amount" id="Amount" placeholder="Amount" required 
									class="form-control form-control-lg form-control mb-3 mb-lg-0" />
							</div>

							<div class="col-lg-3 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Status</label>
								<select class="form-control form-control-lg form-control mb-3 mb-lg-0 " name="amt">
                                    <option value="" selected disabled>Choose Type  </option>
                                    <option value="paid">paid</option>
                                    <option value="Notpaid">Notpaid</option>
                                </select>
							</div>	 	 -->
						</div>


						<div class="row">
					 <div class="col-lg-6 fv-row">
        <label class="col-lg-12 col-form-label fw-bold fs-6">Uploaded Your Aadhar Card (PDF, DOCX, Images)</label>
        <input type="file" name="aadhar_card" id="aadhar_card" placeholder="Your Aadhar Uploaded" required class="form-control form-control-lg form-control mb-3 mb-lg-0" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" />
    </div>
    <div class="col-lg-6 fv-row">
        <label class="col-lg-12 col-form-label fw-bold fs-6">Uploaded Your College ID Card (PDF, DOCX, Images)</label>
        <input type="file" name="college_id_card" id="college_id_card" placeholder="Your College ID Uploaded" required class="form-control form-control-lg form-control mb-3 mb-lg-0" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" />
    </div>
						</div>
						<div class="card-footer d-flex justify-content-end py-6 px-9" >
							<a href="{{route('list.intern')}}" class="btn btn-light-success me-2"> Cancel </a>
							<button type="submit" class="btn btn-primary">Save</button>  
						</div> 
					</form> 
				</div>
			</div>
		</div>
	</div>
</div>
