@extends('admin.admin_master')

@section('admin')
<style>
.booking-form-container {
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

.calendar-container {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
    margin-top: 2rem;
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

.alert-warning {
    background-color: #fef3c7;
    border-color: #fde68a;
    color: #92400e;
}

.loading {
    opacity: 0.6;
    pointer-events: none;
}

.time-slot-suggestions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.time-slot-btn {
    padding: 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background: #f9fafb;
    cursor: pointer;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.time-slot-btn:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.booking-summary {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.summary-label {
    font-weight: 600;
    color: #374151;
}

.summary-value {
    color: #6b7280;
}

/* Calendar event styling */
.fc-event {
    cursor: pointer;
    transition: all 0.2s ease;
}

.fc-event:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.fc-event-title {
    font-weight: 600;
    font-size: 12px;
}

/* Booked slot styling - RED */
.fc-event.booked {
    background-color: #ef4444 !important;
    border-color: #dc2626 !important;
    color: white !important;
}

.fc-event.booked:hover {
    background-color: #dc2626 !important;
    border-color: #b91c1c !important;
}

/* Available slot styling - GREEN */
.fc-event.available {
    background-color: #10b981 !important;
    border-color: #059669 !important;
    color: white !important;
}

.fc-event.available:hover {
    background-color: #059669 !important;
    border-color: #047857 !important;
}

/* Day cell styling for available/blocked */
.fc-day.available-day {
    background-color: rgba(16, 185, 129, 0.1) !important;
}

.fc-day.booked-day {
    background-color: rgba(239, 68, 68, 0.1) !important;
}

/* Blocked time slot styling */
.fc-day-disabled {
    background-color: #f3f4f6;
    opacity: 0.6;
}

.fc-day-disabled .fc-daygrid-day-number {
    color: #9ca3af;
}

/* Time conflict warning */
.time-conflict {
    border-color: #ef4444 !important;
    background-color: #fef2f2 !important;
}

.time-conflict:focus {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

/* Event details modal */
.modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
}

.modal-title {
    font-weight: 600;
}
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_content_container" class="container-xxl">
        
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-6">
            <div>
                <h1 class="fw-bold text-dark mb-2">Book a Studio</h1>
                <p class="text-muted">Schedule appointments and manage your calendar</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('booking.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Calendar
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Booking Form -->
        <div class="booking-form-container">
            <h3 class="fw-bold text-dark mb-4">📅 Booking Details</h3>
            
            <form id="bookingForm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title" class="form-label">
                                <i class="bi bi-calendar-event"></i> Event Title *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="title" 
                                   name="title" 
                                   placeholder="Enter event title"
                                   required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" class="form-label">
                                <i class="bi bi-text-paragraph"></i> Description
                            </label>
                            <textarea class="form-control" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Enter event description (optional)"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date" class="form-label">
                                <i class="bi bi-calendar-plus"></i> Start Date *
                            </label>
                            <input type="date" 
                                   class="form-control" 
                                   id="start_date" 
                                   name="start_date" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_time" class="form-label">
                                <i class="bi bi-clock"></i> Start Time *
                            </label>
                            <input type="time" 
                                   class="form-control" 
                                   id="start_time" 
                                   name="start_time" 
                                   required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date" class="form-label">
                                <i class="bi bi-calendar-minus"></i> End Date *
                            </label>
                            <input type="date" 
                                   class="form-control" 
                                   id="end_date" 
                                   name="end_date" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_time" class="form-label">
                                <i class="bi bi-clock"></i> End Time *
                            </label>
                            <input type="time" 
                                   class="form-control" 
                                   id="end_time" 
                                   name="end_time" 
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Quick Time Slots -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-lightning"></i> Quick Time Slots
                    </label>
                    <div class="time-slot-suggestions">
                        <button type="button" class="time-slot-btn" data-duration="30">30 min</button>
                        <button type="button" class="time-slot-btn" data-duration="60">1 hour</button>
                        <button type="button" class="time-slot-btn" data-duration="90">1.5 hours</button>
                        <button type="button" class="time-slot-btn" data-duration="120">2 hours</button>
                        <button type="button" class="time-slot-btn" data-duration="240">4 hours</button>
                        <button type="button" class="time-slot-btn" data-duration="480">Full Day</button>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="booking-summary" id="bookingSummary" style="display: none;">
                    <h6 class="fw-bold mb-3">📋 Booking Summary</h6>
                    <div class="summary-item">
                        <span class="summary-label">Event:</span>
                        <span class="summary-value" id="summaryTitle">-</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Duration:</span>
                        <span class="summary-value" id="summaryDuration">-</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Date:</span>
                        <span class="summary-value" id="summaryDate">-</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Time:</span>
                        <span class="summary-value" id="summaryTime">-</span>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-check-circle"></i> Create Booking
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset Form
                    </button>
                </div>
            </form>
        </div>

        <!-- Calendar Preview -->
        <div class="calendar-container">
            <h3 class="fw-bold text-dark mb-4">📅 Calendar Preview</h3>
            
                         <!-- Calendar Legend -->
             <div class="d-flex justify-content-center mb-4">
                 <div class="d-flex gap-4">
                     <div class="d-flex align-items-center gap-2">
                         <div style="width: 20px; height: 20px; background-color: #ef4444; border-radius: 4px;"></div>
                         <span class="fw-semibold">🔴 Booked Slots</span>
                     </div>
                 </div>
             </div>
            
            <div id="calendar"></div>
        </div>
    </div>
</div>

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Set up axios defaults for CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
}
axios.defaults.headers.common['Accept'] = 'application/json';

document.addEventListener('DOMContentLoaded', function () {
    // Check if FullCalendar is loaded
    if (typeof FullCalendar === 'undefined') {
        console.error('FullCalendar is not loaded');
        showAlert('❌ Calendar library failed to load. Please refresh the page.', 'danger');
        return;
    }

    // Initialize FullCalendar
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        console.error('Calendar element not found');
        return;
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 400,
        events: {
            url: '/bookings',
            failure: function() {
                showAlert('❌ Failed to load events from server', 'warning');
            }
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        selectConstraint: {
            start: new Date(), // Can't select past dates
            end: '2100-01-01'
        },
        select: function(info) {
            // Check if the selected time slot is available
            const selectedStart = new Date(info.start);
            const selectedEnd = new Date(info.end);
            
            // Get existing events for the selected date
            const existingEvents = calendar.getEvents().filter(event => {
                const eventStart = new Date(event.start);
                const eventEnd = new Date(event.end);
                
                // Check for overlap
                return (selectedStart < eventEnd && selectedEnd > eventStart);
            });
            
            if (existingEvents.length > 0) {
                showAlert('⚠️ This time slot is already booked. Please select a different time.', 'warning');
                return;
            }
            
            // Auto-fill date when clicking on calendar
            document.getElementById('start_date').value = info.startStr;
            document.getElementById('end_date').value = info.endStr;
            updateBookingSummary();
        },
        eventDisplay: 'block',
        eventDidMount: function(info) {
            // Add booked class to existing events (RED)
            info.el.classList.add('booked');
            info.el.style.fontWeight = '600';
            info.el.style.fontSize = '12px';
            info.el.style.padding = '2px 4px';
            info.el.style.borderRadius = '4px';
            
            // Add simple tooltip with event details
            info.el.title = `🔴 BOOKED: ${info.event.title}\n${formatTime(info.event.start)} - ${formatTime(info.event.end)}`;
        },
        eventClick: function(info) {
            // Show event details for booked events
            showEventDetails(info.event);
        },
        dayMaxEvents: 3, // Limit events shown per day
        moreLinkClick: 'popover', // Show popover for more events
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: 'short'
        }
    });
    
    try {
        calendar.render();
        console.log('Calendar rendered successfully');
    } catch (error) {
        console.error('Error rendering calendar:', error);
        showAlert('❌ Failed to render calendar. Please refresh the page.', 'danger');
    }

    // Helper function to format time
    function formatTime(date) {
        return new Date(date).toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    }

    // Show event details modal
    function showEventDetails(event) {
        const startTime = formatTime(event.start);
        const endTime = formatTime(event.end);
        const startDate = new Date(event.start).toLocaleDateString();
        
        const modalHtml = `
            <div class="modal fade" id="eventDetailsModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">📅 Event Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <p><strong>Title:</strong> ${event.title}</p>
                                    <p><strong>Date:</strong> ${startDate}</p>
                                    <p><strong>Time:</strong> ${startTime} - ${endTime}</p>
                                    ${event.extendedProps.description ? `<p><strong>Description:</strong> ${event.extendedProps.description}</p>` : ''}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" onclick="deleteEvent(${event.id})">Delete Event</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remove existing modal if any
        const existingModal = document.getElementById('eventDetailsModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Add new modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
        modal.show();
    }

    // Delete event function
    window.deleteEvent = function(eventId) {
        if (confirm('Are you sure you want to delete this event?')) {
            axios.delete(`/bookings/${eventId}`)
            .then(function(response) {
                if (response.data.status === 'success') {
                    showAlert('✅ Event deleted successfully!', 'success');
                    calendar.refetchEvents();
                    bootstrap.Modal.getInstance(document.getElementById('eventDetailsModal')).hide();
                } else {
                    showAlert('❌ Failed to delete event: ' + (response.data.message || 'Unknown error'), 'danger');
                }
            })
            .catch(function(error) {
                console.error('Delete error:', error);
                let errorMessage = 'Error deleting event';
                
                if (error.response) {
                    if (error.response.data && error.response.data.message) {
                        errorMessage = error.response.data.message;
                    } else if (error.response.status === 404) {
                        errorMessage = 'Event not found';
                    } else if (error.response.status === 500) {
                        errorMessage = 'Server error occurred';
                    }
                }
                
                showAlert('❌ ' + errorMessage, 'danger');
            });
        }
    };

    // Form elements
    const form = document.getElementById('bookingForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alertContainer');

    // Quick time slot buttons
    document.querySelectorAll('.time-slot-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const duration = parseInt(this.dataset.duration);
            const startDate = document.getElementById('start_date').value;
            const startTime = document.getElementById('start_time').value;
            
            if (startDate && startTime) {
                const startDateTime = new Date(startDate + 'T' + startTime);
                const endDateTime = new Date(startDateTime.getTime() + (duration * 60000));
                
                document.getElementById('end_date').value = endDateTime.toISOString().split('T')[0];
                document.getElementById('end_time').value = endDateTime.toTimeString().slice(0, 5);
                updateBookingSummary();
            }
        });
    });

    // Update booking summary
    function updateBookingSummary() {
        const title = document.getElementById('title').value;
        const startDate = document.getElementById('start_date').value;
        const startTime = document.getElementById('start_time').value;
        const endDate = document.getElementById('end_date').value;
        const endTime = document.getElementById('end_time').value;

        if (title && startDate && startTime && endDate && endTime) {
            const start = new Date(startDate + 'T' + startTime);
            const end = new Date(endDate + 'T' + endTime);
            const duration = Math.round((end - start) / (1000 * 60));

            document.getElementById('summaryTitle').textContent = title;
            document.getElementById('summaryDuration').textContent = `${duration} minutes`;
            document.getElementById('summaryDate').textContent = startDate;
            document.getElementById('summaryTime').textContent = `${startTime} - ${endTime}`;
            
            document.getElementById('bookingSummary').style.display = 'block';
        }
    }

    // Form validation
    function validateForm() {
        const startDate = new Date(document.getElementById('start_date').value + 'T' + document.getElementById('start_time').value);
        const endDate = new Date(document.getElementById('end_date').value + 'T' + document.getElementById('end_time').value);
        
        if (endDate <= startDate) {
            showAlert('End time must be after start time', 'warning');
            return false;
        }
        
        if (startDate < new Date()) {
            showAlert('Cannot create bookings in the past', 'warning');
            return false;
        }
        
        // Check for time conflicts with existing events
        const existingEvents = calendar.getEvents();
        const conflictingEvents = existingEvents.filter(event => {
            const eventStart = new Date(event.start);
            const eventEnd = new Date(event.end);
            
            // Check for overlap
            return (startDate < eventEnd && endDate > eventStart);
        });
        
        if (conflictingEvents.length > 0) {
            const conflictDetails = conflictingEvents.map(event => 
                `${event.title} (${formatTime(event.start)} - ${formatTime(event.end)})`
            ).join(', ');
            
            showAlert(`⚠️ Time conflict detected with: ${conflictDetails}`, 'warning');
            return false;
        }
        
        return true;
    }

    // Show alert messages
    function showAlert(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        alertContainer.appendChild(alertDiv);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }

        const formData = {
            title: document.getElementById('title').value,
            description: document.getElementById('description').value,
            start: document.getElementById('start_date').value + 'T' + document.getElementById('start_time').value,
            end: document.getElementById('end_date').value + 'T' + document.getElementById('end_time').value
        };

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Creating...';
        form.classList.add('loading');

        // Submit booking
        axios.post('/bookings', formData)
            .then(function(response) {
                if (response.data.status === 'success') {
                    showAlert('✅ Booking created successfully!', 'success');
                    form.reset();
                    document.getElementById('bookingSummary').style.display = 'none';
                                         calendar.refetchEvents();
                } else {
                    showAlert('❌ ' + (response.data.message || 'Failed to create booking'), 'danger');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                let errorMessage = 'Failed to create booking';
                
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
                submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Create Booking';
                form.classList.remove('loading');
            });
    });

    // Real-time form updates
    ['title', 'start_date', 'start_time', 'end_date', 'end_time'].forEach(id => {
        document.getElementById(id).addEventListener('input', function() {
            updateBookingSummary();
            checkTimeConflicts();
        });
    });

    // Check for time conflicts
    function checkTimeConflicts() {
        const startDate = document.getElementById('start_date').value;
        const startTime = document.getElementById('start_time').value;
        const endDate = document.getElementById('end_date').value;
        const endTime = document.getElementById('end_time').value;
        
        if (startDate && startTime && endDate && endTime) {
            const startDateTime = new Date(startDate + 'T' + startTime);
            const endDateTime = new Date(endDate + 'T' + endTime);
            
            const existingEvents = calendar.getEvents();
            const conflictingEvents = existingEvents.filter(event => {
                const eventStart = new Date(event.start);
                const eventEnd = new Date(event.end);
                return (startDateTime < eventEnd && endDateTime > eventStart);
            });
            
            // Remove previous conflict styling
            document.querySelectorAll('.time-conflict').forEach(el => {
                el.classList.remove('time-conflict');
            });
            
            if (conflictingEvents.length > 0) {
                // Add conflict styling to form fields
                document.getElementById('start_date').classList.add('time-conflict');
                document.getElementById('start_time').classList.add('time-conflict');
                document.getElementById('end_date').classList.add('time-conflict');
                document.getElementById('end_time').classList.add('time-conflict');
                
                // Show conflict warning
                const conflictDetails = conflictingEvents.map(event => 
                    `${event.title} (${formatTime(event.start)} - ${formatTime(event.end)})`
                ).join(', ');
                
                showAlert(`⚠️ Time conflict with: ${conflictDetails}`, 'warning');
            }
        }
    }

    // Set default dates
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').value = today;
    document.getElementById('end_date').value = today;
    
    // Set default times
    const now = new Date();
    const currentTime = now.toTimeString().slice(0, 5);
    const nextHour = new Date(now.getTime() + 60 * 60 * 1000).toTimeString().slice(0, 5);
    
    document.getElementById('start_time').value = currentTime;
    document.getElementById('end_time').value = nextHour;
});
</script>

@endsection
