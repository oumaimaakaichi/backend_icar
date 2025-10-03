<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
class NotificationController extends Controller
{
    /**
     * Récupère les notifications de l'utilisateur connecté
     */
   public function index()
{
    try {
        // Récupère les 10 dernières notifications de la table
        $notifications = Notification::latest()->take(10)->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $notifications->whereNull('read_at')->count()
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la récupération des notifications',
            'notifications' => [],
            'unread_count' => 0
        ], 500);
    }
}


    /**
     * Marque une notification comme lue
     */
    public function markAsRead($id)
    {
        try {
            $notification = Notification::find($id);

            if (!$notification) {
                return response()->json([
                    'message' => 'Notification non trouvée'
                ], 404);
            }

            $notification->update(['read_at' => now()]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Erreur markAsRead: '.$e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Marque toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        try {
            Notification::whereNull('read_at')->update(['read_at' => now()]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Erreur markAllAsRead: '.$e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    /**
     * Récupère le nombre de notifications non lues
     */
    public function getUnreadCount()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'unread_count' => 0
                ], 401);
            }

            $unreadCount = $user->unreadNotifications()->count();

            return response()->json([
                'unread_count' => $unreadCount
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Erreur lors du comptage des notifications: ' . $e->getMessage());

            return response()->json([
                'unread_count' => 0,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
