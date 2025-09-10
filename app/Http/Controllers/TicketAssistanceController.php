<?php

namespace App\Http\Controllers;

use App\Models\TicketAssistance;
use Illuminate\Http\Request;

class TicketAssistanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'message' => 'required|string',
            'titre' => 'required|string',
        ]);

        $ticket = TicketAssistance::create([
            'user_id' => $request->user_id,
            'type' => $request->type,
            'message' => $request->message,
            'titre' => $request->titre,
            'statut' => 'en attente',
        ]);

        return response()->json($ticket, 201);
    }

    public function getUserTickets($userId)
    {
        $tickets = TicketAssistance::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($tickets);
    }

    public function getTicketTypes()
    {
        $types = [
            ['id' => 1, 'type' => 'Problème technique'],
            ['id' => 2, 'type' => 'Question sur le service'],
            ['id' => 3, 'type' => 'Problème de paiement'],
            ['id' => 4, 'type' => 'Autre'],
        ];

        return response()->json($types);
    }

    public function show($id)
    {
        return TicketAssistance::with('user')->findOrFail($id);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reponse' => 'required|string',
        ]);

        $ticket = TicketAssistance::findOrFail($id);
        $ticket->update([
            'reponse' => $request->reponse,
            'statut' => 'traite',
        ]);

        return response()->json(['message' => 'Response saved successfully.']);
    }
   public function index()
{
    $tickets = TicketAssistance::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(3);

    return view('admin.ticketAssistance', ['tickets' => $tickets]); 
}
public function closeTicket($id)
{
    $ticket = TicketAssistance::findOrFail($id);
    
    $ticket->update([
        'statut' => 'ferme',
        'reponse' => $ticket->reponse ?? 'Ticket fermé sans réponse'
    ]);

    return response()->json(['message' => 'Ticket fermé avec succès.']);
}
}
