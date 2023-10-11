<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectDetails extends Component
{
    public $indexproject;
    public $members;
    public $department;
    protected $listeners = ['saveProjectDetails' => 'handleSaveProjectDetails'];
    public function mount($indexproject, $members, $department)
    {
        $this->indexproject = $indexproject;
        $this->members = $members;
        $this->department = $department;
    }
    public function saveProjectDetails($projectDetails)
    {
        Project::where('id', $this->indexproject->id)
            ->update([
                'programtitle' => $projectDetails[0],
                'programleader' => $projectDetails[1],
                'projecttitle' => $projectDetails[2],
                'projectleader' => $projectDetails[3],
                'projectstartdate' => $projectDetails[4],
                'projectenddate' => $projectDetails[5]
            ]);
        $this->indexproject = Project::findOrFail($this->indexproject->id);
    }
    public function handleSaveProjectDetails($projectDetails)
    {
        $this->saveProjectDetails($projectDetails);
    }
    public function render()
    {
        return view('livewire.project-details');
    }
}
