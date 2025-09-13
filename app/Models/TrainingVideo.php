<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingVideo extends Model
{
    use HasFactory;
    protected $table='training_videos';
    protected $fillable = ['tv_name','tv_url','tv_department','tv_description','l_material','status','isdeleted'];
}
