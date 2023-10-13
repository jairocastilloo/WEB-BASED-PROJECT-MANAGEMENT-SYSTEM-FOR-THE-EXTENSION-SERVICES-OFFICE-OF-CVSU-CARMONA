<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class OtherProjects extends Component
{
    public $currentproject;
    public $projectids = [];
    protected $listeners = ['searchInput' => 'handlesearchInput'];

    public function mount($currentproject)
    {
        $this->currentproject = $currentproject;
        $this->projectids = $currentproject->pluck('id')->toArray();
    }

    public function searchInput($inputData)
    {
        $this->currentproject = Project::where('projecttitle', 'like', '%' . $inputData . '%')
            ->whereIn('id', $this->projectids)
            ->get();
    }
    public function handlesearchInput($inputData)
    {
        $this->searchInput($inputData);
    }

    public function render()
    {
        return view('livewire.other-projects');
    }
}
