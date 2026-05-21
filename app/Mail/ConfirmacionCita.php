<?php

namespace App\Mail;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmacionCita extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Cita $cita) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Tu cita en ST BARBER está confirmada!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmacion-cita',
        );
    }
}
