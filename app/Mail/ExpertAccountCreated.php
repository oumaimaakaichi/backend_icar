<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ExpertAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $expert;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $expert, $password)
    {
        $this->expert = $expert;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Votre compte expert a été créé')
                    ->markdown('emails.expert-email');
    }
}
