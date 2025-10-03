<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{

    //afficher une ville
    public function index()
{
    $villes = Ville::paginate(6);  // Pagination de 6 villes par page
    return view('Categories.ville', compact('villes'));
}
public function show(Ville $ville)
{
    return view('ville.show', compact('ville'));
}
  //creer une ville
    public function create()
    {
        return view('ville.create');
    }
    //enregistrer ue ville
    public function store(Request $request)
    {
        $request->validate([
            'nomville' => 'required|string|max:255|unique:villes',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
        ]);

        Ville::create($request->all());

        return redirect()->route('ville.index')
                         ->with('success', 'City created successfully');
    }

    public function edit(Ville $ville)
    {
        return view('ville.edit', compact('ville'));
    }
 //modifier une ville
    public function update(Request $request, Ville $ville)
    {
        $request->validate([
            'nomville' => 'required|string|max:255|unique:villes,nomville,'.$ville->id,
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
        ]);

        $ville->update($request->all());

        return redirect()->route('ville.index')
                         ->with('success', 'City updated successfully');
    }
 //supprimer une ville
    public function destroy(Ville $ville)
    {
        $ville->delete();

        return redirect()->route('ville.index')
                         ->with('success', 'City deleted successfully');
    }
    public function toggleVisibility(Ville $ville)
{
    $ville->update(['is_visible' => !$ville->is_visible]);

    return back()->with('success', 'Visibility updated successfully');
}
}
