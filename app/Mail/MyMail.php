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
    protected $taskname;
    protected $tasktype;
    protected $taskdeadline;
    protected $senderemail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail)
    {
        //
        $this->message = $message;
        $this->name = $name;
        $this->sendername = $sendername;
        $this->taskname = $taskname;
        $this->tasktype = $tasktype;
        $this->taskdeadline = $taskdeadline;
        $this->senderemail = $senderemail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject($this->message)
            ->view('emails.notification')
            ->with([
                'subject' => $this->message,
                'name' => $this->name,
                'taskname' => $this->taskname,
                'tasktype' => $this->tasktype,
                'sendername' => $this->sendername,
                'taskdeadline' => $this->taskdeadline,
                'senderemail' => $this->senderemail,
            ]);
    }
}
