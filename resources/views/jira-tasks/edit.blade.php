@extends('admin.admin_master')
@section('admin')

<style>
.description-editor {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    overflow: hidden;
}

.editor-toolbar {
    background-color: #f8f9fa;
    border-bottom: 1px solid #ced4da;
    padding: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.editor-toolbar .btn {
    border: 1px solid #dee2e6;
    padding: 0.25rem 0.5rem;
    min-width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.editor-toolbar .btn:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
}

.editor-toolbar .btn.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.editor-toolbar .vr {
    width: 1px;
    height: 24px;
    background-color: #dee2e6;
    margin: 0 0.25rem;
}

.editor-content {
    background-color: white;
}

.editor-content textarea {
    border: none;
    border-radius: 0;
    box-shadow: none;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.5;
}

.editor-content textarea:focus {
    border: none;
    box-shadow: none;
    outline: none;
}

.character-count {
    font-size: 0.875rem;
    color: #6c757d;
    text-align: right;
    padding: 0.25rem 0.5rem;
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
}
</style>
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card pt-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0" style="font-size: 1.5rem; font-weight: 700;">
                        <i class="fas fa-edit me-2"></i>
                        Edit RN Task
                    </h3>
                    <div>
                        <a href="{{ route('jira-tasks.show', $task->id) }}" class="btn btn-outline-info me-2">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('jira-tasks.board') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Board
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('jira-tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $task->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="project_id" class="form-label">Project <span class="text-danger">*</span></label>
                                    <select class="form-select @error('project_id') is-invalid @enderror" 
                                            id="project_id" name="project_id" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                                {{ $project->project_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" name="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Task Details Row -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label">Task Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="">Select Task Type</option>
                                        <option value="task" {{ old('type', $task->type) == 'task' ? 'selected' : '' }}>Task</option>
                                        <option value="bug" {{ old('type', $task->type) == 'bug' ? 'selected' : '' }}>Bug</option>
                                        <option value="story" {{ old('type', $task->type) == 'story' ? 'selected' : '' }}>Story</option>
                                        <option value="epic" {{ old('type', $task->type) == 'epic' ? 'selected' : '' }}>Epic</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror" 
                                            id="priority" name="priority" required>
                                        <option value="">Select Priority</option>
                                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="critical" {{ old('priority', $task->priority) == 'critical' ? 'selected' : '' }}>Critical</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="assignee_id" class="form-label">Assignee</label>
                                    <select class="form-select @error('assignee_id') is-invalid @enderror" 
                                            id="assignee_id" name="assignee_id">
                                        <option value="">Select Assignee</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assignee_id', $task->assignee_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assignee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label for="story_points" class="form-label">Story Points <span class="text-danger">*</span></label>
                                    <select class="form-select @error('story_points') is-invalid @enderror" 
                                            id="story_points" name="story_points" required>
                                        <option value="">Select Story Points</option>
                                        <option value="0.5" {{ old('story_points', $task->story_points) == '0.5' ? 'selected' : '' }}>0.5</option>
                                        <option value="1" {{ old('story_points', $task->story_points) == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ old('story_points', $task->story_points) == '2' ? 'selected' : '' }}>2</option>
                                        <option value="4" {{ old('story_points', $task->story_points) == '4' ? 'selected' : '' }}>4</option>
                                        <option value="6" {{ old('story_points', $task->story_points) == '6' ? 'selected' : '' }}>6</option>
                                        <option value="8" {{ old('story_points', $task->story_points) == '8' ? 'selected' : '' }}>8</option>
                                        <option value="10" {{ old('story_points', $task->story_points) == '10' ? 'selected' : '' }}>10</option>
                                        <option value="12" {{ old('story_points', $task->story_points) == '12' ? 'selected' : '' }}>12</option>
                                        <option value="16" {{ old('story_points', $task->story_points) == '16' ? 'selected' : '' }}>16</option>
                                    </select>
                                    @error('story_points')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Description Row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <div class="description-editor">
                                        <div class="editor-toolbar">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('bold')" title="Bold">
                                                <i class="fas fa-bold"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('italic')" title="Italic">
                                                <i class="fas fa-italic"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('underline')" title="Underline">
                                                <i class="fas fa-underline"></i>
                                            </button>
                                            <div class="vr mx-1"></div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertList('ul')" title="Bullet List">
                                                <i class="fas fa-list-ul"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertList('ol')" title="Numbered List">
                                                <i class="fas fa-list-ol"></i>
                                            </button>
                                            <div class="vr mx-1"></div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertLink()" title="Insert Link">
                                                <i class="fas fa-link"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearFormatting()" title="Clear Formatting">
                                                <i class="fas fa-remove-format"></i>
                                            </button>
                                        </div>
                                        <div class="editor-content">
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="8" required 
                                                      style="min-height: 200px; resize: vertical;">{{ old('description', $task->description) }}</textarea>
                                        </div>
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Attachments Row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="attachments" class="form-label">Attachments</label>
                                    @if($task->attachments && count($task->attachments) > 0)
                                        <div class="mb-2">
                                            <small class="text-muted">Current attachments:</small>
                                            @foreach($task->attachments as $attachment)
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2">{{ $attachment }}</span>
                                                    <a href="{{ asset('upload/jira-tasks/' . $attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('attachments') is-invalid @enderror" 
                                           id="attachments" name="attachments[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Leave empty to keep current attachments</small>
                                    @error('attachments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Task
                            </button>
                            <a href="{{ route('jira-tasks.show', $task->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Text Editor Functions
function formatText(command) {
    const textarea = document.getElementById('description');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    if (!selectedText) {
        // No text selected, just insert formatting tags
        const formatMap = {
            'bold': '**text**',
            'italic': '*text*',
            'underline': '<u>text</u>'
        };
        
        const formatText = formatMap[command];
        const beforeCursor = textarea.value.substring(0, start);
        const afterCursor = textarea.value.substring(end);
        
        textarea.value = beforeCursor + formatText + afterCursor;
        
        // Position cursor between the tags
        const newCursorPos = start + formatText.indexOf('text');
        textarea.setSelectionRange(newCursorPos, newCursorPos + 4);
    } else {
        // Text selected, wrap it with formatting
        let formattedText = '';
        switch(command) {
            case 'bold':
                formattedText = '**' + selectedText + '**';
                break;
            case 'italic':
                formattedText = '*' + selectedText + '*';
                break;
            case 'underline':
                formattedText = '<u>' + selectedText + '</u>';
                break;
        }
        
        textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
        textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
    }
    
    textarea.focus();
}

function insertList(type) {
    const textarea = document.getElementById('description');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    let listText = '';
    if (type === 'ul') {
        listText = selectedText ? 
            '• ' + selectedText.replace(/\n/g, '\n• ') : 
            '• ';
    } else if (type === 'ol') {
        listText = selectedText ? 
            '1. ' + selectedText.replace(/\n/g, '\n2. ') : 
            '1. ';
    }
    
    textarea.value = textarea.value.substring(0, start) + listText + textarea.value.substring(end);
    const newCursorPos = start + listText.length;
    textarea.setSelectionRange(newCursorPos, newCursorPos);
    textarea.focus();
}

function insertLink() {
    const textarea = document.getElementById('description');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    const linkText = selectedText || 'link text';
    const url = prompt('Enter URL:', 'https://');
    
    if (url) {
        const link = '[' + linkText + '](' + url + ')';
        textarea.value = textarea.value.substring(0, start) + link + textarea.value.substring(end);
        textarea.setSelectionRange(start + link.length, start + link.length);
    }
    
    textarea.focus();
}

function clearFormatting() {
    const textarea = document.getElementById('description');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    if (selectedText) {
        // Remove common formatting
        let cleanText = selectedText
            .replace(/\*\*(.*?)\*\*/g, '$1')  // Remove bold
            .replace(/\*(.*?)\*/g, '$1')      // Remove italic
            .replace(/<u>(.*?)<\/u>/g, '$1')  // Remove underline
            .replace(/\[(.*?)\]\(.*?\)/g, '$1') // Remove links
            .replace(/^[•\-\*]\s*/gm, '')     // Remove bullet points
            .replace(/^\d+\.\s*/gm, '')       // Remove numbered lists
            .trim();
        
        textarea.value = textarea.value.substring(0, start) + cleanText + textarea.value.substring(end);
        textarea.setSelectionRange(start, start + cleanText.length);
    }
    
    textarea.focus();
}

// Auto-resize textarea
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('description');
    
    function autoResize() {
        textarea.style.height = 'auto';
        textarea.style.height = Math.max(200, textarea.scrollHeight) + 'px';
    }
    
    textarea.addEventListener('input', autoResize);
    autoResize(); // Initial resize
    
    // Keyboard shortcuts
    textarea.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch(e.key) {
                case 'b':
                    e.preventDefault();
                    formatText('bold');
                    break;
                case 'i':
                    e.preventDefault();
                    formatText('italic');
                    break;
                case 'u':
                    e.preventDefault();
                    formatText('underline');
                    break;
            }
        }
    });
});
</script>

@endsection
