<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'room_id', 
        'user_id', 
        'message', 
        'attachment', 
        'attachment_type',
        'is_deleted',
        'reply_to_message_id'
    ];

    protected $casts = [
        'is_deleted' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function replyTo() {
        return $this->belongsTo(Message::class, 'reply_to_message_id');
    }

    public function replies() {
        return $this->hasMany(Message::class, 'reply_to_message_id');
    }

    // Scope for non-deleted messages
    public function scopeActive($query) {
        return $query->where('is_deleted', false);
    }

    // Check if message has attachment
    public function hasAttachment() {
        return !empty($this->attachment);
    }

    // Get attachment URL
    public function getAttachmentUrlAttribute() {
        if ($this->hasAttachment()) {
            return asset('uploads/chat/' . $this->attachment);
        }
        return null;
    }
}
