<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Livestock;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        // Farmer sees only their own owners
        // Admin/Authority sees all
        if (auth()->user()->isFarmer()) {
            $owners = Owner::where('user_id', (string) auth()->id())->paginate(10);
        } else {
            $owners = Owner::latest()->paginate(10);
        }

        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'nic'   => 'required',
            'phone' => 'required',
        ]);

        Owner::create([
            'user_id' => (string) auth()->id(),
            'name'    => $request->name,
            'nic'     => $request->nic,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'address' => $request->address,
        ]);

        return redirect()->route('owners.index')
            ->with('success', 'Owner registered.');
    }

    public function show($id)
    {
        $owner = Owner::findOrFail($id);

        // Farmer can only view their own owners
        if (auth()->user()->isFarmer() && $owner->user_id !== (string) auth()->id()) {
            abort(403);
        }

        $livestock = Livestock::where(function($query) use ($id, $owner) {
            $query->where('owner_id', (string) $owner->id)
                  ->orWhere('owner_id', $id);
        })->get();

        return view('owners.show', compact('owner', 'livestock'));
    }

    public function edit($id)
    {
        $owner = Owner::findOrFail($id);

        if (auth()->user()->isFarmer() && $owner->user_id !== (string) auth()->id()) {
            abort(403);
        }

        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);

        if (auth()->user()->isFarmer() && $owner->user_id !== (string) auth()->id()) {
            abort(403);
        }

        $owner->update($request->only(['name', 'nic', 'phone', 'email', 'address']));
        return redirect()->route('owners.index')
            ->with('success', 'Owner updated.');
    }

    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);

        if (auth()->user()->isFarmer() && $owner->user_id !== (string) auth()->id()) {
            abort(403);
        }

        $owner->delete();
        return redirect()->route('owners.index')
            ->with('success', 'Owner deleted.');
    }
}