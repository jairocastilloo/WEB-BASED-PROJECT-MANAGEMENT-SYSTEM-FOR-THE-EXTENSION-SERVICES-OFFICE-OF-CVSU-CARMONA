<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Output;

class ActivityOutput extends Component
{
    public $outputTypes;
    public $outputs;
    public $activityid;

    protected $listeners = ['addOutput' => 'handleaddOutput', 'saveEditOutput' => 'handlesaveEditOutput'];


    public function mount($outputTypes, $outputs, $activityid)
    {
        $this->outputTypes = $outputTypes;
        $this->outputs = $outputs;
        $this->activityid = $activityid;
    }

    public function addOutput($actid, $outputtype, $outputnumber, $outputValues, $outputNeeded)
    {
        for ($i = 0; $i < $outputnumber; $i++) {
            $output = new Output();
            $output->output_type = $outputtype;
            $output->output_name = $outputValues[$i];
            $output->activity_id = $actid;
            $output->expectedoutput = $outputNeeded[$i];
            $output->save();
        }
        $this->outputs = Output::where('activity_id', $this->activityid)->get();
        $this->outputTypes = $this->outputs->unique('output_type')->pluck('output_type');
        $this->emit('updateOutput');
    }
    public function saveEditOutput($valuesByParentId)
    {
        foreach ($valuesByParentId as $values) {
            Output::where('id', $values['outputid'])
                ->update(['expectedoutput' => $values['outputneeded']]);
        }
        $this->outputs = Output::where('activity_id', $this->activityid)->get();
        $this->outputTypes = $this->outputs->unique('output_type')->pluck('output_type');
    }
    public function handleaddOutput($actid, $outputtype, $outputnumber, $outputValues, $outputNeeded)
    {
        $this->addOutput($actid, $outputtype, $outputnumber, $outputValues, $outputNeeded);
    }
    public function handlesaveEditOutput($valuesByParentId)
    {
        $this->saveEditOutput($valuesByParentId);
    }
    public function render()
    {
        return view('livewire.activity-output');
    }
}
