<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalTask extends Model
{
    use HasFactory;
    protected $table='goal_tasks';
    protected $fillable = [     'g_taskname',
                                'g_category',
                                'g_description',
                                'g_deadline',
                                'g_realenddate',
                                'g_priority',
                                'g_assigned',
                                'g_assignedby',
                                'timer',
                                'running_time',
                                'g_status',
                                'g_isdeleted'  ];
}
