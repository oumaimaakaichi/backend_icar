<?php

namespace App\Http\Controllers;

use App\Models\Forfait;
use App\Models\ServicePanne;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ForfaitController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $servicePannes = ServicePanne::all();
        $forfaits = Forfait::with('servicePannes')->paginate(6);
        return view('Categories.forfait', compact('forfaits', 'servicePannes'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        $servicePannes = ServicePanne::all();
        return view('forfait.create', compact('servicePannes'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomForfait' => 'required|string|max:255',
            'prixForfait' => 'required|numeric|min:0',
            'rival' => 'required|numeric|min:0|max:100',
            'service_pannes' => 'required|array',
            'service_pannes.*' => 'exists:service_pannes,id',
        ]);

        $forfait = Forfait::create([
            'nomForfait' => $validated['nomForfait'],
            'prixForfait' => $validated['prixForfait'],
            'rival' => $validated['rival'],
        ]);

        // Attach service pannes with their prices
        $servicePannesWithPrices = [];
        foreach ($validated['service_pannes'] as $servicePanneId) {
            $servicePanne = ServicePanne::find($servicePanneId);
            $servicePannesWithPrices[$servicePanneId] = ['prix' => $servicePanne->prix ?? 0];
        }

        $forfait->servicePannes()->attach($servicePannesWithPrices);

        return redirect()->route('forfait.index')->with('success', 'Forfait created successfully.');
    }

    // Display the specified resource
    public function show(Forfait $forfait)
    {
        $forfait->load('servicePannes');
        return view('forfait.show', compact('forfait'));
    }

    // Show the form for editing the specified resource
    public function edit(Forfait $forfait)
    {
        $forfait->load('servicePannes');
        $servicePannes = ServicePanne::all();
        return view('forfait.edit', compact('forfait', 'servicePannes'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Forfait $forfait)
    {
        $validated = $request->validate([
            'nomForfait' => 'required|string|max:255',
            'prixForfait' => 'required|numeric|min:0',
            'rival' => 'required|numeric|min:0|max:100',
            'service_pannes' => 'required|array',
            'service_pannes.*' => 'exists:service_pannes,id',
        ]);

        $forfait->update([
            'nomForfait' => $validated['nomForfait'],
            'prixForfait' => $validated['prixForfait'],
            'rival' => $validated['rival'],
        ]);

        // Sync service pannes with their prices
        $servicePannesWithPrices = [];
        foreach ($validated['service_pannes'] as $servicePanneId) {
            $servicePanne = ServicePanne::find($servicePanneId);
            $servicePannesWithPrices[$servicePanneId] = ['prix' => $servicePanne->prix ?? 0];
        }

        $forfait->servicePannes()->sync($servicePannesWithPrices);

        return redirect()->route('forfait.index')->with('success', 'Forfait updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(Forfait $forfait)
    {
        $forfait->servicePannes()->detach();
        $forfait->delete();
        return redirect()->route('forfait.index')->with('success', 'Forfait deleted successfully.');
    }

    public function getAllForfait()
    {
        $forfaits = Forfait::select('id', 'nomForfait')->get();
        return response()->json($forfaits);
    }

public function getAllForfaitsWithServicePannes(): JsonResponse
{
    $forfaits = Forfait::with('servicePannes')->get();
    return response()->json($forfaits);
}
}
