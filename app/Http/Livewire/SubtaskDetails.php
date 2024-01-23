<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subtask;

class SubtaskDetails extends Component
{
    public $subtask;
    public $activity;
    protected $listeners = ['saveSubtask' => 'handleSaveSubtask'];
    public function mount($subtask, $activity)
    {
        $this->subtask = $subtask;
        $this->activity = $activity;
    }
    public function saveSubtask($arguments)
    {
        $subtask = Subtask::findorFail($this->subtask->id);
        $subtask->update([
            'subtask_name' => $arguments['subtask_name'],
            'subduedate' => $arguments['subduedate'],

        ]);
        $this->subtask = $subtask;
        $this->emit('saveSubtaskSuccess');
    }
    public function handleSaveSubtask($arguments)
    {

        $this->saveSubtask($arguments);
    }
    public function markAsCompleted()
    {
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
