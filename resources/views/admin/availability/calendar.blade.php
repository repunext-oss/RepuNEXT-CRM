@extends('admin.admin_master')

@section('admin')
<style>
.calendar-container {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
    margin-bottom: 2rem;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.calendar-nav {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background: #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    min-height: 600px;
}

#calendarDays {
    display: contents;
}

.calendar-day-header {
    background: #f8fafc;
    padding: 1rem;
    text-align: center;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.calendar-day {
    background: white;
    min-height: 120px;
    padding: 0.5rem;
    border-right: 1px solid #e5e7eb;
    border-bottom: 1px solid #e5e7eb;
    position: relative;
    display: flex;
    flex-direction: column;
}

.calendar-day.other-month {
    background: #f9fafb;
    color: #9ca3af;
}

.calendar-day.other-month .day-number {
    color: #9ca3af;
}

.calendar-day.today {
    background: #eff6ff;
    border: 2px solid #3b82f6;
}

.day-number {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #374151;
    font-size: 1.1rem;
    text-align: center;
}

.availability-item {
    background: #d1fae5;
    border: 1px solid #10b981;
    border-radius: 4px;
    padding: 0.25rem 0.5rem;
    margin-bottom: 0.25rem;
    font-size: 0.7rem;
    color: #065f46;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.availability-item.unavailable {
    background: #fee2e2;
    border-color: #ef4444;
    color: #991b1b;
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
                <h1 class="fw-bold text-dark mb-2">📅 Availability Calendar</h1>
                <p class="text-muted">View availability schedules in calendar format</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('availability.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Calendar Container -->
        <div class="calendar-container">
            <!-- Calendar Header -->
            <div class="calendar-header">
                <div class="calendar-nav">
                    <button class="btn btn-outline-secondary" onclick="previousMonth()">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <h3 id="currentMonth" class="mb-0"></h3>
                    <button class="btn btn-outline-secondary" onclick="nextMonth()">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <div>
                    <select id="userFilter" class="form-select" onchange="loadCalendar()">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

                    <!-- Calendar Grid -->
        <div class="calendar-grid">
            <!-- Day Headers -->
            <div class="calendar-day-header">Sun</div>
            <div class="calendar-day-header">Mon</div>
            <div class="calendar-day-header">Tue</div>
            <div class="calendar-day-header">Wed</div>
            <div class="calendar-day-header">Thu</div>
            <div class="calendar-day-header">Fri</div>
            <div class="calendar-day-header">Sat</div>
            
            <!-- Calendar Days -->
            <div id="calendarDays"></div>
        </div>
        

        </div>
    </div>
</div>

<script>
let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

document.addEventListener('DOMContentLoaded', function () {
    try {
        console.log('Calendar page loaded, initializing...');
        loadCalendar();
    } catch (error) {
        console.error('Error initializing calendar:', error);
        document.getElementById('debugInfo').textContent = `Error: ${error.message}`;
    }
});

function loadCalendar() {
    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    
    const currentMonthElement = document.getElementById('currentMonth');
    const calendarDays = document.getElementById('calendarDays');
    
    if (!currentMonthElement || !calendarDays) {
        console.error('Calendar elements not found!');
        return;
    }
    
    currentMonthElement.textContent = `${monthNames[currentMonth]} ${currentYear}`;
    
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - firstDay.getDay());
    
    calendarDays.innerHTML = '';
    
    const selectedUser = document.getElementById('userFilter').value;
    
    // Calculate how many weeks we need (6 weeks = 42 days)
    const totalDays = 42;
    
    // Calculate the end date for the calendar view
    const endDate = new Date(startDate);
    endDate.setDate(startDate.getDate() + totalDays - 1);
    
    // Load availability data for the entire month
    if (selectedUser) {
        loadAvailabilityForMonth(selectedUser, startDate, endDate, calendarDays, totalDays);
    } else {
        loadAllUsersAvailabilityForMonth(startDate, endDate, calendarDays, totalDays);
    }
}

function loadAvailabilityForMonth(userId, startDate, endDate, calendarDays, totalDays) {
    const startDateStr = startDate.toISOString().split('T')[0];
    const endDateStr = endDate.toISOString().split('T')[0];
    
    fetch('/availability/date-range', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            user_id: userId,
            start_date: startDateStr,
            end_date: endDateStr
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const availabilities = data.data;
            const availabilityMap = {};
            
            // Create a map of date -> availability
            availabilities.forEach(av => {
                availabilityMap[av.date] = av;
            });
            
            // Generate calendar days
            for (let i = 0; i < totalDays; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);
                
                const dayDiv = document.createElement('div');
                dayDiv.className = 'calendar-day';
                
                if (date.getMonth() !== currentMonth) {
                    dayDiv.classList.add('other-month');
                }
                
                if (date.toDateString() === new Date().toDateString()) {
                    dayDiv.classList.add('today');
                }
                
                const dayNumber = document.createElement('div');
                dayNumber.className = 'day-number';
                dayNumber.textContent = date.getDate();
                dayDiv.appendChild(dayNumber);
                
                // Check if there's availability for this date
                const formattedDate = date.toISOString().split('T')[0];
                const availability = availabilityMap[formattedDate];
                
                if (availability) {
                    const availabilityItem = document.createElement('div');
                    availabilityItem.className = 'availability-item';
                    availabilityItem.textContent = `${availability.start_time} - ${availability.end_time}`;
                    dayDiv.appendChild(availabilityItem);
                }
                
                calendarDays.appendChild(dayDiv);
            }
        }
    })
    .catch(error => {
        console.error('Error loading availability:', error);
        // Fallback to basic calendar without availability
        generateBasicCalendar(startDate, totalDays, calendarDays);
    });
}



function loadAllUsersAvailabilityForMonth(startDate, endDate, calendarDays, totalDays) {
    // Get all users from the select dropdown
    const userSelect = document.getElementById('userFilter');
    const users = Array.from(userSelect.options).slice(1); // Skip the first "All Users" option
    
    if (users.length === 0) {
        generateBasicCalendar(startDate, totalDays, calendarDays);
        return;
    }
    
    // For now, just show the first user's availability to avoid complexity
    const firstUser = users[0];
    if (firstUser) {
        loadAvailabilityForMonth(firstUser.value, startDate, endDate, calendarDays, totalDays);
    } else {
        generateBasicCalendar(startDate, totalDays, calendarDays);
    }
}

function generateBasicCalendar(startDate, totalDays, calendarDays) {
    for (let i = 0; i < totalDays; i++) {
        const date = new Date(startDate);
        date.setDate(startDate.getDate() + i);
        
        const dayDiv = document.createElement('div');
        dayDiv.className = 'calendar-day';
        
        if (date.getMonth() !== currentMonth) {
            dayDiv.classList.add('other-month');
        }
        
        if (date.toDateString() === new Date().toDateString()) {
            dayDiv.classList.add('today');
        }
        
        const dayNumber = document.createElement('div');
        dayNumber.className = 'day-number';
        dayNumber.textContent = date.getDate();
        dayDiv.appendChild(dayNumber);
        
        calendarDays.appendChild(dayDiv);
    }
}

function previousMonth() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    loadCalendar();
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    loadCalendar();
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
