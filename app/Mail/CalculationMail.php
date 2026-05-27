<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class CalculationMail extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @param  array{name: string, phone: string, email: ?string, items: array, subtotal: int, discountRate: int, discountAmount: int, packagingAmount: int, total: int, ip: ?string}  $calcData
     */
    public function __construct(public array $calcData)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $replyTo = [];
        if (! empty($this->calcData['email'])) {
            $replyTo[] = new Address($this->calcData['email'], $this->calcData['name']);
        }

        return new Envelope(
            subject: 'Новий розрахунок вуликів з ППУ — '.$this->calcData['name'],
            replyTo: $replyTo,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.calculation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
