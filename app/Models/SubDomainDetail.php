<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDomainDetail extends Model
{
    use HasFactory;
    protected $table='sub_domain_details';
    protected $fillable = [ 'subdomain_name','host_id','type','backend_user','backend_password','domain_status','domain_isdeleted'];
}
