<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificationPrix;

class NotificationPrixController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = NotificationPrix::where('notifiable_type', get_class($user))
            ->where('notifiable_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'notifications' => $notifications->items(),
            'unread_count' => NotificationPrix::where('notifiable_type', get_class($user))
                ->where('notifiable_id', $user->id)
                ->whereNull('read_at')->count(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    public function markAsRead($clientId)
    {


        $notification = NotificationPrix::where('notifiable_id', $clientId)

            ->first();

        if ($notification) {
            $notification->update(['read_at' => now()]);
            return response()->json(['message' => 'Notification marquée comme lue']);
        }

        return response()->json(['message' => 'Notification introuvable'], 404);
    }

    public function markAllAsRead($clientId)
    {


        NotificationPrix::where('notifiable_id',$clientId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'Toutes les notifications ont été marquées comme lues']);
    }

    public function getUnreadCount($clientId)
    {


        $count = NotificationPrix::where('notifiable_id', $clientId)

            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $notification = NotificationPrix::where('notifiable_type', get_class($user))
            ->where('notifiable_id', $user->id)
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->delete();
            return response()->json(['message' => 'Notification supprimée']);
        }

        return response()->json(['message' => 'Notification introuvable'], 404);
    }



 public function getNotificationsByClientDemande($clientId)
{
    // Récupérer les notifications où notifiable_id = clientId
    $notifications = NotificationPrix::where('notifiable_id', $clientId)
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    return response()->json([
        'notifications' => $notifications->items(),
        'pagination' => [
            'current_page' => $notifications->currentPage(),
            'last_page' => $notifications->lastPage(),
            'total' => $notifications->total(),
        ],
    ]);
}

}
