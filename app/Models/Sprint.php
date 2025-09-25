<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sprint extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function tasks(): HasMany
    {
        return $this->hasMany(JiraTask::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        return $query->where('status', 'active');
    }

    // Get status as readable text
    public function getStatusTextAttribute()
    {
        $statuses = [
            'planning' => 'Planning',
            'active' => 'Active',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];
        
        return $statuses[$this->status] ?? 'Unknown';
    }

    // Check if sprint is currently active
    public function isActive()
    {
        return $this->status === 'active' && 
               $this->start_date <= now()->toDateString() && 
               $this->end_date >= now()->toDateString();
    }

    // Check if sprint has ended
    public function hasEnded()
    {
        return $this->end_date < now()->toDateString();
    }

    // Get sprint progress percentage
    public function getProgressPercentage()
    {
        // For completed sprints, count all tasks; for active sprints, count only active tasks
        if ($this->status === 'completed') {
            $totalTasks = $this->tasks()->count();
            $completedTasks = $this->tasks()->where('is_active', false)->count();
        } else {
            $totalTasks = $this->tasks()->where('is_active', true)->count();
            $completedTasks = $this->tasks()->where('is_active', true)->where('status', 'done')->count();
        }
        
        if ($totalTasks === 0) {
            return 0;
        }
        
        return round(($completedTasks / $totalTasks) * 100, 1);
    }

    // Get total story points
    public function getTotalStoryPoints()
    {
        // For completed sprints, count all tasks; for active sprints, count only active tasks
        if ($this->status === 'completed') {
            return $this->tasks()->sum('story_points') ?? 0;
        } else {
            return $this->tasks()->where('is_active', true)->sum('story_points') ?? 0;
        }
    }

    // Get completed story points
    public function getCompletedStoryPoints()
    {
        // For completed sprints, completed tasks are inactive; for active sprints, completed tasks are done
        if ($this->status === 'completed') {
            return $this->tasks()->where('is_active', false)->sum('story_points') ?? 0;
        } else {
            return $this->tasks()->where('is_active', true)->where('status', 'done')->sum('story_points') ?? 0;
        }
    }
}
