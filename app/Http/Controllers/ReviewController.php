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
            'message' => 'Review added successfully',
            'review' => $review
        ], 201);
    }


public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'error' => 'Review not found'
            ], 404);
        }

        // Vérifier que l'utilisateur est propriétaire de la review


        $validated = $request->validate([
            'nbr_etoile' => 'sometimes|required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        $review->update($validated);

        return response()->json([
            'message' => 'Review updated successfully',
            'review' => $review
        ], 200);
    }

    // Supprimer une review
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'error' => 'Review not found'
            ], 404);
        }

        // Vérifier que l'utilisateur est propriétaire de la review

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully'
        ], 200);
    }
public function getUserReview($technicienId, $demandeId)
    {
        $userId = auth()->id();

        $review = Review::where('technicien_id', $technicienId)
            ->where('demande_id', $demandeId)
            ->where('client_id', $userId)
            ->first();

        return response()->json([
            'review' => $review
        ]);
    }

    // Récupérer la review de l'utilisateur pour une demande inconnue
    public function getUserReview2($technicienId, $demandeInconnuId)
    {
        $userId = auth()->id();

        $review = Review::where('technicien_id', $technicienId)
            ->where('demande_inconnu_id', $demandeInconnuId)
            ->where('client_id', $userId)
            ->first();

        return response()->json([
            'review' => $review
        ]);
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
            'message' => 'Review added successfully',
            'review' => $review
        ], 201);
    }
// Récupérer toutes les reviews classées par technicien
public function getAllReviewsGroupedByTechnicien()
{
    $reviews = Review::with(['client', 'technicien', 'demande'])
        ->orderBy('technicien_id')
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('technicien_id');

    $result = [];

    foreach ($reviews as $technicienId => $technicienReviews) {
        $technicien = $technicienReviews->first()->technicien;
        $totalReviews = $technicienReviews->count();
        $averageRating = $technicienReviews->avg('nbr_etoile');

        $result[] = [
            'technicien_id' => $technicienId,
            'technicien' => $technicien,
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating, 1),
            'reviews' => $technicienReviews->map(function($review) {
                return [
                    'id' => $review->id,
                    'nbr_etoile' => $review->nbr_etoile,
                    'commentaire' => $review->commentaire,
                    'created_at' => $review->created_at,
                    'client' => [
                        'id' => $review->client->id,
                        'nom' => $review->client->nom ?? 'Client',
                        'prenom' => $review->client->prenom ?? '',
                    ]
                ];
            })
        ];
    }

    return response()->json([
        'success' => true,
        'total_technicians' => count($result),
        'data' => $result
    ]);
}

// Get all reviews made by a specific client
public function getReviewsByClient($clientId)
{
    $reviews = Review::where('client_id', $clientId)
        ->with(['technicien', 'demande', 'demandeInconnu'])
        ->orderBy('created_at', 'desc')
        ->get();

    // Calculate statistics
    $totalReviews = $reviews->count();
    $averageRating = $reviews->avg('nbr_etoile');

    return response()->json([
        'success' => true,
        'client_id' => $clientId,
        'total_reviews' => $totalReviews,
        'average_rating' => round($averageRating, 1),
        'reviews' => $reviews->map(function($review) {
            return [
                'id' => $review->id,
                'nbr_etoile' => $review->nbr_etoile,
                'commentaire' => $review->commentaire,
                'created_at' => $review->created_at,
                'technicien' => [
                    'id' => $review->technicien->id,
                    'nom' => $review->technicien->nom ?? 'Technicien',
                    'prenom' => $review->technicien->prenom ?? '',
                ],
                'demande_id' => $review->demande_id,
                'demande_inconnu_id' => $review->demande_inconnu_id,
            ];
        })
    ]);
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
