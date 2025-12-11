<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon; // Needed for handling Time

class VisitorController extends Controller
{
    // 1. Show the Visitor Log
    public function index()
    {
        // Get all visitors, ordered by latest entry first
        $visitors = Visitor::orderBy('entry_time', 'desc')->get();
        return view('visitors.index', compact('visitors'));
    }

    // 2. Check In a New Visitor
    public function store(Request $request)
    {
        $request->validate([
            'visitor_name' => 'required|string',
            'purpose' => 'required|string',
            'phone' => 'required|string',
        ]);

        // Manual Save (Safe Method)
        $visitor = new Visitor();
        $visitor->visitor_name = $request->visitor_name;
        $visitor->purpose = $request->purpose;
        $visitor->phone = $request->phone;
        $visitor->entry_time = Carbon::now(); // Current Time
        $visitor->save();

        return redirect()->back()->with('success', 'Visitor Checked In!');
    }

    // 3. Check Out (Update exit time)
    public function checkout($id)
    {
        $visitor = Visitor::find($id);
        
        // Update the exit time
        $visitor->exit_time = Carbon::now();
        $visitor->save();

        return redirect()->back()->with('success', 'Visitor Checked Out!');
    }
}