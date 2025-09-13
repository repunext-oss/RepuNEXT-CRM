<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    protected $table='social_media';
    protected $fillable = [ 'sm_name','sm_link','sm_user','sm_password','sm_status','sm_isdeleted'];
}
