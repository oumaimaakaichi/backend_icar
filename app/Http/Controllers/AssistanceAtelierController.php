<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssistanceAtelier;
use Illuminate\Support\Facades\Auth;

class AssistanceAtelierController extends Controller
{
    public function index()
    {
        // Récupérer l'atelier de l'utilisateur connecté


        // Vérifier si l'utilisateur a un atelier associé


        $atelier = Auth::guard('atelier')->user();

        // Récupérer les tickets d'assistance de cet atelier
        $tickets = AssistanceAtelier::where('atelier_id', $atelier->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('ateliers.ticket_maintenance', compact('tickets', 'atelier'));
    }

    public function store(Request $request)
    {
       $atelier = Auth::guard('atelier')->user();

        // Vérifier si l'utilisateur a un atelier associé

        $request->validate([
            'type'       => 'required|string',
            'message'    => 'required|string',
            'titre'      => 'required|string',
        ]);

        $assistance = AssistanceAtelier::create([
            'atelier_id' => $atelier->id,
            'type'       => $request->type,
            'message'    => $request->message,
            'titre'      => $request->titre,
            'statut'     => 'en attente',
        ]);

        return redirect()->back()->with('success', 'Ticket créé avec succès.');
    }

    public function show($id)
    {
         $atelier = Auth::guard('atelier')->user();

        // Vérifier si l'utilisateur a un atelier associé


        $ticket = AssistanceAtelier::where('id', $id)
                    ->where('atelier_id', $atelier->id)
                    ->firstOrFail();

        return view('ateliers.ticket_show', compact('ticket'));
    }
}
