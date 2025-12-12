<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LostItemController extends Controller
{
    // 1. Show the Board
    public function index()
    {
        // Show "Lost" items first, then "Found" items
        $items = LostItem::orderBy('status', 'desc')->latest()->get();
        return view('lost-found.index', compact('items'));
    }

    // 2. Show Create Form
    public function create()
    {
        return view('lost-found.create');
    }

    // 3. Save the Item
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string',
            'description' => 'required|string',
            'contact_phone' => 'required|string',
        ]);

        $item = new LostItem();
        $item->user_id = Auth::id();
        $item->item_name = $request->item_name;
        $item->description = $request->description;
        $item->contact_phone = $request->contact_phone;
        $item->status = 'Lost'; // Default status
        $item->save();

        return redirect()->route('lost-found.index')->with('success', 'Item Reported.');
    }

    // 4. Mark as Found (Update Status)
    public function markAsFound($id)
    {
        $item = LostItem::find($id);

        // Security: Only the owner can mark it as found
        if (Auth::id() !== $item->user_id) {
            abort(403, 'Unauthorized.');
        }

        $item->status = 'Found';
        $item->save();

        return redirect()->back()->with('success', 'Great! Item marked as found.');
    }

    // 5. Delete Item
    public function destroy(LostItem $lost_found)
    {
        if (Auth::id() === $lost_found->user_id) {
            $lost_found->delete();
        }
        return redirect()->route('lost-found.index')->with('success', 'Item Removed.');
    }
}