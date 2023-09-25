<?php

namespace App\Http\Livewire;

use App\Models\ProjectUser;
use App\Models\User;
use Livewire\Component;

class ProjectMembers extends Component
{
    public $project;
    public $members;
    public function mount($indexproject)
    {
        $this->project = $indexproject;

        // Retrieve the member IDs associated with the project
        $memberIds = ProjectUser::where('project_id', $this->project->id)->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->members = User::whereIn('id', $memberIds)->get();
    }

    public function render()
    {
        return view('livewire.project-members');
    }
}
