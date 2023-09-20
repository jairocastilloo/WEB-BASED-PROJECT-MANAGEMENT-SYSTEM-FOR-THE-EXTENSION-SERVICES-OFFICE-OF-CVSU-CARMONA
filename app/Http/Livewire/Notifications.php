<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;


class Notifications extends Component
{
    public $notifications;
    public $unreadnotificationscount;

    public function mount()
    {
        $this->notifications = Notification::where('user_id', Auth::user()->id)->get();
        $this->unreadnotificationscount = count($this->notifications->where('read_at', null));
    }


    public function updateNotifications()
    {

        Notification::where('user_id', Auth::user()->id)
            ->where('read_at', null)
            ->update(['read_at' => now()]);

        $this->emit('updateNotifications');
    }
    public function render()
    {
        return view("livewire.notifications");
    }
}
