<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Récupérer toutes les notifications
    public function index()
    {
        return response()->json(Notification::all(), 200);
    }




    // Afficher une notification spécifique
    public function show($id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            return response()->json(['message' => 'Notification non trouvée'], 404);
        }
        return response()->json($notification, 200);
    }




}

