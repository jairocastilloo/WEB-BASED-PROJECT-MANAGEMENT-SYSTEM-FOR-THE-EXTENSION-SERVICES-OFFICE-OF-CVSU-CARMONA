<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;
use App\Events\NewNotification;

class Notifications extends Component
{
    public $notifications;
    public function mount()
    {
        // Load initial notifications for the authenticated user
        $this->notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
