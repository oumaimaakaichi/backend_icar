<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DemandeFluxInconnuPanne;
use App\Models\FluxDirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemandeFluxInconnuPanneController extends Controller
{
    // Créer une demande de flux
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_flux' => 'required|exists:flux_direct_inconnu_pannes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $demandeFlux = DemandeFluxInconnuPanne::create([
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
        $fluxDirect = DemandeFluxInconnuPanne::where('demande_id', $demandeId)
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
    $demandeFlux = DemandeFluxInconnuPanne::findOrFail($id);

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
    $demandeFlux = DemandeFluxInconnuPanne::where('id_flux', $idFlux)->first();

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
    $demandeFlux = DemandeFluxInconnuPanne::where('id_flux', $id)->first();

    if (!$demandeFlux) {
        return response()->json([
            'status' => 'error',
            'message' => 'Demande de flux non trouvée'
        ], 404);
    }

    $demandeFlux->update([
        'partage_with_client' => true
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Partage avec le client autorisé',
        'data' => $demandeFlux
    ]);
}

}
