<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use App\Models\Livestock;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    public function index()
    {
        $vaccinations = Vaccination::forUser()->latest()->paginate(10);
        return view('vaccinations.index', compact('vaccinations'));
    }

    public function create()
    {
        $animals = Livestock::forUser()->get();
        return view('vaccinations.create', compact('animals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'livestock_id'    => 'required',
            'vaccine_name'    => 'required',
            'date_given'      => 'required|date',
            'next_due_date'   => 'required|date|after:date_given',
            'administered_by' => 'required',
        ]);

        if (auth()->user()->isFarmer()) {
            Livestock::where('_id', $request->livestock_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        }

        Vaccination::create([
            'user_id'         => auth()->id(),
            'livestock_id'    => $request->livestock_id,
            'vaccine_name'    => $request->vaccine_name,
            'date_given'      => $request->date_given,
            'next_due_date'   => $request->next_due_date,
            'administered_by' => $request->administered_by,
            'notes'           => $request->notes,
        ]);

        return redirect()->route('vaccinations.index')
            ->with('success', 'Vaccination recorded.');
    }

    public function destroy($id)
    {
        $vac = Vaccination::findOrFail($id);

        if (auth()->user()->isFarmer() && $vac->user_id !== auth()->id()) {
            abort(403);
        }

        $vac->delete();
        return redirect()->route('vaccinations.index')
            ->with('success', 'Record deleted.');
    }

    public function show($id) { abort(404); }
    public function edit($id) { abort(404); }
    public function update(Request $request, $id) { abort(404); }
}