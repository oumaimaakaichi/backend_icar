<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceTicket;
use App\Models\TypeTickets;
use Illuminate\Support\Facades\Auth;

class MaintenanceTicketController extends Controller
{
    public function index()
    {
        $tickets = MaintenanceTicket::where('atelier_id', Auth::id())
                 // Seulement les tickets visibles
                    ->paginate(10);

        $types = TypeTickets::where('is_visible', true)->get();

        return view('ateliers.ticket_maintenance', compact('tickets', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:50',
            'priorite' => 'sometimes|string|in:basse,moyenne,haute',
            'fichier' => 'sometimes|file|max:5120',
        ]);

        $ticketData = [
            'atelier_id' => Auth::id(),
            'titre' => $request->titre,
            'description' => $request->description,
            'type' => $request->type,
            'statut' => 'en_attente',
            'priorite' => $request->priorite ?? 'moyenne',
            'isVisible' => true // Nouveau ticket toujours visible
        ];

        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('ticket_attachments');
            $ticketData['fichier'] = $path;
        }

        MaintenanceTicket::create($ticketData);

        return redirect()->back()->with('success', 'Ticket de maintenance soumis avec succès.');
    }



    public function storee(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:50',
            'client_id'=> 'required|integer|exists:users,id',
        ]);

        // Vérification que l'utilisateur a le droit d'affecter à cet atelier


        $ticket = MaintenanceTicket::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'client_id' => $validated['client_id'],
            'statut' => 'en_attente',
            'isVisible' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket créé avec succès',
            'data' => $ticket
        ], 201);
    }


    // Nouvelle méthode pour afficher un ticket
    public function show($id)
    {
        $ticket = MaintenanceTicket::where('atelier_id', Auth::id())
                 ->findOrFail($id);

        return view('ateliers.ticket_show', compact('ticket'));
    }

    // Nouvelle méthode pour désactiver un ticket
    public function disable($id)
    {
        $ticket = MaintenanceTicket::where('atelier_id', Auth::id())
                 ->findOrFail($id);

        $ticket->update(['isVisible' => false]);

        return redirect()->route('tickets.index')
               ->with('success', 'Ticket désactivé avec succès.');
    }
    // Add this method to MaintenanceTicketController.php
public function getByClient($client_id)
{
    $tickets = MaintenanceTicket::where('client_id', $client_id)
                ->where('isVisible', true)
                ->orderBy('created_at', 'desc')
                ->get();

    return response()->json([
        'success' => true,
        'data' => $tickets
    ]);
}
}
