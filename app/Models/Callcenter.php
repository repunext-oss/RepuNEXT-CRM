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
        'mobile2',
        'Enquiry_Date',
        'Email',
        'followup1',
        'followup2',    
        'followup3',
        'Company_Name',
        'location',
        'area',
        'Source',
        'Service',
        'Status',
    ];
}
