<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use App\Models\Output;
use Livewire\Component;

class CheckOutput extends Component
{
    public $outputactivity = null;
    public $outputTypes = [];
    public $outputs = null;
    protected $listeners = ['showOutput' => 'handleShowOutput'];

    public function showOutput($checkActId)

    {
        $this->outputactivity = Activity::findorFail($checkActId);
        $this->outputTypes = Output::where('activity_id', $checkActId)
            ->pluck('output_type')
            ->unique()
            ->toArray();
        $this->outputs = Output::where('activity_id', $checkActId)
            ->get();
        $this->emit('successShow');
    }
    public function handleShowOutput($checkActId)
    {
        $this->showOutput($checkActId);
    }
    public function render()
    {
        return view('livewire.check-output');
    }
}
