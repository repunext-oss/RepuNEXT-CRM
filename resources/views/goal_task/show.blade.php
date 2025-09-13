@extends('admin.admin_master')
@section('admin')
<style>
    .custom-input-size {
        width: 100%; /* or a fixed width, e.g., 400px */
        height: 70px; /* Adjust as needed */
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card" style="background-color: #E1EBEE"> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Project / Service</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0">  
						<div class="row">
						
						<div class="col-lg-6 fv-row">
							<input type="hidden" name="id" value="{{ $repn->id }}">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Status</label>
							<select name="g_status" id="g_status" class="form-control form-control-lg form-control mb-3 mb-lg-0"disabled>
								<option value="" disabled>Goal Status</option>
								<option value="new" {{ $repn->g_status == 'new' ? 'selected' : '' }}>New</option>
								<option value="pending" {{ $repn->g_status == 'Pending' ? 'selected' : '' }}>Pending</option>
								<option value="completed" {{ $repn->g_status == 'completed' ? 'selected' : '' }}>Completed</option>
							</select>
						</div>


							<div class="col-lg-6 fv-row"> 
								<label class="col-lg-12 col-form-label fw-bold fs-6">Goal Task Name</label>
								<input type="text" name="g_taskname" id="g_taskname" value="{{ $repn->g_taskname }}" placeholder="Goal Task Name" class="form-control form-control-lg form-control mb-3 mb-lg-0" disabled />
							</div> 
						</div> 
						<div class="row">
							<div class="col-lg-4 fv-row">  
								<label class="col-lg-12 col-form-label fw-bold fs-6">Goal Deadline</label>
								<input type="date" name="g_deadline" id="g_deadline" value="{{ $repn->g_deadline }}" placeholder="Goal Deadline" class="form-control form-control-lg form-control mb-3 mb-lg-0" disabled />
							</div>
							<div class="col-lg-4 fv-row">
							<label for="timer" class="col-lg-12 col-form-label required fw-bold fs-6">Select time to complete task</label>
							<select name="timer" id="timer" class="form-control form-control-lg form-control mb-3 mb-lg-0"disabled>
								<option value="" disabled {{ !isset($repn->timer) ? 'selected' : '' }}>Select Priority</option>
								<option value="5" {{ isset($repn->timer) && $repn->timer == 5 ? 'selected' : '' }}>5 minutes</option>
								<option value="10" {{ isset($repn->timer) && $repn->timer == 10 ? 'selected' : '' }}>10 minutes</option>
								<option value="20" {{ isset($repn->timer) && $repn->timer == 20 ? 'selected' : '' }}>20 minutes</option>
								<option value="30" {{ isset($repn->timer) && $repn->timer == 30 ? 'selected' : '' }}>30 minutes</option>
								<option value="60" {{ isset($repn->timer) && $repn->timer == 60 ? 'selected' : '' }}>1 hour</option>
								<option value="120" {{ isset($repn->timer) && $repn->timer == 120 ? 'selected' : '' }}>2 hours</option>
								<option value="180" {{ isset($repn->timer) && $repn->timer == 180 ? 'selected' : '' }}>3 hours</option>
								<option value="240" {{ isset($repn->timer) && $repn->timer == 240 ? 'selected' : '' }}>4 hours</option>
								<option value="480" {{ isset($repn->timer) && $repn->timer == 480 ? 'selected' : '' }}>8 hours</option>
								<option value="720" {{ isset($repn->timer) && $repn->timer == 720 ? 'selected' : '' }}>12 hours</option>
								<option value="960" {{ isset($repn->timer) && $repn->timer == 960 ? 'selected' : '' }}>16 hours</option>
								<option value="1200" {{ isset($repn->timer) && $repn->timer == 1200 ? 'selected' : '' }}>20 hours</option>
								<option value="1440" {{ isset($repn->timer) && $repn->timer == 1440 ? 'selected' : '' }}>24 hours</option>
							</select>
						</div>



							<div class="col-lg-4 fv-row">  
								<label class="col-lg-12 col-form-label fw-bold fs-6">Goal Category</label>
								<select name="g_categroy[]" id="g_category" class="form-select mb-3 form-control" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" disabled>
								@php $gcategory = explode(',', $repn->g_category); @endphp	
									@foreach($gscc as $gsccs)
										<option value="{{ $gsccs->id }}" {{ in_array($gsccs->id, $gcategory) ? 'selected' : '' }}>{{ $gsccs->gc_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="row">	
						<div class="col-lg-6 fv-row">  
							<label class="col-lg-12 col-form-label fw-bold fs-6">Goal Priority</label>
							<select name="g_priority" id="g_priority" class="form-control form-control-lg form-control mb-3 mb-lg-0" disabled>
								<option value="" disabled>Goal Priority</option>
								<option value="high" {{ isset($repn->g_priority) && $repn->g_priority == 'high' ? 'selected' : '' }}>High</option>
								<option value="medium" {{ isset($repn->g_priority) && $repn->g_priority == 'medium' ? 'selected' : '' }}>Medium</option>
								<option value="low" {{ isset($repn->g_priority) && $repn->g_priority == 'low' ? 'selected' : '' }}>Low</option>
							</select>
						</div>

						<div class="col-lg-6 fv-row">
							<label class="col-lg-12 col-form-label fw-bold fs-6">Goal Assigned</label>
							<select name="g_assigned[]" id="g_assigned" class="form-select mb-3 form-control" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple disabled>
								@php 
									$mems = isset($repn->g_assigned) ? explode(',', $repn->g_assigned) : []; 
								@endphp    
								@foreach($rep as $reps)
									<option value="{{ $reps->id }}" {{ in_array($reps->id, $mems) ? 'selected' : '' }}>{{ $reps->name }}</option>
								@endforeach
							</select>                            
						</div>

						</div>  	
						<div class="row">
							<div class="col-lg-12 fv-row"> 
							<label class="col-lg-12 col-form-label fw-bold fs-6">Goal Description</label> 
								<textarea name="g_description" id="g_description"
									placeholder="Goal Description"
									class="form-control form-control-lg mb-3 mb-lg-0"
									style="height: 100px; max-height: 300px; width: 100%; resize: vertical;" disabled>{{ $repn->g_description }}</textarea>
							</div>

						</div> 
					</div>
				<div class="card-footer d-flex justify-content-end py-6 px-9" >
					<a href="{{route('list.gtask')}}" class="btn btn-primary"> Back </a>
				</div> 
			</div>
		</div>
	</div>
</div>
@endsection  



