<?php

namespace App\Http\Livewire;

use App\Models\Output;
use App\Models\OutputUser;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class OutputSubmission extends Component
{
    public $acceptids;
    public $activityindex;
    public $typeofoutput;
    protected $listeners = ['reject' => 'rejecthandle'];
    public function mount($acceptids, $activityindex, $typeofoutput)
    {
        $this->acceptids = $acceptids;
        $this->activityindex = $activityindex;
        $this->typeofoutput = $typeofoutput;
    }

    public function accept()
    {

        // Update the 'approval' field in SubtaskContributor table
        OutputUser::where('created_at', $this->acceptids)->update(['approval' => 1]);
        $outputids = OutputUser::where('created_at', $this->acceptids)
            ->distinct()
            ->pluck('output_id');
        foreach ($outputids as $outputid) {

            $outputuser = OutputUser::where('created_at', $this->acceptids)
                ->where('output_id', $outputid)
                ->first();
            $outputsubmitted = $outputuser->output_submitted;
            Output::where('id', $outputid)->increment('totaloutput_submitted', $outputsubmitted);
        }

        $url = URL::route('get.output', ['activityid' => $this->activityindex, 'outputtype' => $this->typeofoutput]);
        return redirect($url);
    }
    public function rejecthandle($notes)
    {

        $this->reject($notes);
    }
    public function reject($notes)
    {

        OutputUser::where('created_at', $this->acceptids)->update([
            'approval' => 0,
            'notes' => $notes
        ]);

        $url = URL::route('get.output', ['activityid' => $this->activityindex, 'outputtype' => $this->typeofoutput]);
        return redirect($url);
    }
    public function render()
    {
        return view('livewire.output-submission');
    }
}
