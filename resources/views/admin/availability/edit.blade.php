@extends('admin.admin_master')

@section('admin')
<style>
.availability-form {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
    margin-bottom: 2rem;
}

.form-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-section h5 {
    color: #1e40af;
    margin-bottom: 1rem;
    font-weight: 600;
}

.preview-section {
    background: #e0f2fe;
    border: 1px solid #0284c7;
    border-radius: 8px;
    padding: 1.5rem;
    margin-top: 1.5rem;
}

.preview-item {
    background: white;
    border-radius: 6px;
    padding: 1rem;
    margin-bottom: 0.5rem;
    border-left: 4px solid #0284c7;
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
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_content_container" class="container-xxl">
        
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-6">
            <div>
                <h1 class="fw-bold text-dark mb-2">✏️ Edit Availability</h1>
                <p class="text-muted">Update availability schedule for {{ $availability->user->name }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('availability.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Edit Form -->
        <div class="availability-form">
            <form id="editAvailabilityForm">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="form-section">
                    <h5><i class="bi bi-person"></i> Person Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="user_id" class="form-label fw-semibold">Select Person</label>
                            <select id="user_id" name="user_id" class="form-select" required>
                                <option value="">Choose a person...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $availability->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="availability_type" class="form-label fw-semibold">Availability Type</label>
                            <select id="availability_type" name="availability_type" class="form-select" required>
                                <option value="regular" {{ $availability->availability_type == 'regular' ? 'selected' : '' }}>Regular Schedule</option>
                                <option value="exception" {{ $availability->availability_type == 'exception' ? 'selected' : '' }}>Exception</option>
                                <option value="holiday" {{ $availability->availability_type == 'holiday' ? 'selected' : '' }}>Holiday</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Schedule Information -->
                <div class="form-section">
                    <h5><i class="bi bi-calendar"></i> Schedule Details</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="day_of_week" class="form-label fw-semibold">Day of Week</label>
                            <select id="day_of_week" name="day_of_week" class="form-select" required>
                                @foreach($daysOfWeek as $key => $value)
                                    <option value="{{ $key }}" {{ $availability->day_of_week == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="start_time" class="form-label fw-semibold">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control" 
                                   value="{{ $availability->start_time }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="end_time" class="form-label fw-semibold">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="form-control" 
                                   value="{{ $availability->end_time }}" required>
                        </div>
                    </div>
                    
                    <!-- Exception Date (shown only for exception type) -->
                    <div id="exception_date_section" class="row mt-3" style="display: {{ $availability->availability_type == 'exception' ? 'flex' : 'none' }};">
                        <div class="col-md-6">
                            <label for="exception_date" class="form-label fw-semibold">Exception Date</label>
                            <input type="date" id="exception_date" name="exception_date" class="form-control" 
                                   value="{{ $availability->exception_date }}">
                        </div>
                    </div>
                </div>

                <!-- Status and Notes -->
                <div class="form-section">
                    <h5><i class="bi bi-gear"></i> Status & Notes</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_available" name="is_available" 
                                       value="1" {{ $availability->is_available ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_available">
                                    Available during this time
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ $availability->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Active schedule
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="notes" class="form-label fw-semibold">Notes (Optional)</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" 
                                      placeholder="Any additional notes about this availability...">{{ $availability->notes }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="preview-section">
                    <h5><i class="bi bi-eye"></i> Preview</h5>
                    <div id="previewContent">
                        <div class="preview-item">
                            <strong>Person:</strong> <span id="previewPerson">{{ $availability->user->name }}</span><br>
                            <strong>Day:</strong> <span id="previewDay">{{ $availability->day_of_week }}</span><br>
                            <strong>Time:</strong> <span id="previewTime">{{ $availability->start_time }} - {{ $availability->end_time }}</span><br>
                            <strong>Type:</strong> <span id="previewType">{{ ucfirst($availability->availability_type) }}</span><br>
                            <strong>Status:</strong> <span id="previewStatus">{{ $availability->is_available ? 'Available' : 'Unavailable' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('availability.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Availability
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
    const form = document.getElementById('editAvailabilityForm');
    const availabilityType = document.getElementById('availability_type');
    const exceptionDateSection = document.getElementById('exception_date_section');
    const exceptionDate = document.getElementById('exception_date');

    // Show/hide exception date based on availability type
    availabilityType.addEventListener('change', function() {
        if (this.value === 'exception') {
            exceptionDateSection.style.display = 'flex';
            exceptionDate.required = true;
        } else {
            exceptionDateSection.style.display = 'none';
            exceptionDate.required = false;
        }
        updatePreview();
    });

    // Update preview when form fields change
    const formFields = ['user_id', 'day_of_week', 'start_time', 'end_time', 'availability_type', 'is_available'];
    formFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('change', updatePreview);
        }
    });

    // Update preview for checkbox fields
    document.getElementById('is_available').addEventListener('change', updatePreview);

    function updatePreview() {
        const personSelect = document.getElementById('user_id');
        const person = personSelect.options[personSelect.selectedIndex]?.text || 'Not selected';
        const day = document.getElementById('day_of_week').value || 'Not selected';
        const startTime = document.getElementById('start_time').value || 'Not set';
        const endTime = document.getElementById('end_time').value || 'Not set';
        const type = document.getElementById('availability_type').value || 'Not selected';
        const isAvailable = document.getElementById('is_available').checked;

        document.getElementById('previewPerson').textContent = person;
        document.getElementById('previewDay').textContent = day;
        document.getElementById('previewTime').textContent = `${startTime} - ${endTime}`;
        document.getElementById('previewType').textContent = type.charAt(0).toUpperCase() + type.slice(1);
        document.getElementById('previewStatus').textContent = isAvailable ? 'Available' : 'Unavailable';
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            if (key === 'is_available' || key === 'is_active') {
                data[key] = value === '1';
            } else {
                data[key] = value;
            }
        });

        // Remove empty exception_date if not exception type
        if (data.availability_type !== 'exception') {
            delete data.exception_date;
        }

        axios.put(`/availability/{{ $availability->id }}`, data)
            .then(function(response) {
                if (response.data.status === 'success') {
                    showAlert('✅ Availability updated successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("availability.index") }}';
                    }, 1500);
                } else {
                    showAlert('❌ ' + (response.data.message || 'Failed to update availability'), 'danger');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    let errorMessage = 'Validation errors:\n';
                    Object.keys(errors).forEach(key => {
                        errorMessage += `• ${errors[key][0]}\n`;
                    });
                    showAlert('❌ ' + errorMessage, 'danger');
                } else {
                    showAlert('❌ Error updating availability', 'danger');
                }
            });
    });
});

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
