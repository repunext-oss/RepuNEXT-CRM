@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Edit </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Tasktimesheet</span>
					</h3> 
				</div>
				<form action="{{ route('update.time') }}" method="post" class="form" enctype="multipart/form-data">
				@csrf
					<div class="card-body border-0 pt-0">  	   
						<div class="row">
							<div class="col-lg-12 fv-row">
								<input type="text" name="id" value="{{ $repn->id }}" hidden>
									
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Name</label>
									<select name="goalid_ref[]"  id="goalid_ref" class="form-select mb-3 form-control"  data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" >
										<?php $mems=explode(',', $repn->goalid_ref); ?> 	
										@foreach($serv as $servs)
												<option value="{{$servs->id}}" @if(in_array($servs->id,$mems)) selected @endif>{{$servs->g_taskname}}</option>
											@endforeach
									</select>
							</div>  
						</div>

						<div class="row">
							<div class="col-lg-6 fv-row">
							<input type="text" name="id" value="{{ $repn->id }}" hidden>
								<label class="col-lg-12 col-form-label required fw-bold fs-6">StartTime</label>
								<input type="time" name="starttime" id="starttime" value="{{ $repn->starttime }}" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div> 
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task EndTime</label>
								<input type="time" name="endtime" id="endtime" value="{{ $repn->endtime }}" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div>   
						<br> 

					</div>
					<div class="card-footer d-flex justify-content-end py-6 px-9" >
						<a href="{{route('list.time')}}" class="btn btn-light-success me-2"> Back </a>
						<button type="submit" class="btn btn-primary">Save Changes</button>   
					</div> 
				</form>
			</div>
		</div>
	</div>
</div>
@endsection