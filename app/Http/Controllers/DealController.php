<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    // 1. List all deals (Visible to Everyone: Students, Teachers, etc.)
    public function index()
    {
        // Get newest deals first
        $deals = Deal::latest()->get();
        return view('deals.index', compact('deals'));
    }

    // 2. Show Create Form (Cafe Owner Only)
    public function create()
    {
        // Security Check: Block anyone who is NOT a cafe_owner
        if (Auth::user()->role !== 'cafe_owner') {
            abort(403, 'Only Cafe Owners can post deals.');
        }
        return view('deals.create');
    }

    // 3. Store the Deal (Cafe Owner Only)
    public function store(Request $request)
    {
        // Security Check
        if (Auth::user()->role !== 'cafe_owner') {
            abort(403, 'Unauthorized action.');
        }

        // Validate Inputs
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'promo_code' => 'nullable|string',
        ]);

        // Manual Save
        $deal = new Deal();
        $deal->title = $request->title;
        $deal->description = $request->description;
        $deal->promo_code = $request->promo_code;
        $deal->save();

        return redirect()->route('deals.index')->with('success', 'Deal Posted Successfully!');
    }

    // 4. Delete a Deal (Cafe Owner Only)
    public function destroy(Deal $deal)
    {
        // Security Check
        if (Auth::user()->role === 'cafe_owner') {
            $deal->delete();
            return redirect()->route('deals.index')->with('success', 'Deal Removed.');
        }

        return redirect()->route('deals.index')->with('error', 'You are not authorized to delete this.');
    }
}