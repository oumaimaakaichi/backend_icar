<?php

namespace App\Http\Controllers;

use App\Models\EntrepriseContractante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class Entreprise_contractanteController extends Controller
{
    // Afficher toutes les entreprises
    public function index()
    {
        $entreprises = EntrepriseContractante::all();
        return response()->json($entreprises, 200);
    }

    // Créer une entreprise
    public function store(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string',
            'email' => 'required|email|unique:entreprises_contractante,email',
            'password' => 'required|string|min:8|confirmed', // Validation du mot de passe
            'num_unique' => 'required|numeric|unique:entreprises_contractante,num_unique',
            'nom_mandataire' => 'required|string',
            'num_contact' => 'required|string',
            'nbr_ateliers_requis' => 'required|integer',
            'ville' => 'required|string',
            'nbr_employee' => 'required|integer',
            'type_parking' => 'required|string',
            'adresse_entreprise' => 'required|string',
            'hauteur_plafond_parking' => 'required|numeric',
            'hauteur_autorise' => 'required|numeric',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password); // Hashage du mot de passe

        $entreprise = EntrepriseContractante::create($data);
        return response()->json($entreprise, 201);
    }

    // Afficher une entreprise spécifique
    public function show($id)
    {
        $entreprise = EntrepriseContractante::find($id);
        if (!$entreprise) {
            return response()->json(['message' => 'Entreprise non trouvée'], 404);
        }
        return response()->json($entreprise, 200);
    }

    // Mettre à jour une entreprise
    public function update(Request $request, $id)
    {
        $entreprise = EntrepriseContractante::find($id);
        if (!$entreprise) {
            return response()->json(['message' => 'Entreprise non trouvée'], 404);
        }

        $request->validate([
            'nom_entreprise' => 'sometimes|string',
            'email' => 'sometimes|email|unique:entreprises_contractante,email,' . $id,
            'num_unique' => 'sometimes|numeric|unique:entreprises_contractante,num_unique,' . $id,
            'nom_mandataire' => 'sometimes|string',
            'num_contact' => 'sometimes|string',
            'nbr_ateliers_requis' => 'sometimes|integer',
            'ville' => 'sometimes|string',
            'nbr_employee' => 'sometimes|integer',
            'type_parking' => 'sometimes|string',
            'adresse_entreprise' => 'sometimes|string',
            'hauteur_plafond_parking' => 'sometimes|numeric',
            'hauteur_autorise' => 'sometimes|numeric',
        ]);

        $entreprise->update($request->all());
        return response()->json($entreprise, 200);
    }

    // Supprimer une entreprise
    public function destroy($id)
    {
        $entreprise = EntrepriseContractante::find($id);
        if (!$entreprise) {
            return response()->json(['message' => 'Entreprise non trouvée'], 404);
        }

        $entreprise->delete();
        return response()->json(['message' => 'Entreprise supprimée'], 200);
    }

    // Activer une entreprise
    public function activer($id)
    {
        $entreprise = EntrepriseContractante::find($id);
        if (!$entreprise) {
            return response()->json(['message' => 'Entreprise non trouvée'], 404);
        }

        $entreprise->est_actif = true;
        $entreprise->save();

        return response()->json(['message' => 'Entreprise activée', 'entreprise' => $entreprise], 200);
    }

    // Désactiver une entreprise
    public function desactiver($id)
    {
        $entreprise = EntrepriseContractante::find($id);
        if (!$entreprise) {
            return response()->json(['message' => 'Entreprise non trouvée'], 404);
        }

        $entreprise->est_actif = false;
        $entreprise->save();

        return response()->json(['message' => 'Entreprise désactivée', 'entreprise' => $entreprise], 200);
    }

    // Accepter une demande d'entreprise
    public function accepter($id)
    {
        $entreprise = EntrepriseContractante::find($id);
        if (!$entreprise) {
            return redirect()->route('entreprises.index')->with('error', 'Entreprise non trouvée.');
        }

        // Mettre à jour le statut de la demande
        $entreprise->statut_demande = 'acceptee';
        $entreprise->save();

        return redirect()->route('entrepriseContractante')->with('success', 'Demande acceptée avec succès.');
    }

    public function refuser($id)
    {
        $entreprise = EntrepriseContractante::find($id);
        if (!$entreprise) {
            return redirect()->route('entrepriseContractante')->with('error', 'Entreprise non trouvée.');
        }

        // Mettre à jour le statut de la demande
        $entreprise->statut_demande = 'refusee';
        $entreprise->save();

        return redirect()->route('entrepriseContractante')->with('success', 'Demande refusée avec succès.');
    }

}
