<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasktimesheet extends Model
{
    use HasFactory;
    protected $table='tasktimesheets';
    protected $fillable = [' tt_date','tt_cat','tt_name','tt_desc','tt_starttime','tt_endtime','tc_status','tc_isdeleted'];
}
