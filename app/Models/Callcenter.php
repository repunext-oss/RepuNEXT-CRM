<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Callcenter extends Model
{
    use HasFactory;
    protected $table='callcenter';
    protected $fillable=[
        'Name',
        'Mobile',
        'Enquiry_Date',
        'Email',
        'Company_Name',
        'FollowUp',
        'followupdate',
        'Source',
        'Service',
        'Status',
    ];
}
