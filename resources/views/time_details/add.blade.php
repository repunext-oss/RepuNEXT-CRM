@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card pt-4 " > 
				<div class="card-header pt-6">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Add</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Project / Detail</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
					<form action="{{ route('store.ptime') }}" method="post" class="form" enctype="multipart/form-data">
						@csrf

						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Project Name</label>
								<!-- <input type="text" name="project_ref_id" id="project_ref_id"  placeholder="project_ref_id" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/> -->
								<select name="project_ref_id" id="project_ref_id" class="form-select mb-3 form-control" data-control="select2">
									@foreach($title as $titles) 
										<option value="{{ $titles->id }}">{{ $titles->project_title }}</option>
									@endforeach
								</select>
							
							</div>  
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task Name</label>
								<input type="text" name="task_name" id="task_name"  placeholder="task_name" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div>   
						<br> 

						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task Date</label>
								<input type="date" name="task_date" id="task_date"  placeholder="task_date" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task Assigned</label>
								<input type="text" name="task_assigned" id="task_assigned"  placeholder="task_assigned" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div>   
						<br> 

						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task Start Time</label>
								<input type="date" name="task_start_time" id="task_start_time"  placeholder="task_start_time" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							
							</div>  
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task end Time</label>
								<input type="date" name="task_end_time" id="task_end_time"  placeholder="task end time" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div>   
						<br> 

						<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task Description </label>
								<textarea name="task_description" id="task_description"  rows="4" columns="45" placeholder="Task Description " required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
</textarea>
							
							</div>  
						</div>

						<!-- <div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">Task Status </label>
								<input type="text" name="task_status" id="task_status"  placeholder="Task task_status " required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div> -->

						

						<div class="card-footer d-flex justify-content-end py-6 px-9" >
							<a href="{{route('list.ptime')}}" class="btn btn-light-success me-2"> Cancel </a>
							<button type="submit" class="btn btn-primary">Save</button>  
						</div> 
					</form> 
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection