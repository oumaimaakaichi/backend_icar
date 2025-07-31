<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PieceRecommandeeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $demandeId;

    public function __construct($demandeId)
    {
        $this->demandeId = $demandeId;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'demande_id' => $this->demandeId,
            'message' => 'Des pièces ont été recommandées pour votre demande',
            // plus de 'pieces' ici
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'demande_id' => $this->demandeId,
            'message' => 'Des pièces ont été recommandées pour votre demande',
        ]);
    }
}
