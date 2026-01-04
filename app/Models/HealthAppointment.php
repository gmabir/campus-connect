<?php

namespace App\Http\Controllers;

use App\Models\HealthAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthAppointmentController extends Controller
{
    // 1) Index: Student sees own, Medical/Admin sees all
    public function index()
    {
        $role = Auth::user()->role;

        if ($role === 'medical' || $role === 'admin') {
            $appointments = HealthAppointment::latest()->get();
        } else {
            $appointments = HealthAppointment::where('user_id', Auth::id())->latest()->get();
        }

        return view('health.index', compact('appointments'));
    }

    // 2) Create form (Student/any user)
    public function create()
    {
        return view('health.create');
    }

    // 3) Store appointment request
    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string|max:50',
            'reason' => 'nullable|string|max:255',
        ]);

        HealthAppointment::create([
            'user_id' => Auth::id(),
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('health.index')->with('success', 'Appointment requested!');
    }

    // 4) Update status (Medical/Admin only)
    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'medical' && Auth::user()->role !== 'admin') {
            abort(403, 'Only medical staff or admin can update appointments.');
        }

        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,completed',
            'doctor_note' => 'nullable|string|max:255',
        ]);

        $appt = HealthAppointment::findOrFail($id);
        $appt->status = $request->status;
        $appt->doctor_note = $request->doctor_note;
        $appt->save();

        return redirect()->back()->with('success', 'Appointment updated.');
    }

    // 5) Student can delete/cancel their pending request (optional)
    public function destroy(HealthAppointment $health)
    {
        // Only owner can cancel, and only if pending
        if (Auth::id() !== $health->user_id) {
            abort(403, 'Unauthorized.');
        }

        if ($health->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending requests can be canceled.');
        }

        $health->delete();
        return redirect()->route('health.index')->with('success', 'Appointment request canceled.');
    }
}
