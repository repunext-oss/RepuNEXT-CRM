@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Project / Service</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0">  
					<div class="row">
						<div class="col-lg-6 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Service Name</label>
							<input type="text" name="ps_name" id="ps_name" value="{{$repn->ps_name}}" readonly placeholder="Service Name" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
						</div>   
						<div class="col-lg-6 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Project Service Price</label>
							<input type="text" name="ps_price" id="ps_price" value="{{$repn->ps_price}}" readonly placeholder="Service Price" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
						</div>        
					</div>   
				</div>
				<div class="card-footer d-flex justify-content-end py-6 px-9" >
					<a href="{{route('list.pservice')}}" class="btn btn-primary"> Back </a>
				</div> 
			</div>
		</div>
	</div>
</div>
@endsection  
