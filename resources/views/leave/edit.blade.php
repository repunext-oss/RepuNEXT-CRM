@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Edit </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Leave Apply</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
				<form action="{{ route('update.leave') }}" method="post" class="form" enctype="multipart/form-data">
				@csrf
	
                	<div class="row">
					<div class="col-lg-6 fv-row">
						<label class="col-lg-12 col-form-label required fw-bold fs-6">User Name</label>
						<input type="hidden" name="id" value="{{ $repn->id }}">
						<!-- Hidden field to store name -->
						<input type="hidden" name="name" 
							value="{{ old('name', $repn->name ?? session('name')) }}">

						<!-- Read-only field to display the username -->
						<input type="text" class="form-control mb-3" 
							value="{{ old('username', $repn->user->username ?? session('username') ?? 'Not Available') }}" readonly>
					</div>
						<div class="col-lg-6 col-md-6 col-sm-12">
							<label class="col-form-label  fw-bold fs-6">Leave Type</label>
							<select name="leave_type" id="leave_type"  class="form-control form-control-lg" onchange="updateEndDateOnLeaveTypeChange()">
								<option value="" disabled>Select an Option</option>
								
								<option value="Late Entry/Exit 15 mins (2nd Half)" {{ $repn->leave_type == 'Late Entry/Exit 15 mins (2nd Half)' ? 'selected' : '' }}>Late Entry/Exit 15 mins (2nd Half)</option>
								<option value="Late Entry/Exit 15 mins (1st Half)" {{ $repn->leave_type == 'Late Entry/Exit 15 mins (1st Half)' ? 'selected' : '' }}>Late Entry/Exit 15 mins (1st Half)</option>
								<option value="Permission 1st Half" {{ $repn->leave_type == 'Permission 1st Half' ? 'selected' : '' }}>Permission 1st Half</option>
								<option value="Permission 2nd Half" {{ $repn->leave_type == 'Permission 2nd Half' ? 'selected' : '' }}>Permission 2nd Half</option>
								<option value="Leave" {{ $repn->leave_type == 'Leave' ? 'selected' : '' }}>Leave</option>
								<option value="Long Leave Apply" {{ $repn->leave_type == 'Long Leave Apply' ? 'selected' : '' }}>Long Leave Apply</option>
								<option value="Casual Leave" {{ $repn->leave_type == 'Casual Leave' ? 'selected' : '' }}>Casual Leave</option>
								<option value="Leave(Half Day)" {{ $repn->leave_type == 'Leave(Half Day)' ? 'selected' : '' }}>Leave(Half Day)</option>
								<option value="Loss of Pay(LOP)" {{ $repn->leave_type == 'Loss of Pay(LOP)' ? 'selected' : '' }}>Loss of Pay(LOP)</option>
							</select>
						</div>  
					</div>

					<div class="row">
						<div class="col-lg-6 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">Start Date</label>
							<input type="date" name="startdate" id="startdate" required 
								class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" 
								min="{{ date('Y-m-d') }}" 
								value="{{ old('startdate', $repn->startdate ?? date('Y-m-d')) }}" 
								onchange="updateEndDate()" />
						</div>

						<div class="col-lg-6 fv-row">
							<label class="col-lg-12 col-form-label required fw-bold fs-6">End Date</label>
							<input type="date" name="enddate" id="enddate" required 
								class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" 
								min="{{ old('startdate', $repn->startdate ?? date('Y-m-d')) }}" 
								value="{{ old('enddate', $repn->enddate ?? date('Y-m-d')) }}" />
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
								<option value="0.03" {{ $repn->totaldays == '0.03' ? 'selected' : '' }}>15 min</option>
								<option value="0.25" {{ $repn->totaldays == '0.25' ? 'selected' : '' }}>2 hours</option>
								<option value="0.5" {{ $repn->totaldays == '0.5' ? 'selected' : '' }}>Half day</option>
								<option value="1" {{ $repn->totaldays == '1' ? 'selected' : '' }}>1 day</option>
								<option value="2" {{ $repn->totaldays == '2' ? 'selected' : '' }}>2 days</option>
								<option value="3" {{ $repn->totaldays == '3' ? 'selected' : '' }}>3 days</option>
								<option value="4" {{ $repn->totaldays == '4' ? 'selected' : '' }}>4 days</option>
								<option value="5" {{ $repn->totaldays == '5' ? 'selected' : '' }}>5 days</option>
								<option value="6" {{ $repn->totaldays == '6' ? 'selected' : '' }}>6 days</option>
								<option value="7" {{ $repn->totaldays == '7' ? 'selected' : '' }}>7 days</option>
								<option value="8" {{ $repn->totaldays == '8' ? 'selected' : '' }}>8 days</option>
								<option value="9" {{ $repn->totaldays == '9' ? 'selected' : '' }}>9 days</option>
								<option value="10" {{ $repn->totaldays == '10' ? 'selected' : '' }}>10 days</option>
								<option value="11" {{ $repn->totaldays == '11' ? 'selected' : '' }}>11 days</option>
								<option value="12" {{ $repn->totaldays == '12' ? 'selected' : '' }}>12 days</option>
								<option value="13" {{ $repn->totaldays == '13' ? 'selected' : '' }}>13 days</option>
								<option value="14" {{ $repn->totaldays == '14' ? 'selected' : '' }}>14 days</option>
								<option value="15" {{ $repn->totaldays == '15' ? 'selected' : '' }}>15 days</option>
								<option value="16" {{ $repn->totaldays == '16' ? 'selected' : '' }}>16 days</option>
								<option value="17" {{ $repn->totaldays == '17' ? 'selected' : '' }}>17 days</option>
								<option value="18" {{ $repn->totaldays == '18' ? 'selected' : '' }}>18 days</option>
								<option value="19" {{ $repn->totaldays == '19' ? 'selected' : '' }}>19 days</option>
								<option value="20" {{ $repn->totaldays == '20' ? 'selected' : '' }}>20 days</option>
								<option value="21" {{ $repn->totaldays == '21' ? 'selected' : '' }}>21 days</option>
								<option value="22" {{ $repn->totaldays == '22' ? 'selected' : '' }}>22 days</option>
								<option value="23" {{ $repn->totaldays == '23' ? 'selected' : '' }}>23 days</option>
								<option value="24" {{ $repn->totaldays == '24' ? 'selected' : '' }}>24 days</option>
								<option value="25" {{ $repn->totaldays == '25' ? 'selected' : '' }}>25 days</option>
								<option value="26" {{ $repn->totaldays == '26' ? 'selected' : '' }}>26 days</option>
								<option value="27" {{ $repn->totaldays == '27' ? 'selected' : '' }}>27 days</option>
								<option value="28" {{ $repn->totaldays == '28' ? 'selected' : '' }}>28 days</option>
								<option value="29" {{ $repn->totaldays == '29' ? 'selected' : '' }}>29 days</option>
								<option value="30" {{ $repn->totaldays == '30' ? 'selected' : '' }}>30 days</option>
								<option value="31" {{ $repn->totaldays == '31' ? 'selected' : '' }}>31 days</option>
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
					
					<div class="card-footer d-flex justify-content-end py-6 px-9" >
						<a href="{{route('list.leave')}}" class="btn btn-light-success me-2"> Back </a>
						<button type="submit" class="btn btn-primary">Save Changes</button>   
					</div> 
				</form>
			</div>
		</div>
	</div>
