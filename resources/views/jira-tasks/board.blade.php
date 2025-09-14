@extends('admin.admin_master')
@section('admin')
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center board-header-gradient">
                    <h3 class="card-title mb-0 board-title">
                        <i class="fas fa-project-diagram me-3"></i>
                        Repunext Board - Task Management 
                    </h3>
                    <div>
                        <a href="{{ route('jira-tasks.create') }}" class="btn btn-light me-2 btn-header-primary">
                            <i class="fas fa-plus me-2"></i>Create Task
                        </a>
                        <a href="{{ route('jira-tasks.backlog') }}" class="btn btn-outline-light btn-header-secondary">
                            <i class="fas fa-list me-2"></i>Backlog
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- To Do Column -->
                        <div class="col-md-3">
                            <div class="card" >
                                <div class="card-header column-header-gradient todo-header">
                                    <h6 class="mb-0 text-center text-white column-title">
                                        <i class="fas fa-clipboard-list me-3 column-icon"></i>
                                        <span class="column-label">TO DO</span>
                                        <span class="badge bg-white text-info ms-3 badge-count">{{ $todoTasks->count() }}</span>
                                    </h6>
                                </div>
                                <div class="card-body p-2 sortable-column" data-status="todo">
                                    @if($todoTasks->count() == 0)
                                        <div class="text-center text-muted py-3">
                                            <p>No tasks in todo</p>
                                            <small>Drag tasks here from backlog</small>
                                        </div>
                                    @endif
                                    @foreach($todoTasks as $task)
                                        <div class="task-card mb-3 p-3 border-0 rounded-3 draggable-task shadow-sm" 
                                             data-task-id="{{ $task->id }}" 
                                             data-status="todo"
                                             draggable="true"
                                             onclick="event.preventDefault(); viewTaskDetails({{ $task->id }});"
                                             class="task-card-clickable">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <small class="text-muted">{{ $task->task_key }}</small>
                                                <span class="badge badge-modern badge-priority-{{ $task->priority }} mx-1">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>
                                            <h6 class="mb-2">{{ $task->title }}</h6> 
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="badge badge-info">{{ $task->type_text }}</span>
                                                <div class="d-flex align-items-center">
                                                @if($task->story_points)
                                                        <span class="badge badge-secondary me-2">{{ $task->story_points }}</span>
                                                @endif
                                            @if($task->assignee)
                                                    <img src="{{ asset('upload/profile-img/' . $task->assignee->profile_image) }}" 
                                                         class="rounded-circle me-1 assignee-avatar" width="20" height="20" 
                                                         onerror="this.src='{{ asset('upload/default.jpg') }}'">
                                                        <small class="text-muted fw-semibold">{{ $task->assignee->name }}</small>
                                            @endif
                                                </div>
                                            </div> 
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- In Progress Column -->
                        <div class="col-md-3">
                            <div class="card" >
                                <div class="card-header column-header-gradient in-progress-header">
                                    <h6 class="mb-0 text-center text-white column-title">
                                        <i class="fas fa-play-circle me-3 column-icon"></i>
                                        <span class="column-label">IN PROGRESS</span>
                                        <span class="badge bg-white text-warning ms-3 badge-count">{{ $inProgressTasks->count() }}</span>
                                    </h6>
                                </div>
                                <div class="card-body p-2 sortable-column" data-status="in_progress">
                                    @foreach($inProgressTasks as $task)
                                        <div class="task-card mb-3 p-3 border-0 rounded-3 draggable-task shadow-sm" 
                                             data-task-id="{{ $task->id }}" 
                                             data-status="in_progress"
                                             draggable="true"
                                             onclick="event.preventDefault(); viewTaskDetails({{ $task->id }});"
                                             class="task-card-clickable">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <small class="text-muted">{{ $task->task_key }}</small>
                                                <span class="badge badge-modern badge-priority-{{ $task->priority }} mx-1">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>
                                            <h6 class="mb-2">{{ $task->title }}</h6> 
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="badge badge-info">{{ $task->type_text }}</span>
                                                <div class="d-flex align-items-center">
                                                @if($task->story_points)
                                                        <span class="badge badge-secondary me-2">{{ $task->story_points }}</span>
                                                @endif
                                            @if($task->assignee)
                                                    <img src="{{ asset('upload/profile-img/' . $task->assignee->profile_image) }}" 
                                                         class="rounded-circle me-1 assignee-avatar" width="20" height="20" 
                                                         onerror="this.src='{{ asset('upload/default.jpg') }}'">
                                                        <small class="text-muted fw-semibold">{{ $task->assignee->name }}</small>
                                            @endif
                                                </div>
                                            </div> 
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Review Column -->
                        <div class="col-md-3">
                            <div class="card" >
                                <div class="card-header column-header-gradient review-header">
                                    <h6 class="mb-0 text-center text-dark column-title">
                                        <i class="fas fa-search me-3 column-icon"></i>
                                        <span class="column-label">REVIEW</span>
                                        <span class="badge bg-dark text-white ms-3 badge-count">{{ $reviewTasks->count() }}</span>
                                    </h6>
                                </div>
                                <div class="card-body p-2 sortable-column" data-status="review">
                                    @foreach($reviewTasks as $task)
                                        <div class="task-card mb-3 p-3 border-0 rounded-3 draggable-task shadow-sm" 
                                             data-task-id="{{ $task->id }}" 
                                             data-status="review"
                                             draggable="true"
                                             onclick="event.preventDefault(); viewTaskDetails({{ $task->id }});"
                                             class="task-card-clickable">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <small class="text-muted">{{ $task->task_key }}</small>
                                                <span class="badge badge-modern badge-priority-{{ $task->priority }} mx-1">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>
                                            <h6 class="mb-2">{{ $task->title }}</h6> 
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="badge badge-info">{{ $task->type_text }}</span>
                                                <div class="d-flex align-items-center">
                                                @if($task->story_points)
                                                        <span class="badge badge-secondary me-2">{{ $task->story_points }}</span>
                                                @endif
                                            @if($task->assignee)
                                                    <img src="{{ asset('upload/profile-img/' . $task->assignee->profile_image) }}" 
                                                         class="rounded-circle me-1 assignee-avatar" width="20" height="20" 
                                                         onerror="this.src='{{ asset('upload/default.jpg') }}'">
                                                        <small class="text-muted fw-semibold">{{ $task->assignee->name }}</small>
                                            @endif
                                                </div>
                                            </div> 
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Done Column -->
                        <div class="col-md-3">
                            <div class="card" >
                                <div class="card-header column-header-gradient done-header">
                                    <h6 class="mb-0 text-center text-white column-title">
                                        <i class="fas fa-check-double me-3 column-icon"></i>
                                        <span class="column-label">DONE</span>
                                        <span class="badge bg-white text-success ms-3 badge-count">{{ $doneTasks->count() }}</span>
                                    </h6>
                                </div>
                                <div class="card-body p-2 sortable-column" data-status="done">
                                    @foreach($doneTasks as $task)
                                        <div class="task-card mb-3 p-3 border-0 rounded-3 draggable-task shadow-sm" 
                                             data-task-id="{{ $task->id }}" 
                                             data-status="done"
                                             draggable="true"
                                             onclick="event.preventDefault(); viewTaskDetails({{ $task->id }});"
                                             class="task-card-clickable">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <small class="text-muted">{{ $task->task_key }}</small>
                                                <span class="badge badge-modern badge-priority-{{ $task->priority }} mx-1">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>
                                            <h6 class="mb-2">{{ $task->title }}</h6> 
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="badge badge-info">{{ $task->type_text }}</span>
                                                <div class="d-flex align-items-center">
                                                @if($task->story_points)
                                                        <span class="badge badge-secondary me-2">{{ $task->story_points }}</span>
                                                @endif
                                            @if($task->assignee)
                                                    <img src="{{ asset('upload/profile-img/' . $task->assignee->profile_image) }}" 
                                                         class="rounded-circle me-1 assignee-avatar" width="20" height="20" 
                                                         onerror="this.src='{{ asset('upload/default.jpg') }}'">
                                                        <small class="text-muted fw-semibold">{{ $task->assignee->name }}</small>
                                            @endif
                                                </div>
                                            </div> 
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Task Details Modal -->
<div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content border-0 shadow-lg">
            <!-- Professional Header with Gradient -->
            <div class="modal-header border-0 bg-gradient-primary text-white position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);"></div>
            </div>
                <div class="position-relative">
                    <h4 class="modal-title mb-0 d-flex align-items-center" id="taskDetailsModalLabel">
                        <div class="task-icon-wrapper me-3">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-1">
                                <div class="h5 mb-0 me-2" id="modalTaskTitle">Task Details</div>
                                <button type="button" class="btn btn-sm btn-outline-light" id="editTaskBtn" title="Edit Task">
                                    <i class="fas fa-edit" style="color: rgba(255, 255, 255, 0.9);"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span class="badge badge-light text-dark px-2 py-1" id="modalTaskKey">
                                    <i class="fas fa-key me-1" style="color: rgba(255, 255, 255, 0.9);"></i>TASK-001
                                </span>
                                <span class="badge badge-modern" id="modalTaskPriority">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Priority
                                </span>
                                <small class="opacity-75" id="modalTaskCreated">
                                    <i class="fas fa-calendar-alt me-1" style="color: rgba(255, 255, 255, 0.8);"></i>Created Date
                                </small>
                            </div>
                        </div>
                    </h4>
                </div>
                <button type="button" class="btn-close btn-close-white position-relative" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body p-0" id="taskDetailsContent">
                <div class="text-center py-5 loading-state">
                    <div class="spinner-wrapper mb-3">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                    <h5 class="text-muted">Loading task details...</h5>
                    <p class="text-muted small">Please wait while we fetch the task information</p>
            </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Professional Task Modal Styles */
