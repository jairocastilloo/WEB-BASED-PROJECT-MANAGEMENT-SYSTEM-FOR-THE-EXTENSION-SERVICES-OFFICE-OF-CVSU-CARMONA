<?php

namespace App\Http\Livewire;

use App\Mail\MyMail;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Models\ActivityUser;
use App\Models\Notification;
use App\Models\EmailLogs;

class ActivityAssignees extends Component
{
    public $assignees;
    public $activity;
    public $addassignees;
    public $projectName;

    protected $listeners = ['saveAssignees' => 'handleSaveAssignees', 'sendNotification' => 'handleSendNotification'];
    public function mount($activity, $projectName)
    {
        $this->activity = $activity;
        $this->projectName = $projectName;

        $assigneesIds = ActivityUser::where('activity_id', $activity->id)
            ->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->assignees = User::whereIn('id', $assigneesIds)->get();

        $addassigneesIds = ProjectUser::where('project_id', $activity->project_id)
            ->pluck('user_id');
        $this->addassignees = User::whereIn('id', $addassigneesIds)
            ->whereNotIn('id', $assigneesIds)
            ->get();
    }
    public function saveAssignees($selectedAssignees)
    {
        // Loop through the selected assignees and save them to the database
        foreach ($selectedAssignees as $assigneeId) {
            ActivityUser::create(['user_id' => $assigneeId, 'activity_id' => $this->activity->id]);
        }

        $assigneesIds = ActivityUser::where('activity_id', $this->activity->id)
            ->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->assignees = User::whereIn('id', $assigneesIds)->get();

        $addassigneesIds = ProjectUser::where('project_id', $this->activity->project_id)
            ->pluck('user_id');
        $this->addassignees = User::whereIn('id', $addassigneesIds)
            ->whereNotIn('id', $assigneesIds)
            ->get();
        $this->emit('updateElements', $selectedAssignees);
    }
    public function unassignAssignees($selectedAssignee)
    {
        ActivityUser::where('user_id', $selectedAssignee)
            ->where('activity_id', $this->activity->id)
            ->delete();
        $assigneesIds = ActivityUser::where('activity_id', $this->activity->id)
            ->pluck('user_id');
        Notification::where('task_id', $this->activity->id)
            ->where('user_id', $selectedAssignee)
            ->where('task_type', 'activity')
            ->delete();
        // Fetch the members using the retrieved IDs
        $this->assignees = User::whereIn('id', $assigneesIds)->get();

        $addassigneesIds = ProjectUser::where('project_id', $this->activity->project_id)
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

        $message =  $sendername . ' assigned you to a new activity: "' . $this->activity->actname . '".';
        foreach ($selectedAssignees as $selectedAssignee) {

            $assignee = User::findorFail($selectedAssignee);

            if ($assignee->notifyActivityAdded == 1) {
                $notification = new Notification([
                    'user_id' => $selectedAssignee,
                    'task_id' => $this->activity->id,
                    'task_type' => "activity",
                    'task_name' => $this->activity->actname,
                    'message' => $message,
                ]);

                $notification->save();
            }
            if ($assignee->emailActivityAdded == 1) {
                if ($isMailSendable === 1) {
                    $email = $assignee->email;
                    $name = $assignee->name . ' ' . $assignee->last_name;
                    $taskname = $this->activity->actname;
                    $tasktype = "activity";
                    $startDate = date('F d, Y', strtotime($this->activity->actstartdate));
                    $endDate = date('F d, Y', strtotime($this->activity->actenddate));

                    $taskdeadline = $startDate . ' - ' . $endDate;
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
                    $taskname = $this->activity->actname;
                    $tasktype = "activity";
                    $startDate = date('F d, Y', strtotime($this->activity->actstartdate));
                    $endDate = date('F d, Y', strtotime($this->activity->actenddate));

                    $taskdeadline = $startDate . ' - ' . $endDate;
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
        return view('livewire.activity-assignees');
    }
}
