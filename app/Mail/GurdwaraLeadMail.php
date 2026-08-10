<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GurdwaraLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $name = implode(' ', array_filter([
            $this->data['first_name'] ?? null,
            $this->data['middle_name'] ?? null,
            $this->data['last_name'] ?? null,
        ]));
        return $this->subject('New Gurdwara Info Request — ' . ($name ?: 'Website Visitor'))
                    ->view('emails.gurdwara-lead');
    }
}