.bg-gradient-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
}

/* Optimized Color Variables - only used ones */
:root {
    --primary-color: #667eea;
    --primary-dark: #764ba2;
}

.task-icon-wrapper {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.95);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Modal Header Styling */
#modalTaskTitle {
    font-size: 1.25rem;
    font-weight: 600;
    line-height: 1.2;
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Professional Header Icon Colors */
.modal-header .task-icon-wrapper i {
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.modal-header .btn-outline-light i {
    color: rgba(255, 255, 255, 0.9);
    transition: color 0.3s ease;
}

.modal-header .btn-outline-light:hover i {
    color: rgba(255, 255, 255, 1);
}

.modal-header .badge-light i {
    color: rgba(255, 255, 255, 0.9);
}

.modal-header .badge i {
    color: rgba(255, 255, 255, 0.9);
}

.modal-header small i {
    color: rgba(255, 255, 255, 0.8);
}

#modalTaskKey {
    font-size: 0.875rem;
    font-weight: 500;
    background: linear-gradient(135deg,rgb(67, 147, 138) 0%,rgb(22, 101, 101) 100%) !important;
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 2px 8px rgba(255, 255, 255, 0.25);
    border-radius: 12px;
    text-shadow: 0 1px 2px rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    letter-spacing: 0.5px;
}

#modalTaskKey:hover {
    background: linear-gradient(135deg, #343a40 0%, #212529 100%) !important;
    box-shadow: 0 4px 12px rgba(73, 80, 87, 0.35);
    transform: translateY(-1px);
    border-color: rgba(255, 255, 255, 0.15);
}

#modalTaskCreated {
    font-size: 0.875rem;
    opacity: 0.9;
    color: rgba(255, 255, 255, 0.85) !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

#modalTaskPriority {
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 20px;
    padding: 0.4rem 0.8rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    transition: all 0.3s ease;
}

/* Modal header priority badge specific styling */
.modal-header #modalTaskPriority.badge-modern {
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

#editTaskBtn {
    font-size: 0.875rem;
    padding: 0.25rem 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

#editTaskBtn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-1px);
}

.modal-xl {
    max-width: 95%;
}

@media (max-width: 991.98px) {
    .modal-fullscreen-lg-down {
        width: 100vw;
        max-width: none;
        height: 100vh;
        margin: 0;
    }
}

/* Enhanced Task Card Styles */
.task-detail-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.task-detail-card:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.task-header-gradient {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.task-info-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid rgba(0, 0, 0, 0.05);
    border-radius: 12px;
}

