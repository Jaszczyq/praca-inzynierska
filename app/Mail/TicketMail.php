<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */

    public function envelope()
    {
        return new Envelope(
            subject: count($this->tickets) > 1 ? 'Twoje bilety' : 'Twój bilet',
        );
    }
    /**
     * Get the message content definition.
     *
     * @return Content
     */

    public function content()
    {
        return new Content(
            view: 'mails.ticket_mail',
            with: [
                'tickets' => $this->tickets
            ],
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
