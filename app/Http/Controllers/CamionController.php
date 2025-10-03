<?php

namespace App\Http\Controllers;

use App\Models\Camion;
use App\Models\User;
use Illuminate\Http\Request;

class CamionController extends Controller
{
    public function index()
    {
        $camions = Camion::with('techniciens')->get(); // Charger les relations
        $techniciens = User::where('role', 'technicien')->get();
        return view('Admin.camion', compact('camions', 'techniciens'));
    }

    public function create()
    {
        return view('camions.create');
    }

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
        'direction' => 'required|string|in:Nord,Sud,Est,Ouest',
    ]);

    try {
        // Extraire les techniciens avant de créer le camion
        $techniciens = $validated['techniciens'];
        unset($validated['techniciens']);

        // Créer le camion
        $camion = Camion::create($validated);

        // Attacher les techniciens
        $camion->techniciens()->attach($techniciens);

        return redirect()->route('camions.index')
                         ->with('success', 'Truck added successfully');

    } catch (\Exception $e) {
        return back()->withInput()
                     ->withErrors(['error' => 'Erreur: ' . $e->getMessage()]);
    }
}

    public function show($id)
    {
        $camion = Camion::with('techniciens')->find($id);

        if (!$camion) {
            return redirect()->route('camions.index')->with('error', 'Camion non trouvé');
        }

        return view('show', compact('camion'));
    }

    public function edit(Camion $camion)
    {
        $techniciens = User::where('role', 'technicien')->get();
        return view('camions.edit', compact('camion', 'techniciens'));
    }

    public function update(Request $request, $id)
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
            'direction' => 'required|string|in:Nord,Sud,Est,Ouest',
        ]);

        try {
            $camion = Camion::findOrFail($id);
            $camion->update($validated);
            $camion->techniciens()->sync($request->techniciens);

            return redirect()->back()->with('success', 'Truck successfully updated.');

        } catch (\Exception $e) {
            return back()->withInput()
                         ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

  public function destroy($id)
{
    $camion = Camion::findOrFail($id);
    $camion->delete();

    return redirect()->route('camions.index')
        ->with('success', 'Truk deleted successfully.');
}

}
