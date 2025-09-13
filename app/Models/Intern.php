<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;
    protected $table = 'interns';
    protected $fillable = [
        'Name',
        'Mobile',
        'Startdate',
        'Enddate',
        'Duration',
        'Slot',
        'Course',
        'Source',
        'Letter',
        'Certificate',
        'Documentation',
        'Collage',
        'Department',
        'year',
        'Area',
        'City',
        'Type',
        'Amount',
        'amt',
        'Status',
        'i_isdeleted',
        'aadhar_card',
        'college_id_card',
    ];
}
