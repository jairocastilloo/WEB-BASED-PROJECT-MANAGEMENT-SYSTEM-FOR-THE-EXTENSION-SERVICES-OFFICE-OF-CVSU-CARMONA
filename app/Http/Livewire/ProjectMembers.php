<?php

namespace App\Http\Livewire;

use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectMembers extends Component
{
    public $project;
    public $members;
    public $addmembers;
    protected $listeners = ['saveMembers' => 'handleSaveMembers'];
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
    }
    public function handleSaveMembers($selectedMembers)
    {
        $this->saveMembers($selectedMembers);
    }
    public function render()
    {
        return view('livewire.project-members');
    }
}
