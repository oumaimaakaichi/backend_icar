<?php
namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Voiture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth; // ✅ Ceci est correct

class DemandeController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'forfait_id' => 'required|exists:forfaits,id',
        'service_panne_id' => 'required|exists:service_pannes,id',
        'voiture_id' => 'required|exists:voitures,id',
    ]);

    // Récupérer la voiture pour obtenir le client_id
    $voiture = Voiture::findOrFail($request->voiture_id);
    $clientId = $voiture->client_id;

    // Créer la demande
    $demande = Demande::create([
        'forfait_id' => $request->forfait_id, // Correction ici
        'service_panne_id' => $request->service_panne_id,
        'voiture_id' => $request->voiture_id,
        'client_id' => $clientId,
    ]);

    return response()->json([
        'message' => 'Demande créée avec succès',
        'demande' => $demande,
    ], 201);
}


public function updatePiecesChoisies(Request $request, Demande $demande)
{
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
            // Ajoutez d'autres champs si nécessaire
        ];
    }, $request->pieces);

    // Enregistrer les pièces choisies
    $demande->update([
        'pieces_choisies' => $piecesChoisies,

    ]);

    return response()->json([
        'success' => true,
        'message' => 'Pièces choisies enregistrées avec succès',
        'data' => $demande->fresh() // Retourne les données mises à jour
    ]);
}
public function showDemandesParAtelierPage()
{
    $atelier = Auth::guard('atelier')->user(); // atelier connecté

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
    ])->where('atelier_id', $atelier->id)->get();

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

public function updateInfo(Request $request, $id)
{
    // Validation des champs
    $validated = $request->validate([
        'type_emplacement' => 'nullable|string|max:255',
        'date_maintenance' => 'nullable|date',
        'heure_maintenance' => 'nullable|date_format:H:i', // Ajout pour l'heure
        'atelier_id' => 'nullable|exists:ateliers,id',
    ]);

    // Récupération de la demande
    $demande = Demande::find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    // Mise à jour des champs autorisés
    $demande->type_emplacement = $validated['type_emplacement'] ?? $demande->type_emplacement;

    // Combiner date et heure si elles sont fournies
    if (isset($validated['date_maintenance'])) {
        $dateMaintenance = $validated['date_maintenance'];
        if (isset($validated['heure_maintenance'])) {
            $dateMaintenance .= ' ' . $validated['heure_maintenance'];
        }
        $demande->date_maintenance = $dateMaintenance;
    }

    $demande->atelier_id = $validated['atelier_id'] ?? $demande->atelier_id;
    $demande->save();

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
        'atelier'
    ])->find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    // Calcul du total des pièces
    $pieces = $demande->pieces_choisies ?? [];
    if (!is_array($pieces)) {
        $pieces = json_decode($pieces, true) ?? [];
    }

    $totalPieces = array_reduce($pieces, function($carry, $item) {
        return $carry + ($item['prix'] ?? 0);
    }, 0);

    return response()->json([
        'service_titre' => $demande->servicePanne->titre ?? 'Non spécifié',
        'voiture_model' => $demande->voiture->model ?? 'Non spécifié',
        'total_pieces' => $totalPieces,
        'total_main_oeuvre' => $demande->prix_main_oeuvre ?? 0,
        'pieces_choisies' => $pieces,
        'date_maintenance' => $demande->date_maintenance,
        'atelier' => $demande->atelier,
    ]);
}
public function getDemandesParClient($client_id)
{
    $demandes = Demande::with(['voiture', 'servicePanne', 'pieceRecommandee'])
                       ->where('client_id', $client_id)
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
    $request->validate([
        'techniciens' => 'required|array',
        'techniciens.*.id_technicien' => 'required|integer',
        'techniciens.*.nom' => 'required|string|max:255',
    ]);

    $demande->techniciens = $request->techniciens;
    $demande->save();

    return response()->json([
        'success' => true,
        'message' => 'Techniciens mis à jour avec succès',
        'data' => $demande->fresh(),
    ]);
}

}
