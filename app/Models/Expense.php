<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expense';
    protected $fillable = ['category', 'subcategory', 'amount','e_isdeleted','e_name','payment_method','entry_date'];
}