/* Professional Badge Styles - Consistent Shape System */
.badge-modern {
    padding: 0.5rem 1rem;
    border-radius: 16px;
    font-weight: 600;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Project Chip - Professional Minimal Design */
.project-chip {
    background: transparent;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    display: inline-flex;
    align-items: center;
    font-size: 0.85rem;
    font-weight: 600;
    color: #495057;
    transition: all 0.3s ease;
}

.project-chip i {
    color: #495057;
    font-size: 0.9rem;
}

.project-chip:hover {
    background: rgba(0, 0, 0, 0.02);
    color: #212529;
    transform: translateY(-1px);
}

.badge-status-backlog {
    background: linear-gradient(135deg, #6c757d, #495057) !important;
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    box-shadow: 0 2px 4px rgba(108, 117, 125, 0.3) !important;
}

.badge-status-todo {
    background: linear-gradient(135deg, #17a2b8, #138496) !important;
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    box-shadow: 0 2px 4px rgba(23, 162, 184, 0.3) !important;
}

.badge-status-in-progress,
.badge-status-in_progress {
    background: linear-gradient(135deg, #fd7e14, #e55a00) !important;
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    box-shadow: 0 2px 4px rgba(253, 126, 20, 0.3) !important;
}

.badge-status-review {
    background: linear-gradient(135deg, #6f42c1, #5a2d91) !important;
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    box-shadow: 0 2px 4px rgba(111, 66, 193, 0.3) !important;
}

.badge-status-done {
    background: linear-gradient(135deg, #20c997, #1aa179) !important;
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    box-shadow: 0 2px 4px rgba(32, 201, 151, 0.3) !important;
}

/* Priority Badges - Distinct Pill Shape */
.badge-priority-high {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    border-radius: 20px;
    padding: 0.4rem 0.8rem;
    font-size: 0.7rem;
}

.badge-priority-medium {
    background: linear-gradient(135deg, #fd7e14, #e55a00);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 4px rgba(253, 126, 20, 0.3);
    border-radius: 20px;
    padding: 0.4rem 0.8rem;
    font-size: 0.7rem;
}

.badge-priority-low {
    background: linear-gradient(135deg, #20c997, #1aa179);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 4px rgba(32, 201, 151, 0.3);
    border-radius: 20px;
    padding: 0.4rem 0.8rem;
    font-size: 0.7rem;
}

.badge-priority-critical {
    background: linear-gradient(135deg, #6f42c1, #5a2d91);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 4px rgba(111, 66, 193, 0.3);
    border-radius: 20px;
    padding: 0.4rem 0.8rem;
    font-size: 0.7rem;
}

/* Avatar Styles */
.avatar-professional {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9rem;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Info Card Styles */
.info-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.info-item {
    margin-bottom: 1rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.info-value {
    font-size: 0.9rem;
    font-weight: 500;
    color: #2c3e50;
    line-height: 1.4;
}

/* Task Info Summary Styles */
.task-info-summary {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.info-row {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.info-row .info-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    min-width: 80px;
}

.info-row .info-value {
    font-size: 0.85rem;
    font-weight: 500;
    color: #2c3e50;
}

.avatar-assignee {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.avatar-reporter {
    background: linear-gradient(135deg, #f093fb, #f5576c);
}

/* Content Sections */
.content-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.section-title i {
    margin-right: 0.5rem;
    color: #667eea;
}

/* Attachment Styles */
.attachment-card {
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 8px;
    padding: 1rem;
    background: white;
    transition: all 0.2s ease;
}

.attachment-card:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
    transform: translateY(-1px);
}

.file-icon-large {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-right: 1rem;
}

.file-icon-pdf { background: linear-gradient(135deg, #e74c3c, #c0392b); }
.file-icon-doc { background: linear-gradient(135deg, #3498db, #2980b9); }
.file-icon-img { background: linear-gradient(135deg, #27ae60, #229954); }
.file-icon-default { background: linear-gradient(135deg, #95a5a6, #7f8c8d); }

/* Loading Animation */
.loading-state {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 16px;
    margin: 2rem;
}

.spinner-wrapper {
    position: relative;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-body {
        padding: 1rem;
    }
    
    .task-icon-wrapper {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    #modalTaskTitle {
        font-size: 1.1rem;
    }
    
    #modalTaskKey, #modalTaskCreated, #modalTaskPriority {
        font-size: 0.8rem;
    }
    
    #editTaskBtn {
        font-size: 0.8rem;
        padding: 0.2rem 0.4rem;
    }
    
    .content-section {
        padding: 1rem;
        margin-bottom: 1rem;
    }
}

/* Unused typography classes removed for optimization */

.info-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #7f8c8d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.info-value {
    color: #2c3e50;
    font-weight: 500;
}

/* Additional Professional Enhancements */
.info-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.task-header-info {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.description-content, .comments-content {
    background: white;
    border-radius: 8px;
}

.attachments-grid {
    background: white;
    border-radius: 8px;
}

/* Enhanced Badge Styles - Consistent Shape System */
.badge {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.badge-light {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    color: #495057;
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Task Type Badge - Modern Blue Design */
.badge-info {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.badge-info i {
    color: white !important;
}

.badge-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
    color: #212529;
    box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
}

/* Professional Hover Effects */
.task-info-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.content-section:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

/* Optimized CSS Classes for Inline Styles */
.board-header-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 0.75rem 0.75rem 0 0;
    position: relative;
    z-index: 10;
}

.column-header-gradient {
    border-radius: 0.75rem 0.75rem 0 0;
    padding: 1.25rem 1.5rem;
}

.todo-header {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.in-progress-header {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.review-header {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.done-header {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
}

.badge-count {
    font-size: 1rem;
    font-weight: 800;
    padding: 0.5rem 0.8rem;
    border-radius: 15px;
    box-shadow: 0 2px 8px rgba(255,255,255,0.3);
}

.board-title {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.btn-header-primary {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 600;
}

.btn-header-secondary {
    border: 1px solid rgba(255, 255, 255, 0.5);
    color: white;
    font-weight: 600;
}

.column-title {
    font-size: 1.2rem;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.column-icon {
    font-size: 1.1rem;
}

.column-label {
    display: inline-block;
    vertical-align: middle;
}

.task-card-clickable {
    cursor: pointer;
}

.assignee-avatar {
    border: 2px solid #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

/* Optimized - removed unused print styles */

/* Animation for smooth loading */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.content-section {
    animation: fadeInUp 0.5s ease-out;
}

.task-info-card {
    animation: fadeInUp 0.6s ease-out;
}

/* Professional Jira Board Enhancements */
.card {
    border-radius: 16px;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.card:hover {
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

/* Enhanced Column Cards */
.col-md-3 .card {
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    transition: box-shadow 0.3s ease;
}

.col-md-3 .card:hover {
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.18);
}

/* Professional Task Card Design */
.task-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
    border-radius: 16px;
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.task-card:hover {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12) !important;
    transform: translateY(-3px);
    border-color: rgba(102, 126, 234, 0.3) !important;
}

.card-header {
    border-bottom: none;
    position: relative;
    overflow: hidden;
}

.card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    z-index: 1;
    pointer-events: none;
}

.card-header::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    z-index: 2;
    pointer-events: none;
    animation: shimmer 3s ease-in-out infinite;
}

.card-header h6 {
    position: relative;
    z-index: 3;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: nowrap;
}

.card-header h6 i {
    position: relative;
    z-index: 4;
    color: inherit !important;
    font-size: 1.1rem !important;
    margin-right: 0.75rem !important;
}

.card-header > * {
    position: relative;
    z-index: 4;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.card-body {
    background: #f8f9fa;
    border-radius: 0 0 0.75rem 0.75rem;
}

.sortable-column {
    min-height: 400px !important;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

/* Badge styling consolidated with main badge definition above */

/* Professional Priority Badges */
.badge-danger {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
}

.badge-warning {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    box-shadow: 0 2px 8px rgba(243, 156, 18, 0.3);
}

.badge-success {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
}

/* Task Title Enhancement */
.task-card h6 {
    color: #2c3e50;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

/* Task Key Styling */
.task-card small.text-muted {
    font-size: 0.7rem;
    font-weight: 500;
    color: #6c757d !important;
    letter-spacing: 0.3px;
}

/* Task Description Styling */
.task-card p.small {
    color: #6c757d !important;
    line-height: 1.3;
    font-size: 0.8rem;
}

/* Story Points Styling */
.task-card .badge-secondary {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
    font-weight: 600;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

/* User Info Styling */
.task-card .d-flex.align-items-center img {
    transition: all 0.3s ease;
}

.task-card .d-flex.align-items-center img:hover {
    transform: scale(1.1);
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
}

.task-card .fw-semibold {
    color: #495057;
    font-weight: 600;
}

/* Click to view details styling */
.task-card .text-center small {
    font-style: italic;
    opacity: 0.8;
    transition: all 0.3s ease;
}

.task-card:hover .text-center small {
    opacity: 1;
    color: #007bff;
}

/* User Avatar Enhancement */
.task-card img {
    border: 2px solid rgba(255, 255, 255, 0.8);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Empty State Enhancement */
.text-center.text-muted.py-3 {
    background: rgba(255, 255, 255, 0.7);
    border-radius: 0.5rem;
    border: 2px dashed rgba(0, 0, 0, 0.1);
    margin: 1rem;
}

/* Column Spacing */
.col-md-3 {
    padding: 0 0.5rem;
}

/* Enhanced Badge Styling for Column Headers */
.card-header .badge {
    font-weight: 800;
    letter-spacing: 0.5px;
    border-radius: 15px;
    padding: 0.5rem 0.8rem;
    font-size: 1rem;
    box-shadow: 0 2px 8px rgba(255,255,255,0.3);
    transition: all 0.3s ease;
}

.card-header .badge:hover {
    box-shadow: 0 4px 12px rgba(255,255,255,0.4);
}

/* Column Icon Enhancements */
.card-header i {
    transition: all 0.3s ease;
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    color: inherit !important;
}

.card-header:hover i {
    transform: none;
}

/* Ensure FontAwesome icons are visible */
.fas, .far, .fab, .fal, .fa {
    font-family: "Font Awesome 6 Free" !important;
    font-weight: 900 !important;
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.far {
    font-weight: 400 !important;
}

/* Responsive Enhancements */
@media (max-width: 768px) {
    .card-header {
        padding: 0.75rem 1rem;
    }
    
    .card-header h6 {
        font-size: 1rem;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .card-header .badge {
        font-size: 0.9rem;
        padding: 0.4rem 0.6rem;
    }
    
    .task-card {
        margin-bottom: 0.75rem;
        padding: 0.75rem;
    }
    
    .col-md-3 .card {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .card-header h6 {
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }
    
    .card-header i {
        font-size: 0.9rem !important;
    }
}

/* Comment System Styles */
.comment-form {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.comment-textarea {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 0.9rem;
    line-height: 1.5;
    resize: vertical;
    transition: all 0.3s ease;
    background: white;
}

.comment-textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
    outline: none;
}

.comment-actions {
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding-top: 0.75rem;
}

.comment-buttons .btn {
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.comment-buttons .btn:hover {
    transform: translateY(-1px);
}

/* Individual Comment Styles */
.comment-item {
    background: white;
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    position: relative;
}

.comment-item:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transform: translateY(-1px);
}

.comment-header {
    display: flex;
    justify-content: between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
}

.comment-author {
    display: flex;
    align-items: center;
    flex-grow: 1;
}

.comment-author-info {
    margin-left: 0.75rem;
}

.comment-author-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.comment-timestamp {
    font-size: 0.75rem;
    color: #7f8c8d;
    display: flex;
    align-items: center;
}

.comment-timestamp i {
    margin-right: 0.25rem;
}

.comment-actions-menu {
    position: relative;
}

.comment-actions-btn {
    background: none;
    border: none;
    color: #7f8c8d;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.comment-actions-btn:hover {
    background: rgba(0, 0, 0, 0.05);
    color: #495057;
}

.comment-content {
    color: #2c3e50;
    line-height: 1.6;
    font-size: 0.9rem;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.comment-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    min-width: 120px;
    display: none;
}

.comment-dropdown.show {
    display: block;
}

.comment-dropdown-item {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    color: #495057;
    text-decoration: none;
    font-size: 0.85rem;
    transition: background-color 0.2s ease;
    border: none;
    background: none;
    text-align: left;
}

.comment-dropdown-item:hover {
    background: rgba(0, 0, 0, 0.05);
    color: #2c3e50;
}

.comment-dropdown-item.danger {
    color: #dc3545;
}

.comment-dropdown-item.danger:hover {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.no-comments {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    border: 2px dashed rgba(0, 0, 0, 0.1);
}

/* Character count styling */
#charCount {
    font-weight: 600;
}

#charCount.warning {
    color: #ffc107;
}

#charCount.danger {
    color: #dc3545;
}

/* Loading state for comments */
.comment-loading {
    text-align: center;
    padding: 2rem;
}

.comment-loading .spinner-border {
    width: 2rem;
    height: 2rem;
}

/* Responsive comment design */
@media (max-width: 768px) {
    .comment-form {
        padding: 1rem;
    }
    
    .comment-item {
        padding: 1rem;
    }
    
    .comment-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .comment-actions-menu {
        margin-top: 0.5rem;
        align-self: flex-end;
    }
}
</style>

<!-- Assign Task Modal -->
<div class="modal fade" id="assignTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="assignTaskForm">
                    @csrf
                    <input type="hidden" id="assign_task_id" name="task_id">
                    <div class="mb-3">
                        <label for="assignee_id" class="form-label">Assign to:</label>
                        <select class="form-select" id="assignee_id" name="assignee_id">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="assignTask()">Assign</button>
            </div>
        </div>
    </div>
</div>

<style>
.draggable-task {
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.draggable-task:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.draggable-task.dragging {
    cursor: move;
    opacity: 0.5;
    transform: rotate(5deg);
}

.draggable-task::before {
    content: "⋮⋮";
    position: absolute;
    top: 5px;
    right: 5px;
    color: #ccc;
    font-size: 12px;
    line-height: 1;
}


.sortable-column {
    transition: all 0.3s ease;
}

.sortable-column.drag-over {
    background-color: #f8f9fa;
    border: 2px dashed #007bff;
}

/* Task card styling moved to main definition above */

/* Modal Custom Styles */
#taskDetailsModal .modal-dialog {
    max-width: 1000px;
}

#taskDetailsModal .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

#taskDetailsModal .modal-header {
    border-bottom: 1px solid #e9ecef;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
}

#taskDetailsModal .modal-header .btn-close {
    filter: invert(1);
}

#taskDetailsModal .modal-body {
    padding: 2rem;
}

.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 12px;
}

/* Badge styling consolidated with main badge definition above */

/* Duplicate removed - using main card definition above */

.bg-light {
    background-color: #f8f9fa !important;
}

/* Attachment Styles */
.attachment-item {
    transition: all 0.2s ease;
}

.attachment-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.file-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

/* File type specific colors */
.file-icon .fa-file-pdf { color: #dc3545; }
.file-icon .fa-file-word { color: #007bff; }
.file-icon .fa-file-excel { color: #28a745; }
.file-icon .fa-file-powerpoint { color: #fd7e14; }
.file-icon .fa-file-image { color: #6f42c1; }
.file-icon .fa-file-video { color: #e83e8c; }
.file-icon .fa-file-audio { color: #20c997; }
.file-icon .fa-file-archive { color: #6c757d; }
.file-icon .fa-file-code { color: #17a2b8; }
</style>
@endsection


@push('scripts')
<script>
// Drag and Drop functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeDragAndDrop();
});

function initializeDragAndDrop() {
    const taskCards = document.querySelectorAll('.draggable-task');
    const columns = document.querySelectorAll('.sortable-column');

    if (taskCards.length === 0 || columns.length === 0) {
        return;
    }

    // Add drag event listeners to task cards
    taskCards.forEach((task) => {
        task.removeEventListener('dragstart', handleDragStart);
        task.removeEventListener('dragend', handleDragEnd);
        task.addEventListener('dragstart', handleDragStart);
        task.addEventListener('dragend', handleDragEnd);
        task.draggable = true;
        task.style.cursor = 'move';
    });

    // Add drop event listeners to columns
    columns.forEach((column) => {
        column.removeEventListener('dragover', handleDragOver);
        column.removeEventListener('drop', handleDrop);
        column.removeEventListener('dragenter', handleDragEnter);
        column.removeEventListener('dragleave', handleDragLeave);
        column.addEventListener('dragover', handleDragOver);
        column.addEventListener('drop', handleDrop);
        column.addEventListener('dragenter', handleDragEnter);
        column.addEventListener('dragleave', handleDragLeave);
    });
}

function handleDragStart(e) {
    e.dataTransfer.setData('text/plain', e.target.dataset.taskId);
    e.target.classList.add('dragging');
    e.target.style.opacity = '0.5';
    e.target.style.cursor = 'move';
    
    // Prevent click event during drag
    e.target.setAttribute('data-dragging', 'true');
}

function handleDragEnd(e) {
    e.target.classList.remove('dragging');
    e.target.style.opacity = '1';
    e.target.style.cursor = 'pointer';
    
    // Re-enable click event after drag
    setTimeout(() => {
        e.target.removeAttribute('data-dragging');
    }, 100);
}

function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
}

function handleDragEnter(e) {
    e.preventDefault();
    const column = e.target.closest('.sortable-column');
    if (column) {
        column.classList.add('drag-over');
        column.style.backgroundColor = '#f8f9fa';
        column.style.border = '2px dashed #007bff';
    }
}

function handleDragLeave(e) {
    const column = e.target.closest('.sortable-column');
    if (column) {
        column.classList.remove('drag-over');
        column.style.backgroundColor = '';
        column.style.border = '';
    }
}

function handleDrop(e) {
    e.preventDefault();
    
    const column = e.target.closest('.sortable-column');
    if (!column) {
        return;
    }
    
    column.classList.remove('drag-over');
    column.style.backgroundColor = '';
    column.style.border = '';
    
    const taskId = e.dataTransfer.getData('text/plain');
    const newStatus = column.dataset.status;
    const taskElement = document.querySelector(`[data-task-id="${taskId}"]`);
    const oldStatus = taskElement ? taskElement.dataset.status : null;

    if (!taskId || !newStatus || oldStatus === newStatus) {
        return;
    }

    updateTaskStatus(taskId, newStatus, taskElement, column);
}

function updateTaskStatus(taskId, newStatus, taskElement, targetColumn) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        showNotification('CSRF token not found!', 'error');
        return;
    }
    
    const requestData = {
        task_id: taskId,
        status: newStatus
    };
    
    fetch('{{ route("jira-tasks.updateStatus") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP error! status: ${response.status}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Move the task element to the new column
            if (taskElement && targetColumn) {
                taskElement.dataset.status = newStatus;
                targetColumn.appendChild(taskElement);
            }
            
            // Update column counts
            updateColumnCounts();
            
            // Show success message
            showNotification('Task status updated successfully!', 'success');
        } else {
            showNotification('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('An error occurred while updating the task status.', 'error');
    });
}

function updateColumnCounts() {
    const columns = document.querySelectorAll('.sortable-column');
    columns.forEach(column => {
        const status = column.dataset.status;
        const count = column.querySelectorAll('.draggable-task').length;
        const header = column.previousElementSibling.querySelector('h6');
        if (header) {
            const statusText = status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
            header.textContent = `${statusText} (${count})`;
        }
    });
}

function showNotification(message, type) {
    console.log('🔔 Notification:', message, type);
    
    // Use toastr if available, otherwise create custom notification
    if (typeof toastr !== 'undefined') {
        if (type === 'success') {
            toastr.success(message);
        } else {
            toastr.error(message);
        }
    } else {
        // Fallback notification
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }
}

function assignTask() {
    const form = document.getElementById('assignTaskForm');
    const formData = new FormData(form);
    
    fetch('{{ route("jira-tasks.assign") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while assigning the task.');
    });
}

function openAssignModal(taskId) {
    document.getElementById('assign_task_id').value = taskId;
    new bootstrap.Modal(document.getElementById('assignTaskModal')).show();
}

function viewTaskDetails(taskId) {
    // Check if the element is being dragged
    const taskElement = document.querySelector(`[data-task-id="${taskId}"]`);
    if (taskElement && taskElement.getAttribute('data-dragging') === 'true') {
        return; // Don't open modal if dragging
    }
    
    // Prevent any default behavior
    event.preventDefault();
    event.stopPropagation();
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('taskDetailsModal'));
    modal.show();
    
    // Load task details via AJAX
    fetch(`/jira-tasks/details/${taskId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const task = data.task;
                const users = data.users;
                
                // Update modal header with task information
                document.getElementById('modalTaskTitle').textContent = task.title;
                document.getElementById('modalTaskKey').innerHTML = `<i class="fas fa-key me-1"></i>${task.task_key}`;
                
                // Set up edit button functionality
                const editBtn = document.getElementById('editTaskBtn');
                editBtn.onclick = function() {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('taskDetailsModal'));
                    modal.hide();
                    window.location.href = `/jira-tasks/edit/${task.id}`;
                };
                
                // Update priority badge with professional styling
                const priorityBadge = document.getElementById('modalTaskPriority');
                priorityBadge.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i>${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}`;
                priorityBadge.className = `badge badge-modern badge-priority-${task.priority}`;
                
                const createdDate = new Date(task.created_at).toLocaleDateString('en-IN', { 
                    year: '2-digit', 
                    month: 'short', 
                    day: 'numeric',
                    timeZone: 'Asia/Kolkata'
                });
                document.getElementById('modalTaskCreated').innerHTML = `<i class="fas fa-calendar-alt me-1"></i>Created ${createdDate}`;
                
                // Build the professional task details HTML
                const taskDetailsHTML = `
                    <div class="container-fluid p-4"> 
                    <div class="row">
                            <!-- Main Content Column -->
                            <div class="col-lg-8">
                                <!-- Description Section -->
                                <div class="content-section">
                                    <h5 class="section-title">
                                        <i class="fas fa-align-left"></i>Description
                                    </h5>
                                    <div class="description-content">
                                        ${task.description ? `
                                            <div class="bg-light p-4 rounded-3">
                                                <p class="mb-0 text-dark">${task.description}</p>
                                            </div>
                                        ` : `
                                            <div class="text-center py-4 text-muted">
                                                <i class="fas fa-file-alt fa-2x mb-2"></i>
                                                <p class="mb-0">No description provided for this task</p>
                                            </div>
                                        `}
                                    </div>
                                </div>
                                
                                <!-- Comments Section -->
                                <div class="content-section">
                                    <h5 class="section-title">
                                        <i class="fas fa-comments"></i>Comments & Discussion
                                        <span class="badge badge-light ms-2" id="commentCount">${task.comments && task.comments.length > 0 ? task.comments.length : 0}</span>
                                    </h5>
                                    
                                    <!-- Add Comment Form -->
                                    <div class="add-comment-section mb-4">
                                        <form id="addCommentForm" class="comment-form">
                                            <div class="comment-form-group">
                                                <div class="d-flex align-items-start">
                                                    <div class="user-avatar me-3">
                                                        <div class="avatar-professional avatar-assignee">
                                                            ${getCurrentUserInitial()}
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <textarea 
                                                            id="commentTextarea" 
                                                            class="form-control comment-textarea" 
                                                            placeholder="Add a comment..." 
                                                            rows="3" 
                                                            maxlength="1000"
                                                            required></textarea>
                                                        <div class="comment-actions mt-2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                                    <span id="charCount">0</span>/1000 characters
                                                </small>
                                                                <div class="comment-buttons"> 
                                                                    <button type="submit" class="btn btn-primary btn-sm" id="submitCommentBtn">
                                                                        <i class="fas fa-paper-plane me-1"></i>Add Comment
                                                                    </button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                        </div>
                                        </form>
                                    </div>
                                    
                                    <!-- Comments List -->
                                    <div class="comments-list" id="commentsList">
                                        ${task.comments && task.comments.length > 0 ? 
                                            task.comments.map(comment => generateCommentHTML(comment)).join('') :
                                            `
                                                <div class="no-comments text-center py-4">
                                                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                                    <h6 class="text-muted">No comments yet</h6>
                                                    <p class="text-muted small">Be the first to add a comment to this task</p>
                                            </div>
                                            `
                                        }
                                        </div>
                                </div>
                                    
                                <!-- Attachments Section -->
                                    ${task.attachments && task.attachments.length > 0 ? `
                                    <div class="content-section">
                                        <h5 class="section-title">
                                            <i class="fas fa-paperclip"></i>Attachments (${task.attachments.length})
                                        </h5>
                                        <div class="attachments-grid">
                                            <div class="row g-3">
                                                    ${task.attachments.map(attachment => {
                                                        const isString = typeof attachment === 'string';
                                                        const fileName = isString ? attachment : (attachment.name || 'Attachment');
                                                        const fileUrl = isString ? '/upload/jira_tasks/' + attachment : (attachment.url || '#');
                                                        const fileSize = isString ? '' : (attachment.size ? formatFileSize(attachment.size) : '');
                                                        const fileExtension = fileName.split('.').pop().toLowerCase();
                                                        const fileIcon = getFileIcon(fileExtension);
                                                    const fileIconClass = getFileIconClass(fileExtension);
                                                        
                                                        return `
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="attachment-card">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="file-icon-large ${fileIconClass}">
                                                                        <i class="fas fa-${fileIcon}"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="mb-1 text-dark">${fileName}</h6>
                                                                        <small class="text-muted">${fileSize}</small>
                                                                    </div>
                                                                    <div class="ms-2">
                                                                        <a href="${fileUrl}" class="btn btn-outline-primary btn-sm" target="_blank" title="Download">
                                                                            <i class="fas fa-download"></i>
                                                                        </a>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `;
                                                    }).join('')}
                                                </div>
                                            </div>
                                        </div>
                                    ` : ''}
                                </div>

                            <!-- Sidebar Information Column -->
                            <div class="col-lg-4">
                                <div class="task-info-card p-4">
                                    <h5 class="section-title mb-4">
                                        <i class="fas fa-info-circle"></i>Task Information
                                    </h5>
                                    
                                    <!-- Current Status -->
                                    <div class="info-item mb-4">
                                        <div class="info-label">Status</div>
                                        <div class="info-value">
                                            <span class="badge badge-modern badge-status-${task.status} fs-6 px-3 py-2">
                                                ${task.status.replace('_', ' ').toUpperCase()}
                                            </span>
                            </div>
                        </div>

                                    <!-- Priority -->
                                    <div class="info-item mb-4">
                                        <div class="info-label">Priority</div>
                                        <div class="info-value">
                                            <span class="badge badge-modern badge-priority-${task.priority} fs-6 px-3 py-2">
                                                ${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}
                                            </span>
                                </div>
                                    </div>

                                    <!-- Type -->
                                    <div class="info-item mb-4">
                                        <div class="info-label">Type</div>
                                        <div class="info-value">
                                            <span class="badge badge-info px-3 py-2">
                                                <i class="fas fa-tag me-1"></i>${task.type.toUpperCase()}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Assignee -->
                                    <div class="info-item mb-4">
                                        <div class="info-label">Assignee</div>
                                        <div class="info-value">
                                            ${task.assignee ? `
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-professional avatar-assignee me-3">
                                                        ${task.assignee.name.charAt(0).toUpperCase()}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">${task.assignee.name}</div>
                                                        <small class="text-muted">${task.assignee.email || ''}</small>
                                                </div>
                                                </div>
                                            ` : `
                                                <div class="text-muted">
                                                    <i class="fas fa-user-slash me-2"></i>Unassigned
                                                </div>
                                            `}
                                        </div>
                                    </div>
                                    
                                    <!-- Reporter -->
                                    <div class="info-item mb-4">
                                        <div class="info-label">Reporter</div>
                                        <div class="info-value">
                                            ${task.reporter ? `
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-professional avatar-reporter me-3">
                                                        ${task.reporter.name.charAt(0).toUpperCase()}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">${task.reporter.name}</div>
                                                        <small class="text-muted">${task.reporter.email || ''}</small>
                                                </div>
                                                </div>
                                            ` : `
                                                <div class="text-muted">
                                                    <i class="fas fa-user-question me-2"></i>Unknown
                                                </div>
                                            `}
                                        </div>
                                    </div>
                                    
                                    <!-- Project -->
                                    ${task.project ? `
                                        <div class="info-item mb-4">
                                            <div class="info-label">Project</div>
                                            <div class="info-value">
                                                <div class="project-chip">
                                                    <i class="fas fa-folder me-2"></i>
                                                    <span class="fw-semibold">${task.project.project_title}</span>
                                                </div>
                                            </div>
                                        </div>
                                    ` : ''}
                                    
                                    <!-- Story Points -->
                                    ${task.story_points ? `
                                        <div class="info-item mb-4">
                                            <div class="info-label">Story Points</div>
                                            <div class="info-value">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-chart-line me-2 text-info"></i>
                                                    <span class="fw-semibold text-dark">${task.story_points}</span>
                                                </div>
                                            </div>
                                        </div>
                                    ` : ''}
                                    
                                    <!-- Due Date -->
                                    ${task.due_date ? `
                                        <div class="info-item mb-4">
                                            <div class="info-label">Due Date</div>
                                            <div class="info-value">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-alt me-2 text-warning"></i>
                                                    <span>${new Date(task.due_date).toLocaleDateString('en-IN', { 
                                                        year: '2-digit', 
                                                        month: 'short', 
                                                        day: 'numeric',
                                                        timeZone: 'Asia/Kolkata'
                                                    })}</span>
                                                </div>
                                            </div>
                                        </div>
                                    ` : ''}
                                    
                                    <!-- Moved to Todo Date -->
                                    ${task.moved_to_todo_at ? `
                                        <div class="info-item mb-4">
                                            <div class="info-label">Moved to Todo</div>
                                            <div class="info-value">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-alt me-2 text-info"></i>
                                                    <span>${new Date(task.moved_to_todo_at).toLocaleDateString('en-IN', { 
                                                        year: '2-digit', 
                                                        month: 'short', 
                                                        day: 'numeric',
                                                        timeZone: 'Asia/Kolkata'
                                                    })}</span>
                                        </div>
                                    </div>
                                        </div>
                                    ` : ''}
                                    
                                    <!-- Completed Date -->
                                    ${task.moved_to_done_at ? `
                                        <div class="info-item mb-4">
                                            <div class="info-label">Completed</div>
                                            <div class="info-value">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-check-circle me-2 text-success"></i>
                                                    <span>${new Date(task.moved_to_done_at).toLocaleDateString('en-IN', { 
                                                        year: '2-digit', 
                                                        month: 'short', 
                                                        day: 'numeric',
                                                        timeZone: 'Asia/Kolkata'
                                                    })}</span>
                                        </div>
                                    </div>
                                </div>
                                    ` : ''}
                                    
                                    <!-- Created Date -->
                                    <div class="info-item mb-4">
                                        <div class="info-label">Created</div>
                                        <div class="info-value">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock me-2 text-success"></i>
                                                <span>${new Date(task.created_at).toLocaleDateString('en-IN', { 
                                                    year: '2-digit', 
                                                    month: 'short', 
                                                    day: 'numeric',
                                                    timeZone: 'Asia/Kolkata'
                                                })}</span>
                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Last Updated -->
                                    <div class="info-item mb-0">
                                        <div class="info-label">Last Updated</div>
                                        <div class="info-value">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-edit me-2 text-primary"></i>
                                                <span>${new Date(task.updated_at).toLocaleDateString('en-IN', { 
                                                    year: '2-digit', 
                                                    month: 'short', 
                                                    day: 'numeric',
                                                    timeZone: 'Asia/Kolkata'
                                                })}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             
                        </div>
                    </div>
                `;
                
                document.getElementById('taskDetailsContent').innerHTML = taskDetailsHTML;
                document.getElementById('editTaskBtn').href = `/jira-tasks/${taskId}/edit`;
                
                // Set current task ID for comment functionality
                currentTaskId = taskId;
                
                // Initialize comment form
                setupCommentForm();
                
                // Close any open comment dropdowns when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.comment-actions-menu')) {
                        document.querySelectorAll('.comment-dropdown').forEach(dropdown => {
                            dropdown.classList.remove('show');
                        });
                    }
                });
            } else {
                document.getElementById('taskDetailsContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Error loading task details. Please try again.
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading task details:', error);
            document.getElementById('taskDetailsContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error loading task details. Please try again.
                </div>
            `;
        });
}


/* Optimized - removed unused functions */

function getFileIconClass(extension) {
    switch(extension) {
        case 'pdf': return 'file-icon-pdf';
        case 'doc':
        case 'docx': return 'file-icon-doc';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
        case 'svg': return 'file-icon-img';
        default: return 'file-icon-default';
    }
}

// Comment System Functions
let currentTaskId = null;

function getCurrentUserInitial() {
    // Get current user from a global variable or make an AJAX call
    // For now, return a default initial
    return 'U';
}

function generateCommentHTML(comment) {
    const createdDate = new Date(comment.created_at);
    const timeAgo = getTimeAgo(createdDate);
    const canDelete = comment.user_id == {{ Auth::id() ?? 'null' }};
    
    return `
        <div class="comment-item" data-comment-id="${comment.id}">
            <div class="comment-header">
                <div class="comment-author">
                    <div class="avatar-professional avatar-assignee">
                        ${comment.user_name.charAt(0).toUpperCase()}
                    </div>
                    <div class="comment-author-info">
                        <div class="comment-author-name">${comment.user_name}</div>
                        <div class="comment-timestamp">
                            <i class="fas fa-clock"></i>
                            ${timeAgo}
                        </div>
                    </div>
                </div>
                ${canDelete ? `
                    <div class="comment-actions-menu">
                        <button class="comment-actions-btn" onclick="toggleCommentDropdown('${comment.id}')">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="comment-dropdown" id="dropdown-${comment.id}">
                            <button class="comment-dropdown-item danger" onclick="deleteComment('${comment.id}')">
                                <i class="fas fa-trash me-2"></i>Delete
                            </button>
                        </div>
                    </div>
                ` : ''}
            </div>
            <div class="comment-content">${comment.comment}</div>
        </div>
    `;
}

function getTimeAgo(date) {
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) return 'Just now';
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`;
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`;
    if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 86400)}d ago`;
    
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
}

function toggleCommentDropdown(commentId) {
    // Close all other dropdowns
    document.querySelectorAll('.comment-dropdown').forEach(dropdown => {
        if (dropdown.id !== `dropdown-${commentId}`) {
            dropdown.classList.remove('show');
        }
    });
    
    // Toggle current dropdown
    const dropdown = document.getElementById(`dropdown-${commentId}`);
    dropdown.classList.toggle('show');
}

function deleteComment(commentId) {
    if (!confirm('Are you sure you want to delete this comment?')) {
        return;
    }
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        showNotification('CSRF token not found!', 'error');
        return;
    }
    
    fetch(`/jira-tasks/${currentTaskId}/delete-comment`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            comment_id: commentId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove comment from DOM
            const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
            if (commentElement) {
                commentElement.remove();
            }
            
            // Update comment count
            updateCommentCount();
            
            showNotification('Comment deleted successfully!', 'success');
        } else {
            showNotification('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting comment:', error);
        showNotification('An error occurred while deleting the comment.', 'error');
    });
}

function updateCommentCount() {
    const commentItems = document.querySelectorAll('.comment-item');
    const count = commentItems.length;
    const countElement = document.getElementById('commentCount');
    if (countElement) {
        countElement.textContent = count;
    }
    
    // Show/hide no comments message
    const commentsList = document.getElementById('commentsList');
    const noCommentsElement = commentsList.querySelector('.no-comments');
    
    if (count === 0 && !noCommentsElement) {
        commentsList.innerHTML = `
            <div class="no-comments text-center py-4">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <h6 class="text-muted">No comments yet</h6>
                <p class="text-muted small">Be the first to add a comment to this task</p>
            </div>
        `;
    } else if (count > 0 && noCommentsElement) {
        noCommentsElement.remove();
    }
}

function clearComment() {
    const textarea = document.getElementById('commentTextarea');
    const charCount = document.getElementById('charCount');
    
    if (textarea) textarea.value = '';
    if (charCount) {
        charCount.textContent = '0';
        charCount.className = '';
    }
}

function setupCommentForm() {
    const form = document.getElementById('addCommentForm');
    const textarea = document.getElementById('commentTextarea');
    const charCount = document.getElementById('charCount');
    const submitBtn = document.getElementById('submitCommentBtn');
    
    if (form && textarea && charCount && submitBtn) {
        // Character count update
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
            
            // Update character count styling
            charCount.className = '';
            if (length > 800) {
                charCount.classList.add('danger');
            } else if (length > 600) {
                charCount.classList.add('warning');
            }
            
            // Enable/disable submit button
            submitBtn.disabled = length === 0 || length > 1000;
        });
        
        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const commentText = textarea.value.trim();
            if (!commentText) {
                showNotification('Please enter a comment', 'error');
                return;
            }
            
            if (commentText.length > 1000) {
                showNotification('Comment is too long (max 1000 characters)', 'error');
                return;
            }
            
            addComment(commentText);
        });
    }
}

function addComment(commentText) {
    const submitBtn = document.getElementById('submitCommentBtn');
    if (!submitBtn) return;
    
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Adding...';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        showNotification('CSRF token not found!', 'error');
        return;
    }
    
    fetch(`/jira-tasks/${currentTaskId}/add-comment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            comment: commentText
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add new comment to the list
            const commentsList = document.getElementById('commentsList');
            const noCommentsElement = commentsList.querySelector('.no-comments');
            
            if (noCommentsElement) {
                noCommentsElement.remove();
            }
            
            // Create new comment HTML
            const newCommentHTML = generateCommentHTML(data.comment);
            
            // Insert at the top of the comments list
            commentsList.insertAdjacentHTML('afterbegin', newCommentHTML);
            
            // Update comment count
            updateCommentCount();
            
            // Clear form
            clearComment();
            
            showNotification('Comment added successfully!', 'success');
        } else {
            showNotification('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error adding comment:', error);
        showNotification('An error occurred while adding the comment.', 'error');
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

function formatFileSize(bytes) {
    if (!bytes) return '';
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    if (bytes === 0) return '0 Bytes';
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i) * 100) / 100 + ' ' + sizes[i];
}

function getFileIcon(extension) {
    const iconMap = {
        'pdf': 'file-pdf',
        'doc': 'file-word',
        'docx': 'file-word',
        'xls': 'file-excel',
        'xlsx': 'file-excel',
        'ppt': 'file-powerpoint',
        'pptx': 'file-powerpoint',
        'txt': 'file-alt',
        'jpg': 'file-image',
        'jpeg': 'file-image',
        'png': 'file-image',
        'gif': 'file-image',
        'bmp': 'file-image',
        'svg': 'file-image',
        'mp4': 'file-video',
        'avi': 'file-video',
        'mov': 'file-video',
        'mp3': 'file-audio',
        'wav': 'file-audio',
        'zip': 'file-archive',
        'rar': 'file-archive',
        '7z': 'file-archive',
        'css': 'file-code',
        'js': 'file-code',
        'html': 'file-code',
        'php': 'file-code',
        'json': 'file-code',
        'xml': 'file-code'
    };
    return iconMap[extension] || 'file-alt';
}
</script> 