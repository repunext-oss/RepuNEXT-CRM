<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table='tickets';
    protected $fillable = [' client_user_id','ticket_subject','ticket_description','product','ticket_prority','attachments','ticket_status','isdeleted'];
}

