@extends('admin.admin_master')

@section('admin')
<style>
.check-availability-container {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
    margin-bottom: 2rem;
}

.check-form {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.result-section {
    background: #e0f2fe;
    border: 1px solid #0284c7;
    border-radius: 8px;
    padding: 1.5rem;
    margin-top: 1.5rem;
}

.result-item {
    background: white;
    border-radius: 6px;
    padding: 1rem;
    margin-bottom: 0.5rem;
    border-left: 4px solid #0284c7;
}

.available {
    border-left-color: #10b981;
    background: #f0fdf4;
}

.unavailable {
    border-left-color: #ef4444;
    background: #fef2f2;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
}

.btn-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
}

.slots-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 0.5rem;
    margin-top: 1rem;
}

.slot-item {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
    padding: 0.5rem;
    text-align: center;
    font-size: 0.875rem;
}

.slot-available {
    background: #d1fae5;
    border-color: #10b981;
    color: #065f46;
}

.slot-unavailable {
    background: #fee2e2;
    border-color: #ef4444;
    color: #991b1b;
}
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_content_container" class="container-xxl">
        
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-6">
            <div>
                <h1 class="fw-bold text-dark mb-2">🔍 Check Availability</h1>
                <p class="text-muted">Check person availability for specific dates and times</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('availability.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Check Form -->
        <div class="check-availability-container">
            <form id="checkAvailabilityForm">
                @csrf
                
                <div class="check-form">
                    <h5><i class="bi bi-search"></i> Check Parameters</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="user_id" class="form-label fw-semibold">Select Person</label>
                            <select id="user_id" name="user_id" class="form-select" required>
                                <option value="">Choose a person...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="date" class="form-label fw-semibold">Date</label>
                            <input type="date" id="date" name="date" class="form-control" 
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="time_range" class="form-label fw-semibold">Time Range (Optional)</label>
                            <select id="time_range" name="time_range" class="form-select">
                                <option value="">Check all day</option>
                                <option value="morning">Morning (9:00 AM - 12:00 PM)</option>
                                <option value="afternoon">Afternoon (12:00 PM - 5:00 PM)</option>
                                <option value="evening">Evening (5:00 PM - 9:00 PM)</option>
                                <option value="custom">Custom Time</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Custom Time Range -->
                    <div id="custom_time_section" class="row mt-3" style="display: none;">
                        <div class="col-md-6">
                            <label for="start_time" class="form-label fw-semibold">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label fw-semibold">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Check Availability
                        </button>
                    </div>
                </div>
            </form>

            <!-- Results Section -->
            <div id="resultsSection" class="result-section" style="display: none;">
                <h5><i class="bi bi-info-circle"></i> Availability Results</h5>
                <div id="resultsContent"></div>
            </div>
        </div>

        <!-- Quick Check Section -->
        <div class="check-availability-container">
            <h5><i class="bi bi-lightning"></i> Quick Availability Check</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="check-form">
                        <h6>Today's Availability</h6>
                        <button type="button" class="btn btn-outline-primary" onclick="quickCheck('today')">
                            Check Today
                        </button>
                        <div id="todayResults" class="mt-3"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="check-form">
                        <h6>Tomorrow's Availability</h6>
                        <button type="button" class="btn btn-outline-primary" onclick="quickCheck('tomorrow')">
                            Check Tomorrow
                        </button>
                        <div id="tomorrowResults" class="mt-3"></div>
                    </div>
                </div>
            </div>
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
    const form = document.getElementById('checkAvailabilityForm');
    const timeRange = document.getElementById('time_range');
    const customTimeSection = document.getElementById('custom_time_section');
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');

    // Show/hide custom time section
    timeRange.addEventListener('change', function() {
        if (this.value === 'custom') {
            customTimeSection.style.display = 'flex';
            startTime.required = true;
            endTime.required = true;
        } else {
            customTimeSection.style.display = 'none';
            startTime.required = false;
            endTime.required = false;
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = {
            user_id: formData.get('user_id'),
            date: formData.get('date'),
            start_time: null,
            end_time: null
        };

        // Handle time range
        const timeRangeValue = formData.get('time_range');
        if (timeRangeValue === 'custom') {
            data.start_time = formData.get('start_time');
            data.end_time = formData.get('end_time');
        } else if (timeRangeValue) {
            const timeRanges = {
                'morning': { start: '09:00', end: '12:00' },
                'afternoon': { start: '12:00', end: '17:00' },
                'evening': { start: '17:00', end: '21:00' }
            };
            data.start_time = timeRanges[timeRangeValue].start;
            data.end_time = timeRanges[timeRangeValue].end;
        }

        checkAvailability(data);
    });
});

