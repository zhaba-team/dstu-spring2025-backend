<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class VerifyCodeMail extends Mailable
{
    use Queueable;

    public function __construct(
        private int $code
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Подтверждения кода',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.verify-code',
            with: [
                'code' => $this->code,
            ],
        );
    }

    /** @return array<int, mixed> */
    public function attachments(): array
    {
        return [];
    }
}
