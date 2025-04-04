<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $upcomingAppointments = Appointment::with(['user', 'doctor'])
            ->orderBy('appointment_datetime')
            ->get();

        $allAppointments = auth()->user()->appointments()
            ->with('doctor')
            ->latest('appointment_datetime')
            ->get();

        return view('dashboard', [
            'appointments' => $allAppointments, 
            'upcomingAppointments' => $upcomingAppointments  
        ]);
    }
}
