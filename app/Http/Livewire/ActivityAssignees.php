<?php

namespace App\Http\Livewire;

use App\Mail\MyMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Models\ActivityUser;
use App\Models\Notification;

class ActivityAssignees extends Component
{
    public $assignees;
    public $activity;
    public $addassignees;
    public $projectName;
    public $activityName;
    public $assigneeIds = [];
    protected $listeners = ['saveAssignees' => 'handleSaveAssignees', 'sendmessage' => 'handlesendmessage', 'unassignAssignees' => 'handleUnassignAssignees'];
    public function mount($activity, $projectName, $activityName)
    {
        $this->activity = $activity;
        $this->projectName = $projectName;
        $this->activityName = $activityName;
    }
    public function saveAssignees($selectedAssignees)
    {
        // Loop through the selected assignees and save them to the database
        foreach ($selectedAssignees as $assigneeId) {
            ActivityUser::create(['user_id' => $assigneeId, 'activity_id' => $this->activity->id]);
        }
        $this->assigneeIds = $selectedAssignees;
        $this->emit('updateAssignees');
    }
    public function unassignAssignees($assigneedataid)
    {
        // Loop through the selected assignees and save them to the database

        ActivityUser::where(['user_id' => $assigneedataid, 'activity_id' => $this->activity->id])
            ->delete();

        $this->emit('updateunassignAssignees');
    }
    public function sendmessage()
    {
        $sendername = Auth::user()->name . ' ' . Auth::user()->last_name;
        $assigneeIds = $this->assigneeIds;
        $message =  $sendername . ' assigned you to a new activity: "' . $this->activityName . '".';
        foreach ($assigneeIds as $assigneeId) {
            $notification = new Notification([
                'user_id' => $assigneeId,
                'task_id' => $this->activity->id,
                'task_type' => "activity",
                'task_name' => $this->activityName,
                'message' => $message,
            ]);
            $notification->save();
            $assignee = User::findorFail($assigneeId);
            $email = $assignee->email;
            $name = $assignee->name . ' ' . $assignee->last_name;
            $taskname = $this->activity->actname;
            $tasktype = "activity";
            $startDate = date('F d, Y', strtotime($this->activity->actstartdate));
            $endDate = date('F d, Y', strtotime($this->activity->actenddate));

            $taskdeadline = $startDate . ' - ' . $endDate;
            $senderemail = Auth::user()->email;
            Mail::to($email)->send(new MyMail($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail));
        }
    }
    public function handlesendmessage()
    {
        $this->sendmessage();
    }
    public function handleUnassignAssignees($assigneedataid)
    {
        $this->unassignAssignees($assigneedataid);
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
