<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServicePanne; // Correction: Utilisez le bon modèle
use Illuminate\Http\Request;

class ServicePanneController extends Controller
{
    public function getByCategory($categoryId)
    {
        if (!\App\Models\CategoryPane::find($categoryId)) {
            return response()->json(['error' => 'Catégorie non trouvée'], 404);
        }

        $services = ServicePanne::where('category_pane_id', $categoryId)
            ->with('categoryPane')
            ->get();

        return response()->json($services);
    }


    public function index()
    {
        return ServicePanne::with('categoryPane')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_pane_id' => 'required|exists:category_panes,id',
        ]);

        $service = ServicePanne::create($validated);
        return response()->json($service, 201);
    }

    public function show($id)
    {
        $service = ServicePanne::with('categoryPane')->findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        $service = ServicePanne::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category_pane_id' => 'sometimes|required|exists:category_panes,id',
        ]);

        $service->update($validated);
        return response()->json($service);
    }

    public function destroy($id)
    {
        ServicePanne::destroy($id);
        return response()->json(['message' => 'Service supprimé']);
    }
}
