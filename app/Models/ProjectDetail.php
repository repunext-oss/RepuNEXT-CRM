<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    use HasFactory;
    protected $table='project_details';
    protected $fillable = [  'project_title',
                                'project_description',
                                'project_start_date',
                                'project_end_date',
                                'project_service_category', 
                                'project_timeline', 
                                'assigned_to_member', 
                                'project_priority', 
                                'project_status',
                                'project_isdeleted'  ];
}
