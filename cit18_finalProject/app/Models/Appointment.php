<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_datetime',
        'type',
        'reason',
        'notes',
        'status'
    ];

    protected $casts = [
        'appointment_datetime' => 'datetime'
    ];

    // Define relationship with User model for patient
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Define relationship with User model for doctor
    public function doctor(): BelongsTo
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
