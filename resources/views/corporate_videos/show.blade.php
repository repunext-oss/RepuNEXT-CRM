@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Corporate Videos</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0">  
					<div class="row">
						<div class="col-lg-3 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Name</label>
							<input type="text" name="c_name" id="c_name" value="{{$cvideo->c_name}}" readonly placeholder="Corporate Video Name" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
						</div>
						<div class="col-lg-3 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Description</label>
							<input type="text" name="c_description" id="c_description" value="{{$cvideo->c_description}}" readonly placeholder="Description" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
						</div>

						<div class="col-lg-3 fv-row">
							<label class="col-lg-12 col-form-label fw-bold fs-6">Purpose Video</label>
							<select name="p_video_display" id="p_video" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" disabled>
									<option value="" disabled>Select a Purpose</option>
									<option value="Designer" {{ isset($pvideo) && $pvideo->p_video == 'Designer' ? 'selected' : '' }}>General</option>
									<option value="Developer" {{ isset($pvideo) && $pvideo->p_video == 'Developer' ? 'selected' : '' }}>Gmail</option>
								</select>
								<!-- Hidden field to retain the value when submitting the form -->
								<input type="hidden" name="p_video" value="{{ isset($pvideo) ? $pvideo->p_video : '' }}">
						</div>
						<div class="col-lg-3 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Training Material</label>

								@if($cvideo->l_material && file_exists(public_path('upload/corporate_materials/' . $cvideo->l_material)))
									@php
										$fileUrl = asset('upload/corporate_materials/' . $cvideo->l_material);
									@endphp

									@if($fileExtension == 'pdf')
										<!-- Open PDF in a New Tab -->
										<a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary btn-lg w-100 p-3">
											View Training Material (PDF)
										</a>
									@elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
										<!-- Image Viewer -->
										<a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary btn-lg w-100 p-3">
											View Image
										</a>
									@elseif(in_array($fileExtension, ['doc', 'docx']))
										<!-- Word Document Viewer -->
										<a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary btn-lg w-100 p-3">
											Download Document
										</a>
									@else
										<p>Unsupported File Type</p>
									@endif
								@else
									<p>No Training Material Available</p>
								@endif
							</div>


					<div class="row">
							<div class="col-lg-12 fv-row">
								<span class="mt-5">
									<label class="col-lg-12 col-form-label required fw-bold fs-6">Corporate Video</label>
								</span>
								<input type="hidden" name="c_url" id="c_url" />

								<div class="mt-3">
									@if($cvideo->c_url && file_exists(public_path('upload/corporate_videos/' . $cvideo->c_url)))
										<video id="corporateVideo" controls width="100%" height="400px">
											<source src="{{ asset('upload/corporate_videos/' . $cvideo->c_url) }}" type="video/mp4">
											Your browser does not support the video tag.
										</video>
									@else
										<p>Corporate video not available</p>
									@endif
								</div>
							</div>

						
					<div class="row">
	
					</div>
				</div>
				<div class="card-footer d-flex justify-content-end py-6 px-9" >
					<a href="{{route('list.cvideo')}}" class="btn btn-primary"> Back </a>
				</div> 
			</div>
		</div>
	</div>
</div>
</div>

@endsection  
