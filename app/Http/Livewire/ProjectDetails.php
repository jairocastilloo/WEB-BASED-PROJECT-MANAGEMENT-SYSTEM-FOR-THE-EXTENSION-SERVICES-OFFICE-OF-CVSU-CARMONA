<?php

namespace App\Http\Livewire;

use App\Models\FiscalYear;
use App\Models\ProgramLeader;
use App\Models\Project;
use App\Models\ProjectLeader;
use Livewire\Component;

class ProjectDetails extends Component
{
    public $indexproject;
    public $members;
    public $department;
    public $projectleaders;

    public $programleaders;
    public $allfiscalyears;
    protected $listeners = ['saveProjectDetails' => 'handleSaveProjectDetails'];
    public function mount($indexproject, $members)
    {
        $this->indexproject = $indexproject;
        $this->members = $members;
        $this->department = $indexproject->department;
        $this->projectleaders = $indexproject->projectleaders;
        $this->programleaders = $indexproject->programleaders;
        $this->allfiscalyears = FiscalYear::all();
    }
    public function saveProjectDetails($projectDetails)
    {
        $projectstartdate = date("Y-m-d", strtotime($projectDetails[2]));
        $projectenddate = date("Y-m-d", strtotime($projectDetails[3]));
        Project::where('id', $this->indexproject->id)
            ->update([
                'programtitle' => $projectDetails[0],
                'projecttitle' => $projectDetails[1],
                'projectstartdate' => $projectstartdate,
                'projectenddate' => $projectenddate
            ]);
        if (!empty($projectDetails[4])) {
            ProgramLeader::where('project_id', $this->indexproject->id)->delete();
            foreach ($projectDetails[4] as $userid) {
                ProgramLeader::create(
                    [
                        'project_id' => $this->indexproject->id,
                        'user_id' => $userid,
                    ]
                );
            }
        }
        ProjectLeader::where('project_id', $this->indexproject->id)->delete();
        foreach ($projectDetails[5] as $userid) {
            ProjectLeader::create(
                [
                    'project_id' => $this->indexproject->id,
                    'user_id' => $userid,
                ]
            );
        }
        $this->indexproject = Project::findOrFail($this->indexproject->id);
        $this->programleaders = $this->indexproject->programleaders;
        $this->projectleaders = $this->indexproject->projectleaders;
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
