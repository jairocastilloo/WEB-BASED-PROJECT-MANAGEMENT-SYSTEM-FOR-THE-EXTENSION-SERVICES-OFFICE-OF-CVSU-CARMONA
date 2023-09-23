<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RealTimeUpdate extends Component
{
    public $message = '';

    public function render()
    {
        return view('livewire.real-time-update');
    }

    public function updateMessage()
    {
        // Simulate an update to the message in real-time
        $this->message = 'Updated at: ' . now();
    }
}
