<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use App\Models\ExpectedOutput;
use App\Models\Objective;
use Livewire\Component;

class ListOfActivities extends Component
{

    public $activities;

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
    }
    public function saveActivity($arguments)
    {

        $activity = new Activity();
        $activity->actname = $arguments['actname'];
        $activity->actobjectives = $arguments['objectivevalue'];

        $activity->actstartdate = date("Y-m-d", strtotime($arguments['actstartdate']));
        $activity->actenddate = date("Y-m-d", strtotime($arguments['actenddate']));
        $activity->actbudget = $arguments['actbudget'];
        $activity->actsource = $arguments['actsource'];
        $activity->project_id = $this->indexproject->id;
        $activity->save();
        $expectedoutputs = $arguments['expectedoutput'];
        foreach ($expectedoutputs as $expectedoutput) {
            ExpectedOutput::create([
                'name' => $expectedoutput,
                'activity_id' => $activity->id,
            ]);
        }
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

        return view('livewire.list-of-activities');
    }
}
