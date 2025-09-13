<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTracking extends Model
{
    use HasFactory;
    protected $table='time_tracking';
    protected $fillable = ['goalid_ref','start_time', 'pause_time', 'running_time'];
    public $timestamps = true; 
}

