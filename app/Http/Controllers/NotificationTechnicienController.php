<?php

namespace App\Http\Controllers;

use App\Models\NotificationTechnicien;

use App\Models\User;
use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NotificationTechnicienController extends Controller
{
    /**
     * Récupérer toutes les notifications d'un technicien avec pagination
     */
    public function index(Request $request, $technicienId): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $type = $request->get('type');
            $lu = $request->get('lu');

            $query = NotificationTechnicien::with(['demande:id,status'])
                ->pourTechnicien($technicienId);

            // Filtres optionnels
            if ($type) {
                $query->parType($type);
            }

            if ($lu !== null) {
                $lu === 'true' ? $query->lues() : $query->nonLues();
            }

            $notifications = $query->ordrePriorite()->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $notifications,
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des notifications:', [
                'technicien_id' => $technicienId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer les notifications non lues d'un technicien
     */
public function getNonLues(int $technicienId): JsonResponse
{
    try {
        $notifications = \App\Models\NotificationTechnicien::pourTechnicien($technicienId)
            ->nonLues()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'count' => $notifications->count(),
            'has_notifications' => $notifications->isNotEmpty(),
        ]);
    } catch (\Exception $e) {
        \Log::error('Erreur récupération notifications non lues', [
            'technicien_id' => $technicienId,
            'message' => $e->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la récupération des notifications',
            'error' => $e->getMessage(),
        ], 500);
    }
}




    /**
     * Récupérer les notifications récentes (dernières 24h)
     */
    public function getRecentes($technicienId): JsonResponse
    {
        try {
            $notifications = NotificationTechnicien::with(['demande:id,status'])
                ->pourTechnicien($technicienId)
                ->recentes(24)
                ->ordrePriorite()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $notifications,
                'count' => $notifications->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des notifications récentes:', [
                'technicien_id' => $technicienId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des notifications récentes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Créer une nouvelle notification
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'technicien_id' => 'required|integer|exists:users,id',
            'demande_id' => 'required|integer|exists:demandes,id',
            'titre' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'type' => 'required|in:assignation,modification,annulation'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $notification = NotificationTechnicien::create($validator->validated());

            Log::info('Notification créée:', [
                'notification_id' => $notification->id,
                'technicien_id' => $notification->technicien_id,
                'demande_id' => $notification->demande_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notification créée avec succès',
                'data' => $notification->load(['technicien:id,name', 'demande:id,type_demande'])
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la notification:', [
                'data' => $request->all(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher une notification spécifique
     */
    public function show($id): JsonResponse
    {
        try {
            $notification = NotificationTechnicien::with(['technicien:id,name', 'demande'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $notification
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Notification non trouvée',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Marquer une notification comme lue
     */
    public function marquerLue($id): JsonResponse
    {
        try {
            $notification = NotificationTechnicien::findOrFail($id);
            $notification->marquerCommeLue();

            Log::info('Notification marquée comme lue:', ['notification_id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'Notification marquée comme lue',
                'data' => $notification->fresh()
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors du marquage de la notification:', [
                'notification_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marquer une notification comme non lue
     */
    public function marquerNonLue($id): JsonResponse
    {
        try {
            $notification = NotificationTechnicien::findOrFail($id);
            $notification->marquerCommeNonLue();

            Log::info('Notification marquée comme non lue:', ['notification_id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'Notification marquée comme non lue',
                'data' => $notification->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marquer toutes les notifications d'un technicien comme lues
     */
    public function marquerToutesLues($technicienId): JsonResponse
    {
        try {
            $count = NotificationTechnicien::pourTechnicien($technicienId)
                ->nonLues()
                ->update([
                    'lu' => true,
                    'lu_at' => now()
                ]);

            Log::info('Toutes les notifications marquées comme lues:', [
                'technicien_id' => $technicienId,
                'count' => $count
            ]);

            return response()->json([
                'success' => true,
                'message' => "Toutes les notifications ont été marquées comme lues ({$count} notifications)",
                'count' => $count
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors du marquage de toutes les notifications:', [
                'technicien_id' => $technicienId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour des notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une notification
     */
    public function destroy($id): JsonResponse
    {
        try {
            $notification = NotificationTechnicien::findOrFail($id);
            $technicienId = $notification->technicien_id;
            $notification->delete();

            Log::info('Notification supprimée:', [
                'notification_id' => $id,
                'technicien_id' => $technicienId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notification supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la notification:', [
                'notification_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer toutes les notifications lues d'un technicien
     */
    public function supprimerLues($technicienId): JsonResponse
    {
        try {
            $count = NotificationTechnicien::pourTechnicien($technicienId)
                ->lues()
                ->delete();

            Log::info('Notifications lues supprimées:', [
                'technicien_id' => $technicienId,
                'count' => $count
            ]);

            return response()->json([
                'success' => true,
                'message' => "Toutes les notifications lues ont été supprimées ({$count} notifications)",
                'count' => $count
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression des notifications lues:', [
                'technicien_id' => $technicienId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression des notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les statistiques des notifications d'un technicien
     */
    public function getStatistiques($technicienId): JsonResponse
    {
        try {
            $stats = [
                'total' => NotificationTechnicien::pourTechnicien($technicienId)->count(),
                'non_lues' => NotificationTechnicien::pourTechnicien($technicienId)->nonLues()->count(),
                'lues' => NotificationTechnicien::pourTechnicien($technicienId)->lues()->count(),
                'recentes_24h' => NotificationTechnicien::pourTechnicien($technicienId)->recentes(24)->count(),
                'par_type' => [
                    'assignation' => NotificationTechnicien::pourTechnicien($technicienId)->parType('assignation')->count(),
                    'modification' => NotificationTechnicien::pourTechnicien($technicienId)->parType('modification')->count(),
                    'annulation' => NotificationTechnicien::pourTechnicien($technicienId)->parType('annulation')->count(),
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des statistiques:', [
                'technicien_id' => $technicienId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Nettoyer les anciennes notifications (tâche de maintenance)
     */
    public function nettoyerAnciennes(Request $request): JsonResponse
    {
        try {
            $jours = $request->get('jours', 30);
            $count = NotificationTechnicien::supprimerAnciennes($jours);

            Log::info('Nettoyage des notifications anciennes:', [
                'jours' => $jours,
                'count' => $count
            ]);

            return response()->json([
                'success' => true,
                'message' => "Nettoyage terminé: {$count} notifications supprimées",
                'count' => $count
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors du nettoyage des notifications:', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du nettoyage des notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
