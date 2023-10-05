<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use Livewire\Component;

class OtherActivities extends Component
{
    public $search = '';
    public $activities;
    public $activityIds = [];
    public function mount($activities)
    {
        $this->activities = $activities;
        $this->activityIds = $activities->pluck('id')->toArray();
    }
    public function render()
    {
        $this->activities = Activity::where('actname', 'like', '%' . $this->search . '%')
            ->whereIn('id', $this->activityIds)
            ->get();
        return view('livewire.other-activities');
    }
}
