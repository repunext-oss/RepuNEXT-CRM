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
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / LeaveManagement
                        </span>
                    </h3>
                </div>
                <div class="card-body border-0 pt-0">
                    <form action="{{ route('store.leaveManagement') }}" method="post" class="form" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                        <input type="hidden" class="form-control mb-3" value="{{ session('username') ?? 'Not Available' }}" readonly>

                        <div class="row">
                           <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Select Users</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="select_all_users" onchange="toggleAllUsers()">
                                    <label class="form-check-label fw-bold" for="select_all_users">
                                        Select All Users
                                    </label>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedUsersText">Select Users</span>
                                    </button>
                                    <ul class="dropdown-menu w-100" aria-labelledby="userDropdown" style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($user as $users)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input user-checkbox" type="checkbox" value="{{ $users->id }}" id="user_{{ $users->id }}" onchange="updateSelectedUsers()">
                                                    <label class="form-check-label" for="user_{{ $users->id }}">
                                                        {{ $users->name }}
                                                    </label>
                                                </div>
                                            </li>
                                    @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" name="user_ids" id="selected_user_ids" required>
                                <small class="text-muted">Click to select multiple users</small>
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Credit Date</label>
                                <input type="date" name="credit_date" id="credit_date" required 
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ date('Y-m-d') }}" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Leave Type</label>
                                <select name="leave_type" id="leave_type" required 
                                    class="form-select form-select-lg form-select-solid mb-3 mb-lg-0" onchange="updateLeaveOptions()">
                                    <option value="">Select Leave Type</option>
                                    <option value="credit">Credit Leave</option>
                                    <option value="casual">Casual Leave (CL)</option>
                                    <option value="sick">Sick Leave (SL)</option>
                                </select>
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Number of Days</label>
                                <select name="leave_days" id="leave_days" required 
                                    class="form-select form-select-lg form-select-solid mb-3 mb-lg-0">
                                    <option value="" disabled selected>Select Days</option>
                                    <option value="1">1 day </option>
                                    <option value="2">2 days</option>
                                    <option value="3">3 days</option>
                                    <option value="4">4 days</option>
                                    <option value="5">5 days</option>
                                    <option value="7">1 Week</option>
                                    <option value="14">2 Weeks</option>
                                    <option value="21">3 Weeks</option>
                                    <option value="28">4 Weeks</option>
                                    <option value="30">1 Month</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('add.leaveManagement') }}" class="btn btn-light-success me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
function toggleAllUsers() {
    const selectAllCheckbox = document.getElementById('select_all_users');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    
    if (selectAllCheckbox && userCheckboxes.length > 0) {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        
        updateSelectedUsers();
    }
}

function updateSelectedUsers() {
    const userCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    const selectedUserIds = Array.from(userCheckboxes).map(checkbox => checkbox.value);
    const selectedUsersText = document.getElementById('selectedUsersText');
    const hiddenInput = document.getElementById('selected_user_ids');
    
    if (!selectedUsersText || !hiddenInput) {
        return;
    }
    
    // Update hidden input with selected user IDs
    const userIdsString = selectedUserIds.join(',');
    hiddenInput.value = userIdsString;
    
    
    // Update dropdown button text
    if (selectedUserIds.length === 0) {
        selectedUsersText.textContent = 'Select Users';
    } else if (selectedUserIds.length === 1) {
        const userName = document.querySelector(`#user_${selectedUserIds[0]}`).nextElementSibling.textContent;
        selectedUsersText.textContent = userName;
    } else {
        selectedUsersText.textContent = `${selectedUserIds.length} users selected`;
    }
    
    // Update select all checkbox state
    const selectAllCheckbox = document.getElementById('select_all_users');
    const allCheckboxes = document.querySelectorAll('.user-checkbox');
    const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    
    if (selectAllCheckbox && allCheckboxes.length > 0) {
        if (checkedCheckboxes.length === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (checkedCheckboxes.length === allCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
            selectAllCheckbox.checked = false;
        }
    }
}

function updateLeaveOptions() {
    const leaveDaysSelect = document.getElementById('leave_days');
    
    if (leaveDaysSelect) {
        // Reset the days select when leave type changes
        leaveDaysSelect.selectedIndex = 0;
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize selected users
    updateSelectedUsers();
    
    // Prevent dropdown from closing when clicking on checkboxes
    const dropdownMenu = document.querySelector('.dropdown-menu');
    if (dropdownMenu) {
        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Validate form submission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const selectedUserIds = document.getElementById('selected_user_ids');
            const leaveType = document.getElementById('leave_type');
            const leaveDays = document.getElementById('leave_days');
            
            
            if (!selectedUserIds || !selectedUserIds.value || selectedUserIds.value.trim() === '') {
                e.preventDefault();
                alert('Please select at least one user.');
                return false;
            }
            
            if (!leaveType || !leaveType.value) {
                e.preventDefault();
                alert('Please select a leave type.');
                return false;
            }
            
            if (!leaveDays || !leaveDays.value) {
                e.preventDefault();
                alert('Please select number of days.');
                return false;
            }
            
            const selectedCount = selectedUserIds.value.split(',').length;
            // Show confirmation
            const confirmMessage = `Are you sure you want to credit ${leaveDays.value} day(s) of ${leaveType.value} leave to ${selectedCount} user(s)?`;
            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>
