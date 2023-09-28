<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use Livewire\Component;

class ListOfActivities extends Component
{
    public $activities;
    public function mount($indexproject)
    {
        $this->activities = Activity::where('project_id', $indexproject->id)
            ->get();
    }
    public function render()
    {
        return view('livewire.list-of-activities');
    }
}
