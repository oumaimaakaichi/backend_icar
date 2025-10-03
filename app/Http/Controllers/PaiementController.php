<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\DemandePanneInconnu;
use App\Models\Demande;
use Illuminate\Http\Request;
use PDF;

class PaiementController extends Controller
{
    // Paiement pour une Demande Inconnue
    public function payer(Request $request, $demandeId)
    {
        $validated = $request->validate([
            'methode' => 'required|in:cash,card,transfer',
            'prix_total' => 'required|numeric|min:0',
        ]);

        $demande = DemandePanneInconnu::with(['client', 'voiture'])->findOrFail($demandeId);

        try {
            $paiement = Paiement::create([
                'demande_id' => $demande->id,
                'client_id' => $demande->client_id,
                'montant' => $validated['prix_total'],
                'methode' => $validated['methode'],
                'date_paiement' => now(),
            ]);

            $demande->update(['statut' => 'paye']);

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
                'message' => 'Payment completed successfully',
                'data' => $paiement,
                'pdf_url' => asset('storage/recus/recu_' . $paiement->id . '.pdf'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du paiement: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ✅ Paiement pour une Demande Connue
    public function payerConnu(Request $request, $demandeConnuId)
    {
        $validated = $request->validate([
            'methode' => 'required|in:cash,card,transfer',
            'prix_total' => 'required|numeric|min:0',
        ]);

        $demandeConnu = Demande::with(['client', 'voiture'])->findOrFail($demandeConnuId);

        try {
            $paiement = Paiement::create([
                'demande_connu_id' => $demandeConnu->id, // ✅ Utilisation du nouvel attribut
                'client_id' => $demandeConnu->client_id,
                'montant' => $validated['prix_total'],
                'methode' => $validated['methode'],
                'date_paiement' => now(),
            ]);

            $demandeConnu->update(['statut' => 'paye']);

            $pdf = PDF::loadView('recu', [
                'paiement' => $paiement,
                'demande' => $demandeConnu,
                'client' => $demandeConnu->client,
                'voiture' => $demandeConnu->voiture,
            ]);

            $pdfPath = storage_path('app/public/recus/recu_' . $paiement->id . '.pdf');
            $pdf->save($pdfPath);

            return response()->json([
                'success' => true,
                'message' => 'Payment completed successfully',
                'data' => $paiement,
                'pdf_url' => asset('storage/recus/recu_' . $paiement->id . '.pdf'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du paiement (demande connue): ' . $e->getMessage(),
            ], 500);
        }
    }
}
