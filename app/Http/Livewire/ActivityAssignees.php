<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ActivityUser;

class ActivityAssignees extends Component
{
    public $assignees;
    public $activityid;
    public $addassignees;
    public $projectName;
    protected $listeners = ['saveAssignees' => 'handleSaveAssignees'];

    public function mount($assignees, $activityid, $addassignees, $projectName)
    {
        $this->activityid = $activityid;
        $this->assignees = $assignees;
        $this->addassignees = $addassignees;
        $this->projectName = $projectName;
    }
    public function saveAssignees($selectedAssignees)
    {
        // Loop through the selected assignees and save them to the database
        foreach ($selectedAssignees as $assigneeId) {
            ActivityUser::create(['user_id' => $assigneeId, 'activity_id' => $this->activityid]);
        }
        $this->emit('updateAssignees');
    }
    public function handleSaveAssignees($selectedAssignees)
    {
        // Your code to handle the event goes here
        // For example, you can call the saveAssignees method
        $this->saveAssignees($selectedAssignees);
        // You can also perform other actions or emit events in response to this event

    }

    public function render()
    {
        return view('livewire.activity-assignees');
    }
}
