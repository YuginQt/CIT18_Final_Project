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
        try {
            $this->bookingService->cancelAppointment($appointment);
            
            return response()->json([
                'success' => true,
                'message' => 'Appointment cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel appointment'
            ], 500);
        }
    }

    public function approve(Appointment $appointment)
    {
        // Check if the user is a doctor
        if (auth()->user()->role !== 'doctor') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Check if the appointment belongs to this doctor
        if ($appointment->doctor_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $result = $this->bookingService->approveAppointment($appointment);
        
        return response()->json($result);
    }
}
