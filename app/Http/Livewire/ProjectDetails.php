<?php

namespace App\Http\Livewire;

use App\Models\FiscalYear;
use App\Models\ProgramLeader;
use App\Models\Project;
use App\Models\Program;
use App\Models\ProjectLeader;
use Livewire\Component;

class ProjectDetails extends Component
{
    public $indexproject;
    public $members;
    public $department;
    public $projectleaders;
    public $program;
    public $programleaders;
    public $allfiscalyears;
    protected $listeners = ['saveProjectDetails' => 'handleSaveProjectDetails'];
    public function mount($indexproject, $members)
    {
        $this->indexproject = $indexproject;
        $this->members = $members;
        $this->department = $indexproject->department;
        $this->projectleaders = $indexproject->projectleaders;

        $this->allfiscalyears = FiscalYear::all();
        $programId = $indexproject->program_id;
        if ($programId != null) {
            $this->program = Program::findOrFail($programId);
            $this->programleaders = $this->program->programleaders;
        } else {
            $this->program = null;
            $this->programleaders = null;
        }
    }
    public function saveProjectDetails($projectDetails)
    {
        $projectstartdate = date("Y-m-d", strtotime($projectDetails[2]));
        $projectenddate = date("Y-m-d", strtotime($projectDetails[3]));
        Project::where('id', $this->indexproject->id)
            ->update([
                'program_id' => $this->program->id,
                'projecttitle' => $projectDetails[1],
                'projectstartdate' => $projectstartdate,
                'projectenddate' => $projectenddate
            ]);

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