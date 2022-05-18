<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExchangeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($to, $subject, $data)
    {
        $this->mail_to = $to;
        $this->mail_subject = $subject;
        $this->mail_data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->mail_to)->subject($this->mail_subject)->view('template.exchange_mail')->with('mail_data', $this->mail_data);
    }
}
