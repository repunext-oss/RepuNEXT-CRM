<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'empolyeecode',
        'phone',
        'email',
        'gender',
        'location',
        'dateofbirth',
        'position',
        'reportto',
        'status',
        'isdeleted'
    ];
}
