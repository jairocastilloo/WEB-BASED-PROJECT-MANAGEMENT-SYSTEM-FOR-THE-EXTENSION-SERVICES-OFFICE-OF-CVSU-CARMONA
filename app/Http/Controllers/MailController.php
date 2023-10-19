<?php

namespace App\Http\Controllers;

use App\Mail\MyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function sendEmail()
    {
        $message = "You have been added to project";
        $email = "navarettejairo@gmail.com";
        $name = "Jairo Castillo";
        $taskname = "Making milk tea";
        $tasktype = "project";
        $startDate = "January 1, 2001";
        $endDate = "January 1, 2002";
        $sendername = "Jairo Castillo";
        $senderemail = "navarettejairo@gmail.com";
        $taskdeadline = $startDate . ' - ' . $endDate;

        Mail::to($email)->send(new MyMail($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail));
        return "Email Sent";
    }
}
