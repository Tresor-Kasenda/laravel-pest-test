<?php

declare(strict_types=1);

namespace App\Mail\Api\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class StoreUserEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public $user)
    {

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Store User Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.send',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
