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
							<input type="text" name="id" value="{{ $repn->id }}" hidden>   
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Project Title</label>
								<input type="text" name="project_title" id="project_title" value="{{$repn->project_title}}" readonly placeholder="Project Title" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Project Description</label>
								<input type="text" name="project_description" id="project_description" value="{{$repn->project_description}}"  placeholder="Project Description" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div>   
						<br> 

						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Project Start Date</label>
								<input type="date" name="project_start_date" id="project_start_date" value="{{$repn->project_start_date}}"  placeholder="Project Start Date" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Project End Date</label>
								<input type="date" name="project_end_date" id="project_end_date" value="{{$repn->project_end_date}}"  placeholder="Service End Date" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div>   
						<br> 

						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Project Service Category</label>
								<select name="project_service_category[]"  id="project_service_category" class="form-select mb-3 form-control"  data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" disabled>
								<?php $mems=explode(',', $repn->project_service_category); ?> 	
									@foreach($serv as $servs)
											<option value="{{$servs->id}}" @if(in_array($servs->id,$mems)) selected @endif>{{$servs->ps_name}}</option>
										@endforeach
									</select>
							</div>  
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Project Timeline</label>
								<input type="text" name="project_timeline" id="project_timeline" value="{{$repn->project_timeline}}"  placeholder="Project Timeline" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div>   
						<br> 

						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Project To Member</label>
								<select name="assigned_to_member[]" id="assigned_to_member" class="form-select mb-3 form-control" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                <?php $mem=explode(',', $repn->assigned_to_member); ?> 
								@foreach($rep as $reps)	
										<option value="{{$reps->id}}" @if(in_array($reps->id,$mem)) selected @endif>{{$reps->name}}</option>
								@endforeach
								</select>
							</div>  
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Project Priority</label>
								<input type="text" name="project_priority" id="project_priority" value="{{$repn->project_priority}}"  placeholder="Project Priority" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div>   
						<br> 

					</div>
					<div class="card-footer d-flex justify-content-end py-6 px-9" >
						<a href="{{route('list.pdetail')}}" class="btn btn-light-success me-2"> Back </a>
					</div> 
				</form>
			</div>
		</div>
	</div>
</div>
@endsection