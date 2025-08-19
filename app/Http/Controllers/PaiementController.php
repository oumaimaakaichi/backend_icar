<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\DemandePanneInconnu;
use Illuminate\Http\Request;
use PDF;

class PaiementController extends Controller
{
    public function payer(Request $request, $demandeId)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'methode' => 'required|in:cash,card,transfer',
            'prix_total' => 'required|numeric|min:0',
        ]);

        $demande = DemandePanneInconnu::with(['client', 'voiture'])->findOrFail($demandeId);

        \Log::info('Données reçues du Flutter:', [
            'methode' => $validated['methode'],
            'prix_total' => $validated['prix_total'],
            'type_prix' => gettype($validated['prix_total']),
            'demande_id' => $demandeId,
            'client_id' => $demande->client_id
        ]);

        try {
            // CORRECTION: Utiliser 'montant' au lieu de la clé validée
            $paiement = Paiement::create([
                'demande_id' => $demande->id,
                'client_id' => $demande->client_id, // Ajout du client_id
                'montant' => $validated['prix_total'], // Correction ici
                'methode' => $validated['methode'],
                'date_paiement' => now(),
            ]);

            \Log::info('Paiement créé avec succès:', [
                'paiement_id' => $paiement->id,
                'montant_enregistré' => $paiement->montant
            ]);

            // Mettre à jour le statut de la demande
            $demande->update(['statut' => 'paye']);

            // Créer le dossier s'il n'existe pas
            $recuDir = storage_path('app/public/recus');
            if (!file_exists($recuDir)) {
                mkdir($recuDir, 0755, true);
            }

            // Générer le PDF
            $pdf = PDF::loadView('recu', [
                'paiement' => $paiement,
                'demande' => $demande,
                'client' => $demande->client,
                'voiture' => $demande->voiture,
            ]);

            $pdfPath = storage_path('app/public/recus/recu_' . $paiement->id . '.pdf');
            $pdf->save($pdfPath);

            return response()->json([
                'success' => true,
                'message' => 'Paiement effectué avec succès',
                'data' => $paiement,
                'pdf_url' => asset('storage/recus/recu_' . $paiement->id . '.pdf'),
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du paiement:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du paiement: ' . $e->getMessage(),
            ], 500);
        }
    }
}
