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
        $totalTasks = $this->tasks()->count();
        if ($totalTasks === 0) {
            return 0;
        }
        
        $completedTasks = $this->tasks()->where('status', 'done')->count();
        return round(($completedTasks / $totalTasks) * 100, 1);
    }

    // Get total story points
    public function getTotalStoryPoints()
    {
        return $this->tasks()->sum('story_points') ?? 0;
    }

    // Get completed story points
    public function getCompletedStoryPoints()
    {
        return $this->tasks()->where('status', 'done')->sum('story_points') ?? 0;
    }
}
