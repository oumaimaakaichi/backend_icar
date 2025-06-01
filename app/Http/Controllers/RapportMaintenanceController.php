<?php

namespace App\Http\Controllers;

use App\Models\RapportMaintenance;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use PDF;

class RapportMaintenanceController extends Controller
{
    public function index()
    {
        return RapportMaintenance::with(['technicien', 'demande'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_technicien' => 'required|exists:users,id',
            'id_demande' => 'required|exists:demandes,id',
            'description' => 'required|string',
        ]);

        // Check if rapport already exists for this demande
        $existing = RapportMaintenance::where('id_demande', $validated['id_demande'])->first();

        if ($existing) {
            return response()->json([
                'message' => 'Un rapport existe déjà pour cette demande',
                'rapport' => $existing
            ], 409);
        }

        $rapport = RapportMaintenance::create($validated);
        return response()->json($rapport, 201);
    }

    public function show($id)
    {
        $rapport = RapportMaintenance::with(['technicien', 'demande'])->findOrFail($id);
        return response()->json($rapport);
    }

 // Dans le contrôleur RapportMaintenanceController, modifiez la méthode showByDemande:
public function showByDemande($demandeId)
{
    $rapport = RapportMaintenance::with(['technicien', 'demande'])
        ->where('id_demande', $demandeId)
        ->first();

    if (!$rapport) {
        return response()->json(['message' => 'Rapport non trouvé'], 404);
    }

    return response()->json($rapport);
}

    public function update(Request $request, $id)
    {
        $rapport = RapportMaintenance::findOrFail($id);

        $validated = $request->validate([
            'id_technicien' => 'sometimes|exists:users,id',
            'id_demande' => 'sometimes|exists:demandes,id',
            'description' => 'sometimes|string',
        ]);

        $rapport->update($validated);
        return response()->json($rapport);
    }

    public function destroy($id)
    {
        $rapport = RapportMaintenance::findOrFail($id);
        $rapport->delete();

        return response()->json(['message' => 'Rapport supprimé avec succès']);
    }

public function download($id)
{
    $rapport = RapportMaintenance::with([
        'technicien',
        'demande' => function($query) {
            $query->with(['client', 'servicePanne.categoryPane', 'forfait']);
        }
    ])->findOrFail($id);

    // Charger les catalogues
    $catalogues = Catalogue::all()->keyBy('id');

    $pdf = PDF::loadView('rapports.maintenance', [
        'rapport' => $rapport,
        'date' => now()->format('d/m/Y H:i'),
        'catalogues' => $catalogues
    ]);

    return $pdf->download("rapport-maintenance-{$rapport->id}.pdf");
}
}
