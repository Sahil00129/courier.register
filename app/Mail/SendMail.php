<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $terMailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($terMailData)
    {
        $this->terMailData = $terMailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->testMailData );
        return $this->subject('Email From Eternity Solutions')
                    ->view('emails.hrMail');
    }
}