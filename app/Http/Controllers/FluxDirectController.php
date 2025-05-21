<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FluxDirect;
use App\Models\Demande;
use App\Models\User;
class FluxDirectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'technicien_id' => 'required|exists:users,id',
            'lien_meet' => 'required|string|url', // on vérifie que c'est bien une URL
        ]);

        $flux = FluxDirect::create([
            'demande_id' => $request->demande_id,
            'technicien_id' => $request->technicien_id,
            'lien_meet' => $request->lien_meet,
        ]);

        return response()->json([
            'message' => 'Lien Google Meet enregistré avec succès.',
            'flux' => $flux,
        ], 201);
    }



     public function getOrCreate($demandeId, $technicienId)
    {
        $demande = Demande::findOrFail($demandeId);
        $technicien = User::findOrFail($technicienId);

        // Vérifier si un flux existe déjà
        $flux = FluxDirect::where('demande_id', $demandeId)
                         ->where('technicien_id', $technicienId)
                         ->first();



        return response()->json([
            'success' => true,
            'flux' => $flux,
            'message' => 'Flux direct disponible'
        ]);
    }

    // Afficher le flux direct
    public function show(FluxDirect $flux)
    {
        // Vérifier que l'utilisateur a le droit d'accéder à ce flux
        if (auth()->id() !== $flux->technicien_id &&
            auth()->id() !== $flux->demande->client_id) {
            abort(403);
        }

        return view('flux-direct.show', compact('flux'));
    }
}
