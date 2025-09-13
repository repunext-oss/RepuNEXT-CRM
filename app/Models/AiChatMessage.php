<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AiChatMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_message',
        'chatgpt_response',
        'categoryname',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
