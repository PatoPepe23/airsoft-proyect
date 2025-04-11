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
    public $qrPath;

    public function __construct($data, $qrPath) {
        $this->data = $data;
        $this->qrPath = $qrPath;
    }

    public function build() {
        return $this->view('emails.booking-confirmation')
            ->subject('Confirmación de Reserva')
            ->attach($this->qrPath, [
                'as' => 'qr_code.png',
                'mime' => 'image/png',
                'content_id' => 'qr_cid', // <-- Aquí está el CID
                'disposition' => 'inline',
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