</div>

<script>
    function updateEndDate() {
        let startDateInput = document.getElementById('startdate');
        let endDateInput = document.getElementById('enddate');
        let leaveTypeSelect = document.getElementById('leave_type');

        console.log('updateEndDate called (edit form)');
        console.log('Start date:', startDateInput.value);
        console.log('Leave type:', leaveTypeSelect.value);

        if (startDateInput.value) {
            let startDate = new Date(startDateInput.value);
            let leaveType = leaveTypeSelect.value;

            // Check if it's permission or 15 min late entry/exit
            let isPermissionOrLate = leaveType.includes('Permission 1st Half') || leaveType.includes('Permission 2nd Half') || 
                                   leaveType.includes('Late Entry/Exit 15 mins (1st Half)') || leaveType.includes('Late Entry/Exit 15 mins (2nd Half)');
            
            console.log('Is permission or late:', isPermissionOrLate);

            if (isPermissionOrLate) {
                // For permission and 15 min late, end date = start date
                endDateInput.value = startDateInput.value;
                endDateInput.min = startDateInput.value;
                endDateInput.max = startDateInput.value;
                endDateInput.readOnly = true;
                endDateInput.style.backgroundColor = '#f8f9fa';
            } else {
                // For regular leaves, allow end date to be same or after start date
                endDateInput.readOnly = false;
                endDateInput.style.backgroundColor = '';
                endDateInput.min = startDateInput.value;
                endDateInput.max = '';
                
                // Clear the selected End Date if it's before the start date
                if (endDateInput.value && new Date(endDateInput.value) < startDate) {
                    endDateInput.value = '';
                }
            }
        } else {
            endDateInput.min = "{{ date('Y-m-d') }}"; // Reset min date if Start Date is cleared
            endDateInput.readOnly = false;
            endDateInput.style.backgroundColor = '';
            endDateInput.max = '';
        }
    }

    // Also trigger when leave type changes
    function updateEndDateOnLeaveTypeChange() {
        console.log('Leave type changed (edit form)');
        let startDateInput = document.getElementById('startdate');
        if (startDateInput.value) {
            updateEndDate();
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateEndDate();
    });
</script>

@endsection