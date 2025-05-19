<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(6);
        return view('Categories.service', compact('services'));
    }

    public function show(Service $service)
    {
        return view('service.show', compact('service'));
    }

    public function create()
    {
        return view('service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomService' => 'required|string|max:255|unique:services',
            'payeFabrication' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'rival' => 'required|numeric|min:0|max:100',
        ]);

        Service::create([
            'nomService' => $request->nomService,
            'payeFabrication' => $request->payeFabrication,
            'prix' => $request->prix,
            'rival' => $request->rival,
            'isVisible' => true // Ajout explicite
        ]);

        return redirect()->route('service.index')
                         ->with('success', 'Service créé avec succès');
    }
    public function edit(Service $service)
    {
        return view('service.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
{
    $request->validate([
        'nomService' => 'required|string|max:255|unique:services,nomService,' . $service->id,
        'payeFabrication' => 'required|string|max:255',
        'prix' => 'required|numeric|min:0',
        'rival' => 'required|numeric|min:0|max:100',
    ]);

    $service->update($request->all());

    return redirect()->route('service.index')
                     ->with('success', 'Service mis à jour avec succès');
}
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('service.index')
                         ->with('success', 'Service supprimé avec succès');
    }

    public function toggleVisibility(Service $service)
    {
        $service->update(['isVisible' => !$service->isVisible]);

        return back()->with('success', 'Visibilité du service mise à jour');
    }
}
