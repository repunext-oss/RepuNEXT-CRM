<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectService extends Model
{
    use HasFactory;
    protected $table='project_services';
    protected $fillable = [     
                                'ps_name',
                                'ps_price',
                                'ps_status',
                                'ps_isdeleted'  ];
}
