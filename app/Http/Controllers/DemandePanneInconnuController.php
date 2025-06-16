<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DemandePanneInconnu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemandePanneInconnuController extends Controller
{
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'voiture_id'           => 'required|exists:voitures,id',
        'client_id'            => 'required|exists:users,id',
        'category_id'          => 'required|exists:category_panes,id',
        'description_probleme' => 'required|string|min:20',
        'type_emplacement'     => 'required|string|in:fixe,domicile,maison,quartier_general_prive,en_travail,parking',
        'atelier_id'           => 'nullable|required_if:type_emplacement,fixe|exists:ateliers,id',
        'date_maintenance'     => 'required|date',
        'heure_maintenance'    => 'required|string',
        'latitude'             => 'required|numeric',
        'longitude'            => 'required|numeric',

        // Champs conditionnels
        'surface_maison' => 'nullable|required_if:type_emplacement,maison|numeric',
        'hauteur_plafond_maison' => 'nullable|required_if:type_emplacement,maison|numeric',
        'porte_garage_maison' => 'nullable|required_if:type_emplacement,maison|array',

        'surface_bureau' => 'nullable|required_if:type_emplacement,quartier_general_prive|numeric',
        'hauteur_plafond_bureau' => 'nullable|required_if:type_emplacement,quartier_general_prive|numeric',
        'porte_garage_bureau' => 'nullable|required_if:type_emplacement,quartier_general_prive|array',

        'surface_parking_travail' => 'nullable|required_if:type_emplacement,en_travail|numeric',
        'porte_travail' => 'nullable|required_if:type_emplacement,en_travail|array',
        'autorisation_entree_travail' => 'nullable|required_if:type_emplacement,en_travail|boolean',

        'proximite_parking_public' => 'nullable|required_if:type_emplacement,parking|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
        ], 422);
    }

    try {
        $data = [
            'voiture_id' => $request->voiture_id,
            'client_id' => $request->client_id,
            'category_id' => $request->category_id,
            'description_probleme' => $request->description_probleme,
            'type_emplacement' => $request->type_emplacement,
            'atelier_id' => $request->type_emplacement === 'fixe' ? $request->atelier_id : null,
            'date_maintenance' => $request->date_maintenance,
            'heure_maintenance' => $request->heure_maintenance,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'en_attente',
            'prix_total' => 0,
            'prix_main_oeuvre' => 0,
        ];

        // Ajouter les champs spécifiques selon le type d'emplacement
        switch ($request->type_emplacement) {
            case 'maison':
                $data['surface_maison'] = $request->surface_maison;
                $data['hauteur_plafond_maison'] = $request->hauteur_plafond_maison;
                $data['porte_garage_maison'] = json_encode($request->porte_garage_maison);
                break;

            case 'quartier_general_prive':
                $data['surface_bureau'] = $request->surface_bureau;
                $data['hauteur_plafond_bureau'] = $request->hauteur_plafond_bureau;
                $data['porte_garage_bureau'] = json_encode($request->porte_garage_bureau);
                break;

            case 'en_travail':
                $data['surface_parking_travail'] = $request->surface_parking_travail;
                $data['porte_travail'] = json_encode($request->porte_travail);
                $data['autorisation_entree_travail'] = $request->autorisation_entree_travail;
                break;

            case 'parking':
                $data['proximite_parking_public'] = $request->proximite_parking_public;
                break;
        }

        $demande = DemandePanneInconnu::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Demande créée avec succès',
            'data' => $demande
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la création de la demande',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function show($id)
    {
        $demande = DemandePanneInconnu::with(['voiture', 'client', 'atelier', 'rapports'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $demande
        ]);
    }
}
