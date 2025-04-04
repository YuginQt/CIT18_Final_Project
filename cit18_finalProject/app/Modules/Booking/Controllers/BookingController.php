<?php

namespace App\Modules\Booking\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Booking\Services\BookingService;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Modules\Booking\Requests\BookingRequest;
use App\Modules\Booking\Requests\RescheduleRequest;

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

    public function reschedule(Appointment $appointment)
    {
        return view('booking.book-appointment', [
            'doctors' => User::where('role', 'doctor')->get(),
            'appointment' => $appointment,
            'isRescheduling' => true
        ]);
    }

    public function store(BookingRequest $request)
    {
        $this->bookingService->createAppointment($request->validated());
        
        return redirect()->route('dashboard')
            ->with('success', 'Appointment booked successfully!');
    }

    public function update(RescheduleRequest $request, Appointment $appointment)
    {
        $this->bookingService->rescheduleAppointment($appointment, $request->appointment_datetime);
        
        return redirect()->route('dashboard')
            ->with('success', 'Appointment rescheduled successfully!');
    }

    public function cancel(Appointment $appointment)
    {
        $this->bookingService->cancelAppointment($appointment);
        
        return redirect()->route('dashboard')
            ->with('success', 'Appointment cancelled successfully!');
    }
}
