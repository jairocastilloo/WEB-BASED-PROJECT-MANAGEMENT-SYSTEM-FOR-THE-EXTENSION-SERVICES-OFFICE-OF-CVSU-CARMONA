<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Artisan;

class NotificationIndex extends Component
{
    public $notifications;
    protected $listeners = ['showTask' => 'handleshowTask'];
    public function mount($notifications)
    {
        $this->notifications = $notifications;
    }
    public function showMore($notificationsCount)
    {
        $nextNotifications = Notification::where('user_id', Auth::user()->id)
            ->latest()
            ->skip($notificationsCount)
            ->limit(10)
            ->get();
        $this->notifications = $this->notifications->concat($nextNotifications);
    }
    public function notify()
    {
        Artisan::call('notify:members');
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->latest()
            ->limit(10)
            ->get();
        $this->notifications = $notifications;
    }

    public function showTask($notificationid, $taskid, $tasktype, $taskname)
    {
        $notification = Notification::findOrFail($notificationid);
        $notification->clicked_at = now();
        $notification->save();
        if ($tasktype === 'project') {
            return redirect()->route('projects.display', ["projectid" => $taskid, "department" => Auth::user()->department]);
        } elseif ($tasktype === 'activity') {
            return redirect()->route('activities.display', ["activityid" => $taskid]);
        } elseif ($tasktype === 'subtask') {
            return redirect()->route('subtasks.display', ["subtaskid" => $taskid,  "subtaskname" => $taskname,]);
        } elseif ($tasktype === 'projectcontribution') {
            return redirect()->route('projsubmission.display', ["projsubmissionid" => $taskid,  "projsubmissionname" => $taskname,]);
        } elseif ($tasktype === 'activitycontribution') {
            return redirect()->route('actsubmission.display', ["actsubmissionid" => $taskid,  "actsubmissionname" => $taskname,]);
        } elseif ($tasktype === 'subtaskcontribution') {
            return redirect()->route('submission.display', ["submissionid" => $taskid,  "submissionname" => $taskname,]);
        }
    }
    public function handleshowTask($notificationid, $taskid, $tasktype, $taskname)
    {
        $this->showTask($notificationid, $taskid, $tasktype, $taskname);
    }
    public function render()
    {
        return view('livewire.notification-index');
    }
}
