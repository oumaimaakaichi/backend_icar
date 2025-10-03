<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NewClientRegistrationAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $registrationDate;

    /**
     * Create a new message instance.
     */
    public function __construct(User $client)
    {
        $this->client = $client;
        $this->registrationDate = now()->format('F j, Y \a\t g:i A');
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🚀 New Client Registration - Action Required')
                    ->view('emails.new_client_admin_notification')
                    ->with([
                        'client' => $this->client,
                        'registrationDate' => $this->registrationDate,
                    ]);
    }
}
