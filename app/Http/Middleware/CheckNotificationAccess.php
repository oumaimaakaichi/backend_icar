<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckNotificationAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Non authentifié'
            ], 401);
        }

        // Récupérer l'ID du technicien depuis l'URL
        $technicienId = $request->route('technicienId');

        if ($technicienId) {
            // Vérifier que l'utilisateur peut accéder aux notifications de ce technicien
            if (!$this->canAccessTechnicienNotifications($user, $technicienId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès non autorisé aux notifications de ce technicien'
                ], 403);
            }
        }

        // Pour les actions sur une notification spécifique
        $notificationId = $request->route('id');
        if ($notificationId) {
            if (!$this->canAccessNotification($user, $notificationId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès non autorisé à cette notification'
                ], 403);
            }
        }

        return $next($request);
    }

    /**
     * Vérifier si l'utilisateur peut accéder aux notifications d'un technicien
     */
    private function canAccessTechnicienNotifications($user, $technicienId)
    {
        // Un technicien peut voir ses propres notifications
        if ($user->id == $technicienId) {
            return true;
        }

        // Un admin/manager peut voir toutes les notifications
        if (in_array($user->role, ['admin', 'manager', 'superviseur'])) {
            return true;
        }

        return false;
    }

    /**
     * Vérifier si l'utilisateur peut accéder à une notification spécifique
     */
    private function canAccessNotification($user, $notificationId)
    {
        $notification = \App\Models\NotificationTechnicien::find($notificationId);

        if (!$notification) {
            return false;
        }

        // Un technicien peut accéder à ses propres notifications
        if ($user->id == $notification->technicien_id) {
            return true;
        }

        // Un admin/manager peut accéder à toutes les notifications
        if (in_array($user->role, ['admin', 'manager', 'superviseur'])) {
            return true;
        }

        return false;
    }
}

// Pour utiliser ce middleware, ajoutez ceci dans routes/api.php :
/*
Route::middleware(['auth', 'check.notification.access'])->prefix('notifications')->group(function () {
    // Vos routes de notifications ici
});
*/

// Et enregistrez le middleware dans app/Http/Kernel.php :
/*
protected $routeMiddleware = [
    // ... autres middlewares
    'check.notification.access' => \App\Http\Middleware\CheckNotificationAccess::class,
];
*/
