<?php

namespace App\Http\Controllers;

use App\Models\RapportDemandeInconnu;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use PDF;

class RapportMaintenanceInconnuController extends Controller
{
    public function index()
    {
        return RapportDemandeInconnu::with(['technicien', 'demande'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_technicien' => 'required|exists:users,id',
            'id_demande' => 'required|exists:demandes_panne_inconnue,id',
            'description' => 'required|string',
        ]);

        // Check if rapport already exists for this demande
        $existing = RapportDemandeInconnu::where('id_demande', $validated['id_demande'])->first();

        if ($existing) {
            return response()->json([
                'message' => 'Un rapport existe déjà pour cette demande',
                'rapport' => $existing
            ], 409);
        }

        $rapport = RapportDemandeInconnu::create($validated);
        return response()->json($rapport, 201);
    }

    public function show($id)
    {
        $rapport = RapportDemandeInconnu::with(['technicien', 'demande'])->findOrFail($id);
        return response()->json($rapport);
    }

 // Dans le contrôleur RapportMaintenanceController, modifiez la méthode showByDemande:
public function showByDemande($demandeId)
{
    $rapport = RapportDemandeInconnu::with(['technicien', 'demande'])
        ->where('id_demande', $demandeId)
        ->first();

    if (!$rapport) {
        return response()->json(['message' => 'Rapport non trouvé'], 404);
    }

    return response()->json($rapport);
}

    public function update(Request $request, $id)
    {
        $rapport = RapportDemandeInconnu::findOrFail($id);

        $validated = $request->validate([
            'id_technicien' => 'sometimes|exists:users,id',
            'id_demande' => 'sometimes|exists:demandes_panne_inconnue,id',
            'description' => 'sometimes|string',
        ]);

        $rapport->update($validated);
        return response()->json($rapport);
    }

    public function destroy($id)
    {
        $rapport = RapportDemandeInconnu::findOrFail($id);
        $rapport->delete();

        return response()->json(['message' => 'Rapport supprimé avec succès']);
    }

public function download($id)
{
    $rapport = RapportDemandeInconnu::with([
        'technicien',
        'demande' => function($query) {
            $query->with(['client', 'voiture']);
        }
    ])->findOrFail($id);

    // Charger les catalogues
    $catalogues = Catalogue::all()->keyBy('id');

    $pdf = PDF::loadView('rapports.maintenanceInconnu', [
        'rapport' => $rapport,
        'date' => now()->format('d/m/Y H:i'),
        'catalogues' => $catalogues
    ]);

    return $pdf->download("rapport-maintenance-{$rapport->id}.pdf");
}
}
