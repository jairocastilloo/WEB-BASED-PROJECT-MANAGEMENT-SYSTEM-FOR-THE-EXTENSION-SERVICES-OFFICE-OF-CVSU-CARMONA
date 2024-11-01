<?php

namespace App\Http\Livewire;

use App\Mail\MyMail;
use App\Models\ActivityUser;
use App\Models\Notification;
use App\Models\SubtaskUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Models\EmailLogs;

class SubtaskAssignees extends Component


{
    public $selectedContributors = [];
    public $subtask;
    public $activity;
    public $assignees;

    public $addassignees;

    public $assigneesIds;
    protected $listeners = ['saveAssignees' => 'handleSaveAssignees', 'sendNotification' => 'handleSendNotification', 'updateSubtaskContributors' => 'updateSubtaskContributors'];
    public function mount($subtask, $activity)
    {
        $this->subtask = $subtask;
        $this->activity = $activity;

        $assigneesIds = SubtaskUser::where('subtask_id', $subtask->id)
            ->pluck('user_id')
            ->toArray();

        // Fetch the members using the retrieved IDs
        $this->assignees = User::whereIn('id', $assigneesIds)->get();

        $addassigneesIds = ActivityUser::where('activity_id', $subtask->activity_id)
            ->pluck('user_id');



        $this->addassignees = User::whereIn('id', $addassigneesIds)
            ->whereNotIn('id', $assigneesIds)
            ->get();
    }
    public function saveAssignees($selectedAssignees)
    {
        // Loop through the selected assignees and save them to the database
        foreach ($selectedAssignees as $assigneeId) {
            SubtaskUser::create(['user_id' => $assigneeId, 'subtask_id' => $this->subtask->id]);
        }

        $assigneesIds = SubtaskUser::where('subtask_id', $this->subtask->id)
            ->pluck('user_id')
            ->toArray();

        // Fetch the members using the retrieved IDs
        $this->assignees = User::whereIn('id', $assigneesIds)->get();

        $addassigneesIds = ActivityUser::where('activity_id', $this->subtask->activity_id)
            ->pluck('user_id');
        $this->addassignees = User::whereIn('id', $addassigneesIds)
            ->whereNotIn('id', $assigneesIds)
            ->get();
        $this->emit('updateElements', $selectedAssignees);
    }

    public function unassignAssignees($selectedAssignee)
    {
        SubtaskUser::where('user_id', $selectedAssignee)
            ->where('subtask_id', $this->subtask->id)
            ->delete();

        $assigneesIds = SubtaskUser::where('subtask_id', $this->subtask->id)
            ->pluck('user_id')
            ->toArray();
        Notification::where('task_id', $this->subtask->id)
            ->where('user_id', $selectedAssignee)
            ->where('task_type', 'subtask')
            ->delete();
        // Fetch the members using the retrieved IDs
        $this->assignees = User::whereIn('id', $assigneesIds)->get();

        $addassigneesIds = ActivityUser::where('activity_id', $this->subtask->activity_id)
            ->pluck('user_id');
        $this->addassignees = User::whereIn('id', $addassigneesIds)
            ->whereNotIn('id', $assigneesIds)
            ->get();
        $this->emit('updateUnassignElements');
    }
    public function sendNotification($selectedAssignees)
    {
        $isMailSendable = 1;
        $error = null;
        $sendername = Auth::user()->name . ' ' . Auth::user()->last_name;

        $message =  $sendername . ' assigned you to a new task: "' . $this->subtask->subtask_name . '".';
        foreach ($selectedAssignees as $selectedAssignee) {

            $assignee = User::findorFail($selectedAssignee);

            if ($assignee->notifySubtaskAdded == 1) {
                $notification = new Notification([
                    'user_id' => $selectedAssignee,
                    'task_id' => $this->subtask->id,
                    'task_type' => "subtask",
                    'task_name' => $this->subtask->subtask_name,
                    'message' => $message,
                ]);
                $notification->save();
            }

            if ($assignee->emailSubtaskAdded == 1) {
                if ($isMailSendable === 1) {
                    $email = $assignee->email;
                    $name = $assignee->name . ' ' . $assignee->last_name;
                    $taskname = $this->subtask->subtask_name;
                    $tasktype = "subtask";

                    $taskdeadline = date('F d, Y', strtotime($this->subtask->subduedate));
                    $senderemail = Auth::user()->email;

                    try {
                        Mail::to($email)->send(new MyMail($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail));
                    } catch (\Exception $e) {
                        $failedEmail = new EmailLogs([
                            'email' => $email,
                            'message' => $message,
                            'name' => $name,
                            'sendername' => $sendername,
                            'taskname' => $taskname,
                            'taskdeadline' => $taskdeadline,
                            'tasktype' => $tasktype,
                            'senderemail' => $senderemail
                        ]);
                        $failedEmail->save();
                        $isMailSendable = 0;
                    }
                } else {
                    $email = $assignee->email;
                    $name = $assignee->name . ' ' . $assignee->last_name;
                    $taskname = $this->subtask->subtask_name;
                    $tasktype = "subtask";

                    $taskdeadline = date('F d, Y', strtotime($this->subtask->subduedate));
                    $senderemail = Auth::user()->email;


                    $failedEmail = new EmailLogs([
                        'email' => $email,
                        'message' => $message,
                        'name' => $name,
                        'sendername' => $sendername,
                        'taskname' => $taskname,
                        'taskdeadline' => $taskdeadline,
                        'tasktype' => $tasktype,
                        'senderemail' => $senderemail
                    ]);
                    $failedEmail->save();
                }
            }
        }
        if ($isMailSendable === 1) {
            $this->emit('updateLoading');
        } else {
            $this->emit('updateLoadingFailed', $error);
        }
    }

    public function handleSendNotification($selectedAssignees)
    {
        $this->sendNotification($selectedAssignees);
    }
    public function handleSaveAssignees($selectedAssignees)
    {

        $this->saveAssignees($selectedAssignees);
    }

    public function render()
    {

        return view('livewire.subtask-assignees');
    }
}
