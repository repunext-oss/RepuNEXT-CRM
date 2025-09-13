@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> /Timesheet Category</span>
					</h3> 
				</div>
					<div class="card-body border-0 pt-0">  
						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">TimesheetCategory Name</label>
								<input type="text" name="tc_name" id="tc_name" value="{{ $repn->tc_name }}" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div> 
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label required fw-bold fs-6">TimesheetCategory Name</label>
								<input type="text" name="tc_designation_category" id="tc_designation_category" value="{{ $repn->tc_designation_category }}" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "/>
							</div>  
						</div>   
						<br> 


					<div class="card-footer d-flex justify-content-end py-6 px-9" >
						<a href="{{route('list.timecat')}}" class="btn btn-light-success me-2"> Back </a>
						<!-- <button type="submit" class="btn btn-primary">Save Changes</button>    -->
					</div> 
				</form>
			</div>
		</div>
	</div>
</div>
@endsection