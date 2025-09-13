@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Add </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Tasktimesheet</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
					<form action="{{ route('store.time') }}" method="post" class="form" enctype="multipart/form-data">
						@csrf

						<div class="row">
					
							<div class="col-lg-12 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Name</label>							
								<select name="goalid_ref[]"  id="goalid_ref" class="form-select mb-2 form-control" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
								@foreach($repu as $repus)	
										<option value="{{$repus->id}}">{{$repus->g_taskname}}</option>
								@endforeach
								</select> 
						</div>   
						<br> 	

						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">StartTime</label>
								<input type="time" name="starttime" id="starttime"  placeholder="starttime" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">EndTime</label>
								<input type="time" name="endtime" id="endtime"  placeholder="endtime" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
							
						</div>   
						<br> 
				
						<div class="card-footer d-flex justify-content-end py-6 px-9" >
							<a href="{{route('list.time')}}" class="btn btn-light-success me-2"> Cancel </a>
							<button type="submit" class="btn btn-primary">Save</button>  
						</div> 
					</form> 
				</div>
			</div>
		</div>
	</div>
</div>
@endsection