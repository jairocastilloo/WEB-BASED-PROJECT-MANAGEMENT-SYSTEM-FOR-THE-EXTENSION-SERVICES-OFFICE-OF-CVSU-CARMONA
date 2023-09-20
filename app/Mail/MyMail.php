<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('sender@example.com', 'Sender Name')
            ->subject('Subject of the Email')
            ->view('emails.my_email_template')
            ->with([
                'subject' => 'Subject of the Email',
                'title' => 'Welcome to our website',
                'content' => 'Thank you for joining us!',
            ]);
    }
}
