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
    protected $listeners = ['saveMembers' => 'handleSaveMembers', 'sendNotification' => 'handleSendNotification'];
    public function mount($indexproject)
    {
        $this->project = $indexproject;

        // Retrieve the member IDs associated with the project
        $memberIds = ProjectUser::where('project_id', $this->project->id)
            ->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->members = User::whereIn('id', $memberIds)->get();

        $this->addmembers = User::where('department', Auth::user()->department)
            ->whereNotIn('id', $memberIds)
            ->where('role', '!=', 'FOR APPROVAL')
            ->get();
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

        $this->addmembers = User::where('department', Auth::user()->department)
            ->whereNotIn('id', $memberIds)
            ->where('role', '!=', 'FOR APPROVAL')
            ->get();
        $this->emit('updateElements', $selectedMembers);
    }
    public function unassignMembers($selectedMember)
    {
        ProjectUser::where('user_id', $selectedMember)
            ->delete();
        $memberIds = ProjectUser::where('project_id', $this->project->id)->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->members = User::whereIn('id', $memberIds)->get();

        $this->addmembers = User::where('department', Auth::user()->department)
            ->whereNotIn('id', $memberIds)
            ->where('role', '!=', 'FOR APPROVAL')
            ->get();
        $this->emit('updateUnassignElements');
    }
    public function sendNotification($selectedMembers)
    {
        $sendername = Auth::user()->name . ' ' . Auth::user()->last_name;

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
            $this->emit('updateLoading');
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