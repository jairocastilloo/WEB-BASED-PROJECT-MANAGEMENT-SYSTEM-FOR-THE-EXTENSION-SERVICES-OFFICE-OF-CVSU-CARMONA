<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveAccount extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;
    protected $role;
    protected $username;
    protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $role, $username, $email)
    {
        //
        $this->name = $name;
        $this->role = $role;
        $this->username = $username;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Welcome Aboard: Your Account is Approved.";
        return $this->subject($subject)
            ->view('emails.accountapproval')
            ->with([
                'subject' => $subject,
                'name' => $this->name,
                'role' => $this->role,
                'username' => $this->username,
                'email' => $this->email,
            ]);
    }
}
