<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InProgressActivities extends Component
{
    public $projectid;
    public $xInProgressActivities;
    public $inputSearchInProgressActivities = '';
    public $currentPageInProgressActivities = 1; // The current page number
    public $perPageInProgressActivities = 5;
    public $currentdate;
    public $activityid;
    protected $listeners = ['findInProgressActivities' => 'handleFindInProgressActivities'];

    public function mount($projectid, $activityid, $xInProgressActivities)

    {
        $this->currentdate = now();
        $this->activityid = $activityid;
        $this->xInProgressActivities = $xInProgressActivities;
        $this->projectid = $projectid;
    }
    public function showInProgressActivities($xInProgressActivities)
    {
        $this->xInProgressActivities = $xInProgressActivities;
    }
    public function refreshDataInProgressActivities()
    {
        $this->xInProgressActivities = 1;
        $this->currentPageInProgressActivities = 1;
    }
    public function changePageInProgressActivities($page)
    {
        $this->currentPageInProgressActivities = $page;
    }
    public function findInProgressActivities($inputSearchInProgressActivities, $xInProgressActivities)
    {
        $this->inputSearchInProgressActivities = $inputSearchInProgressActivities;
        $this->xInProgressActivities = $xInProgressActivities;
        $this->currentPageInProgressActivities = 1;
    }
    public function handleFindInProgressActivities($inputSearchInProgressActivities, $xInProgressActivities)
    {
        $this->findInProgressActivities($inputSearchInProgressActivities, $xInProgressActivities);
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($this->projectid == null) {
            switch ($this->xInProgressActivities) {

                case 0:
                    $InProgressActivities = null;
                    $lastpageInProgressActivities = null;
                    break;
                case 1:

                    $InProgressActivities = $user->activities()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '<=', $this->currentdate)
                        ->where('actenddate', '>=', $this->currentdate)
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageInProgressActivities, ['*'], 'page', $this->currentPageInProgressActivities);

                    $lastpageInProgressActivities = $InProgressActivities->lastPage();


                    break;

                case 2:

                    $InProgressActivities = $user->activities()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '<=', $this->currentdate)
                        ->where('actenddate', '>=', $this->currentdate)
                        ->where('actname', 'like', "%$this->inputSearchInProgressActivities%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageInProgressActivities, ['*'], 'page', $this->currentPageInProgressActivities);

                    $lastpageInProgressActivities = $InProgressActivities->lastPage();

                    break;
            }
        } else if ($user->role == 'Admin') {
            switch ($this->xInProgressActivities) {

                case 0:
                    $InProgressActivities = null;
                    $lastpageInProgressActivities = null;
                    break;
                case 1:

                    $InProgressActivities = Activity::query()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '<=', $this->currentdate)
                        ->where('actenddate', '>=', $this->currentdate)
                        ->where('project_id', $this->projectid)
                        ->whereNotIn('activities.id', [$this->activityid])
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageInProgressActivities, ['*'], 'page', $this->currentPageInProgressActivities);

                    $lastpageInProgressActivities = $InProgressActivities->lastPage();


                    break;

                case 2:

                    $InProgressActivities = Activity::query()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '<=', $this->currentdate)
                        ->where('actenddate', '>=', $this->currentdate)
                        ->where('project_id', $this->projectid)
                        ->whereNotIn('activities.id', [$this->activityid])
                        ->where('actname', 'like', "%$this->inputSearchInProgressActivities%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageInProgressActivities, ['*'], 'page', $this->currentPageInProgressActivities);

                    $lastpageInProgressActivities = $InProgressActivities->lastPage();

                    break;
            }
        } else {
            switch ($this->xInProgressActivities) {

                case 0:
                    $InProgressActivities = null;
                    $lastpageInProgressActivities = null;
                    break;
                case 1:

                    $InProgressActivities = $user->activities()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '<=', $this->currentdate)
                        ->where('actenddate', '>=', $this->currentdate)
                        ->where('project_id', $this->projectid)
                        ->whereNotIn('activities.id', [$this->activityid])
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageInProgressActivities, ['*'], 'page', $this->currentPageInProgressActivities);

                    $lastpageInProgressActivities = $InProgressActivities->lastPage();


                    break;

                case 2:

                    $InProgressActivities = $user->activities()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '<=', $this->currentdate)
                        ->where('actenddate', '>=', $this->currentdate)
                        ->where('project_id', $this->projectid)
                        ->whereNotIn('activities.id', [$this->activityid])
                        ->where('actname', 'like', "%$this->inputSearchInProgressActivities%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageInProgressActivities, ['*'], 'page', $this->currentPageInProgressActivities);

                    $lastpageInProgressActivities = $InProgressActivities->lastPage();

                    break;
            }
        }
        return view('livewire.in-progress-activities', [
            'InProgressActivities' => $InProgressActivities,
            'totalPagesInProgressActivities' => $lastpageInProgressActivities
        ]);
    }
}
