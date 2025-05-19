<?php

namespace App\Http\Controllers;

use App\Models\Couleur;
use Illuminate\Http\Request;

class CouleurController extends Controller
{
    public function index()
    {
        $couleurs = Couleur::paginate(6);
        return view('Categories.couleurs', compact('couleurs'));
    }
    public function indexMobile()
    {
        $couleurs = Couleur::all(); // ou paginate() si vous voulez la pagination
        return response()->json($couleurs);
    }
    public function create()
    {
        return view('couleurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_couleur' => 'required|string|max:255',

        ]);

        Couleur::create($request->all());

        return redirect()->route('couleur.index')
                         ->with('success', 'Couleur créée avec succès');
    }

    public function show(Couleur $couleur)
    {
        return view('couleurs.show', compact('couleur'));
    }

    public function edit(Couleur $couleur)
    {
        return view('couleurs.edit', compact('couleur'));
    }

    public function update(Request $request, Couleur $couleur)
    {
        $request->validate([
            'nom_couleur' => 'required|string|max:255',
            'is_visible' => 'boolean'
        ]);

        $couleur->update($request->all());

        return redirect()->route('couleur.index')
                         ->with('success', 'Couleur mise à jour avec succès');
    }

    public function destroy(Couleur $couleur)
    {
        $couleur->delete();

        return redirect()->route('couleur.index')
                         ->with('success', 'Couleur supprimée avec succès');
    }

    public function toggleVisibility(Couleur $couleur)
    {
        $couleur->update(['is_visible' => !$couleur->is_visible]);
        return back()->with('success', 'Visibilité modifiée avec succès');
    }
}
