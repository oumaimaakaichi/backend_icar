<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeTickets;
class TypeTicketController extends Controller
{

    public function index()
    {
        $tickets = TypeTickets::paginate(6);  // Pagination de 10 banque par page
        return view('Categories.ticket', compact('tickets'));
    }
    public function show(TypeTickets $ticket)
    {
        return view('ticket.show', compact('ticket'));
    }

        public function create()
        {
            return view('ticket.create');
        }

        public function store(Request $request)
        {
            $request->validate([
                'type_ticket' => 'required|string|max:255|unique:type_tickets',

            ]);

            TypeTickets::create($request->all());

            return redirect()->route('ticket.index')
                             ->with('success', 'Ticket type created successfully');
        }

        public function edit(TypeTickets $ticket)
        {
            return view('ticket.edit', compact('ticket'));
        }

        public function update(Request $request, TypeTickets $ticket)
        {
            $request->validate([
                'type_ticket' => 'required|string|max:255|unique:type_tickets,type_ticket,'.$ticket->id,

            ]);

            $ticket->update($request->all());

            return redirect()->route('ticket.index')
                             ->with('success', 'Ticket type updated successfully');
        }

        public function destroy(TypeTickets $ticket)
        {
            $ticket->delete();

            return redirect()->route('ticket.index')
                             ->with('success', 'Ticket type deleted successfully');
        }
        public function toggleVisibility(TypeTickets $ticket)
    {
        $ticket->update(['is_visible' => !$ticket->is_visible]);

        return back()->with('success', 'Visibility changed successfully');
    }


    public function getAllTickets()
    {
        // Récupérer tous les tickets avec une pagination (optionnel, selon les besoins)
        $tickets = TypeTickets::where('is_visible', true)->get();
        // Si tu veux récupérer tous les tickets sans pagination

        // Retourner les tickets au format JSON
        return response()->json($tickets);
    }



    public function getTicketTypess()
{
    // Récupérer tous les types de tickets visibles
    $types = TypeTickets::where('is_visible', true)->get();

    // Formater la réponse pour correspondre au modèle Flutter
    $formattedTypes = $types->map(function ($type) {
        return [
            'id' => $type->id,
            'type' => $type->type_ticket // Notez le changement de 'type_ticket' à 'type'
        ];
    });

    return response()->json($formattedTypes);
}
}
