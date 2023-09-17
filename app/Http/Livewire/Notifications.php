<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;


class Notifications extends Component
{
    public $notifications;
    public function mount()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications;
    }
    public function render()
    {

        return view('livewire.notifications');
    }
}
