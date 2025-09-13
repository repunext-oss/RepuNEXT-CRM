<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateVideo extends Model
{
    use HasFactory;
    protected $table='corporate_videos';
    protected $fillable = ['c_name','c_url','p_video','c_description','l_material','status','isdeleted'];
}
