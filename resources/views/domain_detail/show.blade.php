@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Project / Domain</span>
					</h3> 
				</div>
				<form action="{{ route('update.ddetail') }}" method="post" class="form" enctype="multipart/form-data">
				@csrf
					<div class="card-body border-0 pt-0">  
					<div class="row">
							<div class="col-lg-6 fv-row">
							<input type="text" name="id" value="{{ $repn->id }}" hidden>   
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Domain Name</label>
								<input type="text" name="domain_name" id="domain_name" value="{{$repn->domain_name}}" placeholder="domain name" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div> 
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Host Id</label>
								<select name="host_name[]" id="host_name" class="form-select mb-3 form-control" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                <?php $mem=explode(',', $repn->host_name); ?> 
								@foreach($host as $hosts)	
										<option value="{{$hosts->id}}" @if(in_array($hosts->id,$mem)) selected @endif>{{$hosts->host_name}}</option>
								@endforeach
								</select>
							</div>  
						
						</div>   
						<br> 
						<div class="row">
							 
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Type</label>
								<select name="type_name[]" id="type_name" class="form-select mb-3 form-control" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                <?php $mem=explode(',', $repn->type_name); ?> 
								@foreach($type as $types)	
										<option value="{{$types->id}}" @if(in_array($types->id,$mem)) selected @endif>{{$types->type_name}}</option>
								@endforeach
								</select>
							</div>  
							 <div class="col-lg-6 fv-row">
								 <label class="col-lg-12 col-form-label required fw-bold fs-6">Backend username</label>
								 <input type="text" name="backend_user" id="backend_user" value="{{$repn->backend_user}}" placeholder="backend user" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							 </div>  
							 
						 </div>
						 <div class="row">
							 
							 <div class="col-lg-6 fv-row">
								 <label class="col-lg-12 col-form-label required fw-bold fs-6">Backend password</label>
								 <input type="text" name="backend_password" id="backend_password"  value="{{$repn->backend_password}}"  placeholder="backend password" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							 </div> 
						 
						 </div>   

					<div class="card-footer d-flex justify-content-end py-6 px-9" >
						<a href="{{route('list.ddetail')}}" class="btn btn-light-success me-2"> Back </a>
						<button type="submit" class="btn btn-primary">Save Changes</button>   
					</div> 
				</form>
			</div>
		</div>
	</div>
</div>
@endsection