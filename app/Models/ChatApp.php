<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatApp extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';
    protected $fillable = ['incoming_msg_id', 'outgoing_msg_id', 'msg', 'attach', 'status', 'isdeleted'];
}
