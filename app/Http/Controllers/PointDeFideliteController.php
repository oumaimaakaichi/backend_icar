<?php

namespace App\Http\Controllers;

use App\Models\PointDeFidelite;
use Illuminate\Http\Request;

class PointDeFideliteController extends Controller
{
    // Récupérer tous les points de fidélité
    public function index()
    {
        return response()->json(PointDeFidelite::all(), 200);
    }

    // Créer un enregistrement de points de fidélité
    public function store(Request $request)
    {
        $request->validate([
            'points_acquis' => 'required|integer',
            'points_utilises' => 'nullable|integer',
            'date_operation' => 'required|date',
            'description_operation' => 'required|string',
            'cout' => 'required|numeric',
        ]);

        $point = PointDeFidelite::create($request->all());
        return response()->json($point, 201);
    }

    // Afficher un enregistrement spécifique
    public function show($id)
    {
        $point = PointDeFidelite::find($id);
        if (!$point) {
            return response()->json(['message' => 'Enregistrement non trouvé'], 404);
        }
        return response()->json($point, 200);
    }

    // Mettre à jour un enregistrement
    public function update(Request $request, $id)
    {
        $point = PointDeFidelite::find($id);
        if (!$point) {
            return response()->json(['message' => 'Enregistrement non trouvé'], 404);
        }

        $request->validate([
            'points_acquis' => 'sometimes|integer',
            'points_utilises' => 'sometimes|integer',
            'date_operation' => 'sometimes|date',
            'description_operation' => 'sometimes|string',
            'cout' => 'sometimes|numeric',
        ]);

        $point->update($request->all());
        return response()->json($point, 200);
    }

    // Supprimer un enregistrement
    public function destroy($id)
    {
        $point = PointDeFidelite::find($id);
        if (!$point) {
            return response()->json(['message' => 'Enregistrement non trouvé'], 404);
        }

        $point->delete();
        return response()->json(['message' => 'Enregistrement supprimé'], 200);
    }
}