function checkAvailability(data) {
    const resultsSection = document.getElementById('resultsSection');
    const resultsContent = document.getElementById('resultsContent');
    
    resultsContent.innerHTML = '<div class="text-center"><i class="bi bi-hourglass-split"></i> Checking availability...</div>';
    resultsSection.style.display = 'block';

    axios.post('/availability/check', data)
        .then(function(response) {
            if (response.data.status === 'success') {
                displayResults(response.data, data);
            } else {
                showAlert('❌ ' + (response.data.message || 'Failed to check availability'), 'danger');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            showAlert('❌ Error checking availability', 'danger');
        });
}

function displayResults(data, requestData) {
    const resultsContent = document.getElementById('resultsContent');
    const isAvailable = data.is_available;
    const className = isAvailable ? 'available' : 'unavailable';
    const statusText = isAvailable ? 'Available' : 'Unavailable';
    const statusIcon = isAvailable ? '✅' : '❌';

    let timeInfo = '';
    if (requestData.start_time && requestData.end_time) {
        timeInfo = ` for ${requestData.start_time} - ${requestData.end_time}`;
    }

    resultsContent.innerHTML = `
        <div class="result-item ${className}">
            <h6>${statusIcon} ${statusText}${timeInfo}</h6>
            <p class="mb-2">Date: ${requestData.date}</p>
            <p class="mb-0">Person: ${getUserName(requestData.user_id)}</p>
        </div>
    `;

    // If available, also get available slots
    if (isAvailable) {
        getAvailableSlots(requestData.user_id, requestData.date);
    }
}

function getAvailableSlots(userId, date) {
    axios.post('/availability/slots', { user_id: userId, date: date })
        .then(function(response) {
            if (response.data.status === 'success' && response.data.slots.length > 0) {
                displaySlots(response.data.slots);
            }
        })
        .catch(function(error) {
            console.error('Error getting slots:', error);
        });
}

function displaySlots(slots) {
    const resultsContent = document.getElementById('resultsContent');
    const slotsHtml = slots.map(slot => 
        `<div class="slot-item slot-available">${slot.start} - ${slot.end}</div>`
    ).join('');

    resultsContent.innerHTML += `
        <div class="mt-3">
            <h6>Available Time Slots:</h6>
            <div class="slots-grid">
                ${slotsHtml}
            </div>
        </div>
    `;
}

function quickCheck(type) {
    const today = new Date();
    let checkDate;
    
    if (type === 'tomorrow') {
        checkDate = new Date(today);
        checkDate.setDate(today.getDate() + 1);
    } else {
        checkDate = today;
    }

    const formattedDate = checkDate.toISOString().split('T')[0];
    const resultsDiv = document.getElementById(type + 'Results');
    
    resultsDiv.innerHTML = '<small class="text-muted">Checking...</small>';

    // Get all users and check their availability
    const userSelect = document.getElementById('user_id');
    const users = Array.from(userSelect.options).slice(1); // Skip the first "Choose a person" option
    
    let resultsHtml = '';
    let checkedCount = 0;

    users.forEach(user => {
        const userId = user.value;
        axios.post('/availability/check', { 
            user_id: userId, 
            date: formattedDate 
        })
        .then(function(response) {
            checkedCount++;
            const isAvailable = response.data.is_available;
            const statusIcon = isAvailable ? '✅' : '❌';
            const statusClass = isAvailable ? 'text-success' : 'text-danger';
            
            resultsHtml += `
                <div class="small ${statusClass}">
                    ${statusIcon} ${user.text}
                </div>
            `;
            
            if (checkedCount === users.length) {
                resultsDiv.innerHTML = resultsHtml;
            }
        })
        .catch(function(error) {
            checkedCount++;
            resultsHtml += `
                <div class="small text-muted">
                    ❓ ${user.text} (Error)
                </div>
            `;
            
            if (checkedCount === users.length) {
                resultsDiv.innerHTML = resultsHtml;
            }
        });
    });
}

function getUserName(userId) {
    const userSelect = document.getElementById('user_id');
    const option = userSelect.querySelector(`option[value="${userId}"]`);
    return option ? option.text : 'Unknown User';
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
