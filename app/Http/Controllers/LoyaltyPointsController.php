<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyPoint;
use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Http\Request;

class LoyaltyPointsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $points = LoyaltyPoint::with(['user', 'technician', 'sparePart'])
                    ->latest()
                    ->paginate(10);

        $spareParts = Catalogue::all();
        $technicians = User::where('role', 'technician')->get();
        $users = User::all();

        return view('loyalty-points.index', compact('points', 'spareParts', 'technicians', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données entrantes
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'technician_id' => 'required|exists:users,id',
            'spare_part_id' => 'required|exists:spare_parts,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:credit,debit',
            'adjustment_factor' => 'required|numeric|min:0.1|max:10',
            'actual_value' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $catalogue = Catalogue::find($validated['spare_part_id']);
        if (!$catalogue) {
            return back()->withErrors(['spare_part_id' => 'Pièce introuvable'])->withInput();
        }

        // Calcul des points
        $points = ($validated['actual_value'] * $validated['adjustment_factor']) * $validated['quantity'];

        // Si débit, vérifier le solde de points
        if ($validated['type'] === 'debit') {
            $userBalance = LoyaltyPoint::where('user_id', $validated['user_id'])->sum('points');

            if ($userBalance < $points) {
                return back()->withErrors(['points' => 'Le solde du client est insuffisant'])->withInput();
            }

            $points = -$points; // On rend les points négatifs en cas de débit
        }

        // Création de la transaction
        LoyaltyPoint::create([
            'user_id' => $validated['user_id'],
            'technician_id' => $validated['technician_id'],
            'spare_part_id' => $validated['spare_part_id'],
            'type' => $validated['type'],
            'points' => $points,
            'actual_value' => $validated['actual_value'],
            'adjustment_factor' => $validated['adjustment_factor'],
            'quantity' => $validated['quantity'],
            'notes' => $validated['notes'] ?? "Transaction pour {$sparePart->nom_piece} (x{$validated['quantity']})"
        ]);

        return redirect()->route('loyalty-points.index')
            ->with('success', 'Transaction enregistrée avec succès.');
    }


    // ... autres méthodes (show, edit, update, destroy)
}
