<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
  public function index()
{
    try {
        // Récupérer les 10 dernières notifications
        $notifications = Notification::latest()->take(10)->get();

        return response()->json($notifications, 200);
    } catch (\Exception $e) {
        // Retourne une erreur 500 avec message si une exception survient
        return response()->json([
            'message' => 'Erreur lors de la récupération des notifications.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

 public function markAllAsRead()
{
    try {
        // Solution 1: Pour l'utilisateur authentifié seulement
        $count = auth()->user()->notifications()
                     ->whereNull('read_at')
                     ->update(['read_at' => now()]);

        /*
        // Solution 2: Alternative si vous voulez marquer toutes les notifications (admin)
        $count = Notification::whereNull('read_at')
                     ->update(['read_at' => now()]);
        */

        return response()->json([
            'success' => true,
            'message' => "$count notifications marquées comme lues",
            'count' => $count
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => "Erreur lors du marquage des notifications",
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications()->count();
        return response()->json(['count' => $count]);
    }

}
