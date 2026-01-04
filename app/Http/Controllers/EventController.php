<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // 1) Show all events
    public function index()
    {
        $events = Event::latest()->get();

        // registrations for current user (for "Registered" button state)
        $myRegistrations = EventRegistration::where('user_id', Auth::id())
            ->pluck('event_id')
            ->toArray();

        return view('events.index', compact('events', 'myRegistrations'));
    }

    // 2) Show create form (Admin/Teacher only)
    public function create()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'teacher') {
            abort(403, 'Only Admin/Staff can create events.');
        }

        return view('events.create');
    }

    // 3) Store event (Admin/Teacher only)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'teacher') {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:seminar,workshop,cultural,guest_lecture',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $event = new Event();
        $event->user_id = Auth::id();
        $event->title = $request->title;
        $event->type = $request->type;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->event_date = $request->event_date;
        $event->event_time = $request->event_time;
        $event->capacity = $request->capacity;
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    // 4) Register for an event (Student/Any logged user)
    public function register($id)
    {
        $event = Event::findOrFail($id);

        // capacity check
        if (!is_null($event->capacity)) {
            $count = EventRegistration::where('event_id', $event->id)->count();
            if ($count >= $event->capacity) {
                return redirect()->back()->with('error', 'Event is full.');
            }
        }

        // prevent duplicates (unique constraint also protects)
        $already = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($already) {
            return redirect()->back()->with('success', 'You are already registered.');
        }

        EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Registered successfully!');
    }

    // 5) Unregister (optional but useful)
    public function unregister($id)
    {
        EventRegistration::where('event_id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Registration removed.');
    }

    // 6) Delete event (Creator or Admin)
    public function destroy(Event $event)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $event->user_id) {
            abort(403, 'Unauthorized.');
        }

        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted.');
    }
}
