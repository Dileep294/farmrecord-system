<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Livestock;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::latest()->paginate(10);
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
            'user_id' => auth()->id(),
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
        $owner     = Owner::findOrFail($id);
        $livestock = Livestock::where('owner_id', $id)->get();
        return view('owners.show', compact('owner', 'livestock'));
    }

    public function edit($id)
    {
        $owner = Owner::findOrFail($id);
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);
        $owner->update($request->only(['name','nic','phone','email','address']));
        return redirect()->route('owners.index')
            ->with('success', 'Owner updated.');
    }

    public function destroy($id)
    {
        Owner::findOrFail($id)->delete();
        return redirect()->route('owners.index')
            ->with('success', 'Owner deleted.');
    }
}