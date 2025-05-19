<?php

namespace App\Http\Controllers;

use App\Models\Camion;
use App\Models\User;
use Illuminate\Http\Request;

class CamionController extends Controller
{
    public function index()
    {
        $camions = Camion::all();
        $techniciens = User::where('role', 'technicien')->get(); // Récupérer tous les techniciens
        return view('Admin.camion', compact('camions', 'techniciens'));
    }

    // Afficher le formulaire d'ajout d'un camion
    public function create()
    {
        return view('camions.create');
    }

    // Enregistrer un nouveau camion
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_camion' => 'required|string|max:255',
            'techniciens' => 'required|array',
            'techniciens.*' => 'exists:users,id',
            'type_camion' => 'required|string',
            'emplacement' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'lien_map' => 'required|url',
            'nom_entreprise' => 'required|string',
            'date_accord' => 'required|date',
            'direction' => 'required|string|in:Nord,Sud,Est,Ouest', // Limitez les valeurs possibles
        ]);

        try {
            $camion = Camion::create($validated);

            // Attacher les techniciens
            $camion->techniciens()->attach($request->techniciens);

            return redirect()->route('camions.index')
                             ->with('success', 'Camion ajouté avec succès');

        } catch (\Exception $e) {
            return back()->withInput()
                         ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
    // Afficher les détails d'un camion
    public function show($id)
    {
        // Récupérer le camion par son ID
        $camion = Camion::find($id);

        // Vérifier si le camion existe
        if (!$camion) {
            return redirect()->route('camions.index')->with('error', 'Camion non trouvé');
        }

        // Passer le camion à la vue
        return view('show', compact('camion'));
    }

    // Afficher le formulaire de modification d'un camion
    public function edit(Camion $camion)
    {
        return view('camions.edit', compact('camion'));
    }

    // Mettre à jour un camion
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_camion' => 'required|string|max:255',
            'type_camion' => 'required|string',
            'emplacement' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'lien_map' => 'required|url',
            'nom_entreprise' => 'required|string',
            'date_accord' => 'required|date',
            'direction' => 'required|string',
        ]);

        $camion = Camion::findOrFail($id);
        $camion->update($request->all());

        return redirect()->back()->with('success', 'Camion mis à jour avec succès.');
    }


    // Supprimer un camion
    public function destroy(Camion $camion)
    {
        $camion->delete();
        return redirect()->route('camions.index')->with('success', 'Camion supprimé avec succès.');
    }
}
