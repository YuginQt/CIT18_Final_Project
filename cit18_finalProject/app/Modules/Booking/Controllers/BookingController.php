<?php

namespace App\Modules\Booking\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Booking\Services\BookingService;
use Illuminate\Http\Request;
use App\Models\Appointment;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function create()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('booking.book-appointment', compact('doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_datetime' => 'required|date|after:now',
            'type' => 'required|string',
            'reason' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $appointmentData = array_merge($validated, [
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);

        $appointment = Appointment::create($appointmentData);

        return redirect()->route('dashboard')
            ->with('success', 'Appointment booked successfully!');
    }
}
