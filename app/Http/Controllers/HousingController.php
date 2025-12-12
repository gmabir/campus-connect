<?php

namespace App\Http\Controllers;

use App\Models\HousingListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HousingController extends Controller
{
    // 1. Show the Housing Board
    public function index()
    {
        // Get latest posts first
        $listings = HousingListing::latest()->get();
        return view('housing.index', compact('listings'));
    }

    // 2. Show the "Post Ad" Form
    public function create()
    {
        return view('housing.create');
    }

    // 3. Save the Ad
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rent_amount' => 'required|numeric',
            'location' => 'required|string',
            'contact_phone' => 'required|string',
        ]);

        // Manual Save
        $listing = new HousingListing();
        $listing->user_id = Auth::id(); // Link to the student who posted
        $listing->title = $request->title;
        $listing->description = $request->description;
        $listing->rent_amount = $request->rent_amount;
        $listing->location = $request->location;
        $listing->contact_phone = $request->contact_phone;
        $listing->save();

        return redirect()->route('housing.index')->with('success', 'Ad Posted Successfully!');
    }

    // 4. Delete Ad (Secure: Only Owner can delete)
    public function destroy($id)
    {
        $listing = HousingListing::find($id);

        // Security Check: Is the logged-in user the owner?
        if (Auth::id() !== $listing->user_id) {
            abort(403, 'You can only delete your own posts.');
        }

        $listing->delete();
        return redirect()->route('housing.index')->with('success', 'Ad Removed.');
    }
}