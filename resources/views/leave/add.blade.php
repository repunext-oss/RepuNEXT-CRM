@extends('admin.admin_master')
@section('admin')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card pt-4">
                <div class="card-header pt-6">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Add</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Leave Apply
                        </span>
                    </h3>
                </div>
                <div class="card-body border-0 pt-0">
                    <form action="{{ route('store.leave') }}" method="post" class="form" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                           

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="col-form-label required fw-bold fs-6">Leave Type</label>
                                <select name="leave_type" id="leave_type" required class="form-control form-control-lg" onchange="updateEndDateOnLeaveTypeChange()">
                                    <option value="" disabled selected>Select an Option</option>
                                    <option>Late Entry/Exit 15 mins (1st Half)</option>
                                    <option>Late Entry/Exit 15 mins (2nd Half)</option>
                                    <option>Permission 1st Half</option>
                                    <option>Permission 2nd Half</option>
                                    <option>Leave</option>
                                    
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="col-form-label required fw-bold fs-6">Total Days</label>
                                <select name="totaldays" id="totaldays" required class="form-control form-control-lg">
                                    <option value="" disabled selected>Select an Option</option>
                                    <option value="0.03">15 min</option>
                                    <option value="0.25">2 hours</option>
                                    <option value="0.5">Half day</option>
                                    <option value="1">1 day</option>
                                    <option value="2">2 days</option>
                                    <option value="3">3 days</option>
                                    <option value="4">4 days</option>
                                    <option value="5">5 days</option>
                                    <option value="6">6 days</option>
                                    <option value="7">7 days</option>
                                    <option value="8">8 days</option>
                                    <option value="9">9 days</option>
                                    <option value="10">10 days</option>
                                    <option value="11">11 days</option>
                                    <option value="12">12 days</option>
                                    <option value="13">13 days</option>
                                    <option value="14">14 days</option>
                                    <option value="15">15 days</option>
                                    <option value="16">16 days</option>
                                    <option value="17">17 days</option>
                                    <option value="18">18 days</option>
                                    <option value="19">19 days</option>
                                    <option value="20">20 days</option>
                                    <option value="21">21 days</option>
                                    <option value="22">22 days</option>
                                    <option value="23">23 days</option>
                                    <option value="24">24 days</option>
                                    <option value="25">25 days</option>
                                    <option value="26">26 days</option>
                                    <option value="27">27 days</option>
                                    <option value="28">28 days</option>
                                    <option value="29">29 days</option>
                                    <option value="30">30 days</option>
                                    <option value="31">31 days</option>
                                </select>
                            </div>


                        <div class="row">
                             <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Start Date</label>
                                <input type="date" name="startdate" id="startdate" required 
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" 
                                    min="{{ date('Y-m-d') }}" onchange="updateEndDate()" />
                            </div>

                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">End Date</label>
                                <input type="date" name="enddate" id="enddate" required 
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                         </div>

                        <div class="row">
                            <div class="col-lg-12 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Reason</label>
                                <textarea name="reason" id="reason" placeholder="Enter reason" required 
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            
                            <div class="col-lg-6 fv-row">
                                <!-- <label class="col-lg-12 col-form-label required fw-bold fs-6">User Name</label> -->
                                <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                                <input type="hidden" class="form-control mb-3" value="{{ session('username') ?? 'Not Available' }}" readonly>
                            </div>

                            <!-- Status Dropdown (Hidden) --> 
                            <!-- <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="l_status" class="col-form-label required fw-bold fs-6">Status</label>
                                <select name="l_status" id="l_status" class="form-control form-control-lg" required>
                                    <option value="0" selected>Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div> -->
                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('list.leave') }}" class="btn btn-light-success me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function updateEndDate() {
        let startDateInput = document.getElementById('startdate');
        let endDateInput = document.getElementById('enddate');
        let leaveTypeSelect = document.getElementById('leave_type');

        console.log('updateEndDate called');
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
        console.log('Leave type changed');
        let startDateInput = document.getElementById('startdate');
        if (startDateInput.value) {
            updateEndDate();
        }
    }
</script>


@endsection
