<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserLoggedIn extends Mailable
{
    use Queueable, SerializesModels;


    public string $name;
    public string $email;
    public string $ip;
    public ?string $location;
    public string $time;
    public ?string $user_agent;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $ip, $location = null, $time = '', $user_agent = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->ip = $ip;
        $this->location = $location;
        $this->time = $time;
        $this->user_agent = $user_agent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Logged In',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.login_new',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
