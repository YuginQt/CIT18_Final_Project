<?php

namespace App\Modules\Booking\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Booking\Services\BookingService;
use Illuminate\Http\Request;

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
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'appointment_type' => 'required|in:consultation,follow_up,check_up,emergency',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500'
        ]);

        $this->bookingService->createAppointment($validated);
        return redirect()->route('dashboard')->with('success', 'Appointment booked successfully!');
    }
}
