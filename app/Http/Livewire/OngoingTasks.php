<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OngoingTasks extends Component
{
    public $activityid;
    public $xOngoingTasks;
    public $inputSearchOngoingTasks = '';
    public $currentPageOngoingTasks = 1; // The current page number
    public $perPageOngoingTasks = 5;
    public $currentdate;
    public $subtaskid;
    public $fiscalyear;
    protected $listeners = ['findOngoingTasks' => 'handleFindOngoingTasks'];
    public function mount($activityid, $subtaskid, $fiscalyear, $xOngoingTasks)

    {
        $this->currentdate = now();
        $this->activityid = $activityid;
        $this->fiscalyear = $fiscalyear;
        $this->xOngoingTasks = $xOngoingTasks;
        $this->subtaskid = $subtaskid;
    }
    public function showOngoingTasks($xOngoingTasks)
    {
        $this->xOngoingTasks = $xOngoingTasks;
    }
    public function refreshDataOngoingTasks()
    {
        $this->xOngoingTasks = 1;
        $this->currentPageOngoingTasks = 1;
    }
    public function changePageOngoingTasks($page)
    {
        $this->currentPageOngoingTasks = $page;
    }
    public function findOngoingTasks($inputSearchOngoingTasks, $xOngoingTasks)
    {
        $this->inputSearchOngoingTasks = $inputSearchOngoingTasks;
        $this->xOngoingTasks = $xOngoingTasks;
        $this->currentPageOngoingTasks = 1;
    }
    public function handleFindOngoingTasks($inputSearchOngoingTasks, $xOngoingTasks)
    {
        $this->findInProgressActivities($inputSearchOngoingTasks, $xOngoingTasks);
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($this->activityid == null && $this->subtaskid == null) {
            switch ($this->xOngoingTasks) {

                case 0:
                    $OngoingTasks = null;
                    $lastpageOngoingTasks = null;
                    break;
                case 1:

                    $OngoingTasks = $user->subtasks()
                        ->where('status', 'Incomplete')
                        ->where('subduedate', '>=', $this->fiscalyear->startdate)
                        ->where('subduedate', '<=', $this->fiscalyear->enddate)
                        ->where('subduedate', '>=', now())  // Add this line
                        ->orderBy('subduedate', 'asc') // Sort in ascending order
                        ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                    $lastpageOngoingTasks = $OngoingTasks->lastPage();


                    break;

                case 2:

                    $OngoingTasks = $user->subtasks()
                        ->where('status', 'Incomplete')
                        ->where('subduedate', '>=', $this->fiscalyear->startdate)
                        ->where('subduedate', '<=', $this->fiscalyear->enddate)
                        ->where('subduedate', '>=', now())  // Add this line
                        ->where('actname', 'like', "%$this->inputSearchOngoingTasks%")
                        ->orderBy('subduedate', 'asc') // Sort in ascending order
                        ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);

                    $lastpageOngoingTasks = $OngoingTasks->lastPage();


                    break;
            }
        }
        return view('livewire.ongoing-tasks', [
            'OngoingTasks' => $OngoingTasks,
            'totalPagesOngoingTasks' => $lastpageOngoingTasks
        ]);
    }
}
