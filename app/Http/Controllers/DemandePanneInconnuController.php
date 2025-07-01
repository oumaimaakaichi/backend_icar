<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DemandePanneInconnu;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
class DemandePanneInconnuController extends Controller
{
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'voiture_id'           => 'required|exists:voitures,id',
        'client_id'            => 'required|exists:users,id',

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

public function show2($id)
{
    $demande = DemandePanneInconnu::with([
        'client:id,nom,prenom,phone,email',
        'voiture:id,model,serie,date_fabrication,couleur',






    ])->findOrFail($id);
  $catalogues = Catalogue::whereIn('id', $demande->pieces_choisies ?? [])->get();
    $techniciens = User::where('role', 'technicien')
                      ->whereNull('atelier_id')
                      ->where('isActive', true)
                      ->get();

    return view('expert.show2', [
        'demande' => $demande,
        'techniciens' => $techniciens,
         'flux' => $demande->flux, // Cela utilise la relation définie dans le modèle
        'demandeFlux' => $demande->flux ? $demande->flux->demandeFlux : null,
        "catalogues" => $catalogues
    ]);
}



public function showDemandesParAtelierPage()
{
    $atelier = Auth::guard('atelier')->user(); // atelier connecté

    if (!$atelier) {
        abort(403, 'Accès non autorisé');
    }

    $demandes = DemandePanneInconnu::with([
        'client',
        'voiture',
        'category'

    ])->where('atelier_id', $atelier->id)->get();

    return view('ateliers.demandesInconnu', compact('atelier', 'demandes'));
}



public function updateTechniciens(Request $request, DemandePanneInconnu $demande)
{
    \Log::info('Données reçues:', $request->all());

    $validated = $request->validate([
        'techniciens' => 'required|array',
        'techniciens.*.id_technicien' => 'required|integer|exists:users,id',
        'techniciens.*.nom' => 'required|string',
    ]);

    \Log::info('Données validées:', $validated);

    $techniciensData = collect($validated['techniciens'])->map(function ($tech) {
        return [
            'id' => $tech['id_technicien'],
            'nom' => $tech['nom']
        ];
    })->toArray();

    \Log::info('Données à enregistrer:', $techniciensData);

    try {
        $demande->techniciens = $techniciensData;
        $demande->status = 'Assignée';
        $demande->save();

        \Log::info('Demande après mise à jour:', $demande->fresh()->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Techniciens assignés avec succès',
            'data' => $demande->fresh(),
        ]);
    } catch (\Exception $e) {
        \Log::error('Erreur lors de la mise à jour:', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'assignation',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function show1($id)
{
    $demande = DemandePanneInconnu::with('client', 'voiture', 'category')->findOrFail($id);

    // Récupérer les techniciens de l'atelier (à adapter selon ta logique)
    // Supposons que tu as un atelier lié au demande ou utilisateur connecté
    $atelierId = Auth::guard('atelier')->id(); // ou autre logique

  $techniciens = User::where('role', 'technicien')
                       ->where('atelier_id', $atelierId)
                       ->get();
    return view('ateliers.showInconnu', compact('demande', 'techniciens'));
}
public function showRequestChoice()
{
    return view('ateliers.choice');
}
 public function index($userId)
    {
        $user = User::with('atelier')->find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $query = DemandePanneInconnu::with([
            'voiture',
            'client',
            'category',
            'atelier'
        ]);

        if ($user->atelier_id) {
            $query->where('atelier_id', $user->atelier_id);
        } else {
            $query->whereNull('atelier_id');
        }

        $demandes = $query->orderBy('date_maintenance', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $demandes
        ]);
    }





    public function getAllDemandeToExpert()
{
    $status = request()->query('status');
    $search = request()->query('search');

    $demandesQuery = DemandePanneInconnu::with([
        'client:id,nom,prenom,phone',
        'voiture:id,model,serie',

    ])->where('type_emplacement', '!=', 'fixe');

    // Filtrage par statut
    $demandesQuery->when($status, function ($query, $status) {
        return $query->where('status', $status);
    });

    // Filtrage par nom ou prénom du client
    $demandesQuery->when($search, function ($query, $search) {
        return $query->whereHas('client', function ($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%");
        });
    });

    // Paginer les résultats
    $demandes = $demandesQuery->paginate(6);

    // Formater les données pour la vue
    $formattedDemandes = $demandes->through(function ($demande) {
        return [
            'id' => $demande->id,

            'categorie_titre' => $demande->category->titre ?? null,
            'client_nom' => $demande->client->nom ?? null,
            'client_prenom' => $demande->client->prenom ?? null,
            'client_phone' => $demande->client->phone ?? null,
            'voiture_model' => $demande->voiture->model ?? null,
            'voiture_serie' => $demande->voiture->serie ?? null,
            'type_emplacement' => $demande->type_emplacement,
            'description_probleme' => $demande->description_probleme,
            'date_maintenance' => $demande->date_maintenance ? $demande->date_maintenance->format('Y-m-d H:i') : null,
            'created_at' => $demande->created_at->format('Y-m-d H:i:s'),
            'status' => $demande->status ?? 'pending'
        ];
    });

    return view('expert.demande_inconnu', ['demandes' => $formattedDemandes]);
}








public function show($demandeId)
{
    $demande = DemandePanneInconnu::with([
        'voiture',
        'client',
        'category',
        'atelier'
    ])->find($demandeId);

    if (!$demande) {
        return response()->json([
            'success' => false,
            'message' => 'Demande non trouvée'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $demande
    ]);
}





public function getDemandesParTechnicien($technicien_id)
{
    $demandes = DemandePanneInconnu::with(['voiture', 'client', 'category', 'atelier'])
        ->whereJsonContains('techniciens', ['id' => (int)$technicien_id])
        ->orderBy('date_maintenance', 'desc')
        ->get();



    return response()->json([
        'success' => true,
        'data' => $demandes
    ]);
}

public function updatePanne(Request $request, $id)
{
    $request->validate([
        'panne' => 'required|string|min:5',
        'categories' => 'nullable|array',
        'categories.*' => 'integer|exists:category_panes,id',
        'catalogues' => 'nullable|array',
        'catalogues.*' => 'integer|exists:catalogues,id',
    ]);

    $demande = DemandePanneInconnu::findOrFail($id);
    $demande->panne = $request->panne;

    if ($request->has('categories')) {
        $demande->categories = $request->categories;
    }

    if ($request->has('catalogues')) {
        // Enregistre les IDs des catalogues dans pieces_choisies
        $demande->pieces_choisies = $request->catalogues;
    }

    $demande->save();

    return response()->json([
        'success' => true,
        'message' => 'Description de la panne, catégories et pièces mises à jour avec succès.',
        'data' => $demande
    ]);
}
public function ajouterPrixMainOeuvrePiece(Request $request, $id)
{
    $request->validate([
        'piece_id' => 'required|integer|exists:catalogues,id',
        'prix' => 'required|numeric|min:0',
    ]);

    $demande = DemandePanneInconnu::findOrFail($id);

    $mainOeuvrePieces = $demande->main_oeuvre_pieces ?? [];

    // Mettre à jour ou ajouter le prix pour cette pièce
    $mainOeuvrePieces[$request->piece_id] = $request->prix;

    $demande->main_oeuvre_pieces = $mainOeuvrePieces;
    $demande->save();

    return response()->json([
        'success' => true,
        'message' => 'Prix main d\'œuvre ajouté avec succès',
        'data' => $demande
    ]);
}
}
