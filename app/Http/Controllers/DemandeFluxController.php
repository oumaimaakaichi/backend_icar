<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DemandeFlux;
use App\Models\FluxDirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\FluxPartageAvecClient;
use Illuminate\Support\Facades\Mail;
class DemandeFluxController extends Controller
{
    // Créer une demande de flux
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_flux' => 'required|exists:flux_directs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $demandeFlux = DemandeFlux::create([
            'id_flux' => $request->id_flux,
            'permission' => false, // Par défaut false
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $demandeFlux
        ], 201);
    }

    // Récupérer le flux par demande ID
    public function getFluxByDemandeId($demandeId)
    {
        $fluxDirect = FluxDirect::where('demande_id', $demandeId)
            ->with(['demandeFlux' => function($query) {
                $query->select('id', 'id_flux', 'permission');
            }])
            ->first();

        if (!$fluxDirect) {
            return response()->json([
                'status' => 'error',
                'message' => 'Flux non trouvé'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $fluxDirect
        ]);
    }

    // Mettre à jour la permission
   public function updatePermission(Request $request, $id)
{
    $demandeFlux = DemandeFlux::findOrFail($id);

    $request->validate([
        'permission' => 'required|boolean'
    ]);

    $demandeFlux->update([
        'permission' => $request->permission
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Permission mise à jour avec succès'
    ]);
}

// Récupérer une demande de flux par id_flux
public function getDemandeByIdFlux($idFlux)
{
    $demandeFlux = DemandeFlux::where('id_flux', $idFlux)->first();

    if (!$demandeFlux) {
        return response()->json([
            'status' => 'error',
            'message' => 'Demande de flux non trouvée'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'data' => $demandeFlux
    ]);
}

// api pour partager lien meet avec le client
// Autoriser le partage avec le client
public function autoriserPartage($id)
    {
        $demandeFlux = DemandeFlux::where('id_flux', $id)->first();

        if (!$demandeFlux) {
            return response()->json([
                'status' => 'error',
                'message' => 'Demande de flux non trouvée'
            ], 404);
        }

        // Récupérer les informations du flux et du client
        $fluxDirect = FluxDirect::with(['demande.client'])->find($id);

        if (!$fluxDirect || !$fluxDirect->demande || !$fluxDirect->demande->client) {
            return response()->json([
                'status' => 'error',
                'message' => 'Informations du client non trouvées'
            ], 404);
        }

        $client = $fluxDirect->demande->client;
        $lienMeet = $fluxDirect->lien_meet;

        // Mettre à jour le partage
        $demandeFlux->update([
            'partage_with_client' => true
        ]);

        // Envoyer l'email au client
        try {
            Mail::to($client->email)->send(new FluxPartageAvecClient(
                $client->name ?? $client->prenom . ' ' . $client->nom,
                $lienMeet,
                $fluxDirect->demande->id
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'sharing with the client authorized and email sent',
                'data' => $demandeFlux
            ]);

        } catch (\Exception $e) {
            // Même en cas d'erreur d'envoi d'email, le partage est autorisé
            return response()->json([
                'status' => 'success',
                'message' => 'Partage autorisé mais erreur lors de l\'envoi de l\'email: ' . $e->getMessage(),
                'data' => $demandeFlux
            ], 200);
        }
    }

}
