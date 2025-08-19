<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DemandePanneInconnu;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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

    // Récupérer le paramètre de filtre s'il existe
    $status = request()->input('status');

    // Construire la requête avec eager loading
    $query = DemandePanneInconnu::with(['client', 'voiture', 'category'])
                ->where('atelier_id', $atelier->id)
                ->orderBy('created_at', 'desc');

    // Appliquer le filtre si spécifié
    if ($status && $status !== 'all') {
        $query->where('status', str_replace('_', ' ', $status));
    }

    // Paginer les résultats (10 par défaut)
    $demandes = $query->paginate(5);

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



public function getAllDemande(): JsonResponse
{
    $demandes = DemandePanneInconnu::with([
        'client:id,nom,prenom,phone',
        'voiture:id,model,serie',
    ])
    ->whereNotNull('pieces_choisies')
    ->get()
    // filtrer aussi les tableaux vides
    ->filter(function ($demande) {
        return is_array($demande->pieces_choisies) && count($demande->pieces_choisies) > 0;
    });

    $formattedDemandes = $demandes->map(function ($demande) {
        return [
            'id' => $demande->id,
            'client_nom' => $demande->client->nom ?? null,
            'client_prenom' => $demande->client->prenom ?? null,
            'client_phone' => $demande->client->phone ?? null,
            'voiture_model' => $demande->voiture->model ?? null,
            'voiture_serie' => $demande->voiture->serie ?? null,
            'created_at' => $demande->created_at->format('Y-m-d H:i:s'),
        ];
    });

    return response()->json($formattedDemandes->values());
}
public function updateDisponibilitePiece(Request $request, $id)
{
    $request->validate([
        'idPiece' => 'required|integer',
        'prixOriginal' => 'nullable|numeric|min:0',
        'prixCommercial' => 'nullable|numeric|min:0',
        'datedisponibiliteOriginale' => 'nullable|date',
        'dateDisponibiliteComercial' => 'nullable|date',
        'disponibiliteOriginal' => 'required|boolean',
        'disponibiliteCommercial' => 'required|boolean',
    ]);

    $demande = DemandePanneInconnu::findOrFail($id);

    $disponibilites = $demande->disponibilite_pieces ?? [];

    // Vérifie si une entrée existe déjà pour cette pièce
    $existingIndex = null;
    foreach ($disponibilites as $index => $item) {
        if (isset($item['idPiece']) && $item['idPiece'] == $request->idPiece) {
            $existingIndex = $index;
            break;
        }
    }

    $disponibiliteData = [
        'idPiece' => $request->idPiece,
        'prixOriginal' => $request->prixOriginal,
        'prixCommercial' => $request->prixCommercial,
        'datedisponibiliteOriginale' => $request->datedisponibiliteOriginale,
        'dateDisponibiliteComercial' => $request->dateDisponibiliteComercial,
        'disponibiliteOriginal' => $request->disponibiliteOriginal,
        'disponibiliteCommercial' => $request->disponibiliteCommercial,
        'updated_at' => now()->toDateTimeString()
    ];

    if ($existingIndex !== null) {
        $disponibilites[$existingIndex] = $disponibiliteData;
    } else {
        $disponibilites[] = $disponibiliteData;
    }

    $demande->disponibilite_pieces = $disponibilites;
    $demande->save();

    return response()->json([
        'success' => true,
        'message' => 'Disponibilité enregistrée avec succès.',
        'disponibilites' => $disponibilites
    ]);
}


protected function calculateTotalPrice($disponibilites)
{
    $total = 0;

    foreach ($disponibilites as $piece) {
        // Prendre le prix le plus bas disponible (original ou commercial)
        if ($piece['disponibiliteOriginal'] && $piece['disponibiliteCommercial']) {
            $total += min($piece['prixOriginal'], $piece['prixCommercial']);
        } elseif ($piece['disponibiliteOriginal']) {
            $total += $piece['prixOriginal'];
        } elseif ($piece['disponibiliteCommercial']) {
            $total += $piece['prixCommercial'];
        }
    }

    return $total;
}

public function formAjouter($demandeId)
{
    // Récupérer une seule demande par son ID
    $demande = DemandePanneInconnu::findOrFail($demandeId);

    // Récupérer les pièces choisies s'il y en a
    $pieces = Catalogue::whereIn('id', $demande->pieces_choisies ?? [])->get();

    return view('reponsable_piece.piece_recommandee.showInconnu', compact('demande', 'pieces'));
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

    ]);

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


