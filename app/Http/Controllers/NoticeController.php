<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    // 1) Show all notices (visible to all logged users)
    public function index()
    {
        // show latest first; optionally ignore expired
        $notices = Notice::latest()->get();

        return view('notices.index', compact('notices'));
    }

    // 2) Admin create form
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can publish notices.');
        }

        return view('notices.create');
    }

    // 3) Store notice (Admin only)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|string|in:normal,important,emergency',
            'expires_on' => 'nullable|date',
        ]);

        Notice::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'message' => $request->message,
            'priority' => $request->priority,
            'expires_on' => $request->expires_on,
        ]);

        return redirect()->route('notices.index')->with('success', 'Notice published!');
    }

    // 4) Delete notice (Admin only)
    public function destroy(Notice $notice)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $notice->delete();

        return redirect()->route('notices.index')->with('success', 'Notice deleted.');
    }
}
