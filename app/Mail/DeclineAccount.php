<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeclineAccount extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;
    protected $declineReason;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $declineReason)
    {
        //
        $this->name = $name;
        $this->declineReason = $declineReason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Sorry! Your Account is Declined.";
        return $this->subject($subject)
            ->view('emails.accountdecline')
            ->with([
                'subject' => $subject,
                'name' => $this->name,
                'declineReason' => $this->declineReason
            ]);
    }
}
