<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    public function index()
    {
        $spareParts = SparePart::all();
        return view('spare-parts.index', compact('spareParts'));
    }

    public function create()
    {
        return view('spare-parts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_point_value' => 'required|numeric|min:0'
        ]);

        SparePart::create($validated);

        return redirect()->route('spare-parts.index')
            ->with('success', 'Pièce de rechange créée avec succès');
    }

    // ... autres méthodes (show, edit, update, destroy)
}
