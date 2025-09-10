<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RecusController extends Controller
{
    /**
     * Récupérer tous les reçus d'un client
     */
    public function mesRecus($clientId): JsonResponse
    {
        try {
            // Vérifier que le client existe
            $client = User::find($clientId);
            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client non trouvé',
                ], 404);
            }

            // Récupérer tous les paiements du client avec les relations
            $paiements = Paiement::with([
                'demande.voiture',
                'demande.client'
            ])
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'desc')
            ->get();

            // Formatter les données pour l'app Flutter
          // Formatter les données pour l'app Flutter
$recus = $paiements->map(function ($paiement) {
    // Choisir la demande selon le type
    $demande = $paiement->demande ?? $paiement->demandeConnu;

    return [
        'id' => $paiement->id,
        'montant' => $paiement->montant,
        'methode' => $paiement->methode,
        'date_paiement' => $paiement->date_paiement,
        'created_at' => $paiement->created_at,
        'pdf_url' => asset('storage/recus/recu_' . $paiement->id . '.pdf'),
        'demande_id' => $paiement->demande_id ?? $paiement->demande_connu_id,
        'demande' => $demande ? [
            'id' => $demande->id,
            'description' => $demande->description_probleme ?? '',
            'statut' => $demande->statut ?? '',
            'voiture' => [
                'marque' => $demande->voiture->company ?? '',
                'modele' => $demande->voiture->model ?? '',
                'immatriculation' => $demande->voiture->serie ?? '',
            ]
        ] : null
    ];
});


            return response()->json([
                'success' => true,
                'message' => 'Reçus récupérés avec succès',
                'recus' => $recus,
                'total' => $recus->count(),
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des reçus:', [
                'client_id' => $clientId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des reçus: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Télécharger un reçu spécifique
     */
    public function downloadRecu($paiementId)
    {
        try {
            $paiement = Paiement::find($paiementId);

            if (!$paiement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paiement non trouvé',
                ], 404);
            }

            $pdfPath = storage_path('app/public/recus/recu_' . $paiement->id . '.pdf');

            if (!file_exists($pdfPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fichier PDF non trouvé',
                ], 404);
            }

            return response()->download($pdfPath, 'recu_' . $paiement->id . '.pdf');

        } catch (\Exception $e) {
            \Log::error('Erreur lors du téléchargement du reçu:', [
                'paiement_id' => $paiementId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléchargement',
            ], 500);
        }
    }

    /**
     * Régénérer un reçu PDF
     */
    public function regenererRecu($paiementId)
    {
        try {
            $paiement = Paiement::with(['demande.client', 'demande.voiture'])->find($paiementId);

            if (!$paiement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paiement non trouvé',
                ], 404);
            }

            // Créer le dossier s'il n'existe pas
            $recuDir = storage_path('app/public/recus');
            if (!file_exists($recuDir)) {
                mkdir($recuDir, 0755, true);
            }

            // Générer le PDF
            $pdf = \PDF::loadView('recu', [
                'paiement' => $paiement,
                'demande' => $paiement->demande,
                'client' => $paiement->demande->client,
                'voiture' => $paiement->demande->voiture,
            ]);

            $pdfPath = storage_path('app/public/recus/recu_' . $paiement->id . '.pdf');
            $pdf->save($pdfPath);

            return response()->json([
                'success' => true,
                'message' => 'Reçu régénéré avec succès',
                'pdf_url' => asset('storage/recus/recu_' . $paiement->id . '.pdf'),
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la régénération du reçu:', [
                'paiement_id' => $paiementId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la régénération: ' . $e->getMessage(),
            ], 500);
        }
    }
}
