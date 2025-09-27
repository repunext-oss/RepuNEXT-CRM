<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'description', 
        'room_type', 
        'created_by', 
        'r_isdeleted',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'r_isdeleted' => 'boolean'
    ];

    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function messages() {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function latestMessage() {
        return $this->hasOne(Message::class)->latest();
    }

    // Scope for active rooms
    public function scopeActive($query) {
        return $query->where('r_isdeleted', false)->where('is_active', true);
    }

    // Get member count
    public function getMemberCountAttribute() {
        return $this->users()->count();
    }
}
