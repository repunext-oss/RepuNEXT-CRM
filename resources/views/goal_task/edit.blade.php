@extends('admin.admin_master')
@section('admin')

<style>
    .custom-input-size {
        width: 100%;
        height: 70px; 
    }
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card" style="background-color: #E1EBEE"> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">Edit</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> /Goal /Task</span>
					</h3> 
					<div class="d-flex justify-content-end align-items-center gap-2" data-kt-user-table-toolbar="base">
						<input type="hidden" name="running_time" id="running_time" value="{{ $timeTracking ? $timeTracking->running_time : 0 }}">
						<p id="runtimeDisplay" class="mb-0 fw-bold text-primary">Runtime: {{ $timeTracking && $timeTracking->running_time ? gmdate('H : i : s', $timeTracking->running_time) : '00 : 00 : 00' }}</p>
							<input type="hidden" name="id" value="{{ $repn->id }}" id="goalId"> 
						<button type="button" id="playPauseButton" class="btn btn-primary">
							<i class="fa fa-play"></i>
						</button>
						<button type="button" id="stopButton" class="btn btn-danger" disabled>
							<i class="fa fa-stop"></i>
						</button>
					</div>

				
				</div>
				<form action="{{ route('update.gtask') }}" method="post" class="form" enctype="multipart/form-data">
				@csrf
					<div class="card-body border-0 pt-0">  
						<div class="row">
						
                            <div class="col-lg-6 fv-row">
                                <input type="hidden" name="id" value="{{ $repn->id }}">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Status</label>
                                <select name="g_status" id="g_status" class="form-control form-control-lg form-control mb-3 mb-lg-0">
                                    <option value="" disabled>Goal Status</option>
                                    <option value="New" {{ $repn->g_status == 'New' ? 'selected' : '' }}>New</option>
                                    <option value="Pending" {{ $repn->g_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Completed" {{ $repn->g_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
							<div class="col-lg-6 fv-row"> 
								<label class="col-lg-12 col-form-label fw-bold fs-6">Goal Task Name</label>
								<input type="text" name="g_taskname" id="g_taskname" value="{{ $repn->g_taskname }}" placeholder="Goal Task Name" class="form-control form-control-lg form-control mb-3 mb-lg-0"  />
							</div> 
						</div> 
						<div class="row">
							<div class="col-lg-4 fv-row">  
								<label class="col-lg-12 col-form-label fw-bold fs-6">Goal Deadline</label>
								<input type="date" name="g_deadline" id="g_deadline" value="{{ $repn->g_deadline }}" placeholder="Goal Deadline" class="form-control form-control-lg form-control mb-3 mb-lg-0"  disabled/>
							</div>
							<div class="col-lg-4 fv-row">
                                <label for="timer" class="col-lg-12 col-form-label required fw-bold fs-6">Select time to complete task</label>
                                <select name="timer" id="timer" class="form-control form-control-lg form-control mb-3 mb-lg-0" disabled>
                                    <option value="" disabled {{ !isset($repn->timer) ? 'selected' : '' }}>Select Priority</option>
                                    <option value="5" {{ isset($repn->timer) && $repn->timer == 5 ? 'selected' : '' }}>5 minutes</option>
                                    <option value="10" {{ isset($repn->timer) && $repn->timer == 10 ? 'selected' : '' }}>10 minutes</option>
                                    <option value="20" {{ isset($repn->timer) && $repn->timer == 20 ? 'selected' : '' }}>20 minutes</option>
                                    <option value="30" {{ isset($repn->timer) && $repn->timer == 30 ? 'selected' : '' }}>30 minutes</option>
                                    <option value="60" {{ isset($repn->timer) && $repn->timer == 60 ? 'selected' : '' }}>1 hour</option>
                                    <option value="120" {{ isset($repn->timer) && $repn->timer == 120 ? 'selected' : '' }}>2 hours</option>
                                    <option value="180" {{ isset($repn->timer) && $repn->timer == 180 ? 'selected' : '' }}>3 hours</option>
                                    <option value="240" {{ isset($repn->timer) && $repn->timer == 240 ? 'selected' : '' }}>4 hours</option>
                                    <option value="300" {{ isset($repn->timer) && $repn->timer == 300 ? 'selected' : '' }}>5 hours</option>
                                    <option value="360" {{ isset($repn->timer) && $repn->timer == 360 ? 'selected' : '' }}>6 hours</option>
                                    <option value="420" {{ isset($repn->timer) && $repn->timer == 420 ? 'selected' : '' }}>7 hours</option>
                                    <option value="480" {{ isset($repn->timer) && $repn->timer == 480 ? 'selected' : '' }}>8 hours</option>
                                    <option value="720" {{ isset($repn->timer) && $repn->timer == 720 ? 'selected' : '' }}>12 hours</option>
                                    <option value="960" {{ isset($repn->timer) && $repn->timer == 960 ? 'selected' : '' }}>16 hours</option>
                                    <option value="1200" {{ isset($repn->timer) && $repn->timer == 1200 ? 'selected' : '' }}>20 hours</option>
                                    <option value="1440" {{ isset($repn->timer) && $repn->timer == 1440 ? 'selected' : '' }}>24 hours</option>
                                </select>
                            </div>

							<div class="col-lg-4 fv-row">  
								<label class="col-lg-12 col-form-label fw-bold fs-6">Goal Category</label>
								<select name="g_category[]" id="g_category" class="form-select mb-3 form-control" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" >
								@php $gcategory = explode(',', $repn->g_category); @endphp	
									@foreach($gscc as $gsccs)
										<option value="{{ $gsccs->id }}" {{ in_array($gsccs->id, $gcategory) ? 'selected' : '' }}>{{ $gsccs->gc_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="row">	
                            <div class="col-lg-6 fv-row">  
                                <label class="col-lg-12 col-form-label fw-bold fs-6">Goal Priority</label>
                                <select name="g_priority" id="g_priority" class="form-control form-control-lg form-control mb-3 mb-lg-0">
                                    <option value="" disabled>Goal Priority</option>
                                    <option value="high" {{ isset($repn->g_priority) && $repn->g_priority == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="medium" {{ isset($repn->g_priority) && $repn->g_priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="low" {{ isset($repn->g_priority) && $repn->g_priority == 'low' ? 'selected' : '' }}>Low</option>
                                </select>
						    </div>

                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label fw-bold fs-6">Goal Assigned</label>
                                <select name="g_assigned[]" id="g_assigned" class="form-select mb-3 form-control" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple >
                                    @php 
                                        $mems = isset($repn->g_assigned) ? explode(',', $repn->g_assigned) : []; 
                                    @endphp    
                                    @foreach($rep as $reps)
                                        <option value="{{ $reps->id }}" {{ in_array($reps->id, $mems) ? 'selected' : '' }}>{{ $reps->name }}</option>
                                    @endforeach
                                </select>                            
                            </div>
						</div>  	
						<div class="row">
                            <div class="col-lg-12 fv-row">
                             <label class="col-lg-12 col-form-label fw-bold fs-6">Goal Description</label> 
                                <textarea name="g_description" id="g_description"
                                    placeholder="Goal Description"
                                    class="form-control form-control-lg mb-3 mb-lg-0"
                                    style="height: 100px; max-height: 300px; width: 100%; resize: vertical;">{{ old('g_description', $repn->g_description ?? '') }}</textarea>
                            </div>
                        </div>						
					</div>
					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<a href="{{ route('list.gtask') }}" class="btn btn-light-success me-2">Back</a>
						<button type="submit" class="btn btn-primary">Save Changes</button>   
					</div> 
				</form>					
			</div>
		</div>
	</div>
</div>

<script>

// Global state management for multiple tasks
const ACTIVE_TASK_KEY = 'activeTaskId';

// Variables will be initialized in DOMContentLoaded
let goalId, taskKey, runningTime, startTime, isRunning, timerInterval, notifiedBeforeEnd;
const WARNING_TIME = 5 * 60; 

let runtimeDisplay, playPauseButton, stopButton;

// Global task management functions
function setActiveTask(taskId) {
    localStorage.setItem(ACTIVE_TASK_KEY, taskId);
}

function getActiveTask() {
    return localStorage.getItem(ACTIVE_TASK_KEY);
}

function clearActiveTask() {
    localStorage.removeItem(ACTIVE_TASK_KEY);
}

function isTaskActive(taskId) {
    return getActiveTask() === taskId;
}

// Function to attach all event listeners
function attachEventListeners() {
    // Play/Pause button event listener
    playPauseButton.addEventListener('click', () => {
        let token = "{{ csrf_token() }}";

        if (!goalId) {
            console.error('Goal ID is missing');
            return;
        }
        
        let isPaused = playPauseButton.textContent.trim() === 'Pause';

        if (!isPaused) {
            // Check if this is a resume (timer was previously paused) or a fresh start
            const wasPaused = localStorage.getItem(`${taskKey}_wasPaused`) === 'true';
            
            if (wasPaused && runningTime > 0) {
                // Resume from where it was paused - make API call to resume
                console.log('Resuming timer from:', runningTime);
                
                $.ajax({
                    url: `/goal/pause/${goalId}`,
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ goalId: goalId, running_time: runningTime }),
                    headers: { 'X-CSRF-TOKEN': token },
                    success: function(response) {
                        console.log('Goal resumed:', response);
                        playPauseButton.textContent = 'Pause';
                        stopButton.disabled = false;
                        
                        // Set startTime to continue from current runningTime
                        startTime = Date.now() - (runningTime * 1000);
                        localStorage.setItem(`${taskKey}_startTime`, startTime);
                        localStorage.setItem(`${taskKey}_isRunning`, 'true');
                        localStorage.removeItem(`${taskKey}_wasPaused`); // Clear the paused flag
                        
                        // Set this task as the active task
                        setActiveTask(goalId);
                        
                        startTimer();
                    },
                    error: function(xhr, status, error) {
                        console.error('Resume error:', error);
                    }
                });
            } else {
                // Fresh start - make API call
                $.ajax({
                    url: `/goal/start`,
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ goalId: goalId }),
                    headers: { 'X-CSRF-TOKEN': token },
                    success: function(response) {
                        console.log('Goal started:', response);
                        playPauseButton.textContent = 'Pause';
                        stopButton.disabled = false;

                        // Ensure running time is never negative
                        runningTime = Math.max(0, response.running_time || 0);
                        startTime = Date.now() - (runningTime * 1000);
                        
                        localStorage.setItem(`${taskKey}_startTime`, startTime);
                        localStorage.setItem(`${taskKey}_isRunning`, 'true');
                        localStorage.setItem(`${taskKey}_runningTime`, runningTime);
                        localStorage.removeItem(`${taskKey}_wasPaused`); // Clear any previous paused state
                        
                        // Set this task as the active task
                        setActiveTask(goalId);

                        startTimer();
                    },
                    error: function(xhr, status, error) {
                        console.error('Start error:', error);
                    }
                });
            }
        } else {
            // Calculate the current running time before pausing
            const currentRunningTime = startTime ? Math.max(0, Math.floor((Date.now() - startTime) / 1000)) : runningTime;
            
            $.ajax({
                url: `/goal/pause/${goalId}`,
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ goalId: goalId, running_time: currentRunningTime }),
                headers: { 'X-CSRF-TOKEN': token },
                success: function(response) {
                    console.log('Goal paused:', response);
                    playPauseButton.textContent = 'Play';
                    stopButton.disabled = true;

                    // Update runningTime with the calculated value
                    runningTime = currentRunningTime;
                    localStorage.setItem(`${taskKey}_runningTime`, runningTime);
                    localStorage.setItem(`${taskKey}_isRunning`, 'false');
                    localStorage.setItem(`${taskKey}_wasPaused`, 'true'); // Mark that it was paused
                    
                    // Clear active task when paused to allow starting other tasks
                    if (isTaskActive(goalId)) {
                        clearActiveTask();
                    }
                    
                    clearInterval(timerInterval);
                },
                error: function(xhr, status, error) {
                    console.error('Pause error:', error);
                }
            });
        }
    });

    // Stop button event listener
    stopButton.addEventListener('click', () => {
        stopTimer();
        playPauseButton.textContent = 'Play';
        stopButton.disabled = true;
    });

    // Additional stop button event listener for AJAX call
    document.getElementById("stopButton").addEventListener("click", function () {
        let token = "{{ csrf_token() }}";

        if (!goalId) {
            console.error("Goal ID is missing");
            return;
        }
        // Calculate the current running time before stopping
        const currentRunningTime = startTime ? Math.max(0, Math.floor((Date.now() - startTime) / 1000)) : runningTime;
        
        $.ajax({
            url: `/goal/stop/${goalId}`,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({ goalId: goalId, running_time: currentRunningTime }),
            headers: { "X-CSRF-TOKEN": token },
            success: function (response) {
                console.log("Goal stopped:", response);
                
                playPauseButton.disabled = true;
                stopButton.disabled = true;

                // Update runningTime with the calculated value
                runningTime = currentRunningTime;
                localStorage.setItem(`${taskKey}_runningTime`, runningTime);
                localStorage.setItem(`goal_${goalId}`, "stopped");
                localStorage.removeItem(`${taskKey}_wasPaused`); // Clear paused state when stopped
                
                // Clear active task when stopped
                if (isTaskActive(goalId)) {
                    clearActiveTask();
                }

                clearInterval(timerInterval);
                updateRuntimeDisplay(runningTime);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Please click Play and then click Stop.");
            }
        });
    });
}

function formatTime(seconds) {
    let hours = Math.floor(seconds / 3600);
    let minutes = Math.floor((seconds % 3600) / 60);
    let remainingSeconds = seconds % 60;

    return `${String(hours).padStart(2, '0')} : ${String(minutes).padStart(2, '0')} : ${String(remainingSeconds).padStart(2, '0')}`;
}

function updateRuntimeDisplay(time) {
    runtimeDisplay.textContent = `Runtime: ${formatTime(time)}`;
}

function startTimer() {
    if (!startTime) {
        startTime = Date.now() - (runningTime * 1000);
    }

    localStorage.setItem(`${taskKey}_startTime`, startTime);
    localStorage.setItem(`${taskKey}_isRunning`, 'true');
     
    const timer = (parseInt(document.getElementById('timer').value) || 0) * 60;
    const alertSound = new Audio('https://actions.google.com/sounds/v1/alarms/alarm_clock.ogg');
   
    timerInterval = setInterval(() => {
        const currentTime = Math.floor((Date.now() - startTime) / 1000);
        // Ensure runningTime never goes negative
        runningTime = Math.max(0, currentTime);
        localStorage.setItem(`${taskKey}_runningTime`, runningTime);
        updateRuntimeDisplay(runningTime);
       
        const remainingTime = timer - runningTime;
        if (timer > 0 && remainingTime <= WARNING_TIME && remainingTime > 0 && !notifiedBeforeEnd) {
            notifiedBeforeEnd = true;

            alertSound.play();
            alert('⏰ Reminder: Only 5 minutes left to complete this goal!');
        }
    }, 1000);
}

function stopTimer() {
    clearInterval(timerInterval);
    
    // Clear active task when stopped
    if (isTaskActive(goalId)) {
        clearActiveTask();
    }
    
    // Clear only the active state, but preserve the final running time
    localStorage.removeItem(`${taskKey}_startTime`);
    localStorage.removeItem(`${taskKey}_isRunning`);
    localStorage.removeItem(`${taskKey}_wasPaused`);
    
    // Keep the final running time in localStorage and display
    localStorage.setItem(`${taskKey}_runningTime`, runningTime);
    
    startTime = null;
    updateRuntimeDisplay(runningTime); // Display the final time, not zero
}

document.addEventListener('DOMContentLoaded', () => {
    // Initialize all variables after DOM is loaded
    goalId = document.getElementById('goalId').value;
    taskKey = `task_${goalId}`;
    
    // Initialize with database value or localStorage value
    const dbRunningTime = parseInt(document.getElementById('running_time').value) || 0;
    const storedRunningTime = parseInt(localStorage.getItem(`${taskKey}_runningTime`)) || 0;
    
    // Use the higher value (most recent) between database and localStorage
    runningTime = Math.max(dbRunningTime, storedRunningTime);
    startTime = parseInt(localStorage.getItem(`${taskKey}_startTime`)) || null;
    isRunning = localStorage.getItem(`${taskKey}_isRunning`) === 'true';
    timerInterval = null;
    notifiedBeforeEnd = false;
    
    // Get DOM elements
    runtimeDisplay = document.getElementById('runtimeDisplay');
    playPauseButton = document.getElementById('playPauseButton');
    stopButton = document.getElementById('stopButton');
    
    // Debug: Log initialization values
    console.log('Initialization:', {
        goalId: goalId,
        dbRunningTime: dbRunningTime,
        storedRunningTime: storedRunningTime,
        finalRunningTime: runningTime,
        isRunning: isRunning
    });
    
    // Initialize display with the correct running time
    updateRuntimeDisplay(runningTime);
    
    if (isRunning) {
        startTimer();
        playPauseButton.textContent = 'Pause';
        stopButton.disabled = false;
    }
    
    // Attach event listeners after DOM elements are ready
    attachEventListeners();
});

// Check if task is stopped after initialization
setTimeout(() => {
    // Check if task is stopped (either in localStorage or database)
    const isStopped = localStorage.getItem(`goal_${goalId}`) === "stopped" || 
                     (runningTime > 0 && !isRunning && !startTime);
    
    if (isStopped) {
        playPauseButton.disabled = true;
        stopButton.disabled = true;
    }
}, 100);

</script>

@endsection  