public function getAllDemandeByUser($userId): JsonResponse
{
    $user = User::find($userId);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Utilisateur non trouvé.'
        ], 404);
    }

    $demandes = DemandePanneInconnu::with([
        'voiture:id,model,serie,couleur',
        'category:id,titre',
        'atelier:id,nom_commercial',
    ])
    ->where('client_id', $userId)
    ->orderBy('created_at', 'desc')
    ->get();

    $formatted = $demandes->map(function ($demande) {
        // Récupérer les informations des pièces disponibles
        $piecesDisponibles = [];

        // Debug: voir le contenu de disponibilite_pieces
        \Log::info('disponibilite_pieces brut:', ['data' => $demande->disponibilite_pieces]);

        if (!empty($demande->disponibilite_pieces)) {
            // Si c'est déjà un array PHP
            if (is_array($demande->disponibilite_pieces)) {
                $catalogueIds = array_keys($demande->disponibilite_pieces);
            }
            // Si c'est une string JSON, la décoder
            else if (is_string($demande->disponibilite_pieces)) {
                $decoded = json_decode($demande->disponibilite_pieces, true);
                if (is_array($decoded)) {
                    $catalogueIds = array_keys($decoded);
                } else {
                    $catalogueIds = [];
                }
            }
            else {
                $catalogueIds = [];
            }

            if (!empty($catalogueIds)) {
                $pieces = Catalogue::whereIn('id', $catalogueIds)->get();

                foreach ($pieces as $piece) {
                    $quantite = is_array($demande->disponibilite_pieces)
                        ? ($demande->disponibilite_pieces[$piece->id] ?? 1)
                        : 1;

                    $piecesDisponibles[] = [
                        'id' => $piece->id,
                        'nom' => $piece->nom,
                        'prix' => $piece->prix,
                        'quantite' => $quantite,
                    ];
                }
            }
        }

        // Debug: voir le résultat final
        \Log::info('piecesDisponibles final:', ['data' => $piecesDisponibles]);

        return [
            'id' => $demande->id,
            'voiture_model' => $demande->voiture->model ?? null,
             'voiture' => $demande->voiture ?? null,
             'serie'=> $demande->voiture->serie ?? null,
               'date_fabrication'=> $demande->voiture->date_fabrication ?? null,
            'voiture_serie' => $demande->voiture->serie ?? null,
            'type_emplacement' => $demande->type_emplacement,
            'description_probleme' => $demande->description_probleme,
            'date_maintenance' => $demande->date_maintenance ? $demande->date_maintenance->format('Y-m-d') : null,
            'heure_maintenance' => $demande->heure_maintenance,
            'status' => $demande->status,
            'atelier' => $demande->atelier ? $demande->atelier->nom : null,
            'categorie' => $demande->category->titre ?? null,
            'created_at' => $demande->created_at->format('Y-m-d H:i:s'),
            'disponibilite_pieces' => $piecesDisponibles, // Array vide ou avec des éléments
              'pieces_selectionnees' =>$demande->pieces_selectionnees,
              'disponibilite_piecess' =>$demande->disponibilite_pieces,
            'prix_total' => $demande->prix_total,
            'prix_main_oeuvre' => $demande->prix_main_oeuvre,
            'techniciens' => $demande->techniciens,
        ];
    });

    return response()->json([
        'success' => true,
        'data' => $formatted
    ]);
}
public function getPiecesChoisies($demandeId) {
    $demande = DemandePanneInconnu::with(['voiture', 'client'])->findOrFail($demandeId);

    $pieces = [];
    if (!empty($demande->disponibilite_pieces)) {
        foreach ($demande->disponibilite_pieces as $piece) {
            $catalogue = Catalogue::find($piece['idPiece']);
            if ($catalogue) {
                $pieces[] = [
                    'info' => [
                        'idPiece' => $catalogue->id,
                        'nom' => $catalogue->nom_piece,
                        'num_piece' => $catalogue->num_piece,
                        'photo' => $catalogue->photo_piece,
                    ],
                    'original' => [
                        'prix' => $piece['prixOriginal'] ?? null,
                        'disponibiliteOriginal' => isset($piece['disponibiliteOriginal']) ? (int)$piece['disponibiliteOriginal'] : 0,
                        'date_disponibilite' => $piece['datedisponibiliteOriginale'] ?? null,
                    ],
                    'commercial' => [
                        'prix' => $piece['prixCommercial'] ?? null,
                        'disponibiliteCommercial' => isset($piece['disponibiliteCommercial']) ? (int)$piece['disponibiliteCommercial'] : 0,
                        'date_disponibilite' => $piece['dateDisponibiliteComercial'] ?? null,
                    ]
                ];
            }
        }
    }

    return response()->json([
        'success' => true,
        'demande' => [
            'id' => $demande->id,
            'voiture_model' => $demande->voiture->model ?? 'Inconnu',
        ],
        'pieces' => $pieces
    ]);
}
public function saveSelections(Request $request, $demandeId)
{
    $request->validate([
        'pieces_selectionnees' => 'required|array',
        'pieces_selectionnees.*.piece_id' => 'required|integer|exists:catalogues,id',
        'pieces_selectionnees.*.type' => 'required|in:original,commercial',
        'pieces_selectionnees.*.prix' => 'required|numeric|min:0',
    ]);

    $demande = DemandePanneInconnu::findOrFail($demandeId);

    // CORRECTION: Utiliser 'pieces_selectionnees' au lieu de 'pieces'
    $prixTotal = collect($request->pieces_selectionnees)->sum('prix');

    // Enregistrer les sélections dans le champ JSON pieces_selectionnees
    $demande->update([
        'pieces_selectionnees' => $request->pieces_selectionnees,
        'prix_total' => $prixTotal,
        'statut' => 'selections_enregistrees' // Optionnel: changer le statut
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Sélections enregistrées avec succès',
        'prix_total' => $prixTotal,
    ]);
}
}
