@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Tasktimesheet</span>
					</h3> 
				</div>
					<div class="card-body border-0 pt-0">  	   
					<div class="row">
							<div class="col-lg-6 fv-row">
							<input type="text" name="id" value="{{ $repn->id }}" hidden>
								<label class="col-lg-12 col-form-label required fw-bold fs-6">TaskTime Category</label>
				
								<select name="tt_cat[]"  id="tt_cat" class="form-select mb-3 form-control"  data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" readonly>
									<?php $mems=explode(',', $repn->tt_cat); ?> 	
									@foreach($serv as $servs)
											<option value="{{$servs->id}}" @if(in_array($servs->id,$mems)) selected @endif>{{$servs->tc_name}}</option>
										@endforeach
								</select>
							</div>  
							<div class="col-lg-6 fv-row">
							<input type="text" name="id" value="{{ $repn->id }}" hidden>
								<label class="col-lg-12 col-form-label required fw-bold fs-6">TaskTime name</label>
								<input type="text" name="tt_name" id="tt_name" value="{{ $repn->tt_name }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "readonly/>
							</div> 
					</div>   
					<br>
					 	
					<div class="row">
  					  	<div class="col-lg-12 fv-row">
							<label for="tt_desc" class="col-lg-12 col-form-label required fw-bold fs-6">TaskTime Description</label>
							<textarea name="tt_desc" id="tt_desc"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"readonly>{{ $repn->tt_desc }}</textarea>
						</div>
					</div>
					<br> 

						<div class="row">
							<div class="col-lg-6 fv-row">
							<input type="text" name="id" value="{{ $repn->id }}" hidden>
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task StartTime</label>
								<input type="text" name="tt_starttime" id="tt_starttime" value="{{ $repn->tt_starttime }}"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "readonly/>
							</div> 
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task EndTime</label>
								<input type="text" name="tt_endtime" id="tt_endtime" value="{{ $repn->tt_endtime }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "readonly/>
							</div>  
						</div>   
						<br> 

					</div>
					<div class="card-footer d-flex justify-content-end py-6 px-9" >
						<a href="{{route('list.ttimecat')}}" class="btn btn-light-success me-2"> Back </a>
						
					</div> 
				</form>
			</div>
		</div>
	</div>
</div>
@endsection