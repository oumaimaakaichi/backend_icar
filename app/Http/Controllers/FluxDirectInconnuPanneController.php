<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FluxDirectInconnuPanne;
use App\Models\DemandePanneInconnu;
use App\Models\User;
class FluxDirectInconnuPanneController extends Controller
{
   public function store(Request $request)
{
    $validated = $request->validate([
        'demande_id' => 'required|exists:demandes_panne_inconnue,id',
        'technicien_id' => 'required|exists:users,id',
        'lien_meet' => 'required|string|url',
          'type_meet' => 'required|string',
    ]);

    $flux = FluxDirectInconnuPanne::create([
        'demande_id' => $validated['demande_id'],
        'technicien_id' => $validated['technicien_id'],
        'lien_meet' => $validated['lien_meet'],
        'ouvert' => true,
        'type_meet' => $validated['type_meet'],
    ]);

    return response()->json([
        'message' => 'Lien Meet enregistré avec succès.',
        'flux' => $flux,
    ], 201);
}

public function fermerFlux($fluxId)
{
    $flux = FluxDirectInconnuPanne::findOrFail($fluxId);

    // Vérification des permissions (exemple)


    $flux->update(['ouvert' => false]);

    return response()->json([
        'success' => true,
        'message' => 'tream closed successfully',
        'flux' => $flux
    ]);
}

public function getFluxParDemande($demandeId)
{
    $flux = FluxDirectInconnuPanne::where('demande_id', $demandeId)->first();

    if ($flux) {
        return response()->json([
            'lien_meet' => $flux->lien_meet,
            'id_flux' => $flux->id,
            'has_demande_flux' => $flux->demandeFlux ? true : false,
            'ouvert'  => $flux->ouvert ?  true : false,
        ]);
    }

    return response()->json([
        'lien_meet' => null,
        'has_demande_flux' => false
    ], 200);
}



public function getFluxParDemandeEntretient($demandeId)
{
  $flux = FluxDirectInconnuPanne::where('demande_id', $demandeId)
            ->where('type_meet', 'Entretient')
            ->first();
  if ($flux) {
        return response()->json([
            'lien_meet' => $flux->lien_meet,
            'id_flux' => $flux->id,
            'has_demande_flux' => $flux->demandeFlux ? true : false,
            'ouvert'  => $flux->ouvert ?  true : false,
        ]);
    }

    return response()->json([
        'lien_meet' => null,
        'has_demande_flux' => false
    ], 200);
}
 public function getFluxForDemande($demandeId)
    {
        $flux = FluxDirectInconnuPanne::with(['demandeFlux', 'technicien'])
            ->where('demande_id', $demandeId)
            ->first();

        if (!$flux) {
            return response()->json(['message' => 'Flux non trouvé'], 404);
        }

        return response()->json($flux);
    }
     public function getOrCreate($demandeId, $technicienId)
    {
        $demande = DemandePanneInconnu::findOrFail($demandeId);
        $technicien = User::findOrFail($technicienId);

        // Vérifier si un flux existe déjà
        $flux = FluxDirectInconnuPanne::where('demande_id', $demandeId)
                         ->where('technicien_id', $technicienId)
                         ->first();



        return response()->json([
            'success' => true,
            'flux' => $flux,
            'message' => 'Flux direct disponible'
        ]);
    }

    // Afficher le flux direct
    public function show(FluxDirectInconnuPanne $flux)
    {
        // Vérifier que l'utilisateur a le droit d'accéder à ce flux
        if (auth()->id() !== $flux->technicien_id &&
            auth()->id() !== $flux->demande->client_id) {
            abort(403);
        }

        return view('flux-direct.show', compact('flux'));
    }
}
