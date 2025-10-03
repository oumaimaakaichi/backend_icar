<?php

namespace App\Http\Controllers;

use App\Models\Specialisation;
use Illuminate\Http\Request;

class SpecialisationController extends Controller
{
    public function index()
    {
        $specialisations = Specialisation::latest()->paginate(6);
        return view('Categories.specialisation', compact('specialisations'));
    }

    public function create()
    {
        return view('specialisation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_specialite' => 'required|string|max:255|unique:specialisations'
        ]);

        Specialisation::create($request->all());

        return redirect()->route('specialisation.index')
                         ->with('success', 'Specialization created successfully');
    }

    public function edit(Specialisation $specialisation)
    {
        return view('specialisation.edit', compact('specialisation'));
    }

    public function update(Request $request, Specialisation $specialisation)
    {
        $request->validate([
            'nom_specialite' => 'required|string|max:255|unique:specialisations,nom_specialite,'.$specialisation->id
        ]);

        $specialisation->update($request->all());

        return redirect()->route('specialisation.index')
                         ->with('success', 'Specialization updated successfully');
    }

    public function destroy(Specialisation $specialisation)
    {
        $specialisation->delete();

        return redirect()->route('specialisation.index')
                         ->with('success', 'Specialization deleted successfully');
    }

    public function toggleVisibility(Specialisation $specialisation)
    {
        $specialisation->update(['is_visible' => !$specialisation->is_visible]);

        return back()->with('success', 'Visibility updated successfully');
    }
}
