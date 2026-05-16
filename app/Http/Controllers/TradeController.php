<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\Livestock;
use App\Models\Owner;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Trade::forUser()->latest()->paginate(10);
        return view('trades.index', compact('trades'));
    }

    public function create()
    {
        $animals = Livestock::forUser()->get();
        $owners  = Owner::all();
        return view('trades.create', compact('animals', 'owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'livestock_id' => 'required',
            'to_owner_id'  => 'required',
        ]);

        $animal = Livestock::findOrFail($request->livestock_id);

        if (auth()->user()->isFarmer() && $animal->user_id !== auth()->id()) {
            abort(403);
        }

        Trade::create([
            'user_id'       => auth()->id(),
            'livestock_id'  => $request->livestock_id,
            'from_owner_id' => $animal->owner_id,
            'to_owner_id'   => $request->to_owner_id,
            'transfer_date' => now(),
            'price'         => $request->price ?? 0,
            'notes'         => $request->notes,
        ]);

        $animal->update([
            'owner_id' => $request->to_owner_id,
            'status'   => 'transferred',
        ]);

        return redirect()->route('trades.index')
            ->with('success', 'Trade recorded.');
    }

    public function show($id)
    {
        $trade = Trade::findOrFail($id);
        if (auth()->user()->isFarmer() && $trade->user_id !== auth()->id()) {
            abort(403);
        }
        return view('trades.show', compact('trade'));
    }

    public function destroy($id)
    {
        $trade = Trade::findOrFail($id);
        if (auth()->user()->isFarmer() && $trade->user_id !== auth()->id()) {
            abort(403);
        }
        $trade->delete();
        return redirect()->route('trades.index')
            ->with('success', 'Trade deleted.');
    }

    public function edit($id) { abort(404); }
    public function update(Request $request, $id) { abort(404); }
}