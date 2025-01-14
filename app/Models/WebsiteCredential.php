<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class WebsiteCredential extends Model
{
    use HasFactory;
    protected $table='websitecredentials';
 
    protected $fillable=[
        'Website',
        'URL',
        'User_Name',
        'Password',
        'Completion_Date',
        'Next_Renewal_Date',
        'Client_Contact1',
        'Client_Contact2',
        'Month',

    ];

}
