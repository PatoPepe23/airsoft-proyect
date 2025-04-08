<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $qrCodeBase64;

    public function __construct($data, $qrCodeBase64) {
        $this->data = $data;
        $this->qrCodeBase64 = $qrCodeBase64;
    }

    public function build() {
        return $this->subject('Confirmación de reserva')
            ->view('emails.booking-confirmation') // Apunta a la vista
            ->with([
                'data' => $this->data,               // Pasa los datos a la vista
                'qrCodeBase64' => $this->qrCodeBase64 // Pasa el QR en Base64 a la vista
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Confirmation',
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
