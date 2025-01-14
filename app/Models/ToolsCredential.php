<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsCredential extends Model
{
    use HasFactory;
    protected $table='tools_credentials';
    protected $fillable = [ 'tool_name','tooltype_id','link','user','password','tc_status','tc_isdeleted'];
}
