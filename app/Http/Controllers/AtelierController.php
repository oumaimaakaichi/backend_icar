<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atelier;

class AtelierController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */



     public function index(Request $request)
     {
         $query = Atelier::query();

         // Recherche par nom ou email
         if ($request->has('search') && $request->input('search') != '') {
             $search = $request->input('search');
             $query->where(function ($q) use ($search) {
                 $q->where('nom_commercial', 'like', '%' . $search . '%')
                   ->orWhere('email', 'like', '%' . $search . '%');
             });
         }

         // Récupérer les résultats
         $ateliers = $query->get();

         return view('ateliers.index', compact('ateliers'));
     }
    public function showInscriptionForm()
    {
        return view('inscriptionAtelier');
    }

    /**
     * Traite la soumission du formulaire d'inscription.
     */
    public function submitInscriptionForm(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom_commercial' => 'required|string',
            'num_registre_commerce' => 'required|numeric',
            'num_fiscal' => 'required|numeric',
            'ville' => 'required|string',
            'site_web' => 'nullable|url',
            'nom_banque' => 'required|string',
            'num_IBAN' => 'required|string', // IBAN peut contenir des lettres
            'nom_directeur' => 'required|string',
            'num_contact' => 'required|numeric',
            'specialisation_centre' => 'required|string',
            'type_entreprise' => 'required|integer',
            'document' => 'nullable|file', // Si c'est un fichier
            'photos_centre' => 'nullable|image', // Si c'est une image
            'nbr_techniciens' => 'required|integer|min:0',
            'techniciens' => 'nullable|string', // Tableau JSON
           // Validation pour chaque élément du tableau
            'email' => 'required|email|unique:ateliers,email',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'nullable|boolean',
        ]);

        // Création de l'atelier
        Atelier::create([
            'nom_commercial' => $request->nom_commercial,
            'num_registre_commerce' => $request->num_registre_commerce,
            'num_fiscal' => $request->num_fiscal,
            'ville' => $request->ville,
            'site_web' => $request->site_web,
            'nom_banque' => $request->nom_banque,
            'num_IBAN' => $request->num_IBAN,
            'nom_directeur' => $request->nom_directeur,
            'num_contact' => $request->num_contact,
            'specialisation_centre' => $request->specialisation_centre,
            'type_entreprise' => $request->type_entreprise,
            'document' => $request->hasFile('document') ? $request->file('document')->store('documents') : null, // Gestion des fichiers
            'photos_centre' => $request->hasFile('photos_centre') ? $request->file('photos_centre')->store('photos') : null, // Gestion des images
            'nbr_techniciens' => $request->nbr_techniciens,
            'techniciens' => $request->techniciens, // Convertir le tableau en JSON
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash du mot de passe
            'is_active' => $request->is_active ?? true, // Par défaut actif
        ]);

        // Redirection avec message de succès
        return redirect()->route('atelier.inscription')->with('success', 'Inscription réussie !');
    }

    //activer Atelier
    public function activateAtelier($id)
{
    $atelier = Atelier::findOrFail($id);
    $atelier->is_active = 1;  // Activer
    $atelier->save();

    return response()->json(['message' => 'L\'atelier a été activé avec succès.']);
}
public function desactivateAtelier($id)
{
    $atelier = Atelier::findOrFail($id);
    $atelier->is_active = 0;  // Désactiver
    $atelier->save();

    return response()->json(['message' => 'L\'atelier a été désactivé avec succès.']);
}



public function getAllAteliers()
{
    return response()->json(Atelier::select('id', 'nom_commercial' , 'ville')->get());
}
}
