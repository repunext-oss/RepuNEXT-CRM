@extends('admin.admin_master')

@section('admin')
<style>
.availability-container {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
    margin-bottom: 2rem;
}

.availability-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.2s ease;
}

.availability-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.availability-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.availability-time {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1e40af;
}

.availability-day {
    background: #3b82f6;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.availability-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-available {
    background: #dcfce7;
    color: #166534;
}

.status-unavailable {
    background: #fef2f2;
    color: #991b1b;
}

.availability-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 6px;
}

.week-view {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1rem;
    margin-top: 2rem;
}

.day-column {
    background: #f8fafc;
    border-radius: 8px;
    padding: 1rem;
    min-height: 200px;
}

.day-header {
    text-align: center;
    font-weight: 600;
    color: #374151;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.time-slot {
    background: #e0f2fe;
    border: 1px solid #0284c7;
    border-radius: 4px;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    color: #0c4a6e;
}

.time-slot.unavailable {
    background: #fef2f2;
    border-color: #dc2626;
    color: #991b1b;
}

.filter-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.quick-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.quick-action-btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
}

.quick-action-btn:hover {
    transform: translateY(-1px);
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
}

.btn-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: none;
}

.btn-info {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    border: none;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_content_container" class="container-xxl">
        
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-6">
            <div>
                <h1 class="fw-bold text-dark mb-2">👥 Person Availability Management</h1>
                <p class="text-muted">Manage and schedule person availability timings</p>
            </div>
            @if(in_array("person_availability_all",$rolerawdata, TRUE)||in_array("person_availability_create",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
            <div class="d-flex gap-2">
                <a href="{{ route('availability.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Availability
                </a>
           
                <a href="{{ route('availability.bulk-create') }}" class="btn btn-success">
                    <i class="bi bi-calendar-plus"></i> Bulk Setup
                </a>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        @if(in_array("person_availability_all",$rolerawdata, TRUE)||in_array("person_availability_create",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
        <div class="quick-actions">
            <a href="{{ route('availability.create') }}" class="quick-action-btn btn-primary">
                <i class="bi bi-person-plus"></i> Add Single Availability
            </a>
            <a href="{{ route('availability.bulk-create') }}" class="quick-action-btn btn-success">
                <i class="bi bi-calendar-week"></i> Setup Weekly Schedule
            </a>
            <a href="{{ route('availability.check-form') }}" class="quick-action-btn btn-info">
                <i class="bi bi-search"></i> Check Availability
            </a>
            
        </div>
        @endif
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-4">
                    <label for="userFilter" class="form-label fw-semibold">Filter by Person</label>
                    <select id="userFilter" class="form-select">
                        <option value="">All Persons</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="dayFilter" class="form-label fw-semibold">Filter by Day</label>
                    <select id="dayFilter" class="form-select">
                        <option value="">All Days</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="statusFilter" class="form-label fw-semibold">Filter by Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Status</option>
                        <option value="1">Available</option>
                        <option value="0">Unavailable</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Availability List -->
        <div class="availability-container">
            <h3 class="fw-bold text-dark mb-4">📅 Current Availabilities</h3>
            
            @if($availabilities->count() > 0)
                <div id="availabilityList">
                    @foreach($availabilities as $availability)
                        <div class="availability-card" data-user="{{ $availability->user_id }}" data-day="{{ $availability->day_of_week }}" data-status="{{ $availability->is_available }}">
                            <div class="availability-header">
                                <div>
                                    <h5 class="mb-1">{{ $availability->user->name }}</h5>
                                    <p class="text-muted mb-0">{{ $availability->user->role }}</p>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="availability-day">{{ $availability->day_of_week }}</span>
                                    <span class="availability-status {{ $availability->is_available ? 'status-available' : 'status-unavailable' }}">
                                        {{ $availability->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="availability-time">
                                <i class="bi bi-clock"></i> {{ $availability->start_time }} - {{ $availability->end_time }}
                            </div>
                            
                            @if($availability->notes)
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-chat-text"></i> {{ $availability->notes }}
                                    </small>
                                </div>
                            @endif
                            
                            @if($availability->availability_type === 'exception' && $availability->exception_date)
                                <div class="mt-2">
                                    <small class="text-warning">
                                        <i class="bi bi-exclamation-triangle"></i> Exception for {{ $availability->exception_date }}
                                    </small>
                                </div>
                            @endif
                            
                            <div class="availability-actions">
                                <a href="{{ route('availability.edit', $availability->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-outline-success" onclick="toggleStatus({{ $availability->id }})">
                                    <i class="bi bi-toggle-on"></i> Toggle
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteAvailability({{ $availability->id }})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <h4>No Availabilities Found</h4>
                    <p>Start by adding availability schedules for your team members.</p>
                    <a href="{{ route('availability.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add First Availability
                    </a>
                </div>
            @endif
        </div>

        <!-- Week View -->
        <div class="availability-container">
            <h3 class="fw-bold text-dark mb-4">📊 Weekly Overview</h3>
            <div class="week-view">
                @php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                @endphp
                
                @foreach($days as $day)
                    <div class="day-column">
                        <div class="day-header">{{ $day }}</div>
                        @php
                            $dayAvailabilities = $availabilities->where('day_of_week', $day);
                        @endphp
                        
                        @if($dayAvailabilities->count() > 0)
                            @foreach($dayAvailabilities as $availability)
                                <div class="time-slot {{ $availability->is_available ? '' : 'unavailable' }}">
                                    <div class="fw-semibold">{{ $availability->user->name }}</div>
                                    <div class="small">{{ $availability->start_time }} - {{ $availability->end_time }}</div>
                                    @if($availability->availability_type === 'exception')
                                        <div class="small text-warning">Exception: {{ $availability->exception_date }}</div>
                                    @endif
                                    @if($availability->notes)
                                        <div class="small text-muted">{{ $availability->notes }}</div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="text-muted text-center small">No schedules</div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Debug Information -->
            <div class="mt-4 p-3 bg-light rounded">
                <h6>Debug Info:</h6>
                <p><strong>Total Availabilities:</strong> {{ $availabilities->count() }}</p>
                <p><strong>Days Distribution:</strong></p>
                @foreach($days as $day)
                    <span class="badge bg-secondary me-2">{{ $day }}: {{ $availabilities->where('day_of_week', $day)->count() }}</span>
                @endforeach
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
    // Filter functionality
    const userFilter = document.getElementById('userFilter');
    const dayFilter = document.getElementById('dayFilter');
    const statusFilter = document.getElementById('statusFilter');
    const availabilityCards = document.querySelectorAll('.availability-card');

    function applyFilters() {
        const selectedUser = userFilter.value;
        const selectedDay = dayFilter.value;
        const selectedStatus = statusFilter.value;

        availabilityCards.forEach(card => {
            const userId = card.dataset.user;
            const day = card.dataset.day;
            const status = card.dataset.status;

            const userMatch = !selectedUser || userId === selectedUser;
            const dayMatch = !selectedDay || day === selectedDay;
            const statusMatch = !selectedStatus || status === selectedStatus;

            if (userMatch && dayMatch && statusMatch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    userFilter.addEventListener('change', applyFilters);
    dayFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
});

// Toggle availability status
function toggleStatus(availabilityId) {
    if (confirm('Are you sure you want to toggle this availability status?')) {
        axios.post(`/availability/${availabilityId}/toggle`)
            .then(function(response) {
                if (response.data.status === 'success') {
                    showAlert('✅ Availability status updated successfully!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert('❌ ' + (response.data.message || 'Failed to update status'), 'danger');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                showAlert('❌ Error updating availability status', 'danger');
            });
    }
}

// Delete availability
function deleteAvailability(availabilityId) {
    if (confirm('Are you sure you want to delete this availability? This action cannot be undone.')) {
        axios.delete(`/availability/${availabilityId}`)
            .then(function(response) {
                if (response.data.status === 'success') {
                    showAlert('✅ Availability deleted successfully!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert('❌ ' + (response.data.message || 'Failed to delete availability'), 'danger');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                showAlert('❌ Error deleting availability', 'danger');
            });
    }
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
