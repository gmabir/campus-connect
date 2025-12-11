<?php

namespace App\Http\Controllers;

use App\Models\CafeteriaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CafeteriaController extends Controller
{
    // 1. Show Menu (Visible to Everyone)
    public function index()
    {
        $items = CafeteriaItem::all();
        return view('cafeteria.index', compact('items'));
    }

    // 2. Show "Add Item" Form (Cafe Owner Only)
    public function create()
    {
        if (Auth::user()->role !== 'cafe_owner') {
            abort(403, 'Only the Cafe Manager can add items.');
        }
        return view('cafeteria.create');
    }

    // 3. Save the Item (Cafe Owner Only)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'cafe_owner') {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
        ]);

        $item = new CafeteriaItem();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->category = $request->category;
        $item->is_available = true;
        $item->save();

        return redirect()->route('cafeteria.index')->with('success', 'Item Added to Menu!');
    }
}