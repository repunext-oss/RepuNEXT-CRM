<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;
    protected $table='followups';
    protected $fillable=[
        'Enquiry_ref_id',
        'date',
        'description',    
        'Status',
        'f_isdeleted',
    ];
}
