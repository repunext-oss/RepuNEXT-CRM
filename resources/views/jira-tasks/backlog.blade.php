@extends('admin.admin_master')
@section('admin')

<style>
.unassigned-task {
    opacity: 0.6;
    background-color: #f8f9fa !important;
}

.unassigned-task:hover {
    opacity: 0.8;
}

.unassigned-task .assignee-cell {
    color: #dc3545 !important;
    font-weight: bold;
}

.draggable-task:not(.unassigned-task) {
    transition: all 0.3s ease;
}

.draggable-task:not(.unassigned-task):hover {
    background-color: #e3f2fd !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row m-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1 text-dark font-weight-bold">Task Backlog</h2>
                    <p class="text-muted mb-0">Manage and prioritize your project tasks</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('jira-tasks.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Create Task
                    </a>
                    <a href="{{ route('jira-tasks.board') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-columns me-2"></i>Board View
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <!-- Backlog Section -->
                    <div class="p-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-1 text-dark font-weight-bold">
                                    <i class="fas fa-inbox text-primary me-2"></i>Backlog Tasks
                                </h4>
                                <span class="badge badge-primary badge-pill">{{ $backlogTasks->count() }} tasks</span>
                            </div>
                        </div>
                        
                        @if($backlogTasks->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
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
                                            <tr class="draggable-task" 
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
                                                        <br>
                                                        <small class="text-muted">{{ Str::limit($task->description, 60) }}</small>
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
                                                    <small class="text-muted">{{ $task->created_at->format('M d, Y') }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('jira-tasks.show', $task->id) }}" class="btn btn-outline-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('jira-tasks.edit', $task->id) }}" class="btn btn-outline-secondary btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a> 
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No tasks in backlog</h5>
                                <p class="text-muted">Create a new task to get started!</p>
                                <a href="{{ route('jira-tasks.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create First Task
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Drop Zone Section -->
                    <div class="p-4 bg-light border-bottom">
                        <div class="card border-0 shadow-sm sortable-column" data-status="todo" style="min-height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="card-body d-flex align-items-center justify-content-center text-white">
                                <div class="text-center">
                                    <i class="fas fa-hand-paper fa-3x mb-3 opacity-75"></i>
                                    <h4 class="mb-2 font-weight-bold">Move to To Do</h4>
                                    <p class="mb-0 opacity-75">Drag <strong>assigned</strong> tasks here to move them to <strong>To Do</strong> status</p>
                                    <small class="opacity-75 mt-2 d-block"><i class="fas fa-info-circle"></i> Only assigned tasks can be moved to To Do</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- To Do Tasks Section -->
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-1 text-dark font-weight-bold">
                                    <i class="fas fa-check-circle text-success me-2"></i>To Do Tasks
                                </h4>
                                <span class="badge badge-success badge-pill">{{ $todoTasks->count() }} tasks</span>
                            </div>
                            <a href="{{ route('jira-tasks.board') }}" class="btn btn-outline-primary">
                                <i class="fas fa-columns me-2"></i>View on Board
                            </a>
                        </div>
                        
                        @if($todoTasks->count() > 0)
                            <div class="table-responsive border-1 rounded-3">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr class="p-3">
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
                                            <tr >
                                                <td> </td>
                                                <td>
                                                    <span class="badge badge-light text-dark font-weight-bold ">{{ $task->task_key }}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong class="text-dark">{{ $task->title }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ Str::limit($task->description, 60) }}</small>
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
                                                        <i class="fas fa-clock me-1"></i>{{ $task->updated_at->format('M d, Y H:i') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('jira-tasks.show', $task->id) }}" class="btn btn-outline-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('jira-tasks.edit', $task->id) }}" class="btn btn-outline-secondary btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a> 
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No tasks in To Do yet</h5>
                                <p class="text-muted">Drag tasks from backlog above to move them here</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
@endsection

<style>
/* Professional List View Styling */
.table {
    border-radius: 8px;
    overflow: hidden;
}

