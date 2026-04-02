<?php

namespace App\Mail;

use App\Models\Reparacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReparacionListaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reparacion $reparacion) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Tu equipo está listo — Folio {$this->reparacion->folio}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reparacion-lista',
            with: [
                'reparacion'    => $this->reparacion,
                'urlSeguimiento' => url("/seguimiento/{$this->reparacion->token_seguimiento}"),
            ],
        );
    }
}
