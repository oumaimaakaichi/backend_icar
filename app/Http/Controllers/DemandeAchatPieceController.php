<?php
namespace App\Http\Controllers;

use App\Models\DemandeAchatPiece;
use App\Models\Panier;
use Illuminate\Http\Request;

class DemandeAchatPieceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.catalogue_id' => 'required|exists:catalogues,id',
            'client_id' => 'required|exists:users,id',
            'items.*.quantite' => 'required|integer|min:1',
        ]);

        $clientId = $request->client_id;
        $createdDemandes = [];

        foreach ($request->items as $item) {
            // Création de la demande d'achat
            $demande = DemandeAchatPiece::create([
                'catalogue_id' => $item['catalogue_id'],
                'client_id' => $clientId,
                'quantite' => $item['quantite'],
            ]);

            // Suppression du panier correspondant
            Panier::where('catalogue_id', $item['catalogue_id'])
                  ->where('client_id', $clientId)
                  ->delete();

            $createdDemandes[] = $demande;
        }

        return response()->json([
            'message' => 'Demandes ajoutées avec succès et articles retirés du panier.',
            'data' => $createdDemandes
        ], 201);
    }
}
