<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Formulario extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formulario)
    {
        $this->formulario = $formulario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $formulario = $this->formulario;
        return $this->view('email')
                ->from($formulario->email)
                ->with(['formulario' => $formulario])
                ->subject($formulario->asunto);
    }
}
