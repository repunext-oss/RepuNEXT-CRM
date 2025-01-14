<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tools_type extends Model
{
    use HasFactory;
    protected $table='tools_types';
    protected $fillable = [ 'tooltype_name','tl_status','tl_isdeleted'];
}
