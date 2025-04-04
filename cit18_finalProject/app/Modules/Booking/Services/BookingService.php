<?php

namespace App\Modules\Booking\Services;

use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\User;

class BookingService
{
    public function createAppointment(array $data)
    {
        $appointmentDateTime = Carbon::parse($data['appointment_date'] . ' ' . $data['appointment_time']);

        return Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $data['doctor_id'],
            'appointment_datetime' => $appointmentDateTime,
            'type' => $data['appointment_type'],
            'reason' => $data['reason'],
            'notes' => $data['notes'] ?? null,
            'status' => 'pending'
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
        // We can implement this later to get doctor's working days
        return User::findOrFail($doctorId)->is_available;
    }
}
