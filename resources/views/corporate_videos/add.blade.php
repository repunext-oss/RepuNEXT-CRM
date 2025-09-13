@extends('admin.admin_master')
@section('admin')
<style>
    .custom-textarea {
        height: 150px; /* Increase textarea height */
        font-size: 18px;
        padding: 12px;
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Add</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Corporate / Videos</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
					<form action="{{ route('store.cvideo') }}" method="post" class="form" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Corporate Video Name</label>
								<input type="text" name="c_name" id="c_name"  placeholder="Corpoate Video Name" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
							
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label fw-bold fs-6">Purpose Video</label>
								<select name="p_video" id="p_video" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
									<option value="" disabled selected>Select a Purpose</option>
									<option value="General">General</option>
									<option value="Email">Gmail</option>
								</select>
							</div>  
						</div>
						<div class="row">
						<div class="col-lg-12 fv-row">
							<label class="col-lg-12 col-form-label fw-bold fs-6">Corporate Video Description</label>
							<textarea name="c_description" id="c_description" placeholder="Corporate Video"
								class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 custom-textarea"></textarea>
						</div>  
						</div>  
						<div class="row">	
						<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Corporate Video</label>
								<input type="file" name="c_url" id="c_url"  placeholder="Corpoate Video" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div> 
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label fw-bold fs-6">Uploaded Traning Material (PDF, DOCX, Images)</label>
								<input type="file" name="l_material" id="l_material"  placeholder="Traning Material" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"/>
							</div>  
						</div>      
						<br> 
						<div class="card-footer d-flex justify-content-end py-6 px-9" >
							<a href="{{route('list.cvideo')}}" class="btn btn-light-success me-2"> Cancel </a>
							<button type="submit" class="btn btn-primary">Save</button>  
						</div> 
					</form> 
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

 