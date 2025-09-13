@extends('admin.admin_master')

@section('admin')
<style>
.bulk-form-container {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.week-schedule {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.day-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.day-label {
    min-width: 100px;
    font-weight: 600;
    color: #374151;
}

.time-inputs {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex: 1;
}

.time-input {
    width: 120px;
}

.availability-toggle {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #3b82f6;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    border: 1px solid transparent;
}

.alert-success {
    background-color: #d1fae5;
    border-color: #a7f3d0;
    color: #065f46;
}

.alert-danger {
    background-color: #fee2e2;
    border-color: #fecaca;
    color: #991b1b;
}

.loading {
    opacity: 0.6;
    pointer-events: none;
}

.preview-section {
    background: #f0f9ff;
    border: 1px solid #0284c7;
    border-radius: 8px;
    padding: 1.5rem;
    margin-top: 2rem;
}

.preview-day {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 1rem;
    margin-bottom: 0.5rem;
}

.preview-day.unavailable {
    background: #fef2f2;
    border-color: #dc2626;
    color: #991b1b;
}
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_content_container" class="container-xxl">
        
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-6">
            <div>
                <h1 class="fw-bold text-dark mb-2">📅 Bulk Availability Setup</h1>
                <p class="text-muted">Set up weekly availability schedules for team members</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('availability.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Bulk Form -->
        <div class="bulk-form-container">
            <h3 class="fw-bold text-dark mb-4">👥 Weekly Schedule Setup</h3>
            
            <form id="bulkForm">
                <!-- Person Selection -->
                <div class="form-group">
                    <label for="user_id" class="form-label">
                        <i class="bi bi-person"></i> Select Person *
                    </label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="">Choose a person...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Default Time Settings -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="default_start_time" class="form-label">
                                <i class="bi bi-clock"></i> Default Start Time
                            </label>
                            <input type="time" class="form-control" id="default_start_time" value="09:00">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="default_end_time" class="form-label">
                                <i class="bi bi-clock"></i> Default End Time
                            </label>
                            <input type="time" class="form-control" id="default_end_time" value="17:00">
                        </div>
                    </div>
                </div>

                <!-- Week Schedule -->
                <div class="week-schedule">
                    <h5 class="fw-semibold mb-3">📅 Weekly Schedule</h5>
                    
                    @php
                        $days = [
                            'Monday' => 'Monday',
                            'Tuesday' => 'Tuesday',
                            'Wednesday' => 'Wednesday',
                            'Thursday' => 'Thursday',
                            'Friday' => 'Friday',
                            'Saturday' => 'Saturday',
                            'Sunday' => 'Sunday'
                        ];
                    @endphp
                    
                    @foreach($days as $dayKey => $dayLabel)
                        <div class="day-row" data-day="{{ $dayKey }}">
                            <div class="day-label">{{ $dayLabel }}</div>
                            
                            <div class="availability-toggle">
                                <label class="toggle-switch">
                                    <input type="checkbox" class="day-available" data-day="{{ $dayKey }}" 
                                           {{ in_array($dayKey, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                                <span class="availability-text">Available</span>
                            </div>
                            
                            <div class="time-inputs">
                                <input type="time" class="form-control time-input day-start-time" 
                                       data-day="{{ $dayKey }}" value="09:00">
                                <span>to</span>
                                <input type="time" class="form-control time-input day-end-time" 
                                       data-day="{{ $dayKey }}" value="17:00">
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Quick Actions -->
                <div class="d-flex gap-2 mb-4">
                    <button type="button" class="btn btn-outline-primary" onclick="setWeekdays()">
                        <i class="bi bi-calendar-week"></i> Set Weekdays (Mon-Fri)
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="setAllDays()">
                        <i class="bi bi-calendar-check"></i> Set All Days
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="clearAll()">
                        <i class="bi bi-calendar-x"></i> Clear All
                    </button>
                </div>

                <!-- Preview Section -->
                <div class="preview-section" id="previewSection" style="display: none;">
                    <h6 class="fw-bold mb-3">📋 Schedule Preview</h6>
                    <div id="previewContent"></div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-check-circle"></i> Create Weekly Schedule
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset Form
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
// Set up axios defaults for CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
}
axios.defaults.headers.common['Accept'] = 'application/json';

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('bulkForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alertContainer');
    const userId = document.getElementById('user_id');
    const defaultStartTime = document.getElementById('default_start_time');
    const defaultEndTime = document.getElementById('default_end_time');

    // Update preview when form changes
    [userId, defaultStartTime, defaultEndTime].forEach(element => {
        element.addEventListener('input', updatePreview);
    });

    // Update preview when day availability changes
    document.querySelectorAll('.day-available, .day-start-time, .day-end-time').forEach(element => {
        element.addEventListener('change', updatePreview);
    });

    function updatePreview() {
        const previewSection = document.getElementById('previewSection');
        const previewContent = document.getElementById('previewContent');
        const selectedUser = userId.options[userId.selectedIndex];
        
        if (!selectedUser.value) {
            previewSection.style.display = 'none';
            return;
        }

        let previewHtml = `<div class="fw-semibold mb-2">${selectedUser.text}</div>`;
        
        document.querySelectorAll('.day-row').forEach(dayRow => {
            const day = dayRow.dataset.day;
            const isAvailable = dayRow.querySelector('.day-available').checked;
            const startTime = dayRow.querySelector('.day-start-time').value;
            const endTime = dayRow.querySelector('.day-end-time').value;
            
            const statusClass = isAvailable ? '' : 'unavailable';
            const statusText = isAvailable ? 'Available' : 'Unavailable';
            const timeText = isAvailable ? `${startTime} - ${endTime}` : 'Not available';
            
            previewHtml += `
                <div class="preview-day ${statusClass}">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">${day}</span>
                        <span class="badge ${isAvailable ? 'bg-success' : 'bg-danger'}">${statusText}</span>
                    </div>
                    <div class="small">${timeText}</div>
                </div>
            `;
        });
        
        previewContent.innerHTML = previewHtml;
        previewSection.style.display = 'block';
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedUser = userId.options[userId.selectedIndex];
        if (!selectedUser.value) {
            showAlert('❌ Please select a person', 'danger');
            return;
        }

        const availabilities = [];
        document.querySelectorAll('.day-row').forEach(dayRow => {
            const day = dayRow.dataset.day;
            const isAvailable = dayRow.querySelector('.day-available').checked;
            const startTime = dayRow.querySelector('.day-start-time').value;
            const endTime = dayRow.querySelector('.day-end-time').value;
            
            if (isAvailable && startTime && endTime) {
                availabilities.push({
                    day_of_week: day,
                    start_time: startTime,
                    end_time: endTime,
                    is_available: true
                });
            }
        });

        if (availabilities.length === 0) {
            showAlert('❌ Please set at least one day as available', 'danger');
            return;
        }

        const data = {
            user_id: selectedUser.value,
            availabilities: availabilities
        };

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Creating...';
        form.classList.add('loading');

        // Submit bulk availability
        axios.post('/availability/bulk', data)
            .then(function(response) {
                if (response.data.status === 'success') {
                    showAlert('✅ Weekly schedule created successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("availability.index") }}';
                    }, 1500);
                } else {
                    showAlert('❌ ' + (response.data.message || 'Failed to create schedule'), 'danger');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                let errorMessage = 'Failed to create weekly schedule';
                
                if (error.response && error.response.data) {
                    if (error.response.data.errors) {
                        errorMessage = Object.values(error.response.data.errors).flat().join(', ');
                    } else if (error.response.data.message) {
                        errorMessage = error.response.data.message;
                    }
                }
                
                showAlert('❌ ' + errorMessage, 'danger');
            })
            .finally(function() {
                // Reset loading state
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Create Weekly Schedule';
                form.classList.remove('loading');
            });
    });

    // Initialize preview
    updatePreview();
});

// Set weekdays (Monday to Friday)
function setWeekdays() {
    document.querySelectorAll('.day-available').forEach(checkbox => {
        const day = checkbox.dataset.day;
        checkbox.checked = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'].includes(day);
    });
    updatePreview();
}

// Set all days
function setAllDays() {
    document.querySelectorAll('.day-available').forEach(checkbox => {
        checkbox.checked = true;
    });
    updatePreview();
}

// Clear all days
function clearAll() {
    document.querySelectorAll('.day-available').forEach(checkbox => {
        checkbox.checked = false;
    });
    updatePreview();
}

// Update preview function (global)
function updatePreview() {
    const event = new Event('input');
    document.getElementById('user_id').dispatchEvent(event);
}

// Show alert messages
function showAlert(message, type = 'success') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.getElementById('alertContainer').appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>

@endsection
