<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderMail extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @param  array{name: string, phone: string, email: ?string, product: ?string, quantity: int, items: array, subtotal: int, discountRate: int, discountAmount: int, total: int, message: ?string, ip: ?string}  $orderData
     */
    public function __construct(public array $orderData)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $replyTo = [];
        if (! empty($this->orderData['email'])) {
            $replyTo[] = new Address($this->orderData['email'], $this->orderData['name']);
        }

        return new Envelope(
            subject: 'Нове замовлення вуликів з ППУ — '.$this->orderData['name'],
            replyTo: $replyTo,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order',
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
