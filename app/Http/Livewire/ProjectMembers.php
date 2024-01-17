<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyMail;
use Livewire\Component;

class ProjectMembers extends Component
{
    public $project;
    public $members;
    public $addmembers;
    public $department;
    protected $listeners = ['saveMembers' => 'handleSaveMembers', 'sendNotification' => 'handleSendNotification'];
    public function mount($indexproject, $department)
    {
        $this->project = $indexproject;

        // Retrieve the member IDs associated with the project
        $memberIds = ProjectUser::where('project_id', $this->project->id)
            ->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->members = User::whereIn('id', $memberIds)->get();
        if ($department != "All") {
            $this->addmembers = User::where(function ($query) use ($department) {
                $query->where('department', $department)
                    ->orWhere('department', 'All');
            })
                ->whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        } else {
            $this->addmembers = User::whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        }
        $this->department = $department;
    }

    public function saveMembers($selectedMembers)
    {
        foreach ($selectedMembers as $memberId) {
            ProjectUser::create(['user_id' => $memberId, 'project_id' => $this->project->id]);
        }
        // Retrieve the member IDs associated with the project
        $memberIds = ProjectUser::where('project_id', $this->project->id)->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->members = User::whereIn('id', $memberIds)->get();
        $department = $this->department;
        if ($this->department != "All") {
            $this->addmembers = User::where(function ($query) use ($department) {
                $query->where('department', $department)
                    ->orWhere('department', 'All');
            })
                ->whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        } else {
            $this->addmembers = User::whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        }
        $this->emit('updateElements', $selectedMembers);
    }
    public function unassignMembers($selectedMember)
    {
        ProjectUser::where('user_id', $selectedMember)
            ->where('project_id', $this->project->id)
            ->delete();
        $memberIds = ProjectUser::where('project_id', $this->project->id)->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->members = User::whereIn('id', $memberIds)->get();
        $department = $this->department;
        if ($this->department != "All") {
            $this->addmembers = User::where(function ($query) use ($department) {
                $query->where('department', $department)
                    ->orWhere('department', 'All');
            })
                ->whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        } else {
            $this->addmembers = User::whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        }
        $this->emit('updateUnassignElements');
    }
    public function sendNotification($selectedMembers)
    {
        $isMailSendable = 1;
        $sendername = Auth::user()->name . ' ' . Auth::user()->last_name;
        $error = null;
        $message =  $sendername . ' added you as a team member to a project: "' . $this->project->projecttitle . '".';
        foreach ($selectedMembers as $selectedMember) {
            $notification = new Notification([
                'user_id' => $selectedMember,
                'task_id' => $this->project->id,
                'task_type' => "project",
                'task_name' => $this->project->projecttitle,
                'message' => $message,
            ]);
            $notification->save();
            if ($isMailSendable === 1) {
                try {
                    $assignee = User::findorFail($selectedMember);
                    $email = $assignee->email;
                    $name = $assignee->name . ' ' . $assignee->last_name;
                    $taskname = $this->project->projecttitle;
                    $tasktype = "project";
                    $startDate = date('F d, Y', strtotime($this->project->projectstartdate));
                    $endDate = date('F d, Y', strtotime($this->project->projectenddate));

                    $taskdeadline = $startDate . ' - ' . $endDate;
                    $senderemail = Auth::user()->email;
                    Mail::to($email)->send(new MyMail($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail));
                } catch (\Exception $e) {
                    $isMailSendable = 0;
                    $error = $e;
                }
            }
        }
        if ($isMailSendable === 1) {
            $this->emit('updateLoading');
        } else {
            $this->emit('updateLoadingFailed', $error);
        }
    }
    public function handleSaveMembers($selectedMembers)
    {
        $this->saveMembers($selectedMembers);
    }
    public function handleSendNotification($selectedMembers)
    {
        $this->sendNotification($selectedMembers);
    }
    public function render()
    {
        return view('livewire.project-members');
    }
}
