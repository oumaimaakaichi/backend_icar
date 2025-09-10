<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    // Afficher la liste des catalogues
    public function index()
    {
        $catalogues = Catalogue::all();
        return view('Admin.catalogue', compact('catalogues'));
    }


    // Afficher le formulaire de création
    public function create()
    {
        return view('catalogues.create');
    }

    // Enregistrer un nouveau catalogue
  // Enregistrer un nouveau catalogue
public function store(Request $request)
{
    $request->validate([
        'entreprise' => 'required|string',
        'type_voiture' => 'required|string',
        'nom_piece' => 'required|string',
        'num_piece' => 'required|integer',
        'paye_fabrication' => 'required|string',
        'prix' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'photo_piece' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $photoPath = $request->hasFile('photo_piece')
        ? $request->file('photo_piece')->store('catalogues', 'public')
        : null;

    Catalogue::create([
        'entreprise' => $request->entreprise,
        'type_voiture' => $request->type_voiture,
        'nom_piece' => $request->nom_piece,
        'num_piece' => $request->num_piece,
        'paye_fabrication' => $request->paye_fabrication,
        'prix' => $request->prix,
        'stock' => $request->stock,
        'photo_piece' => $photoPath,
    ]);

    return redirect()->route('catalogues.index')->with('success', 'Catalogue ajouté avec succès.');
}

// Mettre à jour un catalogue
public function update(Request $request, Catalogue $catalogue)
{
    $request->validate([
        'entreprise' => 'required|string',
        'type_voiture' => 'required|string',
        'nom_piece' => 'required|string',
        'num_piece' => 'required|integer',
        'paye_fabrication' => 'required|string',
        'prix' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'photo_piece' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('photo_piece')) {
        $catalogue->photo_piece = $request->file('photo_piece')->store('catalogues', 'public');
    }

    $catalogue->update([
        'entreprise' => $request->entreprise,
        'type_voiture' => $request->type_voiture,
        'nom_piece' => $request->nom_piece,
        'num_piece' => $request->num_piece,
        'paye_fabrication' => $request->paye_fabrication,
        'prix' => $request->prix,
        'stock' => $request->stock,
    ]);

    return redirect()->route('catalogues.index')->with('success', 'Catalogue mis à jour avec succès.');
}


    // Afficher les détails d'un catalogue
    public function show(Catalogue $catalogue)
    {
        return view('catalogues.show', compact('catalogue'));
    }

    // Afficher le formulaire d'édition
    public function edit(Catalogue $catalogue)
    {
        return view('catalogues.edit', compact('catalogue'));
    }

  

    // Supprimer un catalogue
    public function destroy(Catalogue $catalogue)
    {
        $catalogue->delete();
        return redirect()->route('catalogues.index')->with('success', 'Catalogue supprimé avec succès.');
    }


    // Ajoutez cette méthode à votre CatalogueController
    public function apiIndex()
    {
        $catalogues = Catalogue::all()->map(function($item) {
            return [
                'id' => $item->id,
                'nom_piece' => $item->nom_piece,
                'type_voiture' => $item->type_voiture,
                'entreprise' => $item->entreprise,
                'num_piece' => $item->num_piece,
                'paye_fabrication' => $item->paye_fabrication,
                'prix' => $item->prix,
                'stock' => $item->stock,
                'photo_piece' => $item->photo_piece
                    ? url('storage/'.$item->photo_piece)
                    : null,
            ];
        });

        return response()->json($catalogues)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
}
