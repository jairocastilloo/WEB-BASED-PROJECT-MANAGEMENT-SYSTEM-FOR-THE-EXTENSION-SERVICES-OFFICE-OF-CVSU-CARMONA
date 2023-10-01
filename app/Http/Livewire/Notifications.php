<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;


class Notifications extends Component
{

    public $unreadnotificationscount;

    public function mount()
    {
        $this->unreadnotificationscount = count(Notification::where('user_id', Auth::user()->id)->where('read_at', null)->get());
    }

    public function update()
    {
        $unreadnotifications = Notification::where('user_id', Auth::user()->id)
            ->where('read_at', null)
            ->get();

        foreach ($unreadnotifications as $unreadnotification) {
            $unreadnotification->read_at = now();
            $unreadnotification->save();
        }
        return redirect()->route('notification.index');
    }

    public function render()
    {
        return view("livewire.notifications");
    }
}
