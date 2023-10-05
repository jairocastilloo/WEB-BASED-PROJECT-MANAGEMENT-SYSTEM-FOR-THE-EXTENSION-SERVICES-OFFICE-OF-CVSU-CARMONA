<?php

namespace App\Http\Livewire;

use App\Models\Subtask;
use Livewire\Component;

class OtherSubtasks extends Component
{
    public $subtasks;
    public $subtasksIds = [];
    public $search = '';
    public function mount($subtasks)
    {
        $this->subtasks = $subtasks;
        $this->subtasksIds = $subtasks->pluck('id')->toArray();
    }
    public function render()
    {
        $this->subtasks = Subtask::where('subtask_name', 'like', '%' . $this->search . '%')
            ->whereIn('id', $this->subtasksIds)
            ->get();
        return view('livewire.other-subtasks');
    }
}
