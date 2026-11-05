<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentExpiryReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $document;
    public $days;

    public function __construct($document, $days)
    {
        $this->document = $document;
        $this->days = $days;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Document Expiry Reminder'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.document-expiry-reminder',
        );
    }
}