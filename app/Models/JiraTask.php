<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JiraTask extends Model
{
    use HasFactory;
    
    protected $table = 'jira_tasks';
    
    protected $fillable = [
        'task_key',
        'title',
        'description',
        'type',
        'priority',
        'status',
        'assignee_id',
        'reporter_id',
        'project_id',
        'sprint_id',
        'story_points',
        'due_date',
        'labels',
        'attachments',
        'comments',
        'is_active',
        'moved_to_todo_at',
        'moved_to_done_at'
    ];

    protected $casts = [
        'labels' => 'array',
        'attachments' => 'array',
        'comments' => 'array',
        'due_date' => 'date',
        'is_active' => 'boolean',
        'story_points' => 'decimal:1',
        'moved_to_todo_at' => 'datetime',
        'moved_to_done_at' => 'datetime',
    ];

    // Relationships
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }

    public function sprint(): BelongsTo
    {
        return $this->belongsTo(Sprint::class, 'sprint_id');
    }

    // Generate unique task key
    public static function generateTaskKey($projectId = null)
    {
        $prefix = $projectId ? 'PROJ' : 'TASK';
        $lastTask = self::where('task_key', 'like', $prefix . '-%')
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastTask) {
            $lastNumber = (int) substr($lastTask->task_key, strrpos($lastTask->task_key, '-') + 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . '-' . $newNumber;
    }

    // Get status as readable text
    public function getStatusTextAttribute()
    {
        $statuses = [
            'backlog' => 'Backlog',
            'todo' => 'To Do',
            'in_progress' => 'In Progress',
            'review' => 'Review',
            'done' => 'Done'
        ];
        
        return $statuses[$this->status] ?? 'Unknown';
    }

    // Get priority as readable text
    public function getPriorityTextAttribute()
    {
        $priorities = [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'critical' => 'Critical'
        ];
        
        return $priorities[$this->priority] ?? 'Medium';
    }

    // Get type as readable text
    public function getTypeTextAttribute()
    {
        $types = [
            'task' => 'Task',
            'bug' => 'Bug',
            'story' => 'Story',
            'epic' => 'Epic'
        ];
        
        return $types[$this->type] ?? 'Task';
    }

    // Scope for active tasks
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for tasks by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Get formatted moved to todo date
    public function getMovedToTodoFormattedAttribute()
    {
        return $this->moved_to_todo_at ? $this->moved_to_todo_at->format('M j, Y g:i A') : 'Not moved to todo yet';
    }

    // Get formatted moved to done date
    public function getMovedToDoneFormattedAttribute()
    {
        return $this->moved_to_done_at ? $this->moved_to_done_at->format('M j, Y g:i A') : 'Not completed yet';
    }
}