<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendVerificationCode extends Notification
{
    use Queueable;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Code de vérification')
            ->greeting('Bonjour,')
            ->line("Votre code de vérification est : **{$this->code}**")
            ->line('Merci de l’utiliser pour compléter votre inscription.')
            ->salutation('Cordialement, ICar');
    }
}

