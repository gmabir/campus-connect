<?php

namespace App\Http\Controllers;

use App\Models\OfficeHourSlot;
use App\Models\OfficeHourBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficeHourController extends Controller
{
    // 1) Show slots
    public function index()
    {
        $role = Auth::user()->role;

        // Student: show all teachers' slots
        // Teacher: show own slots
        // Admin: show all
        if ($role === 'teacher') {
            $slots = OfficeHourSlot::where('teacher_id', Auth::id())->latest()->get();
        } else {
            $slots = OfficeHourSlot::latest()->get();
        }

        // Current user's bookings for button state
        $myBookings = OfficeHourBooking::where('student_id', Auth::id())
            ->pluck('slot_id')
            ->toArray();

        // booking counts per slot (capacity display)
        $bookingCounts = OfficeHourBooking::selectRaw('slot_id, COUNT(*) as total')
            ->groupBy('slot_id')
            ->pluck('total', 'slot_id');

        return view('office-hours.index', compact('slots', 'myBookings', 'bookingCounts'));
    }

    // 2) Teacher create form
    public function create()
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Only teachers can create office hour slots.');
        }

        return view('office-hours.create');
    }

    // 3) Teacher store slot
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'slot_date' => 'required|date',
            'slot_time' => 'required|string|max:50',
            'location' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1|max:20',
        ]);

        OfficeHourSlot::create([
            'teacher_id' => Auth::id(),
            'slot_date' => $request->slot_date,
            'slot_time' => $request->slot_time,
            'location' => $request->location,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('office-hours.index')->with('success', 'Office hour slot created!');
    }

    // 4) Student book a slot
    public function book(Request $request, $slotId)
    {
        $role = Auth::user()->role;

        if ($role !== 'student') {
            abort(403, 'Only students can book office hours.');
        }

        $request->validate([
            'note' => 'nullable|string|max:255',
        ]);

        $slot = OfficeHourSlot::findOrFail($slotId);

        // capacity check
        $count = OfficeHourBooking::where('slot_id', $slot->id)->count();
        if ($count >= $slot->capacity) {
            return redirect()->back()->with('error', 'This slot is already full.');
        }

        $already = OfficeHourBooking::where('slot_id', $slot->id)
            ->where('student_id', Auth::id())
            ->exists();

        if ($already) {
            return redirect()->back()->with('success', 'You already booked this slot.');
        }

        OfficeHourBooking::create([
            'slot_id' => $slot->id,
            'student_id' => Auth::id(),
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Booking confirmed!');
    }

    // 5) Student cancel booking
    public function cancel($slotId)
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Only students can cancel bookings.');
        }

        OfficeHourBooking::where('slot_id', $slotId)
            ->where('student_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Booking canceled.');
    }

    // 6) Teacher view bookings for a slot
    public function bookings($slotId)
    {
        $slot = OfficeHourSlot::findOrFail($slotId);

        if (Auth::user()->role !== 'teacher' && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        // Teacher can only view their own slot
        if (Auth::user()->role === 'teacher' && $slot->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $bookings = OfficeHourBooking::where('slot_id', $slot->id)->latest()->get();

        return view('office-hours.bookings', compact('slot', 'bookings'));
    }

    // 7) Teacher delete slot (also deletes bookings due to cascade)
    public function destroy(OfficeHourSlot $office_hour)
    {
        if (Auth::user()->role !== 'teacher' && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        if (Auth::user()->role === 'teacher' && $office_hour->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $office_hour->delete();

        return redirect()->route('office-hours.index')->with('success', 'Slot deleted.');
    }
}
