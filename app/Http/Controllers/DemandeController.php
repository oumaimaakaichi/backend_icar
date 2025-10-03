<?php
namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Notification;
use App\Models\PieceRecommandee;
use App\Models\NotificationTechnicien;
use App\Models\Voiture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth; // ✅ Ceci est correct
use App\Events\DemandeCreated;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Events\NotificationSent;

class DemandeController extends Controller
{
public function store(Request $request)
{
    $request->validate([

        'service_panne_id' => 'required|exists:service_pannes,id',
        'voiture_id' => 'required|exists:voitures,id',
    ]);

    $voiture = Voiture::findOrFail($request->voiture_id);
    $clientId = $voiture->client_id;

    $demande = Demande::create([

        'service_panne_id' => $request->service_panne_id,
        'voiture_id' => $request->voiture_id,
        'client_id' => $clientId,
    ]);

    $responsables = User::where('role', 'Responsable_piece')->get();

    foreach ($responsables as $responsable) {
        $notification = Notification::create([
            'user_id' => $responsable->id,
            'type' => 'new_demande',
            'message' => 'Nouvelle demande de maintenance pour ' . ($voiture->marque . ' ' . $voiture->modele),
            'data' => [
                'demande_id' => $demande->id,
                'url' => '/demandes/' . $demande->id,
                'client' => $demande->client->nom ?? 'Client inconnu',
                'voiture' => $voiture->marque . ' ' . $voiture->modele
            ]
        ]);

        broadcast(new NotificationSent($notification, $responsable->id))->toOthers();
    }

    return response()->json([
        'message' => 'Demande créée avec succès',
        'demande' => $demande,
    ], 201);
}


public function getAllDemandes(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);

