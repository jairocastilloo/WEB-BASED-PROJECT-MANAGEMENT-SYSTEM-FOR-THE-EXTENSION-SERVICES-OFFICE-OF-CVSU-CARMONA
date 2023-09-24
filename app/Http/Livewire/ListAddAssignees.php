<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use App\Models\ActivityUser;
use App\Models\ProjectUser;
use App\Models\User;
use Livewire\Component;

class ListAddAssignees extends Component
{
    public $addassignees;
    public $actid;
    public function mount($activityid)
    {
        $this->actid = $activityid;
        $assigneesids = ActivityUser::where('activity_id', $activityid)
            ->pluck('user_id')
            ->toArray();
        $projectid = Activity::findorFail($activityid)->value('project_id');
        $projectuser = ProjectUser::where('project_id', $projectid)
            ->whereNotIn('user_id', $assigneesids)
            ->pluck('user_id')
            ->toArray();
        $this->addassignees = User::whereIn('id', $projectuser)
            ->get();
    }
    public function updateaddAssignees()
    {
        $assigneesids = ActivityUser::where('activity_id', $this->actid)
            ->pluck('user_id')
            ->toArray();
        $projectid = Activity::findorFail($this->actid)->value('project_id');
        $projectuser = ProjectUser::where('project_id', $projectid)
            ->whereNotIn('user_id', $assigneesids)
            ->pluck('user_id')
            ->toArray();
        $this->addassignees = User::whereIn('id', $projectuser)
            ->get();
    }

    public function render()
    {
        return view('livewire.list-add-assignees');
    }
}
