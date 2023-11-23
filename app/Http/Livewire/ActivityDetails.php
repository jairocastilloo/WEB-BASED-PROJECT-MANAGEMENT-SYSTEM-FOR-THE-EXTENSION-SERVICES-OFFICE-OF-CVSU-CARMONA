<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use App\Models\ActivityBudget;
use App\Models\ExpectedOutput;
use App\Models\Project;
use Livewire\Component;
use App\Models\Objective;

class ActivityDetails extends Component
{
    public $activity;
    public $currentobjectives;
    public $objectives;
    public $projectdate;
    public $expectedOutputs;
    public $activityBudgets;
    protected $listeners = ['saveActivity' => 'handlesaveActivity'];

    public function mount($activity, $objectives)
    {
        $this->activity = $activity;
        $projectid = $activity->project_id;
        $this->projectdate = Project::where('id', $projectid)->first(['projectstartdate', 'projectenddate']);
        $this->currentobjectives = $objectives;
        $this->objectives = Objective::where('project_id', $projectid)->get();
        $this->expectedOutputs = ExpectedOutput::where('activity_id', $activity->id)->get();
        $this->activityBudgets = ActivityBudget::where('activity_id', $activity->id)->get();
    }
    public function saveActivity($arguments)
    {
        $activity = Activity::findorFail($this->activity->id);
        $activity->update([
            'actname' => $arguments['actname'],
            'actobjectives' => $arguments['objectivevalue'],
            'actstartdate' => date("Y-m-d", strtotime($arguments['actstartdate'])),
            'actenddate' => date("Y-m-d", strtotime($arguments['actenddate'])),
            'actsource' => $arguments['actsource'],
        ]);
        $this->activity = $activity;
        ExpectedOutput::where('activity_id', $activity->id)->delete();
        ActivityBudget::where('activity_id', $activity->id)->delete();
        $expectedoutputs = $arguments['expectedoutput'];
        foreach ($expectedoutputs as $expectedoutput) {
            ExpectedOutput::create([
                'name' => $expectedoutput,
                'activity_id' => $activity->id,
            ]);
        }
        $budgetItems = $arguments['actBudgetItem'];
        $budgetPrices = $arguments['actBudgetPrice'];
        if ($budgetItems != []) {
            foreach ($budgetItems as $key => $budgetItem) {
                ActivityBudget::create([
                    'item' => $budgetItem,
                    'price' => $budgetPrices[$key],
                    'activity_id' => $activity->id,
                ]);
            }
        }

        $objectiveset = $activity->actobjectives;
        $objectives = Objective::where('project_id', $activity->project_id)
            ->where('objectiveset_id', $objectiveset)
            ->get();
        $this->currentobjectives = $objectives;
        $this->expectedOutputs = ExpectedOutput::where('activity_id', $activity->id)->get();
        $this->activityBudgets = ActivityBudget::where('activity_id', $activity->id)->get();
        $this->emit('closeActivity', $arguments['objectivevalue']);
    }
    public function handlesaveActivity($arguments)
    {
        $this->saveActivity($arguments);
    }
    public function render()
    {
        return view('livewire.activity-details');
    }
}
