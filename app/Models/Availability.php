<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'day_of_week',
        'start_time',
        'end_time',
        'availability_type',
        'exception_date',
        'notes',
        'is_available',
        'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'exception_date' => 'date',
        'is_available' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for active availabilities
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for available slots
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Scope for regular availabilities
    public function scopeRegular($query)
    {
        return $query->where('availability_type', 'regular');
    }

    // Scope for exceptions
    public function scopeExceptions($query)
    {
        return $query->where('availability_type', 'exception');
    }

    // Check if a specific date/time is available
    public static function isAvailable($userId, $date, $startTime = null, $endTime = null)
    {
        $dayOfWeek = Carbon::parse($date)->format('l'); // Monday, Tuesday, etc.
        
        // Check for exceptions first (both available and unavailable)
        $exception = self::where('user_id', $userId)
            ->where('availability_type', 'exception')
            ->where('exception_date', $date)
            ->where('is_active', true)
            ->first();

        if ($exception) {
            // If there's an exception for this date, use it
            if (!$exception->is_available) {
                return false; // Explicitly unavailable
            }
            
            if ($startTime && $endTime) {
                return $startTime >= $exception->start_time && $endTime <= $exception->end_time;
            }
            return true;
        }

        // Check regular availability
        $regular = self::where('user_id', $userId)
            ->where('availability_type', 'regular')
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->where('is_active', true)
            ->first();

        if (!$regular) {
            return false;
        }

        if ($startTime && $endTime) {
            return $startTime >= $regular->start_time && $endTime <= $regular->end_time;
        }

        return true;
    }

    // Get available time slots for a specific date
    public static function getAvailableSlots($userId, $date)
    {
        $dayOfWeek = Carbon::parse($date)->format('l');
        
        // Check for exceptions first (both available and unavailable)
        $availability = self::where('user_id', $userId)
            ->where('availability_type', 'exception')
            ->where('exception_date', $date)
            ->where('is_active', true)
            ->first();

        if ($availability) {
            // If there's an exception and it's unavailable, return empty array
            if (!$availability->is_available) {
                return [];
            }
        } else {
            // Use regular availability
            $availability = self::where('user_id', $userId)
                ->where('availability_type', 'regular')
                ->where('day_of_week', $dayOfWeek)
                ->where('is_available', true)
                ->where('is_active', true)
                ->first();
        }

        if (!$availability) {
            return [];
        }

        // Generate 30-minute slots
        $slots = [];
        $start = Carbon::parse($availability->start_time);
        $end = Carbon::parse($availability->end_time);

        while ($start < $end) {
            $slotEnd = $start->copy()->addMinutes(30);
            if ($slotEnd <= $end) {
                $slots[] = [
                    'start' => $start->format('H:i'),
                    'end' => $slotEnd->format('H:i')
                ];
            }
            $start->addMinutes(30);
        }

        return $slots;
    }
}
