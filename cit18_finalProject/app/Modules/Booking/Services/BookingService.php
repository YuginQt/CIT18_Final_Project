<?php

namespace App\Modules\Booking\Services;

use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\User;

class BookingService
{
    public function createAppointment(array $data)
    {
        return Appointment::create([
            'user_id' => auth()->id(),
            'doctor_id' => $data['doctor_id'],
            'appointment_datetime' => $data['appointment_datetime'],
            'type' => $data['type'],
            'reason' => $data['reason'],
            'notes' => $data['notes'] ?? null,
            'status' => 'pending'
        ]);
    }

    public function rescheduleAppointment(Appointment $appointment, string $newDateTime)
    {
        return $appointment->update([
            'appointment_datetime' => $newDateTime,
            'status' => 'pending' // Reset to pending after rescheduling
        ]);
    }

    public function getAvailableTimeSlots($doctorId, $date)
    {
        // We can implement this later to check doctor's availability
        return [
            '09:00', '10:00', '11:00',
            '14:00', '15:00', '16:00'
        ];
    }

    public function getDoctorAvailability($doctorId)
    {
        return User::findOrFail($doctorId)->is_available;
    }

    public function cancelAppointment(Appointment $appointment)
    {
        return $appointment->update(['status' => 'cancelled']);
    }
}
