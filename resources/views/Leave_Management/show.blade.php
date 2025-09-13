@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card " style="width: 114%;"> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / leave</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
				<div class="row">
						<div class="col-lg-6 fv-row">
						<input type="text" name="id" value="{{ $repn->id }}" hidden>   
							<label class="col-lg-12 col-form-label  fw-bold fs-6">User Name</label>
							<select name="name" id="name" class="form-select mb-3 form-control" data-control="select2">
								@foreach($user as $users)
									<option value="{{ $users->id }}" {{ $repn->name == $users->id ? 'selected' : '' }}>
										{{ $users->username }}
									</option>
								@endforeach
							</select>
						</div>  
						<div class="col-lg-6 col-md-6 col-sm-12">
							<label class="col-form-label  fw-bold fs-6">Leave Type</label>
							<select name="leave_type" id="leave_type"  class="form-control form-control-lg">
								<option value="" disabled>Select an Option</option>
								<option value="Restricted Holiday" {{ $repn->leave_type == 'Restricted Holiday' ? 'selected' : '' }}>Restricted Holiday</option>
								<option value="Late Entry/Exit 15 mins (2nd Half)" {{ $repn->leave_type == 'Late Entry/Exit 15 mins (2nd Half)' ? 'selected' : '' }}>Late Entry/Exit 15 mins (2nd Half)</option>
								<option value="Late Entry/Exit 15 mins (1st Half)" {{ $repn->leave_type == 'Late Entry/Exit 15 mins (1st Half)' ? 'selected' : '' }}>Late Entry/Exit 15 mins (1st Half)</option>
								<option value="Permission 1st Half" {{ $repn->leave_type == 'Permission 1st Half' ? 'selected' : '' }}>Permission 1st Half</option>
								<option value="Permission 2nd Half" {{ $repn->leave_type == 'Permission 2nd Half' ? 'selected' : '' }}>Permission 2nd Half</option>
								<option value="Sick Leave" {{ $repn->leave_type == 'Sick Leave' ? 'selected' : '' }}>Sick Leave</option>
								<option value="Long Leave Apply" {{ $repn->leave_type == 'Long Leave Apply' ? 'selected' : '' }}>Long Leave Apply</option>
								<option value="Casual Leave" {{ $repn->leave_type == 'Casual Leave' ? 'selected' : '' }}>Casual Leave</option>
								<option value="Leave(Half Day)" {{ $repn->leave_type == 'Leave(Half Day)' ? 'selected' : '' }}>Leave(Half Day)</option>
								<option value="Loss of Pay(LOP)" {{ $repn->leave_type == 'Loss of Pay(LOP)' ? 'selected' : '' }}>Loss of Pay(LOP)</option>
							</select>
						</div>  
					</div>

					<div class="row">
						<div class="col-lg-6 fv-row">
							<label class="col-lg-12 col-form-label  fw-bold fs-6">Start Date</label>
							<input type="date" name="startdate" id="startdate" value="{{ $repn->startdate }}"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"/>
						</div>  
						<div class="col-lg-6 fv-row">
							<label class="col-lg-12 col-form-label  fw-bold fs-6">End Date</label>
							<input type="date" name="enddate" id="enddate" value="{{ $repn->enddate }}"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"/>
						</div>  
					</div>

					<div class="row">
						<div class="col-lg-12 fv-row">
							<label class="col-lg-12 col-form-label  fw-bold fs-6">Reason</label>
							<textarea name="reason" id="reason"  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">{{ $repn->reason }}</textarea>
						</div>  
					</div>   

					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12">
							<label class="col-form-label  fw-bold fs-6">Total Days</label>
							<select name="totaldays" id="totaldays"  class="form-control form-control-lg">
								<option value="" disabled>Select an Option</option>
								<option value="15 min" {{ $repn->totaldays == '15 min' ? 'selected' : '' }}>15 min</option>
								<option value="Half day" {{ $repn->totaldays == 'Half day' ? 'selected' : '' }}>Half day</option>
								<option value="1 days" {{ $repn->totaldays == '1 days' ? 'selected' : '' }}>1 days</option>
								<option value="2 days" {{ $repn->totaldays == '2 days' ? 'selected' : '' }}>2 days</option>
								<option value="3 days" {{ $repn->totaldays == '3 days' ? 'selected' : '' }}>3 days</option>
								<option value="4 days" {{ $repn->totaldays == '4 days' ? 'selected' : '' }}>4 days</option>
								<option value="1 Week" {{ $repn->totaldays == '1 Week' ? 'selected' : '' }}>1 Week</option>
								<option value="2 Week" {{ $repn->totaldays == '2 Week' ? 'selected' : '' }}>2 Week</option>
								<option value="3 Week" {{ $repn->totaldays == '3 Week' ? 'selected' : '' }}>3 Week</option>
								<option value="4 Week" {{ $repn->totaldays == '4 Week' ? 'selected' : '' }}>4 Week</option>
								<option value="1 Month" {{ $repn->totaldays == '1 Month' ? 'selected' : '' }}>1 Month</option>
							</select>
						</div>  

						<div class="col-lg-6 col-md-6 col-sm-12">
							<label class="col-form-label  fw-bold fs-6">Status</label>
							<select name="l_status" id="l_status"  class="form-control form-control-lg">
								<option value="0" {{ $repn->l_status == 'Pending' ? 'selected' : '' }}>Pending</option>
								<option value="1" {{ $repn->l_status == 'Approved' ? 'selected' : '' }}>Approved</option>
								<option value="2" {{ $repn->l_status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
							</select>
						</div>
					</div>
				</div>
					<div class="card-footer d-flex justify-content-end py-6 px-9" >
						<a href="{{route('list.leave')}}" class="btn btn-light-success me-2"> Back </a>
					</div> 
					
				</form>
			</div>
		</div>
		</div>
	</div>
</div>
@endsection