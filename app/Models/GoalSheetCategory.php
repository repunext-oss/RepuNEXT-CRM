<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalSheetCategory extends Model
{
    use HasFactory;
    protected $table='goal_sheet_categories';
    protected $fillable = [     
                                'gc_name',
                                'gc_status',
                                'gc_isdeleted'];
}
