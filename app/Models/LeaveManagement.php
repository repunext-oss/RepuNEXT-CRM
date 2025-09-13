<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveManagement extends Model
{
    use HasFactory;
    protected $table='leave_management';
    protected $fillable = [     'user_ref_id',
                                'date',
                                'taken_leave',
                                'credit_leave', 
                                'casual_leave',  // Added
                                'sick_leave',    // Added
                                'permission',    // Added
                                'start_date',
                                'end_date',
                                'l_status', 
                                'l_isdeleted'  ];

                                 public function user()
    {
        return $this->belongsTo(User::class, 'user_ref_id');
    }
}
