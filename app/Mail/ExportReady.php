<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExportReady extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $downloadUrl)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Export Ready',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.export-ready',
        );
    }
}