            $demandes = Demande::with(['client', 'atelier', 'voiture', 'servicePanne'])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'success' => true,
                'data' => $demandes->items(),
                'pagination' => [
                    'current_page' => $demandes->currentPage(),
                    'per_page' => $demandes->perPage(),
                    'total' => $demandes->total(),
                    'last_page' => $demandes->lastPage(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des demandes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer le nombre de demandes par date
     */
    public function getDemandesCountByDate(Request $request)
    {
        try {
            $startDate = $request->get('start_date', now()->format('Y-m-d'));
            $endDate = $request->get('end_date', now()->addYear()->format('Y-m-d'));

            $demandesCount = Demande::whereNotNull('date_maintenance')
                ->whereBetween('date_maintenance', [$startDate, $endDate])
                ->select('date_maintenance', DB::raw('COUNT(*) as count'))
                ->groupBy('date_maintenance')
                ->get()
                ->pluck('count', 'date_maintenance');

            return response()->json([
                'success' => true,
                'data' => $demandesCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des comptes par date',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer les dates bloquées (5 demandes ou plus)
     */
    public function getBlockedDates(Request $request)
    {
        try {
            $startDate = $request->get('start_date', now()->format('Y-m-d'));
            $endDate = $request->get('end_date', now()->addYear()->format('Y-m-d'));
            $maxDemandesPerDay = $request->get('max_demandes', 5);

            $blockedDates = Demande::whereNotNull('date_maintenance')
                ->whereBetween('date_maintenance', [$startDate, $endDate])
                ->select('date_maintenance', DB::raw('COUNT(*) as count'))
                ->groupBy('date_maintenance')
                ->having('count', '>=', $maxDemandesPerDay)
                ->pluck('date_maintenance')
                ->map(function ($date) {
                    return $date->format('Y-m-d');
                });

            return response()->json([
                'success' => true,
                'data' => $blockedDates,
                'max_demandes_per_day' => $maxDemandesPerDay
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des dates bloquées',
                'error' => $e->getMessage()
            ], 500);
        }
    }
public function updatePiecesChoisies(Request $request, Demande $demande)
{
    $pieceRecommandee = PieceRecommandee::where('demande_id', $demande->id)->first();

    if (!$pieceRecommandee) {
        return response()->json([
            'error' => 'Aucune recommandation de pièces trouvée pour cette demande'
        ], 404);
    }

    // Cas où seule la main d'œuvre est recommandée
    if ($pieceRecommandee->main_oeuvre_seule) {
        $request->validate([
            'prix_main_oeuvre' => 'required|numeric|min:0',
        ]);

        $demande->update([
            'main_oeuvre_seule' => true,
            'prix_main_oeuvre' => $request->prix_main_oeuvre,
            'pieces_choisies' => [] // Tableau vide pour indiquer aucune pièce
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Main d\'œuvre enregistrée avec succès',
            'data' => $demande->fresh()
        ]);
    }

    // Cas normal avec des pièces recommandées
    $request->validate([
        'pieces' => 'required|array',
        'pieces.*.piece_id' => 'required|integer',
        'pieces.*.type' => 'required|in:original,commercial',
        'pieces.*.prix' => 'required|numeric',
    ]);

    // Convertir les données reçues en format approprié
    $piecesChoisies = array_map(function ($piece) {
        return [
            'piece_id' => $piece['piece_id'],
            'type' => $piece['type'],
            'prix' => $piece['prix'],
        ];
    }, $request->pieces);

    // Enregistrer les pièces choisies
    $demande->update([
        'pieces_choisies' => $piecesChoisies,
        'main_oeuvre_seule' => false
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Pièces choisies enregistrées avec succès',
        'data' => $demande->fresh()
    ]);
}
public function showDemandesParAtelierPage()
{
    $atelier = Auth::guard('atelier')->user();

    if (!$atelier) {
        abort(403, 'Accès non autorisé');
    }

    $demandes = Demande::with([
        'client',
        'voiture',
        'forfait',
        'servicePanne.categoryPane',
        'servicePanne',
        'pieceRecommandee'
    ])->where('atelier_id', $atelier->id)->paginate(4);

    return view('ateliers.demandes-par-atelier', compact('atelier', 'demandes'));
}

public function getAllDemande(): JsonResponse
{
    $demandes = Demande::with([
        'client:id,nom,prenom,phone',
        'voiture:id,model,serie',
        'forfait:id,nomForfait',
        'servicePanne.categoryPane:id,titre',
        'servicePanne:id,titre,category_pane_id',
        'pieceRecommandee'
    ])->get();

    $formattedDemandes = $demandes->map(function ($demande) {
        return [
            'id' => $demande->id,
            'service_titre' => $demande->servicePanne->titre ?? null,
            'categorie_titre' => $demande->servicePanne->categoryPane->titre ?? null,
            'client_nom' => $demande->client->nom ?? null,
            'client_prenom' => $demande->client->prenom ?? null,
            'client_phone' => $demande->client->phone ?? null,
            'voiture_model' => $demande->voiture->model ?? null,
            'voiture_serie' => $demande->voiture->serie ?? null,
            'forfait_titre' => $demande->forfait->nomForfait ?? null, // ✅ Correction ici
            'created_at' => $demande->created_at->format('Y-m-d H:i:s'),
            'has_piece_recommandee' => $demande->pieceRecommandee ? true : false
        ];
    });

    return response()->json($formattedDemandes);
}
public function getAllDemandeToExpert()
{
    $status = request()->query('status');
    $search = request()->query('search');

    $demandesQuery = Demande::with([
        'client:id,nom,prenom,phone',
        'voiture:id,model,serie',
        'forfait:id,nomForfait',
        'servicePanne.categoryPane:id,titre',
        'servicePanne:id,titre,category_pane_id',
        'pieceRecommandee'
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
            'service_titre' => $demande->servicePanne->titre ?? null,
            'categorie_titre' => $demande->servicePanne->categoryPane->titre ?? null,
            'client_nom' => $demande->client->nom ?? null,
            'client_prenom' => $demande->client->prenom ?? null,
            'client_phone' => $demande->client->phone ?? null,
            'voiture_model' => $demande->voiture->model ?? null,
            'voiture_serie' => $demande->voiture->serie ?? null,
            'forfait_titre' => $demande->forfait->nomForfait ?? null,
            'type_emplacement' => $demande->type_emplacement,
            'date_maintenance' => $demande->date_maintenance ? $demande->date_maintenance->format('Y-m-d H:i') : null,
            'created_at' => $demande->created_at->format('Y-m-d H:i:s'),
            'has_piece_recommandee' => $demande->pieceRecommandee ? true : false,
            'status' => $demande->status ?? 'pending'
        ];
    });

    return view('expert.demande_maintenance', ['demandes' => $formattedDemandes]);
}
public function getAllDemandeAtelierToExpert()
{
    $status = request()->query('status');
    $search = request()->query('search');

    $demandesQuery = Demande::with([
        'client:id,nom,prenom,phone',
        'voiture:id,model,serie',
        'forfait:id,nomForfait',
        'servicePanne.categoryPane:id,titre',
        'servicePanne:id,titre,category_pane_id',
        'pieceRecommandee'
    ])
    ->where('type_emplacement', 'fixe')
    ->whereNotNull('techniciens');

    // Filtrage par statut
    if ($status) {
        $demandesQuery->where('status', $status);
    }

    // Filtrage par nom ou prénom du client
    if ($search) {
        $demandesQuery->whereHas('client', function ($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%");
        });
    }

    // Paginer les résultats
    $demandes = $demandesQuery->paginate(6);

    // Formater les données pour la vue
    $formattedDemandes = $demandes->through(function ($demande) {
        return [
            'id' => $demande->id,
            'service_titre' => $demande->servicePanne->titre ?? null,
            'categorie_titre' => $demande->servicePanne->categoryPane->titre ?? null,
            'client_nom' => $demande->client->nom ?? null,
            'client_prenom' => $demande->client->prenom ?? null,
            'client_phone' => $demande->client->phone ?? null,
            'voiture_model' => $demande->voiture->model ?? null,
            'voiture_serie' => $demande->voiture->serie ?? null,
            'forfait_titre' => $demande->forfait->nomForfait ?? null,
            'type_emplacement' => $demande->type_emplacement,
            'date_maintenance' => $demande->date_maintenance ? $demande->date_maintenance->format('Y-m-d H:i') : null,
            'created_at' => $demande->created_at ? $demande->created_at->format('Y-m-d H:i:s') : null,
            'has_piece_recommandee' => $demande->pieceRecommandee ? true : false,
            'status' => $demande->status ?? 'pending'
        ];
    });

    return view('expert.demandeAutorisation', ['demandes' => $formattedDemandes]);
}

public function updateInfo(Request $request, $id)
{
    // Validation des champs
    $validated = $request->validate([
        'type_emplacement' => 'nullable|string|max:255',
        'date_maintenance' => 'nullable|date',
        'heure_maintenance' => 'nullable|date_format:H:i',
        'atelier_id' => 'nullable|exists:ateliers,id',
    ]);

    // Récupération de la demande
    $demande = Demande::find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    // Stocker l'ancien atelier pour comparaison
    $ancienAtelierId = $demande->atelier_id;

    // Mise à jour des champs
    $demande->fill($validated);
    $demande->save();

    // Envoyer une notification si l'atelier a changé
    if ($demande->atelier_id && $demande->atelier_id != $ancienAtelierId) {
        $atelier = Atelier::find($demande->atelier_id);

        if ($atelier) {
            $notification = Notification::create([
                'user_id' => $atelier->id, // Assurez-vous que votre modèle Atelier utilise le même ID que User
                'type' => 'demande_assignee',
                'message' => 'A new request has been assigned to you',
                'data' => [
                    'demande_id' => $demande->id,
                    'url' => '/demandes/' . $demande->id,
                    'client' => $demande->client->nom ?? 'Client inconnu',
                    'date_maintenance' => $demande->date_maintenance,
                    'heure_maintenance' => $demande->heure_maintenance
                ]
            ]);

            // Diffuser la notification en temps réel
            event(new NotificationSent($notification));
        }
    }

    return response()->json([
        'message' => 'Demande mise à jour avec succès',
        'demande' => $demande
    ]);
}

public function getDetailsForConfirmation($id)
{
    $demande = Demande::with([
        'servicePanne',
        'voiture',
        'atelier',
        'pieceRecommandee' // relation à ajouter si pas encore faite
    ])->find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    // ---- Total des pièces choisies ----
    $pieces = $demande->pieces_choisies ?? [];
    if (!is_array($pieces)) {
        $pieces = json_decode($pieces, true) ?? [];
    }

    $totalPieces = array_reduce($pieces, function ($carry, $item) {
        return $carry + ($item['prix'] ?? 0);
    }, 0);

    // ---- Total de la main d’œuvre (table PieceRecommandee -> JSON "pieces") ----
  // ---- Total de la main d’œuvre (table PieceRecommandee -> JSON "pieces") ----
$totalMainOeuvre = 0;
if ($demande->pieceRecommandee) {
    if (is_array($demande->pieceRecommandee->pieces) && count($demande->pieceRecommandee->pieces) > 0) {
        foreach ($demande->pieceRecommandee->pieces as $piece) {
            $totalMainOeuvre += $piece['prix_main_oeuvre'] ?? 0;
        }
    } else {
        // Si la liste de pièces est vide, prendre le prix de la main d'oeuvre seule
        $totalMainOeuvre = $demande->pieceRecommandee->prix_main_oeuvre_seule ?? 0;
    }
}

    return response()->json([
        'service_titre'     => $demande->servicePanne->titre ?? 'Non spécifié',
        'voiture_model'     => $demande->voiture->model ?? 'Non spécifié',
        'total_pieces'      => $totalPieces,
        'total_main_oeuvre' => $totalMainOeuvre,
        'pieces_choisies'   => $pieces,
        'date_maintenance'  => $demande->date_maintenance,
        'atelier'           => $demande->atelier,
    ]);
}

public function updateLocation(Request $request, $id)
{
    // Validation commune
    $validated = $request->validate([
        'type_emplacement' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'date_maintenance' => 'nullable|date',
        'heure_maintenance' => 'nullable|date_format:H:i',

    ]);

    $demande = Demande::find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    $demande->type_emplacement = $validated['type_emplacement'];
    $demande->latitude = $validated['latitude'];
    $demande->longitude = $validated['longitude'];

    // Gestion conditionnelle de la date et heure de maintenance
    if (isset($validated['date_maintenance'])) {
        $demande->date_maintenance = $validated['date_maintenance'];

        if (isset($validated['heure_maintenance'])) {
            $demande->heure_maintenance = $validated['heure_maintenance'];
        } else {
            $demande->heure_maintenance = null;
        }
    }

    // Gestion des types d'emplacement spécifiques
    switch ($validated['type_emplacement']) {
        case 'maison':
            $request->validate([
                'surface_maison' => 'required|numeric',
                'hauteur_plafond_maison' => 'required|numeric',
                'porte_garage_maison' => 'required|array',
            ]);
            $demande->surface_maison = $request->input('surface_maison');
            $demande->hauteur_plafond_maison = $request->input('hauteur_plafond_maison');
            $demande->porte_garage_maison = $request->input('porte_garage_maison');
            break;

        case 'quartier_general_prive':
            $request->validate([
                'surface_bureau' => 'required|numeric',
                'hauteur_plafond_bureau' => 'required|numeric',
                'porte_garage_bureau' => 'required|array',
            ]);
            $demande->surface_bureau = $request->input('surface_bureau');
            $demande->hauteur_plafond_bureau = $request->input('hauteur_plafond_bureau');
            $demande->porte_garage_bureau = $request->input('porte_garage_bureau');
            break;

        case 'en_travail':
            $request->validate([
                'surface_parking_travail' => 'required|numeric',
                'porte_travail' => 'required|array',
                'autorisation_entree_travail' => 'required|boolean',
            ]);
            $demande->surface_parking_travail = $request->input('surface_parking_travail');
            $demande->porte_travail = $request->input('porte_travail');
            $demande->autorisation_entree_travail = $request->input('autorisation_entree_travail');
            break;

        case 'parking':
            $request->validate([
                'proximite_parking_public' => 'required|boolean',
            ]);
            $demande->proximite_parking_public = $request->input('proximite_parking_public');
            break;
    }

    $demande->save();

    return response()->json([
        'message' => 'Demande mise à jour avec succès',
        'demande' => $demande,
    ], 200);
}

public function getByDemandeWithTechnicien($client_id)
{
    $demandes = Demande::with(['voiture', 'servicePanne', 'atelier'])
        ->where('client_id', $client_id)
        ->whereNotNull('techniciens') // techniciens est un champ JSON
        ->orderByDesc('created_at')
        ->get();

    // Formattage
    $formatted = $demandes->map(function ($demande) {
        return [
            'id'              => $demande->id,
            'created_at'      => $demande->created_at->format('Y-m-d H:i:s'),
            'date_maintenance'=> $demande->date_maintenance?->format('Y-m-d') ?? null,
            'heure_maintenance'=> $demande->heure_maintenance,

            'voiture' => [
                'model'            => $demande->voiture->model ?? 'Modèle non spécifié',
                'serie'            => $demande->voiture->serie ?? 'Série non spécifiée',
                'company'          => $demande->voiture->company ?? 'Compagnie non spécifiée',
                'date_fabrication' => $demande->voiture->date_fabrication ?? 'Date non spécifiée',
            ],

            'atelier' => [
                'nom_commercial' => $demande->atelier->nom_commercial ?? 'Atelier non spécifié',
                'ville'          => $demande->atelier->ville ?? 'Ville non spécifiée',
            ],

            'service_panne' => [
                'titre' => $demande->servicePanne->titre ?? 'Service non spécifié',
            ],

            'techniciens'     => $demande->techniciens ?? [],
            'type_emplacement'=> $demande->type_emplacement,
        ];
    });

    // Retourne toujours un 200, même si aucune demande
    return response()->json($formatted, 200);
}


public function showRequestChoice()
{
    return view('expert.choice');
}



// Dans DemandeController.php

public function getDemandesParTechnicien($technicien_id)
{
    $demandes = Demande::with([
        'client:id,nom,prenom,phone',
        'voiture:id,model,serie,company,date_fabrication',
        'servicePanne:id,titre',
        'forfait:id,nomForfait',
        'atelier:id,nom_commercial'
    ])
    ->whereJsonContains('techniciens', ['id' => (int)$technicien_id])
    ->orderBy('date_maintenance', 'desc')
    ->get();

    if ($demandes->isEmpty()) {
        return response()->json(['message' => 'Aucune demande trouvée pour ce technicien'], 404);
    }

    $formattedDemandes = $demandes->map(function ($demande) {
        // Handle empty pieces_choisies
        $piecesChoisies = $demande->pieces_choisies ?? [];
        if (is_string($piecesChoisies)) {
            $piecesChoisies = json_decode($piecesChoisies, true) ?? [];
        }

        // Ensure pieces_choisies is always an array
        if (!is_array($piecesChoisies)) {
            $piecesChoisies = [];
        }

        return [
            'id' => $demande->id,
            'date_maintenance' => $demande->date_maintenance,
            'heure_maintenance' => $demande->heure_maintenance,
            'type_emplacement' => $demande->type_emplacement,
            'status' => $demande->status,
            'client' => [
                'nom' => $demande->client->nom,
                'prenom' => $demande->client->prenom,
                'phone' => $demande->client->phone,
            ],
            'voiture' => [
                'model' => $demande->voiture->model,
                'serie' => $demande->voiture->serie,
                'company' => $demande->voiture->company,
                'date_fabrication' => $demande->voiture->date_fabrication,
            ],
            'service' => [
                'titre' => $demande->servicePanne->titre,
            ],

            'atelier' => $demande->atelier->nom_commercial ?? null,
            'pieces_choisies' => $piecesChoisies, // Always an array
            'latitude' => $demande->latitude,
            'longitude' => $demande->longitude,
            'prix_total' => $demande->prix_total,
            'prix_main_oeuvre' => $demande->prix_main_oeuvre,
            'surface_maison' => $demande->surface_maison,
            'hauteur_plafond_maison' => $demande->hauteur_plafond_maison,
            'porte_garage_maison' => $demande->porte_garage_maison,
            'surface_bureau' => $demande->surface_bureau,
            'hauteur_plafond_bureau' => $demande->hauteur_plafond_bureau,
            'porte_garage_bureau' => $demande->porte_garage_bureau,
            'surface_parking_travail' => $demande->surface_parking_travail,
            'autorisation_entree_travail' => $demande->autorisation_entree_travail,
            'porte_travail' => $demande->porte_travail,
            'proximite_parking_public' => $demande->proximite_parking_public,
            'main_oeuvre_seule' => $demande->main_oeuvre_seule ?? false // Add this field
        ];
    });

    return response()->json($formattedDemandes);
}
public function getDemandesParClient($client_id)
{
    $demandes = Demande::with(['voiture', 'servicePanne', 'pieceRecommandee'])
                       ->where('client_id', $client_id)
                       ->whereNull('date_maintenance')
                       ->get();

    if ($demandes->isEmpty()) {
        return response()->json(['message' => 'Aucune demande trouvée'], 404);
    }

    $formatted = $demandes->map(function ($demande) {
        return [
            'id' => $demande->id,
            'created_at' => $demande->created_at->format('Y-m-d H:i:s'),
            'voiture' => [
                'model' => $demande->voiture->model ?? null,
                'serie' => $demande->voiture->serie ?? null,
            ],
            'service_panne' => [
                'titre' => $demande->servicePanne->titre ?? null,
            ],
            'has_piece_recommandee' => $demande->pieceRecommandee ? true : false,
        ];
    });

    return response()->json($formatted, 200);
}


public function getTotalPrixPieces($id)
{
    $demande = Demande::find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    $pieces = $demande->pieces_choisies;

    // Vérifie si c'est un tableau
    if (!is_array($pieces)) {
        $pieces = json_decode($pieces, true); // au cas où ce serait une chaîne JSON
    }

    if (empty($pieces)) {
        return response()->json([
            'total_prix' => 0,
            'message' => 'Aucune pièce choisie'
        ]);
    }

    // Calcul du total
    $totalPrix = array_reduce($pieces, function ($carry, $item) {
        return $carry + ($item['prix'] ?? 0);
    }, 0);

    return response()->json([
        'total_prix' => $totalPrix
    ]);
}
public function show($id)
{
    $demande = Demande::with('client', 'voiture', 'servicePanne.categoryPane', 'forfait')->findOrFail($id);

    // Récupérer les techniciens de l'atelier (à adapter selon ta logique)
    // Supposons que tu as un atelier lié au demande ou utilisateur connecté
    $atelierId = Auth::guard('atelier')->id(); // ou autre logique

  $techniciens = User::where('role', 'technicien')
                       ->where('atelier_id', $atelierId)
                       ->get();
    return view('ateliers.show', compact('demande', 'techniciens'));
}

public function show2($id)
{
    $demande = Demande::with([
        'client:id,nom,prenom,phone',
        'voiture:id,model,serie',
        'forfait:id,nomForfait',
        'servicePanne.categoryPane:id,titre',
        'servicePanne:id,titre,category_pane_id',
        'pieceRecommandee',

    ])->findOrFail($id);

    $techniciens = User::where('role', 'technicien')
                      ->whereNull('atelier_id')
                      ->where('isActive', true)
                      ->get();

    return view('expert.show', [
        'demande' => $demande,
        'techniciens' => $techniciens
    ]);
}
public function ajouterPrixMainOeuvre(Request $request, $id)
{
    $request->validate([
        'prix_main_oeuvre' => 'required|numeric|min:0',
    ]);

    $demande = Demande::find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    $demande->prix_main_oeuvre = $request->prix_main_oeuvre;
    $demande->status = 'Une_offre_a_été_faite'; // status automatiquement mis à jour
    $demande->save();

    return response()->json([
        'message' => 'Prix de la main d\'œuvre ajouté et statut mis à jour à "Assigné"',
        'demande' => $demande
    ]);
}

public function getDemandesAvecOffrePourClient($client_id)
{
    $demandes = Demande::with(['voiture', 'servicePanne', 'pieceRecommandee'])
        ->where('client_id', $client_id)
        ->where('status', 'Une_offre_a_été_faite')
        ->get();

    if ($demandes->isEmpty()) {
        return response()->json(['message' => 'Aucune demande avec offre trouvée pour ce client'], 404);
    }

    $formatted = $demandes->map(function ($demande) {
        return [
            'id' => $demande->id,
            'created_at' => $demande->created_at->format('Y-m-d H:i:s'),
            'voiture' => [
                'model' => $demande->voiture->model ?? null,
                'serie' => $demande->voiture->serie ?? null,
            ],
            'service_panne' => [
                'titre' => $demande->servicePanne->titre ?? null,
            ],
            'status' => $demande->status,
            'has_piece_recommandee' => $demande->pieceRecommandee ? true : false,
                 'prix_main_oeuvre' => $demande->prix_main_oeuvre ?? 0,
        ];
    });

    return response()->json($formatted, 200);
}

/**
 * Accepter une offre
 */
public function accepterOffre($id)
{
    $demande = Demande::find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    $demande->status = 'offre_acceptee';
    $demande->save();

    return response()->json([
        'message' => 'Offre acceptée avec succès',
        'demande' => $demande
    ]);
}

/**
 * Refuser une offre
 */
public function refuserOffre($id)
{
    $demande = Demande::find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    $demande->status = 'offre_refusee';
    $demande->save();

    return response()->json([
        'message' => 'Offre refusée avec succès',
        'demande' => $demande
    ]);
}
public function updateTechniciens(Request $request, Demande $demande)
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
        // Récupérer les anciens techniciens pour comparaison
        $anciensTechniciens = collect($demande->techniciens ?? [])->pluck('id')->toArray();
        $nouveausTechniciens = collect($techniciensData)->pluck('id')->toArray();

        // Mise à jour de la demande
        $demande->techniciens = $techniciensData;
        $demande->status = 'Assignée';
        $demande->save();

        // Créer des notifications pour les nouveaux techniciens assignés
        $techniciensANotifier = array_diff($nouveausTechniciens, $anciensTechniciens);

        foreach ($techniciensANotifier as $technicienId) {
            $technicien = collect($techniciensData)->firstWhere('id', $technicienId);

            NotificationTechnicien::create([
                'technicien_id' => $technicienId,
                'demande_id' => $demande->id,
                'titre' => 'New request assigned',
                'message' => "A new request has been assigned to you. " .
                           "Type: {$demande->type_demande}. " .
                           "Description: " . Str::limit($demande->description, 100),
                'type' => 'assignation'
            ]);

            \Log::info("Notification créée pour le technicien {$technicien['nom']} (ID: {$technicienId})");
        }

        // Optionnel: Notifier aussi les techniciens qui ont été retirés
        $techniciensRetires = array_diff($anciensTechniciens, $nouveausTechniciens);
        foreach ($techniciensRetires as $technicienId) {
            NotificationTechnicien::create([
                'technicien_id' => $technicienId,
                'demande_id' => $demande->id,
                'titre' => 'Assignation retirée',
                'message' => "Vous n'êtes plus assigné à la demande #{$demande->id}.",
                'type' => 'modification'
            ]);
        }

        \Log::info('Demande après mise à jour:', $demande->fresh()->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Technicians assigned successfully',
            'data' => $demande->fresh(),
            'notifications_creees' => count($techniciensANotifier)
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
public function getDemandeStatistics(): JsonResponse
{
    $total = Demande::count();

    $parStatut = Demande::selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status');

    $parMois = Demande::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mois, COUNT(*) as total')
        ->groupBy('mois')
        ->orderBy('mois', 'asc')
        ->get();

    $delaiMoyen = Demande::whereNotNull('date_maintenance')
        ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, date_maintenance)) as moyenne_heures')
        ->value('moyenne_heures');

    return response()->json([
        'total' => $total,
        'par_statut' => $parStatut,
        'par_mois' => $parMois,
        'delai_moyen_heures' => round($delaiMoyen, 2),
    ]);
}


/**
 * Affiche la vue des statistiques
 */
public function showStatistics()
{
    return view('expert.statistiques');
}

}