.table thead th {
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
    padding: 12px 8px;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.draggable-task {
    cursor: move;
}

.draggable-task:hover {
    background-color: #e3f2fd !important;
}

.draggable-task.dragging {
    opacity: 0.7;
    background-color: #fff3cd !important;
    transform: rotate(1deg);
    z-index: 1000;
}

.sortable-column {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.sortable-column.drag-over {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    transform: scale(1.01);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.badge-pill {
    border-radius: 20px;
    padding: 0.4em 0.8em;
    font-size: 0.75em;
}

.btn-group .btn {
    border-radius: 4px;
    margin: 0 1px;
    padding: 0.25rem 0.5rem;
}

.btn-group .btn:first-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

.btn-group .btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

/* Professional color scheme */
.text-primary { color: #667eea !important; }
.bg-primary { background-color: #667eea !important; }
.border-primary { border-color: #667eea !important; }

.text-success { color: #28a745 !important; }
.bg-success { background-color: #28a745 !important; }
.border-success { border-color: #28a745 !important; }

/* Table styling */
.table td {
    padding: 12px 8px;
    vertical-align: middle;
    border-top: 1px solid #e9ecef;
}

.table tbody tr:first-child td {
    border-top: none;
}

/* Badge styling */
.badge {
    font-size: 0.75em;
    padding: 0.35em 0.65em;
}

.badge-light {
    background-color: #f8f9fa;
    color: #495057;
    border: 1px solid #dee2e6;
}

/* Professional shadows */
.shadow-sm {
    box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
}

/* Typography */
.font-weight-bold {
    font-weight: 600 !important;
}

/* Spacing */
.gap-2 > * + * {
    margin-left: 0.5rem;
}

/* Responsive table */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group .btn {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
}
</style>

<script>
// Drag and Drop functionality for backlog
document.addEventListener('DOMContentLoaded', function() {
    initializeBacklogDragAndDrop();
});

function initializeBacklogDragAndDrop() {
    const taskRows = document.querySelectorAll('.draggable-task');
    const dropZone = document.querySelector('.sortable-column');

    if (taskRows.length === 0 || !dropZone) {
        return;
    }

    // Add drag event listeners to task rows
    taskRows.forEach((row) => {
        row.addEventListener('dragstart', handleDragStart);
        row.addEventListener('dragend', handleDragEnd);
    });

    // Add drop event listeners to drop zone
    dropZone.addEventListener('dragover', handleDragOver);
    dropZone.addEventListener('drop', handleDrop);
    dropZone.addEventListener('dragenter', handleDragEnter);
    dropZone.addEventListener('dragleave', handleDragLeave);
}

function handleDragStart(e) {
    const taskRow = e.target.closest('.draggable-task');
    if (!taskRow) {
        return;
    }
    
    // Prevent dragging unassigned tasks
    if (taskRow.classList.contains('unassigned-task')) {
        e.preventDefault();
        showNotification('Cannot drag unassigned task: Task must be assigned first!', 'error');
        return;
    }
    
    e.dataTransfer.setData('text/plain', taskRow.dataset.taskId);
    e.dataTransfer.effectAllowed = 'move';
    
    taskRow.style.opacity = '0.5';
    taskRow.classList.add('table-warning');
}

function handleDragEnd(e) {
    const taskRow = e.target.closest('.draggable-task');
    if (taskRow) {
        taskRow.style.opacity = '1';
        taskRow.classList.remove('table-warning');
    }
}

function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
}

function handleDragEnter(e) {
    e.preventDefault();
    const dropZone = e.target.closest('.sortable-column');
    if (dropZone) {
        dropZone.classList.add('border-primary');
        dropZone.style.backgroundColor = '#e3f2fd';
    }
}

function handleDragLeave(e) {
    const dropZone = e.target.closest('.sortable-column');
    if (dropZone) {
        dropZone.classList.remove('border-primary');
        dropZone.style.backgroundColor = '';
    }
}

function handleDrop(e) {
    e.preventDefault();
    
    const dropZone = e.target.closest('.sortable-column');
    if (!dropZone) {
        return;
    }
    
    dropZone.classList.remove('border-primary');
    dropZone.style.backgroundColor = '';
    
    const taskId = e.dataTransfer.getData('text/plain');
    const newStatus = dropZone.dataset.status;
    const taskRow = document.querySelector(`[data-task-id="${taskId}"]`);
    const oldStatus = taskRow ? taskRow.dataset.status : null;

    if (!taskId || !newStatus || oldStatus === newStatus) {
        return;
    }

    updateTaskStatus(taskId, newStatus, taskRow);
}

function updateTaskStatus(taskId, newStatus, taskRow) {
    // Check if trying to move to todo and task has no assignee
    if (newStatus === 'todo') {
        const assigneeCell = taskRow.querySelector('.assignee-cell');
        const hasAssignee = assigneeCell && assigneeCell.textContent.trim() !== 'Unassigned' && assigneeCell.textContent.trim() !== '';
        
        if (!hasAssignee) {
            showNotification('Cannot move task to To Do: Task must be assigned to someone first!', 'error');
            return;
        }
    }

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
            showNotification('Task moved to To Do successfully!', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('An error occurred while updating the task status.', 'error');
    });
}

function showNotification(message, type) {
    if (typeof toastr !== 'undefined') {
        if (type === 'success') {
            toastr.success(message);
        } else {
            toastr.error(message);
        }
    } else {
        alert(message);
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

function moveToTodo(taskId) {
    // Find the task row and check if it has an assignee
    const taskRow = document.querySelector(`[data-task-id="${taskId}"]`);
    if (taskRow) {
        const assigneeCell = taskRow.querySelector('.assignee-cell');
        const hasAssignee = assigneeCell && assigneeCell.textContent.trim() !== 'Unassigned' && assigneeCell.textContent.trim() !== '';
        
        if (!hasAssignee) {
            showNotification('Cannot move task to To Do: Task must be assigned to someone first!', 'error');
            return;
        }
    }

    if (confirm('Are you sure you want to move this task to To Do?')) {
        fetch('{{ route("jira-tasks.updateStatus") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                task_id: taskId,
                status: 'todo'
            })
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
            alert('An error occurred while updating the task status.');
        });
    }
}
</script> 
