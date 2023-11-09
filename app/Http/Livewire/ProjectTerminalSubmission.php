<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\ProjectTerminal;
use Livewire\Component;

class ProjectTerminalSubmission extends Component
{
    public $projcontributionid;
    public $project;
    protected $listeners = ['reject' => 'rejecthandle'];
    public function mount($projcontributionid, $project)
    {
        $this->projcontributionid = $projcontributionid;
        $this->project = $project;
    }
    public function accept()
    {

        $projcontribution = ProjectTerminal::findorFail($this->projcontributionid);
        $projcontribution->update(['approval' => 1]);

        Project::where('id', $this->project->id)->update(['projectstatus' => 'Completed']);

        ProjectTerminal::where('project_id', $this->project->id)
            ->where('approval', null)
            ->delete();

        return redirect()->route('projects.close', ['projectid' => $this->project->id, 'department' => $this->project->department]);
    }
    public function rejecthandle($notes)
    {

        $this->reject($notes);
    }
    public function reject($notes)
    {

        $projcontribution = ProjectTerminal::findorFail($this->projcontributionid);
        $projcontribution->update([
            'approval' => 0,
            'notes' => $notes
        ]);

        return redirect()->route('projects.close', ['projectid' => $this->project->id, 'department' => $this->project->department]);
    }
    public function render()
    {
        return view('livewire.project-terminal-submission');
    }
}
