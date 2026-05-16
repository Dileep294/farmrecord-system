<?php

namespace App\Http\Controllers;

use App\Models\Livestock;
use App\Models\Owner;
use App\Models\Trade;
use App\Models\Vaccination;
use Illuminate\Http\Request;

class LivestockController extends Controller
{
    public function index()
    {
        $livestock = Livestock::forUser()->latest()->paginate(10);
        return view('livestock.index', compact('livestock'));
    }

    public function create()
    {
        $owners = auth()->user()->canSeeAllData()
            ? Owner::all()
            : Owner::where('user_id', auth()->id())->get();

        return view('livestock.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tag_number' => 'required|unique:mongodb.livestock',
            'species'    => 'required',
            'breed'      => 'required',
            'age'        => 'required|integer|min:0',
            'owner_id'   => 'required',
        ]);

        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('livestock', 'public');
        }

        Livestock::create([
            'user_id'    => auth()->id(),
            'owner_id'   => $request->owner_id,
            'tag_number' => $request->tag_number,
            'species'    => $request->species,
            'breed'      => $request->breed,
            'age'        => $request->age,
            'colour'     => $request->colour,
            'status'     => 'active',
            'photo'      => $photo,
        ]);

        return redirect()->route('livestock.index')
            ->with('success', 'Animal registered successfully.');
    }

    public function show($id)
    {
        $animal       = $this->findOwned($id);
        $vaccinations = Vaccination::where('livestock_id', $id)->latest()->get();
        $history      = Trade::where('livestock_id', $id)->latest()->get();
        $owners       = Owner::all();
        return view('livestock.show', compact('animal', 'vaccinations', 'history', 'owners'));
    }

    public function edit($id)
    {
        $animal = $this->findOwned($id);
        $owners = auth()->user()->canSeeAllData()
            ? Owner::all()
            : Owner::where('user_id', auth()->id())->get();

        return view('livestock.edit', compact('animal', 'owners'));
    }

    public function update(Request $request, $id)
    {
        $animal = $this->findOwned($id);

        $request->validate([
            'tag_number' => 'required',
            'species'    => 'required',
            'breed'      => 'required',
        ]);

        $animal->update([
            'tag_number' => $request->tag_number,
            'species'    => $request->species,
            'breed'      => $request->breed,
            'age'        => $request->age,
            'colour'     => $request->colour,
            'status'     => $request->status,
        ]);

        return redirect()->route('livestock.index')
            ->with('success', 'Animal updated successfully.');
    }

    public function destroy($id)
    {
        $animal = $this->findOwned($id);
        $animal->delete();
        return redirect()->route('livestock.index')
            ->with('success', 'Animal deleted.');
    }

    public function transfer(Request $request, $id)
    {
        $request->validate([
            'new_owner_id' => 'required',
            'price'        => 'nullable|numeric',
        ]);

        $animal = Livestock::findOrFail($id);

        Trade::create([
            'user_id'       => auth()->id(),
            'livestock_id'  => $id,
            'from_owner_id' => $animal->owner_id,
            'to_owner_id'   => $request->new_owner_id,
            'transfer_date' => now(),
            'price'         => $request->price ?? 0,
            'notes'         => $request->notes,
        ]);

        $animal->update([
            'owner_id' => $request->new_owner_id,
            'status'   => 'transferred',
        ]);

        return redirect()->route('livestock.show', $id)
            ->with('success', 'Ownership transferred successfully.');
    }

    private function findOwned($id)
    {
        $animal = Livestock::findOrFail($id);

        if (auth()->user()->isFarmer() && $animal->user_id !== auth()->id()) {
            abort(403, 'You do not have access to this record.');
        }

        return $animal;
    }
}