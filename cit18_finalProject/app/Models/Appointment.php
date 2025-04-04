<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'doctor_id',
        'appointment_datetime',
        'type',
        'reason',
        'status',
        'notes'
    ];

    protected $casts = [
        'appointment_datetime' => 'datetime'
    ];

    /**
     * Scope a query to only include upcoming appointments.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_datetime', '>=', now())
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('appointment_datetime');
    }

    /**
     * Get the user that owns the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the doctor for the appointment.
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Helper method to check if appointment is pending
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    // Helper method to check if appointment is confirmed
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    // Helper method to check if appointment is cancelled
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    // Helper method to check if appointment is completed
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
