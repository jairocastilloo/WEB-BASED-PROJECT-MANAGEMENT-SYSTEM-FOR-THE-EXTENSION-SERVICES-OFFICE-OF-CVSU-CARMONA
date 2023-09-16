<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function markasread($id)
    {
        $notifications = Notification::where('user_id', $id)->get();

        foreach ($notifications as $notification) {
            $notification->read_at = now(); // Set the 'read_at' timestamp to the current time
            $notification->save();
        }
    }
}
