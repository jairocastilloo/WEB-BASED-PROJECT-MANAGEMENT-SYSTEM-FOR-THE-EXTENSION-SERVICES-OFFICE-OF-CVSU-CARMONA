<?php

namespace App\Http\Livewire;

use App\Models\Activity;
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
    public $showOnlyMyUpcomingActivities;
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
    public function toggleSelectionUpcomingActivities($isChecked)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isChecked) {

            $user->update([
                'showOnlyMyUpcomingActivities' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyUpcomingActivities' => 0,
            ]);
        }

        $this->showOnlyMyUpcomingActivities = $user->showOnlyMyUpcomingActivities;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyUpcomingActivities = $user->showOnlyMyUpcomingActivities;
        if ($user->role == "Admin" && $this->showOnlyMyUpcomingActivities == 0) {
            if ($this->projectid == null) {

                switch ($this->xNotStartedActivities) {

                    case 0:
                        $NotStartedActivities = null;
                        $lastpageNotStartedActivities = null;
                        break;
                    case 1:

                        $NotStartedActivities = Activity::query()
                            ->where('actremark', 'Incomplete')
                            ->where('actstartdate', '>', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageNotStartedActivities, ['*'], 'page', $this->currentPageNotStartedActivities);

                        $lastpageNotStartedActivities = $NotStartedActivities->lastPage();


                        break;

                    case 2:

                        $NotStartedActivities = Activity::query()
                            ->where('actremark', 'Incomplete')
                            ->where('actstartdate', '>', $this->currentdate)
                            ->where('actname', 'like', "%$this->inputSearchNotStartedActivities%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageNotStartedActivities, ['*'], 'page', $this->currentPageNotStartedActivities);

                        $lastpageNotStartedActivities = $NotStartedActivities->lastPage();

                        break;
                }
            } else {
                switch ($this->xNotStartedActivities) {

                    case 0:
                        $NotStartedActivities = null;
                        $lastpageNotStartedActivities = null;
                        break;
                    case 1:

                        $NotStartedActivities = Activity::query()
                            ->where('actremark', 'Incomplete')
                            ->where('actstartdate', '>', $this->currentdate)
                            ->where('project_id', $this->projectid)
                            ->whereNotIn('activities.id', [$this->activityid])
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageNotStartedActivities, ['*'], 'page', $this->currentPageNotStartedActivities);

                        $lastpageNotStartedActivities = $NotStartedActivities->lastPage();


                        break;

                    case 2:

                        $NotStartedActivities = Activity::query()
                            ->where('actremark', 'Incomplete')
                            ->where('actstartdate', '>', $this->currentdate)
                            ->where('project_id', $this->projectid)
                            ->whereNotIn('activities.id', [$this->activityid])
                            ->where('actname', 'like', "%$this->inputSearchNotStartedActivities%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageNotStartedActivities, ['*'], 'page', $this->currentPageNotStartedActivities);

                        $lastpageNotStartedActivities = $NotStartedActivities->lastPage();

                        break;
                }
            }
        } else {
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
            } else {
                switch ($this->xNotStartedActivities) {

                    case 0:
                        $NotStartedActivities = null;
                        $lastpageNotStartedActivities = null;
                        break;
                    case 1:

                        $NotStartedActivities = $user->activities()
                            ->where('actremark', 'Incomplete')
                            ->where('actstartdate', '>', $this->currentdate)
                            ->where('project_id', $this->projectid)
                            ->whereNotIn('activities.id', [$this->activityid])
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageNotStartedActivities, ['*'], 'page', $this->currentPageNotStartedActivities);

                        $lastpageNotStartedActivities = $NotStartedActivities->lastPage();


                        break;

                    case 2:

                        $NotStartedActivities = $user->activities()
                            ->where('actremark', 'Incomplete')
                            ->where('actstartdate', '>', $this->currentdate)
                            ->where('project_id', $this->projectid)
                            ->whereNotIn('activities.id', [$this->activityid])
                            ->where('actname', 'like', "%$this->inputSearchNotStartedActivities%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageNotStartedActivities, ['*'], 'page', $this->currentPageNotStartedActivities);

                        $lastpageNotStartedActivities = $NotStartedActivities->lastPage();

                        break;
                }
            }
        }
        return view('livewire.not-started-activities', [
            'NotStartedActivities' => $NotStartedActivities,
            'totalPagesNotStartedActivities' => $lastpageNotStartedActivities
        ]);
    }
}
