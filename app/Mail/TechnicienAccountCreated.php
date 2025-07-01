<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class TechnicienAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $technicien;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $technicien, $password)
    {
        $this->technicien = $technicien;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Votre compte technicien a été créé')
                    ->markdown('emails.technicien_account_created');
    }
}
