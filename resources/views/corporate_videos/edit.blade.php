@extends('admin.admin_master')
@section('admin')
<style>
    .custom-textarea {
        height: 150px; /* Increase height for better readability */
        font-size: 16px; /* Adjust font size */
        padding: 12px; /* Add padding for better spacing */
        resize: vertical; /* Allow vertical resizing but restrict horizontal resizing */
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Edit </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Corporate / Videos</span>
					</h3> 
				</div>
				<form action="{{ route('update.cvideo') }}" method="post" class="form" enctype="multipart/form-data">
				@csrf
					<div class="card-body border-0 pt-0">  
						<div class="row">
							<div class="col-lg-6 fv-row">
								<input type="text" name="id" value="{{ $cvideo->id }}" hidden>   
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Name</label>
								<input type="text" name="c_name" id="c_name" value="{{$cvideo->c_name}}" placeholder="Corporate Video Name" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label fw-bold fs-6">Department Video</label>
								<select name="p_video" id="p_video" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
									<option value="" disabled>Select a Purpose</option>
									<option value="General" {{ isset($pvideo) && $pvideo->p_video == 'Designer' ? 'selected' : '' }}>General</option>
									<option value="Gmail" {{ isset($pvideo) && $pvideo->p_video == 'Developer' ? 'selected' : '' }}>Gmail</option>
								</select>
							</div>
							<div class="row">
							<div class="col-lg-12 fv-row">  
								<label class="col-lg-12 col-form-label fw-bold fs-6">Corporate Video Description</label>
								<textarea name="c_description" id="c_description" placeholder="Corporate Video Description"
									class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 custom-textarea">{{ $cvideo->c_description }}</textarea>
							</div>
							</div>    
						</div> 
						<div class="row">
						<div class="col-lg-6 fv-row">  
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Corporate Video</label>

							<!-- Input for Uploading a New File -->
							<input type="file" name="c_url" id="c_url" placeholder="Corporate Video" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />

							<!-- Display Existing File Name -->
							@if($cvideo->c_url)
								<p class="form-text text-muted mt-2">Current File: <strong>{{ basename($cvideo->c_url) }}</strong></p>
							@else
								<p class="form-text text-muted mt-2">No file uploaded yet.</p>
							@endif
						</div>

						<div class="col-lg-6 fv-row">  
							<label class="col-lg-12 col-form-label fw-bold fs-6">Uploaded Training Material (PDF, DOCX, Images)</label>

							<!-- Input for Uploading New File -->
							<input type="file" name="l_material" id="l_material" placeholder="Corporate Video Description" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />

							<!-- Display Existing File Name -->
							@if($cvideo->l_material)
								<p class="form-text text-muted mt-2">Current File: <strong>{{ basename($cvideo->l_material) }}</strong></p>
							@else
								<p class="form-text text-muted mt-2">No file uploaded yet.</p>
							@endif
						</div>
 					</div> 
					</div>
					<div class="card-footer d-flex justify-content-end py-6 px-9" >
						<a href="{{route('list.cvideo')}}" class="btn btn-light-success me-2"> Back </a>
						<button type="submit" class="btn btn-primary">Save Changes</button>   
					</div> 
				</form>
			</div>
		</div>
	</div>
</div>
@endsection  



