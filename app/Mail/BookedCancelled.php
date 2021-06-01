<?php

namespace App\Mail;

use App\Models\CarbonCopy;
use Illuminate\Bus\Queueable;
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
                    ->cc(CarbonCopy::getList($this->appointment['has_one_service']['created_by']))
                    ->subject('Appointment Cancelled: ' . $this->appointment['has_one_service']['name'])
                    ->view('layouts.email.cancelled-appoint');
    }
}
