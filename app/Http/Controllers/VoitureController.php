<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class VoitureController extends Controller
{
    public function index($client_id): JsonResponse
    {
        $voitures = Voiture::where('client_id', $client_id)->get();
        return response()->json($voitures);
    }
public function index2($client_id): JsonResponse
{
    $voitures = Voiture::where('client_id', $client_id)
        ->paginate(6);

    return response()->json([
        'data' => $voitures->items(),
        'total' => $voitures->total(),
        'current_page' => $voitures->currentPage(),
        'per_page' => $voitures->perPage(),
        'last_page' => $voitures->lastPage(),
    ]);
}
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'serie' => 'required|integer',
            'date_fabrication' => 'required|date',
            'model' => 'required|string',
            'couleur' => 'required|string',
            'company' => 'required|string',
            'numero_chassis' => 'required|string', // Changé de integer à string
            'client_id' => 'required|exists:users,id',
        ]);

        $voiture = Voiture::create([
            'serie' => $request->serie,
            'date_fabrication' => $request->date_fabrication,
            'model' => $request->model,
            'couleur' => $request->couleur,
            'company' => $request->company,
            'numero_chassis' => $request->numero_chassis, // Maintenant accepté comme string
            'client_id' => $request->client_id,
        ]);

        return response()->json([
            'message' => 'Voiture ajoutée avec succès.',
            'data' => $voiture
        ], 201);
    }


    public function show($id): JsonResponse
    {
        $voiture = Voiture::findOrFail($id);

        // Optionnel : vérifier que la voiture appartient au client connecté
        if ($voiture->client_id !== Auth::id()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        return response()->json($voiture);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $voiture = Voiture::findOrFail($id);



        $request->validate([
            'serie' => 'sometimes|integer',
            'date_fabrication' => 'sometimes|date',
            'model' => 'sometimes|string',
            'couleur' => 'sometimes|string',
            'company' => 'sometimes|string',
            'numero_chassis' => 'sometimes|integer',
        ]);

        $voiture->update($request->only([
            'serie', 'date_fabrication', 'model', 'couleur', 'company', 'numero_chassis'
        ]));

        return response()->json($voiture);
    }

    public function destroy($id): JsonResponse
    {
        $voiture = Voiture::findOrFail($id);


        $voiture->delete();
        return response()->json(null, 204);
    }
}

