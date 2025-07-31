<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDemandeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $demande;

    public function __construct($demande)
    {
        $this->demande = $demande;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Envoi par email et stockage en base
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle demande de maintenance')
                    ->line('Une nouvelle demande de maintenance a été créée.')
                    ->action('Voir la demande', url('/demandes/'.$this->demande->id))
                    ->line('Merci d\'utiliser notre application!');
    }

    public function toArray($notifiable)
    {
        return [
            'demande_id' => $this->demande->id,
            'message' => 'Nouvelle demande de maintenance créée',
            'url' => '/demandes/'.$this->demande->id
        ];
    }
}
