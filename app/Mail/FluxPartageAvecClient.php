<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FluxPartageAvecClient extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;
    public $lienMeet;
    public $demandeId;

    /**
     * Create a new message instance.
     */
    public function __construct($clientName, $lienMeet, $demandeId)
    {
        $this->clientName = $clientName;
        $this->lienMeet = $lienMeet;
        $this->demandeId = $demandeId;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Live Maintenance Session - Your Technician is Ready')
                    ->view('emails.flux_partage_client')
                    ->with([
                        'clientName' => $this->clientName,
                        'lienMeet' => $this->lienMeet,
                        'demandeId' => $this->demandeId,
                    ]);
    }
}
