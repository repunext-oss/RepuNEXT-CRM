@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Edit </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Project / Service</span>
					</h3> 
				</div>
				<form action="{{ route('update.hdetail') }}" method="post" class="form" enctype="multipart/form-data">
				@csrf
					<div class="card-body border-0 pt-0">  
			
						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Host Name</label>
								<input type="text" name="host_name" id="host_name"  value="{{$repn->host_name}}" placeholder="host name" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Host UserName</label>
								<input type="text" name="host_username" id="host_username" value="{{$repn->host_username}}" placeholder="host username" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						
						</div> 
						<div class="row">  
						<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Host Password</label>
								<input type="text" name="host_password" id="host_password" value="{{$repn->host_password}}" placeholder="host password" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						<br> 	
						</div>
					<div class="card-footer d-flex justify-content-end py-6 px-9" >
						<a href="{{route('list.hdetail')}}" class="btn btn-light-success me-2"> Back </a>
						<button type="submit" class="btn btn-primary">Save Changes</button>   
					</div> 
				</form>
			</div>
		</div>
	</div>
</div>
@endsection