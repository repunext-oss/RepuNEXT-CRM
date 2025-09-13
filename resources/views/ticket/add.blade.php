@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Add</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Ticket</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
				
				
				<form action="{{ route('store.ticket') }}" method="post" class="form" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-lg-12 fv-row">
								<label for="ticket_subject" class="col-form-label  fw-bold fs-6">Subject</label>
								<input type="text" name="ticket_subject" id="ticket_subject" placeholder="Enter a Subject"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
							</div>
						</div>
						<div class = "row">
							<div class="col-lg-4 fv-row">
								<label for="product" class="col-form-label fw-bold fs-6">Product</label>
								<select name="product" id="product" 
									class="form-select form-select-lg form-select-solid mb-3 mb-lg-0" 
									data-placeholder="Select a Product">
									<option value="" disabled selected>Select a Product</option>
									@foreach($gc as $gcs)
										<option value="{{ $gcs->id }}">{{ $gcs->gc_name }}</option>
									@endforeach
								</select>
							</div>

							<div class="col-lg-4 fv-row">
								<label for="ticket_prority" class="col-form-label  fw-bold fs-6">Priority</label>
								<input type="text" name="ticket_prority" id="ticket_prority" placeholder="Ticket priority"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
							</div> 
							         
							<div class="col-lg-4 fv-row">
									<label for="ticket_status" class="col-form-label fw-bold fs-6">Status</label>
									<div class="position-relative">
										<select name="ticket_status" id="ticket_status"
											class="form-select form-select-lg form-select-solid mb-3 mb-lg-0 bg-gray-100 border border-gray-300 text-gray-800 py-3 px-4 pe-10 rounded-xl focus:outline-none focus:bg-white focus:border-blue-400">
											<option value="0">Open</option>
											<option value="1">Pending</option>
											<option value="2">Resolved</option>
											<option value="3">Closed</option>
										</select>

										<div class="position-absolute top-50 end-0 translate-middle-y pe-3 pointer-events-none text-gray-600">
											<svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
												<path d="M7 7l3-3 3 3m0 6l-3 3-3-3" />
											</svg>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12 fv-row">
									<label for="ticket_description" class="col-form-label  fw-bold fs-6">Description</label>
									<textarea name="ticket_description" id="ticket_description" placeholder="Enter a ticket description"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" rows="4"></textarea>
								</div>
							</div>

							<div class="mb-4">
								<label for="attachments" class="col-form-label  fw-bold fs-6 n">Attachments</label>
								<div class="input-group">
									<input type="file" class="form-control form-control-lg border-primary-subtle shadow-sm" id="attachments" name="attachments" >
								</div>
								<div class="form-text">Accepted formats: PDF, JPG, PNG, DOCX. Max size: 5MB.</div>
							</div>
						

						<br> 	
						<div class="card-footer d-flex justify-content-end py-6 px-9" >
							<a href="{{route('list.ticket')}}" class="btn btn-light-success me-2"> Cancel </a>
							<button type="submit" class="btn btn-primary" id="kt_button_1">
								<span class="indicator-label">
									Submit
								</span>
								<span class="indicator-progress">
									Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
								</span>
							</button>  
						</div> 
					</form> 
				</div>
			</div>
		</div>
	</div>
</div>
<script>
//submit button
var button = document.querySelector("#kt_button_1");
button.addEventListener("click", function() {
button.setAttribute("data-kt-indicator", "on");
setTimeout(function() {
    button.removeAttribute("data-kt-indicator");
}, 3000);
});

//dropdown
$(document).ready(function() {
        $('#product').select2({
            placeholder: "Select a Product",
            allowClear: true
        });
    });
</script>
@endsection

 