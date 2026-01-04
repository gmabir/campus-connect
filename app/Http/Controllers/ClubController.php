<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    // 1️⃣ List all clubs
    public function index()
    {
        $clubs = Club::latest()->get();

        $joinedClubIds = ClubMember::where('user_id', Auth::id())
            ->pluck('club_id')
            ->toArray();

        return view('clubs.index', compact('clubs', 'joinedClubIds'));
    }

    // 2️⃣ Admin create form
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can create clubs.');
        }

        return view('clubs.create');
    }

    // 3️⃣ Store club (Admin only)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Club::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('clubs.index')->with('success', 'Club created!');
    }

    // 4️⃣ Student join club
    public function join($clubId)
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Only students can join clubs.');
        }

        ClubMember::firstOrCreate([
            'club_id' => $clubId,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Joined club!');
    }

    // 5️⃣ Student leave club
    public function leave($clubId)
    {
        ClubMember::where('club_id', $clubId)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Left club.');
    }

    // 6️⃣ Admin view members
    public function members($clubId)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $club = Club::findOrFail($clubId);

        $members = ClubMember::where('club_id', $clubId)->latest()->get();

        return view('clubs.members', compact('club', 'members'));
    }
}
