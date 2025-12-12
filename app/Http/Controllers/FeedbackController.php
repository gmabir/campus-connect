<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User; // Need this to find teachers
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // 1. Show All Feedback (The "Dashboard" for feedback)
    public function index()
    {
        // Get all feedback, latest first
        $feedbacks = Feedback::latest()->get();
        return view('feedback.index', compact('feedbacks'));
    }

    // 2. Show the Create Form
    public function create()
    {
        // Get list of users who are 'teacher' so we can show them in a dropdown
        $teachers = User::where('role', 'teacher')->get();
        return view('feedback.create', compact('teachers'));
    }

    // 3. Save the Feedback
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        $feedback = new Feedback();
        $feedback->user_id = Auth::id();
        $feedback->type = $request->type;
        $feedback->message = $request->message;
        $feedback->rating = $request->rating;

        // Logic to save the correct Target Name
        if ($request->type === 'teacher') {
            $feedback->target_name = $request->teacher_id; // Selected from dropdown
        } else {
            $feedback->target_name = $request->custom_target; // Typed manually (Course name)
        }

        $feedback->save();

        return redirect()->route('feedback.index')->with('success', 'Feedback Posted!');
    }

    // 4. Delete (Student can delete their own, Admin can delete any)
    public function destroy(Feedback $feedback)
    {
        // Check permission
        if (Auth::id() === $feedback->user_id || Auth::user()->role === 'admin') {
            $feedback->delete();
            return redirect()->back()->with('success', 'Feedback Deleted.');
        }
        
        abort(403, 'Unauthorized');
    }
}