<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $url, $header_title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $usuario)
    {
        $this->url = $data;
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.usuarios.confirmacion')->subject('Por favor confirma tu correo')->with('usuario', $this->usuario);
    }
}
