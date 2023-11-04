<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotStartedActivities extends Component
{
    public $projectid;
    public $xNotStartedActivities;
    public $inputSearchNotStartedActivities = '';
    public $currentPageNotStartedActivities = 1; // The current page number
    public $perPageNotStartedActivities = 5;
    public $currentdate;
    public $activityid;
    protected $listeners = ['findNotStartedActivities' => 'handleFindNotStartedActivities'];

    public function mount($projectid, $activityid, $xNotStartedActivities)

    {
        $this->currentdate = now();
        $this->activityid = $activityid;
        $this->xNotStartedActivities = $xNotStartedActivities;
        $this->projectid = $projectid;
    }
    public function showNotStartedActivities($xNotStartedActivities)
    {
        $this->xNotStartedActivities = $xNotStartedActivities;
    }
    public function refreshDataNotStartedActivities()
    {
        $this->xNotStartedActivities = 1;
        $this->currentPageNotStartedActivities = 1;
    }
    public function changePageNotStartedActivities($page)
    {
        $this->currentPageNotStartedActivities = $page;
    }
    public function findNotStartedActivities($inputSearchNotStartedActivities, $xNotStartedActivities)
    {
        $this->inputSearchNotStartedActivities = $inputSearchNotStartedActivities;
        $this->xNotStartedActivities = $xNotStartedActivities;
        $this->currentPageNotStartedActivities = 1;
    }
    public function handleFindNotStartedActivities($inputSearchNotStartedActivities, $xNotStartedActivities)
    {
        $this->findNotStartedActivities($inputSearchNotStartedActivities, $xNotStartedActivities);
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($this->projectid == null) {
            switch ($this->xNotStartedActivities) {

                case 0:
                    $NotStartedActivities = null;
                    $lastpageNotStartedActivities = null;
                    break;
                case 1:

                    $NotStartedActivities = $user->activities()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '>', $this->currentdate)
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageNotStartedActivities, ['*'], 'page', $this->currentPageNotStartedActivities);

                    $lastpageNotStartedActivities = $NotStartedActivities->lastPage();


                    break;

                case 2:

                    $NotStartedActivities = $user->activities()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '>', $this->currentdate)
                        ->where('actname', 'like', "%$this->inputSearchNotStartedActivities%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageNotStartedActivities, ['*'], 'page', $this->currentPageNotStartedActivities);

                    $lastpageNotStartedActivities = $NotStartedActivities->lastPage();

                    break;
            }
        }
        return view('livewire.not-started-activities', [
            'NotStartedActivities' => $NotStartedActivities,
            'totalPagesNotStartedActivities' => $lastpageNotStartedActivities
        ]);
    }
}
