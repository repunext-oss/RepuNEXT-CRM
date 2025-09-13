<!DOCTYPE html>
<html lang="en">
<head>
	<title>Repunext - Edit Intern</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="shortcut icon" href="{{asset('backend/assets/media/logos/favicon.ico')}}" />
	<link href="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" />
	<link href="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" />
	<link href="{{asset('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" />
	<link href="{{asset('backend/assets/css/style.bundle.css')}}" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" ></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
	<style>
		.ui-datepicker-trigger { float: right; margin-top: -30px; padding-right: 9px; cursor: pointer; }
		.form-control { border: 1px solid #b9b9b9 !important; }
		td { vertical-align: middle; }
	</style>
</head>

<body>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card">
				<div class="card-header pt-5">
					<h3 class="card-title">
						<span class="card-label fw-bold fs-3 mb-1">Edit Intern</span>
					</h3>
				</div>
				<div class="card-body border-0 pt-0">
					<form action="{{ route('update.intern') }}" method="POST" class="form" enctype="multipart/form-data">
						@csrf	
						<div class="row">
							<div class="col-lg-6 fv-row">
								<input type="hidden" name="id" value="{{ $intern->id }}">
								<label class="fw-bold fs-6">Name</label>
								<input type="text" name="Name" value="{{ $intern->Name }}" class="form-control" required />
							</div>
							<div class="col-lg-6 fv-row">
								<label class="fw-bold fs-6">Phone Number</label>
								<input type="text" name="Mobile" value="{{ $intern->Mobile }}" class="form-control" required minlength="10" maxlength="10" />
							</div>
						</div>

		<div class="row mt-3">
			<div class="col-lg-3 fv-row">
				<label class="fw-bold fs-6">Start Date</label>
				<input type="date" name="Startdate" value="{{ old('Startdate', $intern->Startdate) }}" class="form-control" />
			</div>
			<div class="col-lg-3 fv-row">
				<label class="fw-bold fs-6">End Date</label>
				<input type="date" name="Enddate" value="{{ old('Enddate', $intern->Enddate) }}" class="form-control" />
			</div>
			<div class="col-lg-3 fv-row">
				<label class="fw-bold fs-6">Duration</label>
				<select name="Duration" class="form-control">
					<option value="" disabled>Choose Duration</option>
					@foreach(['7','10','15','30','60','90','180'] as $value)
						<option value="{{ $value }}" {{ old('Duration', $intern->Duration) == $value ? 'selected' : '' }}>{{ $value }} Days</option>
					@endforeach
				</select>
			</div>
			<div class="col-lg-3 fv-row">
				<label class="fw-bold fs-6">Slot</label>
				<select name="Slot" class="form-control">
					@foreach(['Slot1','Slot2','Slot3','Slot4','Slot5','Slot6'] as $value)
						<option value="{{ $value }}" {{ old('Slot', $intern->Slot) == $value ? 'selected' : '' }}>{{ $value }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-lg-8 fv-row">
				<label class="fw-bold fs-6 mb-2">Course</label>
				<select class="form-control" name="Course">
					<option value="" disabled>Choose Course</option>
					@foreach([
						'Web Development','Software Development','Web Application','Full Stack','UI UX Design',
						'HR & Admin','Finance & Accounting','Prompt Engineering','Soft skills','SEO','Graphic Design',
						'Photography','Video Editing','Animation','Social Media','Digital Marketing','Entrepreneurship',
						'Content Writer','Branding'
					] as $course)
						<option value="{{ $course }}" {{ old('Course', $intern->Course) == $course ? 'selected' : '' }}>{{ $course }}</option>
					@endforeach
				</select>
			</div>

			<div class="col-lg-4 fv-row">
				<label class="fw-bold fs-6 mb-2">Source</label>
				<select class="form-control" name="Source">
					@foreach(['Reference','Facebook Ads','Google Ads','Flute board','Chatgpt','Google','Map','Other'] as $src)
						<option value="{{ $src }}" {{ old('Source', $intern->Source) == $src ? 'selected' : '' }}>{{ $src }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="row mt-3">
			@foreach(['Letter','Certificate','Documentation'] as $field)
			<div class="col-lg-4 fv-row">
				<label class="fw-bold fs-6">{{ $field }}</label>
				<select name="{{ $field }}" class="form-control">
					<option value="" {{ old($field, $intern->$field) == '' ? 'selected' : '' }}>Select</option>
					<option value="Yes" {{ old($field, $intern->$field) == 'Yes' ? 'selected' : '' }}>Yes</option>
					<option value="No" {{ old($field, $intern->$field) == 'No' ? 'selected' : '' }}>No</option>
				</select>
			</div>
			@endforeach
		</div>

						<div class="row mt-3">
							<div class="col-lg-4 fv-row">
								<label class="fw-bold fs-6">Collage Name</label>
								<input type="text" name="Collage" value="{{ $intern->Collage }}" class="form-control" required />
							</div>
							<div class="col-lg-4 fv-row">
								<label class="fw-bold fs-6">Department</label>
								<select name="Department" class="form-control" required>
									<option value="" disabled {{ $intern->Department == '' ? 'selected' : '' }}>Choose Department</option>
									<option value="Computer Science" {{ $intern->Department == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
									<option value="Information Technology" {{ $intern->Department == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
									<option value="Electronics and Communication" {{ $intern->Department == 'Electronics and Communication' ? 'selected' : '' }}>Electronics and Communication</option>
									<option value="Electrical and Electronics" {{ $intern->Department == 'Electrical and Electronics' ? 'selected' : '' }}>Electrical and Electronics</option>
									<option value="Mechanical Engineering" {{ $intern->Department == 'Mechanical Engineering' ? 'selected' : '' }}>Mechanical Engineering</option>
									<option value="Civil Engineering" {{ $intern->Department == 'Civil Engineering' ? 'selected' : '' }}>Civil Engineering</option>
									<option value="Biomedical Engineering" {{ $intern->Department == 'Biomedical Engineering' ? 'selected' : '' }}>Biomedical Engineering</option>
									<option value="Biotechnology" {{ $intern->Department == 'Biotechnology' ? 'selected' : '' }}>Biotechnology</option>
									<option value="Chemical Engineering" {{ $intern->Department == 'Chemical Engineering' ? 'selected' : '' }}>Chemical Engineering</option>
									<option value="Automobile Engineering" {{ $intern->Department == 'Automobile Engineering' ? 'selected' : '' }}>Automobile Engineering</option>
									<option value="Aerospace Engineering" {{ $intern->Department == 'Aerospace Engineering' ? 'selected' : '' }}>Aerospace Engineering</option>
									<option value="Mechatronics" {{ $intern->Department == 'Mechatronics' ? 'selected' : '' }}>Mechatronics</option>
									<option value="Artificial Intelligence" {{ $intern->Department == 'Artificial Intelligence' ? 'selected' : '' }}>Artificial Intelligence</option>
									<option value="Data Science" {{ $intern->Department == 'Data Science' ? 'selected' : '' }}>Data Science</option>
									<option value="Cybersecurity" {{ $intern->Department == 'Cybersecurity' ? 'selected' : '' }}>Cybersecurity</option>
									<option value="Physics" {{ $intern->Department == 'Physics' ? 'selected' : '' }}>Physics</option>
									<option value="Chemistry" {{ $intern->Department == 'Chemistry' ? 'selected' : '' }}>Chemistry</option>
									<option value="Mathematics" {{ $intern->Department == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
									<option value="English" {{ $intern->Department == 'English' ? 'selected' : '' }}>English</option>
									<option value="Commerce" {{ $intern->Department == 'Commerce' ? 'selected' : '' }}>Commerce</option>
									<option value="Economics" {{ $intern->Department == 'Economics' ? 'selected' : '' }}>Economics</option>
									<option value="Business Administration" {{ $intern->Department == 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
									<option value="MBA" {{ $intern->Department == 'MBA' ? 'selected' : '' }}>MBA</option>
									<option value="MCA" {{ $intern->Department == 'MCA' ? 'selected' : '' }}>MCA</option>
									<option value="Architecture" {{ $intern->Department == 'Architecture' ? 'selected' : '' }}>Architecture</option>
									<option value="Fashion Design" {{ $intern->Department == 'Fashion Design' ? 'selected' : '' }}>Fashion Design</option>
									<option value="Visual Communication" {{ $intern->Department == 'Visual Communication' ? 'selected' : '' }}>Visual Communication</option>
									<option value="Psychology" {{ $intern->Department == 'Psychology' ? 'selected' : '' }}>Psychology</option>
									<option value="Sociology" {{ $intern->Department == 'Sociology' ? 'selected' : '' }}>Sociology</option>
									<option value="History" {{ $intern->Department == 'History' ? 'selected' : '' }}>History</option>
									<option value="Political Science" {{ $intern->Department == 'Political Science' ? 'selected' : '' }}>Political Science</option>
									<option value="Hotel Management" {{ $intern->Department == 'Hotel Management' ? 'selected' : '' }}>Hotel Management</option>
								</select>

							</div>
							<div class="col-lg-4 fv-row">
								<label class="fw-bold fs-6">Year</label>
								<select name="year" class="form-control" required>
									<option value="UG - 1st Year" {{ $intern->year == 'UG - 1st Year' ? 'selected' : '' }}>UG - 1st Year</option>
									<option value="UG - 2nd Year" {{ $intern->year == 'UG - 2nd Year' ? 'selected' : '' }}>UG - 2nd Year</option>
									<option value="UG - 3rd Year" {{ $intern->year == 'UG - 3rd Year' ? 'selected' : '' }}>UG - 3rd Year</option>
									<option value="UG - 4th Year" {{ $intern->year == 'UG - 4th Year' ? 'selected' : '' }}>UG - 4th Year</option>
									<option value="PG - 1st Year" {{ $intern->year == 'PG - 1st Year' ? 'selected' : '' }}>PG - 1st Year</option>
									<option value="PG - 2nd Year" {{ $intern->year == 'PG - 2nd Year' ? 'selected' : '' }}>PG - 2nd Year</option>
								</select>
							</div>
						</div>

						<div class="row mt-3">
							<div class="col-lg-4 fv-row">
								<label class="fw-bold fs-6">Type</label>
								<select name="Type" class="form-control">
									<option value="Intenship" {{ $intern->Type == 'Intenship' ? 'selected' : '' }}>Intenship</option>
									<option value="Course" {{ $intern->Type == 'Course' ? 'selected' : '' }}>Course</option>
								</select>
							</div>
							<div class="col-lg-4 fv-row">
								<label class="fw-bold fs-6">Area</label>
								<input type="text" name="Area" value="{{ $intern->Area }}" class="form-control" required />
							</div>
							<div class="col-lg-4 fv-row">
								<label class="fw-bold fs-6">City</label>
								<input type="text" name="City" value="{{ $intern->City }}" class="form-control" required />
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-lg-6 fv-row">
								<label class="fw-bold fs-6">Amount</label>
								<input type="text" name="Amount" value="{{ $intern->Amount }}" class="form-control" required />
							</div>
							<div class="col-lg-6 fv-row">
								<label class="fw-bold fs-6">Status</label>
								<select name="amt" class="form-control">
									<option value="paid" {{ $intern->amt == 'paid' ? 'selected' : '' }}>Paid</option>
									<option value="Notpaid" {{ $intern->amt == 'Notpaid' ? 'selected' : '' }}>Not Paid</option>
								</select>
							</div>
						</div>

		<div class="card-footer d-flex justify-content-end py-6 px-9 mt-4">
			<a href="{{ route('list.intern') }}" class="btn btn-light-success me-2">Cancel</a>
			<button type="submit" class="btn btn-primary">Update</button>
		</div>
	</form>
</div>

			</div>
		</div>
	</div>
</div>

</body>
</html>
