<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Ajouter une nouvelle review
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nbr_etoile' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
            'client_id' => 'required|exists:users,id',
            'technicien_id' => 'required|exists:users,id',
            'demande_id' => 'required|exists:demandes,id',

        ]);

        // Vérifier si l'utilisateur a déjà donné un avis pour ce technicien sur cette demande
        $existingReview = Review::where('client_id', $validated['client_id'])
            ->where('technicien_id', $validated['technicien_id'])
            ->where('demande_id', $validated['demande_id'])
            ->first();

        if ($existingReview) {
            return response()->json([
                'error' => 'Vous avez déjà donné votre avis pour ce technicien sur cette demande'
            ], 422);
        }

        $review = Review::create($validated);

        return response()->json([
            'message' => 'Review ajoutée avec succès',
            'review' => $review
        ], 201);
    }



     public function store2(Request $request)
    {
        $validated = $request->validate([
            'nbr_etoile' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
            'client_id' => 'required|exists:users,id',
            'technicien_id' => 'required|exists:users,id',
            'demande_inconnu_id' => 'required|exists:demandes_panne_inconnue,id',

        ]);

        // Vérifier si l'utilisateur a déjà donné un avis pour ce technicien sur cette demande
        $existingReview = Review::where('client_id', $validated['client_id'])
            ->where('technicien_id', $validated['technicien_id'])
            ->where('demande_inconnu_id', $validated['demande_inconnu_id'])
            ->first();

        if ($existingReview) {
            return response()->json([
                'error' => 'Vous avez déjà donné votre avis pour ce technicien sur cette demande'
            ], 422);
        }

        $review = Review::create($validated);

        return response()->json([
            'message' => 'Review ajoutée avec succès',
            'review' => $review
        ], 201);
    }

    // Lister les reviews d'une demande
    public function getByDemande($demandeId)
    {
        $reviews = Review::where('demande_id', $demandeId)
            ->with(['client', 'technicien'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }


    public function getByDemande2($demandeId)
    {
        $reviews = Review::where('demande_inconnu_id', $demandeId)
            ->with(['client', 'technicien'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }

    // Lister les reviews d'un technicien pour une demande spécifique
    public function getByDemandeAndTechnicien($demandeId, $technicienId)
    {
        $reviews = Review::where('demande_id', $demandeId)
            ->where('technicien_id', $technicienId)
            ->with(['client'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }

    // Vérifier si un client a déjà donné un avis
    public function hasUserReviewed($demandeId, $technicienId, $clientId)
    {
        $hasReviewed = Review::where('demande_id', $demandeId)
            ->where('technicien_id', $technicienId)
            ->where('client_id', $clientId)
            ->exists();

        return response()->json([
            'has_reviewed' => $hasReviewed


        ]);



    }




         public function getByDemandeAndTechnicien2($demandeId, $technicienId)
    {
        $reviews = Review::where('demande_inconnu_id', $demandeId)
            ->where('technicien_id', $technicienId)
            ->with(['client'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }





    // Lister toutes les reviews d'un technicien (toutes demandes confondues)
public function getReviewsByTechnicien($technicienId)
{
    $reviews = Review::where('technicien_id', $technicienId)
        ->with(['client', 'demande']) // pour inclure les détails du client et de la demande
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'technicien_id' => $technicienId,
        'total_reviews' => $reviews->count(),
        'reviews' => $reviews
    ]);
}

}
