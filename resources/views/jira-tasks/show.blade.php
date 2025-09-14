@extends('admin.admin_master')
@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Jira Task Details</h3>
                    <div>
                        <a href="{{ route('jira-tasks.edit', $task->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('jira-tasks.board') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Board
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ $task->title }}</h4>
                                    <small class="text-muted">
                                        {{ $task->task_key }} • 
                                        Created {{ $task->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                                <div class="card-body">
                                    <h6>Description:</h6>
                                    <p>{{ $task->description }}</p>
                                    
                                    @if($task->comments)
                                        <h6>Comments:</h6>
                                        <div class="border rounded p-3 bg-light">
                                            {{ $task->comments }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Task Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        <span class="badge badge-{{ $task->status == 'backlog' ? 'primary' : ($task->status == 'todo' ? 'info' : ($task->status == 'in_progress' ? 'warning' : ($task->status == 'review' ? 'secondary' : 'success'))) }}">
                                            {{ $task->status_text }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Type:</strong>
                                        <span class="badge badge-info">{{ $task->type_text }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Priority:</strong>
                                        <span class="badge badge-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                            {{ $task->priority_text }}
                                        </span>
                                    </div>

                                    @if($task->assignee)
                                        <div class="mb-3">
                                            <strong>Assignee:</strong>
                                            <div class="d-flex align-items-center mt-1">
                                                <img src="{{ asset('upload/profile-img/' . $task->assignee->profile_image) }}" 
                                                     class="rounded-circle me-2" width="30" height="30" 
                                                     onerror="this.src='{{ asset('upload/default.jpg') }}'">
                                                <span>{{ $task->assignee->name }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($task->reporter)
                                        <div class="mb-3">
                                            <strong>Reporter:</strong>
                                            <div class="d-flex align-items-center mt-1">
                                                <img src="{{ asset('upload/profile-img/' . $task->reporter->profile_image) }}" 
                                                     class="rounded-circle me-2" width="30" height="30" 
                                                     onerror="this.src='{{ asset('upload/default.jpg') }}'">
                                                <span>{{ $task->reporter->name }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($task->project)
                                        <div class="mb-3">
                                            <strong>Project:</strong>
                                            <span>{{ $task->project->project_title }}</span>
                                        </div>
                                    @endif

                                    @if($task->story_points)
                                        <div class="mb-3">
                                            <strong>Story Points:</strong>
                                            <span>{{ $task->story_points }}</span>
                                        </div>
                                    @endif

                                    @if($task->due_date)
                                        <div class="mb-3">
                                            <strong>Due Date:</strong>
                                            <span>{{ $task->due_date->format('M d, Y') }}</span>
                                        </div>
                                    @endif

                                    @if($task->labels && count($task->labels) > 0)
                                        <div class="mb-3">
                                            <strong>Labels:</strong>
                                            <div class="mt-1">
                                                @foreach($task->labels as $label)
                                                    <span class="badge badge-light me-1">{{ $label }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($task->attachments && count($task->attachments) > 0)
                                        <div class="mb-3">
                                            <strong>Attachments:</strong>
                                            <div class="mt-1">
                                                @foreach($task->attachments as $attachment)
                                                    <a href="{{ asset('upload/jira-tasks/' . $attachment) }}" 
                                                       target="_blank" class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="fas fa-download"></i> {{ $attachment }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Created:</strong>
                                        <span>{{ $task->created_at->format('M d, Y H:i') }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Last Updated:</strong>
                                        <span>{{ $task->updated_at->format('M d, Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6>Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @if($task->status != 'done')
                                            <button class="btn btn-success btn-sm" onclick="updateStatus('{{ $task->id }}', 'done')">
                                                Mark as Done
                                            </button>
                                        @endif
                                        
                                        @if($task->status != 'in_progress')
                                            <button class="btn btn-warning btn-sm" onclick="updateStatus('{{ $task->id }}', 'in_progress')">
                                                Start Progress
                                            </button>
                                        @endif
                                        
                                        <button class="btn btn-info btn-sm" onclick="openAssignModal('{{ $task->id }}')">
                                            Assign Task
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <option value="{{ $user->id }}" {{ $task->assignee_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
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

@push('scripts')
<script>
function updateStatus(taskId, newStatus) {
    if (confirm('Are you sure you want to update the task status?')) {
        fetch('{{ route("jira-tasks.updateStatus") }}', {
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
</script>
@endpush
