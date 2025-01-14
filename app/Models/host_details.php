<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class host_details extends Model
{
    use HasFactory;
    protected $table='host_details';
    protected $fillable = [ 'host_name','host_username','host_password','h_status','h_isdeleted'];
}
