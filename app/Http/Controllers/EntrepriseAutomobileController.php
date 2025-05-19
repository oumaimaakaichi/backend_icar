<?php

namespace App\Http\Controllers;

use App\Models\EntrepriseAutomobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EntrepriseAutomobileController extends Controller
{
    //select
    public function index()
    {
        $entreprises = EntrepriseAutomobile::latest()->paginate(6);
        return view('Categories.entrepriseAutomobile', compact('entreprises'));
    }
     //create
     public function getAllEntreprisesWithVoitures()
    {
        $entreprises = EntrepriseAutomobile::all()->map(function($entreprise) {
            return [
                'id' => $entreprise->id,
                'entreprise' => $entreprise->entreprise,
                'logo' => $entreprise->logo ? asset('storage/' . $entreprise->logo) : null,
                'voitures' => $entreprise->voitures ?? []
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $entreprises
        ]);
    }
    public function create()
    {
        return view('entreprises.create');
    }
    //store
    public function store(Request $request)
    {
        $request->validate([
            'entreprise' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->only(['entreprise', 'pays']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        EntrepriseAutomobile::create($data);

        return redirect()->route('entrepriseAutomobile.index')
                         ->with('success', 'Entreprise créée avec succès');
    }
    // show by id
    public function show(EntrepriseAutomobile $entrepriseAutomobile)
    {
        return view('Categories.entrepriseAutomobileShow', compact('entrepriseAutomobile'));
    }
    //edit
    public function edit(EntrepriseAutomobile $entrepriseAutomobile)
    {
        return view('entrepriseAutomobile.edit', compact('entrepriseAutomobile'));
    }
    //update
    public function update(Request $request, EntrepriseAutomobile $entrepriseAutomobile)
    {
        $request->validate([
            'entreprise' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->only(['entreprise', 'pays']);

        if ($request->hasFile('logo')) {
            if ($entrepriseAutomobile->logo) {
                Storage::disk('public')->delete($entrepriseAutomobile->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $entrepriseAutomobile->update($data);

        return redirect()->route('entrepriseAutomobile.index')
                         ->with('success', 'Entreprise mise à jour avec succès');
    }
    //delete
    public function destroy(EntrepriseAutomobile $entrepriseAutomobile)
    {
        if ($entrepriseAutomobile->logo) {
            Storage::disk('public')->delete($entrepriseAutomobile->logo);
        }

        $entrepriseAutomobile->delete();

        return redirect()->route('entrepriseAutomobile.index')
                         ->with('success', 'Entreprise supprimée avec succès');
    }
    //ajouter voiture a l'entreprise
    public function addVoiture(Request $request, EntrepriseAutomobile $entreprise)
    {
        $request->validate([
            'nom_voiture' => 'required|string|max:255'
        ]);

        $entreprise->addVoiture($request->nom_voiture);

        return redirect()->route('entrepriseAutomobile.show', $entreprise->id)
                         ->with('success', 'Voiture ajoutée avec succès');
    }
    //supprimer une voiture
    public function removeVoiture(EntrepriseAutomobile $entreprise, $index)
    {
        $voitures = $entreprise->voitures ?? [];

        if (isset($voitures[$index])) {
            array_splice($voitures, $index, 1);
            $entreprise->voitures = $voitures;
            $entreprise->save();

            return redirect()->route('entrepriseAutomobile.show', $entreprise->id)
                             ->with('success', 'Voiture supprimée avec succès');
        }

        return redirect()->route('entrepriseAutomobile.show', $entreprise->id)
                         ->with('error', 'Voiture introuvable');
    }
}
