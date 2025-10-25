<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatApp extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';
    protected $fillable = ['incoming_msg_id', 'outgoing_msg_id', 'msg', 'attach', 'status', 'isdeleted'];

    public function outgoingUser()
    {
        return $this->belongsTo(User::class, 'outgoing_msg_id');
    }

    public function incomingUser()
    {
        return $this->belongsTo(User::class, 'incoming_msg_id');
    }
}
