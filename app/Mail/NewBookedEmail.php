<?php

namespace App\Mail;

use App\Models\CarbonCopy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBookedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment, $customer)
    {
        $this->appointment = $appointment;
        $this->customer    = $customer;
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
                    ->view('layouts.email.new-book')
                    ->subject('Confirmation: ' . $this->appointment['has_one_service']['name']);
    }
}
