<?php

namespace App\Http\Controllers;

use App\Models\EventPhoto;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventPhotoController extends Controller
{
    // 1) Browse gallery
    public function index(Request $request)
    {
        $query = EventPhoto::latest();

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        $photos = $query->get();

        // for dropdown filter + upload selection
        $events = Event::latest()->get();

        return view('gallery.index', compact('photos', 'events'));
    }

    // 2) Upload form
    public function create()
    {
        $events = Event::latest()->get();
        return view('gallery.create', compact('events'));
    }

    // 3) Store upload
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'nullable|integer|exists:events,id',
            'caption' => 'nullable|string|max:255',
            'image' => 'required|image|max:5120', // 5MB
        ]);

        $file = $request->file('image');

        $path = $file->store('gallery/' . Auth::id(), 'public');

        EventPhoto::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'caption' => $request->caption,
            'image_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('gallery.index')->with('success', 'Photo uploaded!');
    }

    // 4) Delete (Owner or Admin)
    public function destroy(EventPhoto $gallery)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $gallery->user_id) {
            abort(403, 'Unauthorized.');
        }

        if (Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->back()->with('success', 'Photo deleted.');
    }
}
