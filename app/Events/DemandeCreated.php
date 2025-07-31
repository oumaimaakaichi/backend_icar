<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemandeCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $demande;

    public function __construct($demande)
    {
        $this->demande = $demande;
    }

    public function broadcastOn()
    {
        return new Channel('demandes');
    }

    public function broadcastAs()
    {
        return 'demande.created';
    }
}
