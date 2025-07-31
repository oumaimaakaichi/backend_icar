<?php

namespace App\Http\Controllers;

use App\Models\Atelier;
use App\Models\AtelierAvailability;
use Illuminate\Http\Request;

class AtelierAvailabilityController extends Controller
{
    /**
     * Afficher le formulaire de disponibilité
     */
    public function showForm($atelierId)
    {
        // Rechercher l'atelier avec ses disponibilités
        $atelier = Atelier::with('availabilities')->find($atelierId);

        // Vérifier si l'atelier existe
        if (!$atelier) {
            return redirect()->route('home')->with('error', 'Atelier non trouvé.');
        }

        return view('ateliers.availability', compact('atelier'));
    }

    /**
     * Enregistrer les disponibilités
     */
    public function store(Request $request, $atelierId)
    {
        // Validation
        $request->validate([
            'availabilities' => 'required|array',
            'availabilities.*.start' => 'nullable|date_format:H:i',
            'availabilities.*.end' => 'nullable|date_format:H:i',
        ]);

        $atelier = Atelier::findOrFail($atelierId);

        // Supprimer les anciennes disponibilités
        $atelier->availabilities()->delete();

        // Ajouter les nouvelles disponibilités
        foreach ($request->availabilities as $day => $times) {
            if (!empty($times['start']) && !empty($times['end'])) {
                AtelierAvailability::create([
                    'atelier_id' => $atelier->id,
                    'day' => $day,
                    'start_time' => $times['start'],
                    'end_time' => $times['end'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Disponibilités mises à jour avec succès.');
    }
}
