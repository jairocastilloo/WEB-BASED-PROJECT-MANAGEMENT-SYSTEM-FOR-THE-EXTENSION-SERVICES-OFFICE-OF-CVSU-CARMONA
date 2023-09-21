<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ActivityAssignees extends Component
{
    public $assignees;
    public $activity;

    public function mount($assignees, $activity)
    {
        $this->activity = $activity;
        $this->assignees = $assignees;
    }
    public function render()
    {
        return view('livewire.activity-assignees');
    }
}
