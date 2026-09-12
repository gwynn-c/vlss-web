<?php

namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactSubmission $submission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New pitch — '.$this->submission->name
                .($this->submission->topic ? ' ('.$this->submission->topic.')' : ''),
            replyTo: [$this->submission->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact-submitted',
            with: ['submission' => $this->submission],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
