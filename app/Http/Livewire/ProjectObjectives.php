<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProjectObjectives extends Component
{
    public $indexproject;
    public function mount($indexproject)
    {
        $this->indexproject = $indexproject;
    }
    public function render()
    {
        return view('livewire.project-objectives');
    }
}
