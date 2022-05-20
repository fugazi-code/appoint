<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAppointmentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(['yaramayservices@gmail.com'])
            ->subject('NEW SLOT: '. $this->subject)
            ->html('https://appoint.poloksa-ph.com/login');
    }
}
