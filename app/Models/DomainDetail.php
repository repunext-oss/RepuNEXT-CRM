<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainDetail extends Model
{
    use HasFactory;
    protected $table='domain_details';
    protected $fillable = [ 'domain_name','host_id','type','backend_user','backend_password','domain_status','domain_isdeleted'];
}
