@extends('admin.admin_master')
@section('admin')

<div class="container-fluid mt-3">  
    <!-- Sprint Management Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 ">
                <div class="card-header bg-primary text-white p-5">
                    <div class="d-flex justify-content-between align-items-center"> 
                        <h2 class="mb-1 text-white font-weight-bold">
                            <i class="fas fa-clipboard-list text-white me-2"></i>Task Backlog
                        </h2> 
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('jira-tasks.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Create Task
                        </a>
                        <a href="{{ route('jira-tasks.board') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-columns me-2"></i>Board View
                        </a>
                    </div>
                </div>
                <div class="card-body p-5">
                    <div class="row">
                        <!-- Current Sprint Info -->
                        <div class="col-md-6">
                            @if($currentSprint)
                                <div class="d-flex align-items-center rounded">
                                    <div class="bg-success rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                    <div>
                                        <h6 class="mb-0">{{ $currentSprint->name }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $currentSprint->start_date->format('M d') }} - {{ $currentSprint->end_date->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex align-items-center rounded">
                                    <div class="bg-secondary rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                    <div>
                                        <h6 class="mb-0">No Active Sprint</h6>
                                        <p class="text-muted mb-0">Create a new sprint to start tracking your work</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Sprint Actions -->
                        <div class="col-md-6">
                            <div class="d-flex flex-wrap justify-content-end gap-2">
                                @if($currentSprint)
                                    <button class="btn btn-info btn-sm" onclick="viewSprintDetails({{ $currentSprint->id }})">
                                        <i class="fas fa-chart-bar me-1"></i>View Details
                                    </button>
                                    <button class="btn btn-success btn-sm" onclick="completeSprint({{ $currentSprint->id }})">
                                        <i class="fas fa-check me-1"></i>Complete Sprint
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="manageSprintTasks()">
                                        <i class="fas fa-tasks me-1"></i>Manage Tasks
                                    </button>
                                @else
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#sprintModal">
                                        <i class="fas fa-plus me-1"></i>Create Sprint
                                    </button>
                                    <button class="btn btn-secondary btn-sm" onclick="viewAllSprints()">
                                        <i class="fas fa-history me-1"></i>History
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h4 class="d-flex align-items-center rounded">
                        <i class="fas fa-inbox text-primary me-2"></i>Backlog Tasks
                        <span class="badge bg-primary ms-2">{{ $backlogTasks->count() }} tasks</span>
                    </h4> 
                </div>
                <div class="card-body p-0">
                        
                        @if($backlogTasks->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="1%"></th>
                                            <th width="10%">Task Key</th>
                                            <th width="22%">Title</th>
                                            <th width="8%">Type</th>
                                            <th width="8%">Priority</th>
                                            <th width="13%">Assignee</th>
                                            <th width="10%">Story Pts</th>
                                            <th width="12%">Moved Date</th>
                                            <th width="12%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($backlogTasks as $task)
                                            <tr class="draggable-task {{ !$task->assignee ? 'unassigned-task' : '' }}" 
                                                data-task-id="{{ $task->id }}" 
                                                data-status="backlog"
                                                draggable="true"
                                                style="cursor: move;">
                                                <td> </td> 
                                                <td>
                                                    <span class="badge badge-light text-dark font-weight-bold">{{ $task->task_key }}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong class="text-dark">{{ $task->title }}</strong>  
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $task->type_text }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                                        {{ ucfirst($task->priority) }}
                                                    </span>
                                                </td>
                                                <td class="assignee-cell">
                                                    @if($task->assignee)
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('upload/profile-img/' . $task->assignee->profile_image) }}" 
                                                                 class="rounded-circle me-2" width="24" height="24" 
                                                                 onerror="this.src='{{ asset('upload/default.jpg') }}'">
                                                            <span class="text-dark">{{ $task->assignee->name }}</span>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Unassigned</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($task->story_points)
                                                        <span class="badge badge-secondary">{{ $task->story_points }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $task->moved_to_todo_at ? $task->moved_to_todo_at->format('M d, Y') : 'N/A' }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button class="btn btn-outline-info btn-sm" onclick="viewTaskDetails({{ $task->id }})" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-outline-primary btn-sm" onclick="assignTask({{ $task->id }})" title="Assign Task">
                                                            <i class="fas fa-user-plus"></i>
                                                        </button>
                                                        <button class="btn btn-outline-secondary btn-sm" onclick="editTask({{ $task->id }})" title="Edit Task">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteTask({{ $task->id }})" title="Delete Task">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted mb-3">No tasks in backlog</h4>
                                <p class="text-muted mb-4">Create a new task to get started with your project management!</p>
                                <a href="{{ route('jira-tasks.create') }}" class="btn btn-primary btn-lg px-4 py-2">
                                    <i class="fas fa-plus me-2"></i>Create Task
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Drop Zone Section -->
                    <div class="p-4 bg-light border-top">
                        <div class="card border-2 border-dashed border-primary sortable-column drop-zone" data-status="todo">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-hand-paper fa-3x text-primary mb-3"></i>
                                <h5 class="mb-2">Move to To Do</h5>
                                <p class="text-muted mb-2">Drag assigned tasks here to move them to To Do status</p>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Only assigned tasks can be moved to To Do
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- To Do Tasks Section -->
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fas fa-check-circle text-success me-2"></i>To Do Tasks
                                    <span class="badge bg-success ms-2">{{ $todoTasks->count() }} tasks</span>
                                </h5>
                            </div>
                            <a href="{{ route('jira-tasks.board') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-columns me-1"></i>View on Board
                            </a>
                        </div>
                        
                        @if($todoTasks->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="1%"></th>
                                            <th width="10%">Task Key</th>
                                            <th width="22%">Title</th>
                                            <th width="8%">Type</th>
                                            <th width="8%">Priority</th>
                                            <th width="13%">Assignee</th>
                                            <th width="10%">Story Pts</th>
                                            <th width="12%">Moved Date</th>
                                            <th width="12%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($todoTasks as $task)
                                            <tr class="draggable-task" 
                                                data-task-id="{{ $task->id }}" 
                                                data-status="todo"
                                                draggable="true"
                                                style="cursor: move;">
                                                <td> </td> 
                                                <td>
                                                    <span class="badge badge-light text-dark font-weight-bold">{{ $task->task_key }}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong class="text-dark">{{ $task->title }}</strong>  
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $task->type_text }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                                        {{ ucfirst($task->priority) }}
                                                    </span>
                                                </td>
                                                <td class="assignee-cell">
                                                    @if($task->assignee)
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('upload/profile-img/' . $task->assignee->profile_image) }}" 
                                                                 class="rounded-circle me-2" width="24" height="24" 
                                                                 onerror="this.src='{{ asset('upload/default.jpg') }}'">
                                                            <span class="text-dark">{{ $task->assignee->name }}</span>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Unassigned</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($task->story_points)
                                                        <span class="badge badge-secondary">{{ $task->story_points }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $task->moved_to_todo_at ? $task->moved_to_todo_at->format('M d, Y') : 'N/A' }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button class="btn btn-outline-info btn-sm" onclick="viewTaskDetails({{ $task->id }})" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-outline-primary btn-sm" onclick="assignTask({{ $task->id }})" title="Assign Task">
                                                            <i class="fas fa-user-plus"></i>
                                                        </button>
                                                        <button class="btn btn-outline-secondary btn-sm" onclick="editTask({{ $task->id }})" title="Edit Task">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteTask({{ $task->id }})" title="Delete Task">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                                <h4 class="text-muted mb-3">No tasks in To Do</h4>
                                <p class="text-muted mb-4">Drag assigned tasks here from backlog to start working on them!</p>
                                <a href="{{ route('jira-tasks.create') }}" class="btn btn-success btn-lg px-4 py-2">
                                    <i class="fas fa-plus me-2"></i>Create New Task
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sprint Modal -->
    <div class="modal fade" id="sprintModal" tabindex="-1" aria-labelledby="sprintModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #323248; color: white;">
                    <h5 class="modal-title text-white" id="sprintModalLabel">
                        <i class="fas fa-rocket me-2"></i>Create New Sprint
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sprintForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="sprintName" class="form-label">Sprint Name</label>
                            <input type="text" class="form-control" id="sprintName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="sprintDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="sprintDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="start_date" required min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="end_date" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Sprint</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Assign Task Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Assign Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="assignForm">
                    <div class="modal-body">
                        <input type="hidden" id="assignTaskId" name="task_id">
                        <div class="mb-3">
                            <label for="assigneeSelect" class="form-label">Select Assignee</label>
                            <select class="form-select" id="assigneeSelect" name="assignee_id" required>
                                <option value="">Choose an assignee...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sprint Details Modal -->
    <div class="modal fade" id="sprintDetailsModal" tabindex="-1" aria-labelledby="sprintDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Content will be dynamically inserted here -->
            </div>
        </div>
    </div>

    <!-- All Sprints History Modal -->
    <div class="modal fade" id="allSprintsModal" tabindex="-1" aria-labelledby="allSprintsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Content will be dynamically inserted here -->
            </div>
        </div>
    </div>

    <!-- Sprint Task Management Modal -->
    <div class="modal fade" id="sprintTaskModal" tabindex="-1" aria-labelledby="sprintTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="sprintTaskModalLabel">
                        <i class="fas fa-tasks me-2"></i>Sprint Task Management
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Available Tasks Column -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-inbox me-2 text-info"></i>Available Tasks
                                        <span class="badge bg-info ms-2" id="availableTasksCount">0</span>
                                    </h6>
                                    <small class="text-muted">Tasks that can be added to the sprint</small>
                                </div>
                                <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                                    <div id="availableTasksList" class="p-3">
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-spinner fa-spin fa-2x mb-2"></i>
                                            <p>Loading available tasks...</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light">
                                    <button class="btn btn-primary btn-sm" onclick="assignSelectedTasks()" id="assignTasksBtn" disabled>
                                        <i class="fas fa-plus me-1"></i>Add Selected to Sprint
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Sprint Tasks Column -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-running me-2 text-success"></i>Sprint Tasks
                                        <span class="badge bg-success ms-2" id="sprintTasksCount">0</span>
                                    </h6>
                                    <small class="text-muted">Tasks currently in the sprint</small>
                                </div>
                                <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                                    <div id="sprintTasksList" class="p-3">
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-spinner fa-spin fa-2x mb-2"></i>
                                            <p>Loading sprint tasks...</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light">
                                    <button class="btn btn-danger btn-sm" onclick="removeSelectedTasks()" id="removeTasksBtn" disabled>
                                        <i class="fas fa-minus me-1"></i>Remove Selected from Sprint
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='/jira-tasks/board'">
                        <i class="fas fa-columns me-1"></i>View on Board
                    </button>
                </div>
            </div>
        </div>
    </div>


    <style>
    /* CSS Variables for Consistent Gradients */
    :root {
        --gradient-primary: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        --gradient-success: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        --gradient-warning: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        --gradient-info: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        --gradient-secondary: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        --gradient-dark: #4a4a6a;
        --gradient-light: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        --gradient-theme: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    /* Enhanced Sprint Details Modal Styles */
    .modal-header.bg-primary {
        background: var(--gradient-primary) !important;
        border-bottom: none;
    }
    
    .modal-header h5 {
        font-weight: 600;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .card.bg-primary, .card.bg-success, .card.bg-warning, .card.bg-info {
        background: var(--gradient-primary) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card.bg-primary:hover, .card.bg-success:hover, .card.bg-warning:hover, .card.bg-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    .progress-bar.bg-gradient {
        background: linear-gradient(90deg, var(--gradient-success), var(--gradient-info)) !important;
        font-weight: 600;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
        transform: scale(1.01);
        transition: all 0.2s ease;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .modal-body .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .modal-body .card-header {
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
    }
    
    .modal-footer.bg-light {
        background: var(--gradient-light) !important;
        border-top: 1px solid #dee2e6;
    }
    
    /* Animation for modal content */
    .modal-content {
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Enhanced table styling */
    .table th {
        border-top: none;
        font-weight: 600;
        color: #ffffff;
        background: var(--gradient-dark);
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border-bottom: 2px solid #1a252f;
        position: relative;
    }
    
    .table th:first-child {
        border-top-left-radius: 8px;
    }
    
    .table th:last-child {
        border-top-right-radius: 8px;
    }
    
    .table th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px; 
    }
    
    .table td {
        vertical-align: middle;
        border-color: #e9ecef;
    }
    
    /* Profile image styling */
    .rounded-circle {
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Status badge enhancements */
    .badge.bg-success {
        background: var(--gradient-success) !important;
    }
    
    .badge.bg-warning {
        background: var(--gradient-warning) !important;
        color: #212529 !important;
    }
    
    .badge.bg-info {
        background: var(--gradient-info) !important;
    }
    
    .badge.bg-primary {
        background: var(--gradient-primary) !important;
    }
    
    .badge.bg-secondary {
        background: var(--gradient-secondary) !important;
        color: white !important;
        font-family: Arial, sans-serif !important;
        font-size: 0.75em !important;
        font-weight: 600 !important;
        text-shadow: none !important;
    }
    
    /* Sprint Modal Styling */
    .sprint-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .sprint-icon i {
        color: rgba(255, 255, 255, 0.95);
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    #sprintModalLabel {
        font-size: 1.25rem;
        font-weight: 600;
        line-height: 1.2;
        color: rgba(255, 255, 255, 0.95);
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .modal-header .text-warning {
        color: #ffc107 !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header .text-white-50 {
        color: rgba(255, 255, 255, 0.7) !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    
    .btn-close-white:hover {
        filter: invert(1) grayscale(100%) brightness(200%) opacity(0.8);
    }
    
    /* Sprint History Modal Styling */
    .sprint-history-table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }
    
    .sprint-history-table thead th {
        background: #4a4a6a;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem 1rem 1.5rem;
        border: none;
        position: relative;
    }
    
    .sprint-history-table thead th:first-child {
        border-top-left-radius: 12px;
    }
    
    .sprint-history-table thead th:last-child {
        border-top-right-radius: 12px;
    }
    
    .sprint-history-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f4;
    }
    
    .sprint-history-table tbody tr:hover {
        background: var(--gradient-light);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .sprint-history-table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border: none;
    }
    
    .sprint-mini-icon {
        width: 32px;
        height: 32px;
        background: var(--gradient-theme);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }
    
    .sprint-status-badge {
        font-weight: 600;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    
    .sprint-status-badge.bg-success {
        background: var(--gradient-success) !important;
    }
    
    .sprint-status-badge.bg-primary {
        background: var(--gradient-primary) !important;
    }
    
    .sprint-status-badge.bg-secondary {
        background: var(--gradient-secondary) !important;
    }
    
    .date-info {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .task-stats .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
        border-radius: 12px;
        font-weight: 500;
    }
    
    .task-stats .bg-info {
        background: var(--gradient-info) !important;
    }
    
    .task-stats .bg-success {
        background: var(--gradient-success) !important;
    }
    
    .sprint-progress {
        border-radius: 12px;
        background-color: #e9ecef;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .sprint-progress .progress-bar {
        background: linear-gradient(90deg, #28a745 0%, #20c997 50%, #17a2b8 100%);
        border-radius: 12px;
        font-weight: 600;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .progress-text {
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }
    
    .story-points-info .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
        border-radius: 12px;
        font-weight: 500;
    }
    
    .story-points-info .bg-warning {
        background: var(--gradient-warning) !important;
        color: #212529 !important;
    }
    
    .story-points-info .bg-success {
        background: var(--gradient-success) !important;
    }
    </style>

    <script>
    // Utility Functions for Code Optimization
    function getPriorityBadgeClass(priority) {
        return priority === 'high' ? 'danger' : (priority === 'medium' ? 'warning' : 'success');
    }
    
    function getPriorityBadgeHtml(priority, priorityText = null) {
        const badgeClass = getPriorityBadgeClass(priority);
        const displayText = priorityText || priority || 'N/A';
        return `<span class="badge bg-${badgeClass}">${displayText}</span>`;
    }
    
    function getTaskKeyBadgeHtml(taskKey, isBlade = false) {
        if (isBlade) {
            return `<span class="badge badge-light text-dark font-weight-bold">${taskKey}</span>`;
        }
        return `<span class="badge bg-light text-dark border">${taskKey}</span>`;
    }
    
    function getStatusBadgeHtml(status, statusText = null) {
        const statusMap = {
            'done': { class: 'success', icon: 'check' },
            'in_progress': { class: 'warning', icon: 'play' },
            'todo': { class: 'info', icon: 'clock' },
            'review': { class: 'info', icon: 'eye' }
        };
        
        const statusInfo = statusMap[status] || { class: 'secondary', icon: 'question' };
        const displayText = statusText || status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        
        return `<span class="badge bg-${statusInfo.class}">
                    <i class="fas fa-${statusInfo.icon} me-1"></i>
                    ${displayText}
                </span>`;
    }
    
    function getAssigneeHtml(assignee) {
        if (assignee) {
            return `<div class="d-flex align-items-center">
                        <img src="/upload/profile-img/${assignee.profile_image || 'default.jpg'}" 
                             class="rounded-circle me-1" width="20" height="20" 
                             onerror="this.src='/upload/default.jpg'">
                        <small>${assignee.name || 'Unknown'}</small>
                    </div>`;
        }
        return '<span class="badge bg-light text-dark">Unassigned</span>';
    }
    
    function getStoryPointsBadgeHtml(storyPoints) {
        if (storyPoints) {
            return `<span class="badge bg-secondary" style="font-family: Arial, sans-serif;">${storyPoints} pts</span>`;
        }
        return '';
    }
    
    function generateTaskRowHtml(task, isBlade = false) {
        const taskKeyBadge = isBlade ? 
            `<span class="badge badge-light text-dark font-weight-bold">${task.task_key}</span>` :
            `<span class="badge bg-light text-dark border">${task.task_key}</span>`;
            
        const priorityBadge = isBlade ?
            `<span class="badge badge-${getPriorityBadgeClass(task.priority)}">${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}</span>` :
            getPriorityBadgeHtml(task.priority, task.priority_text);
            
        const assigneeCell = task.assignee ? 
            `<div class="d-flex align-items-center">
                <img src="/upload/profile-img/${task.assignee.profile_image}" 
                     class="rounded-circle me-2" width="24" height="24" 
                     onerror="this.src='/upload/default.jpg'">
                <span>${task.assignee.name}</span>
            </div>` :
            '<span class="text-muted"><i class="fas fa-user-slash me-1"></i>Unassigned</span>';
            
        const storyPointsBadge = task.story_points ? 
            `<span class="badge bg-secondary">${task.story_points}</span>` : 
            '<span class="text-muted">-</span>';
            
        return {
            taskKeyBadge,
            priorityBadge,
            assigneeCell,
            storyPointsBadge
        };
    }

    // Date validation for sprint form
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');

        startDateInput.addEventListener('change', function() {
            if (this.value) {
                endDateInput.min = this.value;
            }
        });

        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value <= startDateInput.value) {
                alert('End date must be after start date');
                this.value = '';
            }
        });
    });

    // Drag and drop functionality
    document.addEventListener('DOMContentLoaded', function() {
        const draggableTasks = document.querySelectorAll('.draggable-task');
        const sortableColumns = document.querySelectorAll('.sortable-column');

        // Add drag event listeners to tasks
        draggableTasks.forEach(task => {
            task.addEventListener('dragstart', handleDragStart);
            task.addEventListener('dragend', handleDragEnd);
        });

        // Add drop event listeners to columns
        sortableColumns.forEach(column => {
            column.addEventListener('dragover', handleDragOver);
            column.addEventListener('drop', handleDrop);
            column.addEventListener('dragenter', handleDragEnter);
            column.addEventListener('dragleave', handleDragLeave);
        });
    });

    function handleDragStart(e) {
        e.target.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', e.target.outerHTML);
        e.dataTransfer.setData('text/plain', e.target.dataset.taskId);
    }

    function handleDragEnd(e) {
        e.target.classList.remove('dragging');
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        e.dataTransfer.dropEffect = 'move';
        return false;
    }

    function handleDragEnter(e) {
        e.target.classList.add('drag-over');
    }

    function handleDragLeave(e) {
        e.target.classList.remove('drag-over');
    }

    function handleDrop(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        }

        e.target.classList.remove('drag-over');

        const taskId = e.dataTransfer.getData('text/plain');
        const newStatus = e.target.closest('.sortable-column').dataset.status;
        
        if (taskId && newStatus) {
            updateTaskStatus(taskId, newStatus);
        }

        return false;
    }

    function updateTaskStatus(taskId, newStatus) {
        fetch('/jira-tasks/update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                task_id: taskId,
                status: newStatus 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showNotification(data.message || 'Unknown error', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating task status: ' + error.message, 'error');
        });
    }


    // Sprint management functions
    function viewSprintDetails(sprintId) {
        // Fetch sprint details and show in modal
        fetch(`/sprints/${sprintId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSprintDetailsModal(data.sprint);
            } else {
                alert('Error loading sprint details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading sprint details');
        });
    }

    function completeSprint(sprintId) {
        if (confirm('Are you sure you want to complete this sprint? Completed tasks will be closed permanently and incomplete tasks will be moved to backlog.')) {
            fetch(`/sprints/${sprintId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error completing sprint');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error completing sprint');
            });
        }
    }


    function manageSprintTasks() {
        // Get current sprint ID and show task management modal
        fetch('/sprints/current')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.sprint) {
                currentSprintId = data.sprint.id;
                loadSprintTasks();
                loadAvailableTasks();
                const modal = new bootstrap.Modal(document.getElementById('sprintTaskModal'));
                modal.show();
            } else {
                showNotification('No active sprint found. Please create or start a sprint first.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error loading sprint information', 'error');
        });
    }

    function viewAllSprints() {
        // Fetch all sprints and show in modal
        fetch('/sprints/all')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAllSprintsModal(data.sprints);
            } else {
                alert('Error loading sprint history');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading sprint history');
        });
    }

    function assignTask(taskId) {
        document.getElementById('assignTaskId').value = taskId;
        new bootstrap.Modal(document.getElementById('assignModal')).show();
    }

    function editTask(taskId) {
        // Redirect to edit task page
        window.location.href = `/jira-tasks/edit/${taskId}`;
    }

    function viewTaskDetails(taskId) {
        // Fetch task details and show in modal
        fetch(`/jira-tasks/details/${taskId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showTaskDetailsModal(data.task);
            } else {
                alert('Error loading task details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading task details');
        });
    }

    function deleteTask(taskId) {
        if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
            fetch(`/jira-tasks/destroy/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error deleting task');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting task');
            });
        }
    }

    function showTaskDetailsModal(task) {
        const modalContent = `
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-tasks me-2"></i>Task Details: ${task.task_key}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Title:</strong>
                        <p class="text-muted">${task.title}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p>${getStatusBadgeHtml(task.status, task.status_text)}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Type:</strong>
                        <p><span class="badge bg-info">${task.type_text || task.type || 'N/A'}</span></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Priority:</strong>
                        <p>${getPriorityBadgeHtml(task.priority, task.priority_text)}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Assignee:</strong>
                        <p class="text-muted">${task.assignee ? task.assignee.name : 'Unassigned'}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Reporter:</strong>
                        <p class="text-muted">${task.reporter ? task.reporter.name : 'N/A'}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Story Points:</strong>
                        <p class="text-muted">${task.story_points || 'Not set'}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Due Date:</strong>
                        <p class="text-muted">${task.due_date ? new Date(task.due_date).toLocaleDateString() : 'Not set'}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Description:</strong>
                    <p class="text-muted">${task.description || 'No description provided'}</p>
                </div>
                ${task.project ? `
                <div class="mb-3">
                    <strong>Project:</strong>
                    <p class="text-muted">${task.project.project_name || 'N/A'}</p>
                </div>
                ` : ''}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editTask(${task.id})">Edit Task</button>
            </div>
        `;
        
        // Create modal dynamically
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'taskDetailsModal';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    ${modalContent}
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
        
        // Remove modal from DOM when hidden
        modal.addEventListener('hidden.bs.modal', function() {
            document.body.removeChild(modal);
        });
    }

    // Sprint Task Management Functions
    let availableTasks = [];
    let sprintTasks = [];
    let currentSprintId = null;

    function loadAvailableTasks() {
        fetch('/jira-tasks/available-for-sprint')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                availableTasks = data.tasks;
                displayAvailableTasks();
                updateAvailableTasksCount();
            } else {
                showNotification('Failed to load available tasks', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error loading available tasks', 'error');
        });
    }

    function loadSprintTasks() {
        if (!currentSprintId) return;
        
        fetch(`/sprints/${currentSprintId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                sprintTasks = data.sprint.tasks || [];
                displaySprintTasks();
                updateSprintTasksCount();
            } else {
                showNotification('Failed to load sprint tasks', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error loading sprint tasks', 'error');
        });
    }

    function displayAvailableTasks() {
        const container = document.getElementById('availableTasksList');
        
        if (availableTasks.length === 0) {
            container.innerHTML = '<div class="text-center text-muted py-4"><i class="fas fa-inbox fa-2x mb-2"></i><p>No available tasks</p></div>';
            return;
        }
        
        // Debug: Log the first task to see what data we're getting
        if (availableTasks.length > 0) {
            console.log('First available task:', availableTasks[0]);
        }
        
        const tasksHtml = availableTasks.map(task => `
            <div class="task-item border rounded p-3 mb-2 cursor-pointer" onclick="toggleTaskSelection('available', ${task.id})">
                <div class="d-flex align-items-start">
                    <div class="form-check me-3">
                        <input type="checkbox" class="form-check-input task-checkbox-input" id="available_${task.id}" onchange="updateAssignButton()">
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-1">${task.task_key || 'N/A'}</h6>
                            ${getPriorityBadgeHtml(task.priority, task.priority_text)}
                        </div>
                        <p class="mb-2 text-dark">${task.title || 'No title'}</p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-info">${task.type_text || task.type || 'N/A'}</span>
                            ${getStoryPointsBadgeHtml(task.story_points)}
                            ${getAssigneeHtml(task.assignee)}
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        
        container.innerHTML = tasksHtml;
    }

    function displaySprintTasks() {
        const container = document.getElementById('sprintTasksList');
        
        if (sprintTasks.length === 0) {
            container.innerHTML = '<div class="text-center text-muted py-4"><i class="fas fa-running fa-2x mb-2"></i><p>No tasks in sprint</p></div>';
            return;
        }
        
        // Debug: Log the first task to see what data we're getting
        if (sprintTasks.length > 0) {
            console.log('First sprint task:', sprintTasks[0]);
        }
        
        const tasksHtml = sprintTasks.map(task => `
            <div class="task-item border rounded p-3 mb-2 cursor-pointer" onclick="toggleTaskSelection('sprint', ${task.id})">
                <div class="d-flex align-items-start">
                    <div class="form-check me-3">
                        <input type="checkbox" class="form-check-input task-checkbox-input" id="sprint_${task.id}" onchange="updateRemoveButton()">
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-1">${task.task_key || 'N/A'}</h6>
                            ${getPriorityBadgeHtml(task.priority, task.priority_text)}
                        </div>
                        <p class="mb-2 text-dark">${task.title || 'No title'}</p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-info">${task.type_text || task.type || 'N/A'}</span>
                            ${getStatusBadgeHtml(task.status, task.status_text)}
                            ${getStoryPointsBadgeHtml(task.story_points)}
                            ${getAssigneeHtml(task.assignee)}
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        
        container.innerHTML = tasksHtml;
    }

    function toggleTaskSelection(type, taskId) {
        const checkbox = document.getElementById(`${type}_${taskId}`);
        checkbox.checked = !checkbox.checked;
        
        if (type === 'available') {
            updateAssignButton();
        } else {
            updateRemoveButton();
        }
    }

    function updateAssignButton() {
        const checkboxes = document.querySelectorAll('#availableTasksList input[type="checkbox"]');
        const checkedBoxes = document.querySelectorAll('#availableTasksList input[type="checkbox"]:checked');
        const assignBtn = document.getElementById('assignTasksBtn');
        
        assignBtn.disabled = checkedBoxes.length === 0;
    }

    function updateRemoveButton() {
        const checkboxes = document.querySelectorAll('#sprintTasksList input[type="checkbox"]');
        const checkedBoxes = document.querySelectorAll('#sprintTasksList input[type="checkbox"]:checked');
        const removeBtn = document.getElementById('removeTasksBtn');
        
        removeBtn.disabled = checkedBoxes.length === 0;
    }

    function updateAvailableTasksCount() {
        document.getElementById('availableTasksCount').textContent = availableTasks.length;
    }

    function updateSprintTasksCount() {
        document.getElementById('sprintTasksCount').textContent = sprintTasks.length;
    }

    function assignSelectedTasks() {
        const checkedBoxes = document.querySelectorAll('#availableTasksList input[type="checkbox"]:checked');
        const taskIds = Array.from(checkedBoxes).map(cb => cb.id.replace('available_', ''));
        
        if (taskIds.length === 0) return;
        
        fetch('/jira-tasks/bulk-assign-to-sprint', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                task_ids: taskIds,
                sprint_id: currentSprintId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Successfully assigned ${data.assigned_count} tasks to sprint!`, 'success');
                loadAvailableTasks();
                loadSprintTasks();
            } else {
                showNotification(data.message || 'Error assigning tasks to sprint', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error assigning tasks to sprint', 'error');
        });
    }

    function removeSelectedTasks() {
        const checkedBoxes = document.querySelectorAll('#sprintTasksList input[type="checkbox"]:checked');
        const taskIds = Array.from(checkedBoxes).map(cb => cb.id.replace('sprint_', ''));
        
        if (taskIds.length === 0) return;
        
        if (!confirm(`Are you sure you want to remove ${taskIds.length} task(s) from the sprint?`)) {
            return;
        }
        
        // Remove tasks one by one
        const promises = taskIds.map(taskId => 
            fetch('/jira-tasks/remove-from-sprint', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ task_id: taskId })
            })
        );
        
        Promise.all(promises)
        .then(responses => Promise.all(responses.map(r => r.json())))
        .then(results => {
            const successCount = results.filter(r => r.success).length;
            showNotification(`Successfully removed ${successCount} tasks from sprint!`, 'success');
            loadAvailableTasks();
            loadSprintTasks();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error removing tasks from sprint', 'error');
        });
    }

    function showNotification(message, type = 'info') {
        // Simple notification - you can enhance this with a proper notification system
        const alertClass = type === 'success' ? 'alert-success' : type === 'error' ? 'alert-danger' : 'alert-info';
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }

    // Modal functions for sprint details and history
    function showSprintDetailsModal(sprint) {
        // Calculate progress statistics
        const totalTasks = sprint.tasks.length;
        const completedTasks = sprint.tasks.filter(task => task.status === 'done').length;
        const inProgressTasks = sprint.tasks.filter(task => task.status === 'in_progress').length;
        const todoTasks = sprint.tasks.filter(task => task.status === 'to_do').length;
        const progressPercentage = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
        
        // Calculate days remaining
        const endDate = new Date(sprint.end_date);
        const today = new Date();
        const timeDiff = endDate.getTime() - today.getTime();
        const daysRemaining = Math.ceil(timeDiff / (1000 * 3600 * 24));
        
        const modalContent = `
            <div class="modal-header" style="background: var(--gradient-theme); border: none;">
                <div class="d-flex align-items-center">
                    <div class="sprint-icon me-3">
                        <i class="fas fa-rocket fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="modal-title text-white mb-0 fw-bold">
                            <span class="text-warning">Sprint Details</span>
                        </h4>
                        <p class="text-white-50 mb-0">${sprint.name}</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Sprint Stats Overview -->
                <div class="bg-light p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="stats-card bg-white rounded-3 shadow-sm p-4 text-center border-start border-primary border-4">
                                <div class="stats-icon mb-3">
                                    <i class="fas fa-tasks fa-2x text-primary"></i>
                                </div>
                                <h3 class="fw-bold text-dark mb-1">${totalTasks}</h3>
                                <p class="text-muted mb-0 fw-medium">Total Tasks</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card bg-white rounded-3 shadow-sm p-4 text-center border-start border-success border-4">
                                <div class="stats-icon mb-3">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <h3 class="fw-bold text-dark mb-1">${completedTasks}</h3>
                                <p class="text-muted mb-0 fw-medium">Completed</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card bg-white rounded-3 shadow-sm p-4 text-center border-start border-warning border-4">
                                <div class="stats-icon mb-3">
                                    <i class="fas fa-play-circle fa-2x text-warning"></i>
                                </div>
                                <h3 class="fw-bold text-dark mb-1">${inProgressTasks}</h3>
                                <p class="text-muted mb-0 fw-medium">In Progress</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card bg-white rounded-3 shadow-sm p-4 text-center border-start border-info border-4">
                                <div class="stats-icon mb-3">
                                    <i class="fas fa-clock fa-2x text-info"></i>
                                </div>
                                <h3 class="fw-bold text-dark mb-1">${todoTasks}</h3>
                                <p class="text-muted mb-0 fw-medium">To Do</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Section -->
                <div class="p-4">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold text-dark">
                                            <i class="fas fa-chart-line me-2 text-primary"></i>Sprint Progress
                                        </h5>
                                        <span class="badge bg-primary fs-6 px-3 py-2">${progressPercentage}% Complete</span>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="progress mb-3" style="height: 12px; border-radius: 10px;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: ${progressPercentage}%; background: linear-gradient(90deg, #28a745 0%, #20c997 50%, #17a2b8 100%); border-radius: 10px;" 
                                             aria-valuenow="${progressPercentage}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-3">
                                            <div class="progress-item">
                                                <div class="progress-dot bg-success"></div>
                                                <small class="text-muted">Completed</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="progress-item">
                                                <div class="progress-dot bg-warning"></div>
                                                <small class="text-muted">In Progress</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="progress-item">
                                                <div class="progress-dot bg-info"></div>
                                                <small class="text-muted">To Do</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="progress-item">
                                                <div class="progress-dot bg-secondary"></div>
                                                <small class="text-muted">Total</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sprint Information & Timeline -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0 fw-bold text-dark">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>Sprint Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-item mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="info-icon me-3">
                                                <i class="fas fa-align-left text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold text-dark mb-1">Description</h6>
                                                <p class="text-muted mb-0">${sprint.description || 'No description provided'}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="d-flex align-items-center">
                                            <div class="info-icon me-3">
                                                <i class="fas fa-flag text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold text-dark mb-1">Status</h6>
                                                <span class="badge bg-${sprint.status === 'active' ? 'success' : (sprint.status === 'completed' ? 'primary' : 'secondary')} fs-6 px-3 py-2">
                                                    <i class="fas fa-${sprint.status === 'active' ? 'play' : (sprint.status === 'completed' ? 'check' : 'pause')} me-1"></i>
                                                    ${sprint.status.charAt(0).toUpperCase() + sprint.status.slice(1)}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0 fw-bold text-dark">
                                        <i class="fas fa-calendar me-2 text-primary"></i>Timeline
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="timeline-item mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="timeline-icon me-3">
                                                <i class="fas fa-play text-success"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold text-dark mb-1">Start Date</h6>
                                                <p class="text-muted mb-0">${new Date(sprint.start_date).toLocaleDateString('en-US', { 
                                                    weekday: 'long', 
                                                    year: 'numeric', 
                                                    month: 'long', 
                                                    day: 'numeric' 
                                                })}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline-item mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="timeline-icon me-3">
                                                <i class="fas fa-flag-checkered text-danger"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold text-dark mb-1">End Date</h6>
                                                <p class="text-muted mb-0">${new Date(sprint.end_date).toLocaleDateString('en-US', { 
                                                    weekday: 'long', 
                                                    year: 'numeric', 
                                                    month: 'long', 
                                                    day: 'numeric' 
                                                })}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="d-flex align-items-center">
                                            <div class="timeline-icon me-3">
                                                <i class="fas fa-hourglass-half text-warning"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold text-dark mb-1">Days Remaining</h6>
                                                <span class="badge bg-${daysRemaining > 0 ? (daysRemaining <= 3 ? 'danger' : 'warning') : 'success'} fs-6 px-3 py-2">
                                                    ${daysRemaining > 0 ? `${daysRemaining} days left` : 'Sprint ended'}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-list me-2 text-info"></i>Sprint Tasks (${totalTasks})
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                ${totalTasks > 0 ? `
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th><i class="fas fa-key me-1"></i>Task Key</th>
                                                    <th><i class="fas fa-file-alt me-1"></i>Title</th>
                                                    <th><i class="fas fa-tag me-1"></i>Status</th>
                                                    <th><i class="fas fa-user me-1"></i>Assignee</th>
                                                    <th><i class="fas fa-chart-bar me-1"></i>Story Points</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${sprint.tasks.map(task => `
                                                    <tr>
                                                        <td>
                                                            <span class="badge bg-light text-dark border">${task.task_key}</span>
                                                        </td>
                                                        <td>
                                                            <strong>${task.title}</strong>
                                                            ${task.description ? `<br><small class="text-muted">${task.description.substring(0, 100)}${task.description.length > 100 ? '...' : ''}</small>` : ''}
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-${task.status === 'done' ? 'success' : (task.status === 'in_progress' ? 'warning' : 'info')}">
                                                                <i class="fas fa-${task.status === 'done' ? 'check' : (task.status === 'in_progress' ? 'play' : 'clock')} me-1"></i>
                                                                ${task.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            ${task.assignee ? `
                                                                <div class="d-flex align-items-center">
                                                                    <img src="/upload/profile-img/${task.assignee.profile_image}" 
                                                                         class="rounded-circle me-2" width="24" height="24" 
                                                                         onerror="this.src='/upload/default.jpg'">
                                                                    <span>${task.assignee.name}</span>
                                                                </div>
                                                            ` : '<span class="text-muted"><i class="fas fa-user-slash me-1"></i>Unassigned</span>'}
                                                        </td>
                                                        <td>
                                                            ${task.story_points ? `<span class="badge bg-secondary">${task.story_points}</span>` : '<span class="text-muted">-</span>'}
                                                        </td>
                                                    </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>
                                    </div>
                                ` : `
                                    <div class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No tasks in this sprint</h5>
                                        <p class="text-muted">Tasks will appear here when added to the sprint.</p>
                                    </div>
                                `}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
                <button type="button" class="btn btn-primary" onclick="manageSprintTasks()">
                    <i class="fas fa-cog me-1"></i>Manage Tasks
                </button>
            </div>
        `;
        
        const modal = document.getElementById('sprintDetailsModal');
        modal.querySelector('.modal-content').innerHTML = modalContent;
        new bootstrap.Modal(modal).show();
    }

    function showAllSprintsModal(sprints) {
        const modalContent = `
            <div class="modal-header" style="background-color: #323248; color: white;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-history me-2"></i>Sprint History
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover sprint-history-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-tag me-1"></i>Name</th>
                                <th><i class="fas fa-flag me-1"></i>Status</th>
                                <th><i class="fas fa-calendar-start me-1"></i>Start Date</th>
                                <th><i class="fas fa-calendar-end me-1"></i>End Date</th>
                                <th><i class="fas fa-tasks me-1"></i>Tasks</th>
                                <th><i class="fas fa-chart-line me-1"></i>Progress</th>
                                <th><i class="fas fa-star me-1"></i>Story Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${sprints.map(sprint => `
                                <tr class="sprint-history-row">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="sprint-mini-icon me-2">
                                                <i class="fas fa-rocket text-primary"></i>
                                            </div>
                                            <strong>${sprint.name}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge sprint-status-badge bg-${sprint.status === 'active' ? 'success' : (sprint.status === 'completed' ? 'primary' : 'secondary')}">
                                            <i class="fas fa-${sprint.status === 'active' ? 'play' : (sprint.status === 'completed' ? 'check' : 'pause')} me-1"></i>
                                            ${sprint.status.charAt(0).toUpperCase() + sprint.status.slice(1)}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <i class="fas fa-calendar text-muted me-1"></i>
                                            ${new Date(sprint.start_date).toLocaleDateString()}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <i class="fas fa-calendar text-muted me-1"></i>
                                            ${new Date(sprint.end_date).toLocaleDateString()}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="task-stats">
                                            <span class="badge bg-info me-1">${sprint.total_tasks} total</span>
                                            <span class="badge bg-success">${sprint.closed_tasks} closed</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-container">
                                            <div class="progress sprint-progress" style="height: 24px;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                                     role="progressbar" 
                                                     style="width: ${sprint.total_tasks > 0 ? (sprint.closed_tasks / sprint.total_tasks * 100) : 0}%"
                                                     aria-valuenow="${sprint.total_tasks > 0 ? (sprint.closed_tasks / sprint.total_tasks * 100) : 0}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    <span class="progress-text">${sprint.total_tasks > 0 ? Math.round(sprint.closed_tasks / sprint.total_tasks * 100) : 0}%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="story-points-info">
                                            <span class="badge bg-warning text-dark me-1">${sprint.total_story_points || 0} total</span>
                                            <span class="badge bg-success">${sprint.completed_story_points || 0} done</span>
                                        </div>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
            </div>
        `;
        
        const modal = document.getElementById('allSprintsModal');
        modal.querySelector('.modal-content').innerHTML = modalContent;
        new bootstrap.Modal(modal).show();
    }

    // Sprint form submission
    document.getElementById('sprintForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const sprintData = Object.fromEntries(formData);

        // Set default status to 'planning' if not selected
        if (!sprintData.status) {
            sprintData.status = 'planning';
        }

        fetch('/sprints', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(sprintData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal and reload page
                const modal = bootstrap.Modal.getInstance(document.getElementById('sprintModal'));
                modal.hide();
                location.reload();
            } else {
                alert(data.message || 'Error creating sprint');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error creating sprint: ' + error.message);
        });
    });

    // Assign form submission
    document.getElementById('assignForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const assignData = Object.fromEntries(formData);

        fetch('/jira-tasks/assign', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(assignData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error assigning task');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error assigning task');
        });
    });
    </script>

    <style>
    .draggable-task {
        cursor: move;
        transition: all 0.2s ease;
    }

    .draggable-task:hover {
        background-color: #f8f9fa;
    }

    .draggable-task.dragging {
        opacity: 0.7;
        background-color: #fff3cd !important;
        transform: rotate(1deg);
        z-index: 1000;
    }

    .unassigned-task {
        opacity: 0.6;
        background-color: #f8f9fa !important;
    }

    .unassigned-task .assignee-cell {
        color: #dc3545 !important;
        font-weight: bold;
    }

    .sortable-column {
        transition: all 0.3s ease;
    }

    .sortable-column.drag-over {
        background-color: #e3f2fd !important;
        border: 2px dashed #007bff !important;
    }

    /* Enhanced table styling for backlog */
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
        transform: scale(1.01);
        transition: all 0.2s ease;
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .task-description {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .badge {
        font-size: 0.75em;
        font-weight: 500;
    }

    .unassigned-task {
        opacity: 0.7;
        background-color: #f8f9fa !important;
    }

    .unassigned-task:hover {
        opacity: 1;
        background-color: #e9ecef !important;
    }

    /* Sprint Task Management Modal Styles */
    .task-item {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .task-item:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .task-item.selected {
        background-color: #e3f2fd;
        border-color: #2196f3 !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .modal-xl {
        max-width: 1200px;
    }

    .task-checkbox-input:checked + .task-item {
        background-color: #e3f2fd;
    }

    /* Professional Sprint Modal Styles */
    .sprint-icon {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .stats-card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }

    .stats-icon {
        background: rgba(0, 123, 255, 0.1);
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .progress-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .progress-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: block;
    }

    .info-item, .timeline-item {
        padding: 16px;
        border-radius: 8px;
        background: #f8f9fa;
        border-left: 3px solid #007bff;
    }

    .info-icon, .timeline-icon {
        width: 40px;
        height: 40px;
        background: rgba(0, 123, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .modal-xl {
        max-width: 1200px;
    }

    .modal-content {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        padding: 2rem;
        border-bottom: none;
    }

    .modal-body {
        background: #f8f9fa;
    }

    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .badge {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    </style>
@endsection