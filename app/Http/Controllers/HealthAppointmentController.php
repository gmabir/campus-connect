<?php

namespace App\Http\Controllers;

use App\Models\HealthAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthAppointmentController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        
        // Admin/Medical see all, Students see only theirs
        if ($role === 'medical' || $role === 'admin') {
            $appointments = HealthAppointment::with('user')->latest()->get();
        } else {
            $appointments = HealthAppointment::where('user_id', Auth::id())->latest()->get();
        }

        return view('health.index', compact('appointments'));
    }

    public function create()
    {
        return view('health.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'reason' => 'required|string|max:255',
        ]);

        HealthAppointment::create([
            'user_id' => Auth::id(),
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'status' => 'Pending',
        ]);

        return redirect()->route('health.index')->with('success', 'Appointment booked!');
    }

    public function destroy(HealthAppointment $health)
    {
        // Only allow owner or admin to delete
        if (Auth::id() === $health->user_id || Auth::user()->role === 'admin') {
            $health->delete();
            return back()->with('success', 'Appointment cancelled.');
        }
        return back()->with('error', 'Unauthorized.');
    }
}