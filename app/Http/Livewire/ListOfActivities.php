<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use App\Models\Objective;
use Livewire\Component;

class ListOfActivities extends Component
{
    public $search = '';
    public $activities;
    public $activityIds = [];
    public $objectives;
    public $indexproject;
    protected $listeners = ['saveActivity' => 'handlesaveActivity'];
    public function mount($indexproject)
    {

        $this->activities = Activity::where('project_id', $indexproject->id)
            ->get();
        $this->objectives = Objective::where('project_id', $indexproject->id)
            ->get();
        $this->indexproject = $indexproject;
        $this->activityIds = $this->activities->pluck('id')->toArray();
    }
    public function saveActivity($arguments)
    {
        $activity = new Activity();
        $activity->actname = $arguments['actname'];
        $activity->actobjectives = $arguments['objectivevalue'];
        $activity->actoutput = $arguments['expectedoutput'];
        $activity->actstartdate = $arguments['actstartdate'];
        $activity->actenddate = $arguments['actenddate'];
        $activity->actbudget = $arguments['actbudget'];
        $activity->actsource = $arguments['actsource'];
        $activity->project_id = $this->indexproject->id;
        $activity->save();
        $this->activities = Activity::where('project_id', $this->indexproject->id)
            ->get();
        $this->emit('closeActivity');
    }
    public function handlesaveActivity($arguments)
    {
        $this->saveActivity($arguments);
    }
    public function render()
    {
        $this->activities = Activity::where('actname', 'like', '%' . $this->search . '%')
            ->whereIn('id', $this->activityIds)
            ->get();
        return view('livewire.list-of-activities');
    }
}
