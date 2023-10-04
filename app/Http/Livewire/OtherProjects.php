<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class OtherProjects extends Component
{
    public $search = '';
    public $currentproject;
    public $projectids = [];

    public function mount($currentproject)
    {
        $this->currentproject = $currentproject;
        $this->projectids = $currentproject->pluck('id')->toArray();
    }

    public function render()
    {

        $this->currentproject = Project::where('projecttitle', 'like', '%' . $this->search . '%')
            ->whereIn('id', $this->projectids)
            ->get();


        return view('livewire.other-projects');
    }
}
