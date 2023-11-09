<?php

namespace App\Http\Livewire;

use App\Models\activityContribution;
use App\Models\Activity;
use Livewire\Component;

class ActivityHoursSubmission extends Component
{
    public $actcontributionid;
    public $activityid;
    public $activityname;
    protected $listeners = ['reject' => 'rejecthandle'];
    public function mount($actcontributionid, $activityid, $activityname)
    {
        $this->actcontributionid = $actcontributionid;
        $this->activityid = $activityid;
        $this->activityname = $activityname;
    }
    //dsf
    public function accept()
    {

        $actcontribution = activityContribution::findorFail($this->actcontributionid);
        $actcontribution->update(['approval' => 1]);


        $activityid = $actcontribution->activity_id;
        $hoursrendered = $actcontribution->hours_rendered;
        Activity::where('id', $activityid)->increment('totalhours_rendered', $hoursrendered);
        activityContribution::where('activity_id', $activityid)
            ->where('approval', null)
            ->delete();

        return redirect()->route('hours.display', ['activityid' => $this->activityid, 'activityname' => $this->activityname]);
    }
    public function rejecthandle($notes)
    {

        $this->reject($notes);
    }
    public function reject($notes)
    {

        $actcontribution = activityContribution::findorFail($this->actcontributionid);
        $actcontribution->update([
            'approval' => 0,
            'notes' => $notes
        ]);

        return redirect()->route('hours.display', ['activityid' => $this->activityid, 'activityname' => $this->activityname]);
    }
    public function render()
    {
        return view('livewire.activity-hours-submission');
    }
}
