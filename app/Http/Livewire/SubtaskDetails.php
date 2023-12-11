<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subtask;

class SubtaskDetails extends Component
{
    public $subtask;

    public function mount($subtask) {
        $this->subtask = $subtask;
    }
    public function markAsCompleted(){
        $subtask = Subtask::findOrFail($this->subtask->id);

        $subtask->update([
            'status' => "Completed",
        ]);
        $this->subtask = $subtask;
        $this->emit('closeModal');
    }
    public function render()
    {
        return view('livewire.subtask-details');
    }
}