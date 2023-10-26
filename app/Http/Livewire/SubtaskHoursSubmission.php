<?php

namespace App\Http\Livewire;

use App\Models\Contribution;
use App\Models\Subtask;
use Livewire\Component;

class SubtaskHoursSubmission extends Component
{
    public $contributionid;
    public $subtaskid;
    public $subtaskname;
    protected $listeners = ['reject' => 'rejecthandle'];
    public function mount($contributionid, $subtaskid, $subtaskname)
    {
        $this->contributionid = $contributionid;
        $this->subtaskid = $subtaskid;
        $this->subtaskname = $subtaskname;
    }
    public function accept()
    {
        $contribution = Contribution::findorFail($this->contributionid);
        $contribution->update(['approval' => 1]);

        $subtaskid = $contribution->subtask_id;
        $hoursrendered = $contribution->hours_rendered;
        Subtask::where('id', $subtaskid)->increment('hours_rendered', $hoursrendered);
        Contribution::where('subtask_id', $subtaskid)
            ->where('approval', null)
            ->delete();
        return redirect()->route("subtasks.display", ["subtaskid" => $this->subtaskid, "subtaskname" => $this->subtaskname]);
    }
    public function rejecthandle($notes)
    {

        $this->reject($notes);
    }
    public function reject($notes)
    {
        $contribution = Contribution::findorFail($this->contributionid);
        $contribution->update([
            'approval' => 0,
            'notes' => $notes
        ]);
        return redirect()->route("subtasks.display", ["subtaskid" => $this->subtaskid, "subtaskname" => $this->subtaskname]);
    }
    public function render()
    {
        return view('livewire.subtask-hours-submission');
    }
}
