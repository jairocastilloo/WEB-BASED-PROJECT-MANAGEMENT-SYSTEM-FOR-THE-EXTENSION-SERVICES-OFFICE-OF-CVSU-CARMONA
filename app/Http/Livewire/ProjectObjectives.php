<?php

namespace App\Http\Livewire;

use App\Models\Objective;
use Livewire\Component;

class ProjectObjectives extends Component
{
    public $indexproject;
    public $objectives;
    public $lastObjectivesetId;
    public function mount($indexproject)
    {
        $this->indexproject = $indexproject;
        $this->lastObjectivesetId = Objective::where('project_id', $indexproject->id)
            ->latest()
            ->value('objectiveset_id');
        $this->objectives = Objective::where('project_id', $indexproject->id)
            ->get();
    }
    public function render()
    {
        return view('livewire.project-objectives');
    }
}
