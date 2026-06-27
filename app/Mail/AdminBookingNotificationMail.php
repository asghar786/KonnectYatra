<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminBookingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $name = $this->data['name'] ?? 'Yatri';
        return $this->subject('New Booking Received — ' . ($this->data['yatri_id'] ?? '') . ' (' . $name . ')')
                    ->view('emails.admin-new-booking');
    }
}
