<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ActivityAssignees extends Component
{
    public $assignees;
    public $activity;
    public $addassignees;
    public $projectName;

    public function mount($assignees, $activity, $addassignees, $projectName)
    {
        $this->activity = $activity;
        $this->assignees = $assignees;
        $this->addassignees = $addassignees;
        $this->projectName = $projectName;
    }
    public function render()
    {
        return view('livewire.activity-assignees');
    }
}
