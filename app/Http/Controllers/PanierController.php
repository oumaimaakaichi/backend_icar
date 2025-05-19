<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function index($client_id)
    {
        $paniers = Panier::with('catalogue')->where('client_id', $client_id)->get();
        return response()->json($paniers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'catalogue_id' => 'required|exists:catalogues,id',
            'client_id' => 'required|exists:users,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $panier = Panier::create($request->all());

        return response()->json($panier, 201);
    }

    public function destroy($id)
    {
        $panier = Panier::findOrFail($id);
        $panier->delete();

        return response()->json(['message' => 'Article supprimé du panier']);
    }
    public function updateQuantite(Request $request, $id)
{
    $request->validate([
        'quantite' => 'required|integer|min:1',
    ]);

    $panier = Panier::findOrFail($id);
    $panier->quantite = $request->quantite;
    $panier->save();

    return response()->json([
        'message' => 'Quantité mise à jour avec succès',
        'panier' => $panier
    ]);
}

}

