<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rapport;

use Illuminate\Http\JsonResponse;
class RapportController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Rapport::all());
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'number' => 'required|integer',
            'date_maintenance' => 'required|date',
            'photos_jointes' => 'nullable|string',
        ]);

        $rapport = Rapport::create($request->all());
        return response()->json($rapport, 201);
    }

    public function show($id): JsonResponse
    {
        return response()->json(Rapport::findOrFail($id));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $rapport = Rapport::findOrFail($id);
        $rapport->update($request->all());
        return response()->json($rapport);
    }

    public function destroy($id): JsonResponse
    {
        Rapport::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
