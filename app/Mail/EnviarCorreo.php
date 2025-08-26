<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class EnviarCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $factura;
    public $pdfPath;

    public function __construct($factura, $pdfPath)
    {
        $this->factura = $factura;
        $this->pdfPath = $pdfPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Factura de venta Bazurto Shop',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.factura_cliente',
            with: [
                'factura' => $this->factura,
            ],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path($this->pdfPath))
                ->as('Factura.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
