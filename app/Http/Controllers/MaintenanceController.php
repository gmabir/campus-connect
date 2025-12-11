<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    // FUNCTION 1: Show the list of past requests
    public function index()
    {
        // Get all requests created by the CURRENT logged-in user
        $myRequests = MaintenanceRequest::where('user_id', Auth::id())->get();
        
        // Send this data to the 'index' view
        return view('maintenance.index', compact('myRequests'));
    }

    // FUNCTION 2: Show the form to create a new request
    public function create()
    {
        return view('maintenance.create');
    }
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'area' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $report = new MaintenanceRequest();
        $report->user_id = Auth::id();
        $report->area = $request->area;
        $report->description = $request->description;
        $report->status = 'Pending';
        $report->save(); 

        // 3. Redirect
        return redirect()->route('maintenance.index')->with('success', 'Report submitted successfully!');
    }
}