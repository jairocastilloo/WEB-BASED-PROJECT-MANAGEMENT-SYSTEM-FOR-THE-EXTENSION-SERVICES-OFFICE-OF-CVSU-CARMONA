<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompletedActivities extends Component
{
    public $projectid;
    public $xCompletedActivities;
    public $inputSearchCompletedActivities = '';
    public $currentPageCompletedActivities = 1; // The current page number
    public $perPageCompletedActivities = 5;
    public $currentdate;
    public $activityid;
    protected $listeners = ['findCompletedActivities' => 'handleFindCompletedActivities'];
    public function mount($projectid, $activityid, $xCompletedActivities)

    {
        $this->currentdate = now();
        $this->activityid = $activityid;
        $this->xCompletedActivities = $xCompletedActivities;
        $this->projectid = $projectid;
    }
    public function showCompletedActivities($xCompletedActivities)
    {
        $this->xCompletedActivities = $xCompletedActivities;
    }
    public function refreshDataCompletedActivities()
    {
        $this->xCompletedActivities = 1;
        $this->currentPageCompletedActivities = 1;
    }
    public function changePageCompletedActivities($page)
    {
        $this->currentPageCompletedActivities = $page;
    }
    public function findCompletedActivities($inputSearchCompletedActivities, $xCompletedActivities)
    {
        $this->inputSearchCompletedActivities = $inputSearchCompletedActivities;
        $this->xCompletedActivities = $xCompletedActivities;
        $this->currentPageCompletedActivities = 1;
    }
    public function handleFindCompletedActivities($inputSearchCompletedActivities, $xCompletedActivities)
    {
        $this->findCompletedActivities($inputSearchCompletedActivities, $xCompletedActivities);
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($this->projectid == null) {
            switch ($this->xCompletedActivities) {

                case 0:
                    $CompletedActivities = null;
                    $lastpageCompletedActivities = null;
                    break;
                case 1:

                    $CompletedActivities = $user->activities()
                        ->where('actremark', 'Completed')
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageCompletedActivities, ['*'], 'page', $this->currentPageCompletedActivities);

                    $lastpageCompletedActivities = $CompletedActivities->lastPage();


                    break;

                case 2:

                    $CompletedActivities = $user->activities()
                        ->where('actremark', 'Completed')
                        ->where('actname', 'like', "%$this->inputSearchCompletedActivities%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageCompletedActivities, ['*'], 'page', $this->currentPageCompletedActivities);

                    $lastpageCompletedActivities = $CompletedActivities->lastPage();

                    break;
            }
        } else if ($user->role == 'Admin') {
            switch ($this->xCompletedActivities) {

                case 0:
                    $CompletedActivities = null;
                    $lastpageCompletedActivities = null;
                    break;
                case 1:

                    $CompletedActivities = Activity::query()
                        ->where('actremark', 'Completed')
                        ->where('project_id', $this->projectid)
                        ->whereNotIn('activities.id', [$this->activityid])
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageCompletedActivities, ['*'], 'page', $this->currentPageCompletedActivities);

                    $lastpageCompletedActivities = $CompletedActivities->lastPage();


                    break;

                case 2:

                    $CompletedActivities = Activity::query()
                        ->where('actremark', 'Completed')
                        ->where('project_id', $this->projectid)
                        ->whereNotIn('activities.id', [$this->activityid])
                        ->where('actname', 'like', "%$this->inputSearchCompletedActivities%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageCompletedActivities, ['*'], 'page', $this->currentPageCompletedActivities);

                    $lastpageCompletedActivities = $CompletedActivities->lastPage();

                    break;
            }
        } else {
            switch ($this->xCompletedActivities) {

                case 0:
                    $CompletedActivities = null;
                    $lastpageCompletedActivities = null;
                    break;
                case 1:

                    $CompletedActivities = $user->activities()
                        ->where('actremark', 'Completed')
                        ->where('project_id', $this->projectid)
                        ->whereNotIn('activities.id', [$this->activityid])
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageCompletedActivities, ['*'], 'page', $this->currentPageCompletedActivities);

                    $lastpageCompletedActivities = $CompletedActivities->lastPage();


                    break;

                case 2:

                    $CompletedActivities = $user->activities()
                        ->where('actremark', 'Completed')
                        ->where('project_id', $this->projectid)
                        ->whereNotIn('activities.id', [$this->activityid])
                        ->where('actname', 'like', "%$this->inputSearchCompletedActivities%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPageCompletedActivities, ['*'], 'page', $this->currentPageCompletedActivities);

                    $lastpageCompletedActivities = $CompletedActivities->lastPage();

                    break;
            }
        }
        return view('livewire.completed-activities', [
            'CompletedActivities' => $CompletedActivities,
            'totalPagesCompletedActivities' => $lastpageCompletedActivities
        ]);
    }
}
