<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationIndex extends Component
{
    public $notifications;
    public function mount($notifications)
    {
        $this->notifications = $notifications;
    }
    public function render()
    {
        return view('livewire.notification-index');
    }
}
