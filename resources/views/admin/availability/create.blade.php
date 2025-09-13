@extends('admin.admin_master')

@section('admin')
<style>
.availability-form-container {
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

.time-preview {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.preview-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    padding: 0.5rem;
    background: white;
    border-radius: 4px;
    border: 1px solid #e5e7eb;
}

.preview-label {
    font-weight: 600;
    color: #374151;
}

.preview-value {
    color: #6b7280;
}

.availability-type-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.type-option {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    padding: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.type-option:hover {
    border-color: #3b82f6;
    background: #f0f9ff;
}

.type-option.selected {
    border-color: #3b82f6;
    background: #dbeafe;
}

.type-option input[type="radio"] {
    margin: 0;
}

.type-description {
    margin-left: 1.5rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.conditional-field {
    display: none;
}

.conditional-field.show {
    display: block;
}
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_content_container" class="container-xxl">
        
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-6">
            <div>
                <h1 class="fw-bold text-dark mb-2">➕ Add Person Availability</h1>
                <p class="text-muted">Set up availability schedule for team members</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('availability.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Availability Form -->
        <div class="availability-form-container">
            <h3 class="fw-bold text-dark mb-4">📅 Availability Details</h3>
            
            <form id="availabilityForm">
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

                <!-- Availability Type -->
                <div class="availability-type-section">
                    <h5 class="fw-semibold mb-3">📋 Availability Type</h5>
                    
                    <div class="type-option" onclick="selectType('regular')">
                        <input type="radio" name="availability_type" value="regular" id="type_regular" checked>
                        <div>
                            <label for="type_regular" class="fw-semibold">Regular Schedule</label>
                            <div class="type-description">Set recurring weekly availability (e.g., every Monday 9 AM - 5 PM)</div>
                        </div>
                    </div>
                    
                    <div class="type-option" onclick="selectType('exception')">
                        <input type="radio" name="availability_type" value="exception" id="type_exception">
                        <div>
                            <label for="type_exception" class="fw-semibold">Exception/Override</label>
                            <div class="type-description">Set specific date availability that overrides regular schedule</div>
                        </div>
                    </div>
                    
                    <div class="type-option" onclick="selectType('holiday')">
                        <input type="radio" name="availability_type" value="holiday" id="type_holiday">
                        <div>
                            <label for="type_holiday" class="fw-semibold">Holiday/Leave</label>
                            <div class="type-description">Mark specific dates as unavailable (holidays, leave days)</div>
                        </div>
                    </div>
                </div>

                <!-- Day Selection (for regular schedule) -->
                <div class="form-group conditional-field show" id="dayField">
                    <label for="day_of_week" class="form-label">
                        <i class="bi bi-calendar-week"></i> Day of Week *
                    </label>
                    <select class="form-control" id="day_of_week" name="day_of_week">
                        @foreach($daysOfWeek as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Exception Date (for exceptions/holidays) -->
                <div class="form-group conditional-field" id="exceptionDateField">
                    <label for="exception_date" class="form-label">
                        <i class="bi bi-calendar-date"></i> Exception Date *
                    </label>
                    <input type="date" class="form-control" id="exception_date" name="exception_date">
                </div>

                <!-- Time Selection -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_time" class="form-label">
                                <i class="bi bi-clock"></i> Start Time *
                            </label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_time" class="form-label">
                                <i class="bi bi-clock"></i> End Time *
                            </label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                    </div>
                </div>

                <!-- Availability Status -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-toggle-on"></i> Availability Status
                    </label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_available" id="available_yes" value="1" checked>
                            <label class="form-check-label" for="available_yes">
                                <i class="bi bi-check-circle text-success"></i> Available
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_available" id="available_no" value="0">
                            <label class="form-check-label" for="available_no">
                                <i class="bi bi-x-circle text-danger"></i> Unavailable
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes" class="form-label">
                        <i class="bi bi-chat-text"></i> Notes (Optional)
                    </label>
                    <textarea class="form-control" id="notes" name="notes" rows="3" 
                              placeholder="Add any additional notes about this availability..."></textarea>
                </div>

                <!-- Preview Section -->
                <div class="time-preview" id="previewSection" style="display: none;">
                    <h6 class="fw-bold mb-3">📋 Availability Preview</h6>
                    <div class="preview-item">
                        <span class="preview-label">Person:</span>
                        <span class="preview-value" id="previewPerson">-</span>
                    </div>
                    <div class="preview-item">
                        <span class="preview-label">Type:</span>
                        <span class="preview-value" id="previewType">-</span>
                    </div>
                    <div class="preview-item">
                        <span class="preview-label">Schedule:</span>
                        <span class="preview-value" id="previewSchedule">-</span>
                    </div>
                    <div class="preview-item">
                        <span class="preview-label">Time:</span>
                        <span class="preview-value" id="previewTime">-</span>
                    </div>
                    <div class="preview-item">
                        <span class="preview-label">Status:</span>
                        <span class="preview-value" id="previewStatus">-</span>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-check-circle"></i> Create Availability
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
    const form = document.getElementById('availabilityForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alertContainer');

    // Form elements for preview
    const userId = document.getElementById('user_id');
    const availabilityType = document.querySelectorAll('input[name="availability_type"]');
    const dayOfWeek = document.getElementById('day_of_week');
    const exceptionDate = document.getElementById('exception_date');
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const isAvailable = document.querySelectorAll('input[name="is_available"]');
    const notes = document.getElementById('notes');

    // Update preview when form changes
    [userId, dayOfWeek, exceptionDate, startTime, endTime, notes].forEach(element => {
        element.addEventListener('input', updatePreview);
    });

    availabilityType.forEach(radio => {
        radio.addEventListener('change', updatePreview);
    });

    isAvailable.forEach(radio => {
        radio.addEventListener('change', updatePreview);
    });

    function updatePreview() {
        const previewSection = document.getElementById('previewSection');
        const previewPerson = document.getElementById('previewPerson');
        const previewType = document.getElementById('previewType');
        const previewSchedule = document.getElementById('previewSchedule');
        const previewTime = document.getElementById('previewTime');
        const previewStatus = document.getElementById('previewStatus');

        // Person
        const selectedUser = userId.options[userId.selectedIndex];
        previewPerson.textContent = selectedUser.value ? selectedUser.text : '-';

        // Type
        const selectedType = document.querySelector('input[name="availability_type"]:checked');
        previewType.textContent = selectedType ? selectedType.value.charAt(0).toUpperCase() + selectedType.value.slice(1) : '-';

        // Schedule
        if (selectedType && selectedType.value === 'regular') {
            previewSchedule.textContent = dayOfWeek.value ? dayOfWeek.value : '-';
        } else if (selectedType && selectedType.value === 'exception') {
            previewSchedule.textContent = exceptionDate.value ? exceptionDate.value : '-';
        } else if (selectedType && selectedType.value === 'holiday') {
            previewSchedule.textContent = exceptionDate.value ? exceptionDate.value : '-';
        } else {
            previewSchedule.textContent = '-';
        }

        // Time
        if (startTime.value && endTime.value) {
            previewTime.textContent = `${startTime.value} - ${endTime.value}`;
        } else {
            previewTime.textContent = '-';
        }

        // Status
        const selectedStatus = document.querySelector('input[name="is_available"]:checked');
        previewStatus.textContent = selectedStatus ? (selectedStatus.value === '1' ? 'Available' : 'Unavailable') : '-';

        // Show preview if we have some data
        if (selectedUser.value || startTime.value || endTime.value) {
            previewSection.style.display = 'block';
        } else {
            previewSection.style.display = 'none';
        }
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        // Convert boolean values
        data.is_available = data.is_available === '1';
        data.is_active = true;

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Creating...';
        form.classList.add('loading');

        // Submit availability
        axios.post('/availability', data)
            .then(function(response) {
                if (response.data.status === 'success') {
                    showAlert('✅ Availability created successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("availability.index") }}';
                    }, 1500);
                } else {
                    showAlert('❌ ' + (response.data.message || 'Failed to create availability'), 'danger');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                let errorMessage = 'Failed to create availability';
                
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
                submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Create Availability';
                form.classList.remove('loading');
            });
    });

    // Set default times
    startTime.value = '09:00';
    endTime.value = '17:00';
    updatePreview();
});

// Select availability type
function selectType(type) {
    // Update radio button
    document.getElementById('type_' + type).checked = true;
    
    // Show/hide conditional fields
    const dayField = document.getElementById('dayField');
    const exceptionDateField = document.getElementById('exceptionDateField');
    
    if (type === 'regular') {
        dayField.classList.add('show');
        exceptionDateField.classList.remove('show');
        exceptionDateField.querySelector('input').removeAttribute('required');
        dayField.querySelector('select').setAttribute('required', 'required');
    } else {
        dayField.classList.remove('show');
        exceptionDateField.classList.add('show');
        dayField.querySelector('select').removeAttribute('required');
        exceptionDateField.querySelector('input').setAttribute('required', 'required');
    }
    
    // Update type option styling
    document.querySelectorAll('.type-option').forEach(option => {
        option.classList.remove('selected');
    });
    event.currentTarget.classList.add('selected');
    
    // Update preview
    updatePreview();
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
