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
            ->latest()
            ->limit(10)
            ->get();
        return view('implementer.notifications', [
            'notifications' =>  $notifications
        ]);
    }
}
