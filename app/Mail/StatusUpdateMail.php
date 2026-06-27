<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $forAdmin;

    public function __construct($data, bool $forAdmin = false)
    {
        $this->data     = $data;
        $this->forAdmin = $forAdmin;
    }

    public function build()
    {
        $type  = $this->data['status_type'] ?? 'Status';
        $value = $this->data['status_value'] ?? '';
        return $this->subject('Booking ' . ($this->data['yatri_id'] ?? '') . ' — ' . $type . ': ' . $value)
                    ->view('emails.status-update', ['forAdmin' => $this->forAdmin]);
    }
}
