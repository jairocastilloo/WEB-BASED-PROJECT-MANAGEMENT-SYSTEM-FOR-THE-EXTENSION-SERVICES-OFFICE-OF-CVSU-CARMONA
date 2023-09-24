<?php

namespace App\Http\Livewire;

use App\Mail\MyMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Models\ActivityUser;
use App\Models\Notification;

class ActivityAssignees extends Component
{
    public $assignees;
    public $activityid;
    public $addassignees;
    public $projectName;
    public $activityName;
    public $assigneeIds = [];
    protected $listeners = ['saveAssignees' => 'handleSaveAssignees', 'sendmessage' => 'handlesendmessage'];
    public function mount($assignees, $activityid, $addassignees, $projectName, $activityName)
    {
        $this->activityid = $activityid;
        $this->assignees = $assignees;
        $this->addassignees = $addassignees;
        $this->projectName = $projectName;
        $this->activityName = $activityName;
    }
    public function saveAssignees($selectedAssignees)
    {
        // Loop through the selected assignees and save them to the database
        foreach ($selectedAssignees as $assigneeId) {
            ActivityUser::create(['user_id' => $assigneeId, 'activity_id' => $this->activityid]);
        }
        $this->assigneeIds = $selectedAssignees;
        $this->emit('updateAssignees');
    }
    public function sendmessage()
    {
        $assignees = $this->assigneeIds;
        foreach ($assignees as $assignee) {
            $notification = new Notification([
                'user_id' => $assignee,
                'task_id' => $this->activityid,
                'task_type' => "activity",
                'task_name' => $this->activityName,
                'message' => Auth::user()->name . ' ' . Auth::user()->last_name . ' added you to a new activity: "' . $this->activityName . '".',
            ]);
            $notification->save();
        }
        Mail::to('recipient@example.com')->send(new MyMail());
    }
    public function handlesendmessage()
    {
        $this->sendmessage();
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
