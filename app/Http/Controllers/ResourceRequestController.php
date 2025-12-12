<?php

namespace App\Http\Controllers;

use App\Models\ResourceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceRequestController extends Controller
{
    // 1. List Requests (Admin sees all, Faculty sees their own)
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $requests = ResourceRequest::latest()->get();
        } elseif ($user->role === 'teacher') {
            $requests = ResourceRequest::where('user_id', $user->id)->latest()->get();
        } else {
            abort(403, 'Students cannot access this page.');
        }

        return view('resources.index', compact('requests'));
    }

    // 2. Show Form (Faculty Only)
    public function create()
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Only Faculty can make requests.');
        }
        return view('resources.create');
    }

    // 3. Save Request
    public function store(Request $request)
    {
        $request->validate([
            'item_needed' => 'required|string',
            'quantity' => 'required|integer',
            'needed_date' => 'required|date',
        ]);

        $res = new ResourceRequest();
        $res->user_id = Auth::id();
        $res->item_needed = $request->item_needed;
        $res->quantity = $request->quantity;
        $res->needed_date = $request->needed_date;
        $res->status = 'Pending';
        $res->save();

        return redirect()->route('resources.index')->with('success', 'Request sent to Admin.');
    }

    // 4. Update Status (Admin Only)
    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $res = ResourceRequest::find($id);
        $res->status = $request->status; // Approved, Denied, Delivered
        $res->save();

        return redirect()->back()->with('success', 'Status updated.');
    }
}