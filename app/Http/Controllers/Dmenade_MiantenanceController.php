<?php

namespace App\Http\Controllers;
use App\Models\DemandeMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Dmenade_MiantenanceController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(DemandeMaintenance::all());
    }


   // Dans votre contrôleur
public function getByUserAtelier(Request $request)
{
    if (!Auth::user()->atelier_id) {
        return redirect()->back()->with('error', 'User is not associated with any workshop');
    }

    $demandes = DemandeMaintenance::where('atelier_id', Auth::user()->atelier_id)
        ->with('atelier')
        ->get();

    return view('expert.demande_maintenance', ['demandes' => $demandes]);
}
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'type_service' => 'required|string',
            'type_assistance' => 'required|string',
            'type_maintenance' => 'required|string',
            'type_voiture' => 'required|string',
            'piece_rechange' => 'required|string',
            'emplacement' => 'required|string',
            'donnees_carte' => 'required|string',
        ]);

        $demande = DemandeMaintenance::create($request->all());
        return response()->json($demande, 201);
    }

    public function show($id): JsonResponse
    {
        return response()->json(DemandeMaintenance::findOrFail($id));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $demande = DemandeMaintenance::findOrFail($id);
        $demande->update($request->all());
        return response()->json($demande);
    }

    public function destroy($id): JsonResponse
    {
        DemandeMaintenance::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
