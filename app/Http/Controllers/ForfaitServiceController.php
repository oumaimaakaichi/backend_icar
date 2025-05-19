<?php

namespace App\Http\Controllers;

use App\Models\ForfaitService;
use Illuminate\Http\Request;

class ForfaitServiceController extends Controller
{
    public function index()
    {
        return response()->json(ForfaitService::with('servicePanne')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'rival' => 'nullable|string|max:255',
            'service_panne_id' => 'required|exists:service_pannes,id',
        ]);

        $forfait = ForfaitService::create($validated);

        return response()->json($forfait, 201);
    }

    public function show($id)
    {
        $forfait = ForfaitService::with('servicePanne')->findOrFail($id);
        return response()->json($forfait);
    }

    public function update(Request $request, $id)
    {
        $forfait = ForfaitService::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'sometimes|required|numeric',
            'rival' => 'nullable|string|max:255',
            'service_panne_id' => 'sometimes|required|exists:service_pannes,id',
        ]);

        $forfait->update($validated);

        return response()->json($forfait);
    }

    public function destroy($id)
    {
        $forfait = ForfaitService::findOrFail($id);
        $forfait->delete();

        return response()->json(['message' => 'Forfait supprimé avec succès']);
    }


    public function getByService($serviceId)
{
    $forfaits = ForfaitService::where('service_panne_id', $serviceId)->get();

    return response()->json($forfaits);
}

}
