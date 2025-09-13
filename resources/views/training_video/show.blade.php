@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Training / Videos</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0">  
					<div class="row">
						<div class="col-lg-3 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Name</label>
							<input type="text" name="tv_name" id="tv_name" value="{{$tvideo->tv_name}}" readonly placeholder="Training Video Name" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
						</div>
						<div class="col-lg-3 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Description</label>
							<input type="text" name="tv_description" id="tv_description" value="{{$tvideo->tv_description}}" readonly placeholder="Description" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
						</div>

						<div class="col-lg-3 fv-row">
							<label class="col-lg-12 col-form-label fw-bold fs-6">Department</label>
							<select name="tv_department_display" id="tv_department" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" disabled>
									<option value="" disabled>Select a Department</option>
									<option value="Content" {{ isset($tvideo) && $tvideo->tv_department == 'Content' ? 'selected' : '' }}>Content</option>
									<option value="Design" {{ isset($tvideo) && $tvideo->tv_department == 'Design' ? 'selected' : '' }}>Design</option>
									<option value="Development" {{ isset($tvideo) && $tvideo->tv_department == 'Development' ? 'selected' : '' }}>Development</option>
									<option value="SEO" {{ isset($tvideo) && $tvideo->tv_department == 'SEO' ? 'selected' : '' }}>SEO</option>
									<option value="Support" {{ isset($tvideo) && $tvideo->tv_department == 'Support' ? 'selected' : '' }}>Support</option>
								</select>
								<!-- Hidden field to retain the value when submitting the form -->
								<input type="hidden" name="tv_department" value="{{ isset($tvideo) ? $tvideo->p_video : '' }}">
						</div> 
							<div class="col-lg-3 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Training Material</label>

							@if($tvideo->l_material && file_exists(public_path('upload/training_learn_materials/' . $tvideo->l_material)))
								@php
									$fileUrl = asset('upload/training_learn_materials/' . $tvideo->l_material);
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
									<label class="col-lg-12 col-form-label required fw-bold fs-6">Training Video</label>
								</span>
								<input type="hidden" name="tv_url" id="tv_url" />

								<div class="mt-3">
									@if($tvideo->tv_url && file_exists(public_path('upload/training_videos/' . $tvideo->tv_url)))
										<video id="corporateVideo" controls width="100%" height="400px">
											<source src="{{ asset('upload/training_videos/' . $tvideo->tv_url) }}" type="video/mp4">
											Your browser does not support the video tag.
										</video>
									@else
										<p>Training video not available</p>
									@endif
								</div>
							</div>
						</div>

		
					</div>
				</div>
				<div class="card-footer d-flex justify-content-end py-6 px-9" >
					<a href="{{route('list.tvideos')}}" class="btn btn-primary"> Back </a>
				</div> 
			</div>
		</div>
	</div>
</div>


@endsection  
