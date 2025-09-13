<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTime extends Model
{
    use HasFactory;
    Protected $table='task_times';
    protected $fillable = [' goal_id_ref','starttime','endtime','time_status','time_isdeleted'];
}
