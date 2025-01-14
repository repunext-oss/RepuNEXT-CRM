<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeDetail extends Model
{
    use HasFactory;
    protected $table='time_details';
    protected $fillable = [ 'project_ref_id',
    'task_name','task_date','task_assigned','task_start_time','task_end_time','task_description','task_status','task_isdeleted'];
}
