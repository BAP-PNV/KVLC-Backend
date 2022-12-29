<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelComeMail extends Mailable
{

    use Queueable, SerializesModels;
    private string $email;
    private int $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email,int $password)
    {
        $this->email=$email;
        $this->password=$password;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: '[KVLC chat][Welcome to our app]',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content():Content
    {
        return new Content(
            view: 'mail.welcome_message',
            with: ['email'=>$this->email,'password'=>$this->password]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
