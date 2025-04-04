<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('doctor')
            ->where('patient_id', auth()->id())
            ->where('appointment_datetime', '>=', now())
            ->orderBy('appointment_datetime')
            ->get();

        return view('dashboard', compact('appointments'));
    }
}
