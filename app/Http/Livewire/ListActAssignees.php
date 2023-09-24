<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use Livewire\Component;
use App\Models\ActivityUser;
use App\Models\User;

class ListActAssignees extends Component
{
    public $assignees;
    public $actid;
    public function mount($activityid)
    {
        $this->actid = $activityid;
        $assigneesids = ActivityUser::where('activity_id', $activityid)
            ->pluck('user_id')
            ->toArray();
        $this->assignees = User::whereIn('id', $assigneesids)
            ->get();
    }
    public function updateAssignees()
    {
        $assigneesids = ActivityUser::where('activity_id', $this->actid)
            ->pluck('user_id')
            ->toArray();
        $this->assignees = User::whereIn('id', $assigneesids)
            ->get();
    }

    public function render()
    {
        return view('livewire.list-act-assignees');
    }
}
