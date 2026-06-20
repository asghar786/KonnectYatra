<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayLaterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Your Konnect Yatra Booking ' . ($this->data['order_no'] ?? '') . ' — Payment Instructions')
                    ->view('emails.pay-later');
    }
}
