@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Edit </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Followup Details</span>
					</h3> 
				</div>

				<!-- Update Form -->
				<form action="{{ route('update.followup') }}" method="post" class="form" enctype="multipart/form-data">
					@csrf
					<div class="card-body border-0 pt-0"> 
					<div class="row">

						<div class="col-lg-4 fv-row">
							<input type="hidden" name="id" value="{{ $repn->id }}">  
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Enquiry Reference ID</label>
							<select name="Enquiry_ref_id" id="Enquiry_ref_id" class="form-select mb-3 form-control" data-control="select2" required>
								<option value="" disabled>Choose...</option>
								@foreach($support as $supports) 
									<option value="{{ $supports->id }}" 
										{{ $repn->Enquiry_ref_id == $supports->id ? 'selected' : '' }}>
										{{ $supports->Name }}
									</option>
								@endforeach
							</select>
						</div>  

						<!-- Date Field -->
						<div class="col-lg-4 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Date</label>
							<input type="date" name="date" id="date" value="{{ old('date', $repn->date) }}" required 
								class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
						</div> 

				
						<div class="col-lg-4 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Status</label>
							<select class="form-select" name="Status" required>
								<option value="" disabled>Choose...</option>
								<option value="Completed" {{ $repn->Status == 'Completed' ? 'selected' : '' }}>Completed</option>    
								<option value="Pending" {{ $repn->Status == 'Pending' ? 'selected' : '' }}>Pending</option>
								<option value="Not Picked" {{ $repn->Status == 'Not Picked' ? 'selected' : '' }}>Not Picked</option>
							</select>
						</div>
					</div> 

					<!-- Description -->
					<div class="row">
						<div class="col-lg-12 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Description</label>
							<textarea name="description" id="description" required 
								class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">{{ old('description', $repn->description) }}</textarea>
						</div>  
					</div>   
					<br> 

					<!-- Buttons -->
					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<a href="{{route('list.followup')}}" class="btn btn-light-success me-2">Back</a>
						<button type="submit" class="btn btn-primary">Save Changes</button>   
					</div> 
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
