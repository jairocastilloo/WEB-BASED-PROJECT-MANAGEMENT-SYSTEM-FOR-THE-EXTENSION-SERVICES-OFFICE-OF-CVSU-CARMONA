<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function index()
    {

        $notifications = Notification::where('user_id', Auth::user()->id)
            ->latest() // Orders the notifications by created_at in descending order (latest first)
            ->limit(10) // Limits the number of notifications to 10
            ->get();
        return view('implementer.notifications', [
            'notifications' =>  $notifications
        ]);
    }
}
