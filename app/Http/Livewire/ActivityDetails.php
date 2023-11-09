<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use App\Models\Project;
use Livewire\Component;
use App\Models\Objective;

class ActivityDetails extends Component
{
    public $activity;
    public $currentobjectives;
    public $objectives;
    public $projectdate;
    protected $listeners = ['saveActivity' => 'handlesaveActivity'];

    public function mount($activity, $objectives)
    {
        $this->activity = $activity;
        $projectid = $activity->project_id;
        $this->projectdate = Project::where('id', $projectid)->first(['projectstartdate', 'projectenddate']);
        $this->currentobjectives = $objectives;
        $this->objectives = Objective::where('project_id', $projectid)->get();
    }
    public function saveActivity($arguments)
    {
        $activity = Activity::findorFail($this->activity->id);
        $activity->update([
            'actname' => $arguments['actname'],
            'actobjectives' => $arguments['objectivevalue'],
            'actoutput' => $arguments['expectedoutput'],
            'actstartdate' => $arguments['actstartdate'],
            'actenddate' => $arguments['actenddate'],
            'actbudget' => $arguments['actbudget'],
            'actsource' => $arguments['actsource'],
        ]);
        $this->activity = $activity;
        $objectiveset = $activity->actobjectives;
        $objectives = Objective::where('project_id', $activity->project_id)
            ->where('objectiveset_id', $objectiveset)
            ->get();
        $this->currentobjectives = $objectives;
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
