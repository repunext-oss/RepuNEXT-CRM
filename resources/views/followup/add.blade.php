@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Add</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Followup Details </span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
				<form action="{{ route('store.followup') }}" method="post" class="form" enctype="multipart/form-data">
   					 @csrf
					<div class="row">
						<div class="col-lg-4 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Enquiry Reference ID</label>
							<select name="Enquiry_ref_id" id="Enquiry_ref_id" class="form-select mb-3 form-control" data-control="select2" required>
								<option value="" selected disabled>Choose...</option>
								@foreach($support as $supports) 
									<option value="{{ $supports->id }}">{{ $supports->Name }}</option>
								@endforeach
							</select>
						</div>  

						<div class="col-lg-4 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Date</label>
							<input type="date" name="date" id="date" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
						</div> 

						<div class="col-lg-4 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Status</label>
							<select class="form-select" name="Status" required>
								<option value="" selected disabled>Choose...</option>
								<option value="Completed">Completed</option>    
							 	<option value="Pending">Pending</option>
								 <option value="Not Picked">Not Picked</option>
							</select>
						</div>
					</div> 

					<div class="row">
						<div class="col-lg-12 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Description</label>
							<textarea name="description" id="description" placeholder="Enter description" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"></textarea>
						</div>  
					</div>   
					<br> 	

					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<a href="{{route('list.followup')}}" class="btn btn-light-success me-2">Cancel</a>
						<button type="submit" class="btn btn-primary">Save</button>  
					</div> 
				</form>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection