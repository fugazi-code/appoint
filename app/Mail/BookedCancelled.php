<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookedCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attributes, $message)
    {
        $this->appointment = $attributes;
        $this->msg     = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(['appointment-sys@poloksa.com'])
                    ->subject('Appointment Cancelled: ' . $this->appointment['has_one_service']['name'])
                    ->view('layouts.email.cancelled-appoint');
    }
}
