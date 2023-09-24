<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $message;
    protected $name;
    protected $sendername;
    protected $activityname;
    protected $activitydeadline;
    protected $senderemail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $name, $sendername, $activityname, $activitydeadline, $senderemail)
    {
        //
        $this->message = $message;
        $this->name = $name;
        $this->sendername = $sendername;
        $this->activityname = $activityname;
        $this->activitydeadline = $activitydeadline;
        $this->senderemail = $senderemail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('sender@example.com', 'Sender Name')
            ->subject($this->message)
            ->view('emails.notification')
            ->with([
                'subject' => $this->message,
                'name' => $this->name,
                'activityname' => $this->activityname,
                'sendername' => $this->sendername,
                'activitydeadline' => $this->activitydeadline,
                'senderemail' => $this->senderemail,
            ]);
    }
}
