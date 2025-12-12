<?php

namespace App\Http\Controllers;

use App\Models\BusRoute; // Note: We named the model BusRoute earlier
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportRouteController extends Controller
{
    // 1. Show Schedule (Visible to Everyone)
    public function index()
    {
        $routes = BusRoute::all();
        return view('transport.index', compact('routes'));
    }

    // 2. Show Form (Admin Only)
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only Admin can manage transport.');
        }
        return view('transport.create');
    }

    // 3. Save Route (Admin Only)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'route_name' => 'required|string',
            'schedule_time' => 'required|string',
            'stops_list' => 'required|string',
        ]);

        $route = new BusRoute();
        $route->route_name = $request->route_name;
        $route->schedule_time = $request->schedule_time;
        $route->stops_list = $request->stops_list;
        $route->save();

        return redirect()->route('transport.index')->with('success', 'Route Added!');
    }

    // 4. Delete Route (Admin Only)
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        BusRoute::destroy($id);
        return redirect()->route('transport.index')->with('success', 'Route Deleted.');
    }
}