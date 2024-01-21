<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;

class ListOfProjects extends Component
{
    public $projects;

    public $indexprogram;
    protected $listeners = ['saveProject' => 'handlesaveProject'];
    public function mount($indexprogram)
    {

        $this->projects = Project::where('program_id', $indexprogram->id)
            ->get();

        $this->indexprogram = $indexprogram;
    }
    public function render()
    {
        return view('livewire.list-of-projects');
    }
}
