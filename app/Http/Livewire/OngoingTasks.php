<?php

namespace App\Http\Livewire;

use App\Models\Subtask;
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
    public $showOnlyMyActiveTasks;
    protected $listeners = ['findOngoingTasks' => 'handleFindOngoingTasks'];
    public function mount($activityid, $subtaskid, $xOngoingTasks)

    {
        $this->currentdate = now();
        $this->activityid = $activityid;
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
        $this->findOngoingTasks($inputSearchOngoingTasks, $xOngoingTasks);
    }
    public function toggleSelectionActive($isChecked)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isChecked) {

            $user->update([
                'showOnlyMyActiveTasks' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyActiveTasks' => 0,
            ]);
        }

        $this->showOnlyMyActiveTasks = $user->showOnlyMyActiveTasks;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyActiveTasks = $user->showOnlyMyActiveTasks;
        if ($user->role == "Admin" && $this->showOnlyMyActiveTasks == 0) {
            if ($this->activityid == null) {

                switch ($this->xOngoingTasks) {

                    case 0:
                        $OngoingTasks = null;
                        $lastpageOngoingTasks = null;
                        break;
                    case 1:

                        $OngoingTasks = Subtask::query()
                            ->where('status', 'Incomplete')
                            ->whereDate('subduedate', '>=', now())  // Add this line
                            ->orderBy('subduedate', 'asc') // Sort in ascending order
                            ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                        $lastpageOngoingTasks = $OngoingTasks->lastPage();


                        break;

                    case 2:

                        $OngoingTasks = Subtask::query()
                            ->where('status', 'Incomplete')
                            ->whereDate('subduedate', '>=', now())  // Add this line
                            ->where('subtask_name', 'like', "%$this->inputSearchOngoingTasks%")
                            ->orderBy('subduedate', 'asc') // Sort in ascending order
                            ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);

                        $lastpageOngoingTasks = $OngoingTasks->lastPage();


                        break;
                }
            } else {
                switch ($this->xOngoingTasks) {

                    case 0:
                        $OngoingTasks = null;
                        $lastpageOngoingTasks = null;
                        break;
                    case 1:
                        if ($this->subtaskid == null) {
                            $OngoingTasks = Subtask::query()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereDate('subduedate', '>=', now())  // Add this line
                                ->orderBy('subduedate', 'asc') // Sort in ascending order
                                ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                            $lastpageOngoingTasks = $OngoingTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $OngoingTasks = Subtask::query()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', [$this->subtaskid])
                                ->whereDate('subduedate', '>=', now())  // Add this line
                                ->orderBy('subduedate', 'asc') // Sort in ascending order
                                ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                            $lastpageOngoingTasks = $OngoingTasks->lastPage();
                        }
                        break;

                    case 2:
                        if ($this->subtaskid == null) {
                            $OngoingTasks = Subtask::query()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->where('subtask_name', 'like', "%$this->inputSearchOngoingTasks%")
                                ->whereDate('subduedate', '>=', now())  // Add this line
                                ->orderBy('subduedate', 'asc') // Sort in ascending order
                                ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                            $lastpageOngoingTasks = $OngoingTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $OngoingTasks = Subtask::query()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', [$this->subtaskid])
                                ->where('subtask_name', 'like', "%$this->inputSearchOngoingTasks%")
                                ->whereDate('subduedate', '>=', now())  // Add this line
                                ->orderBy('subduedate', 'asc') // Sort in ascending order
                                ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                            $lastpageOngoingTasks = $OngoingTasks->lastPage();
                        }

                        break;
                }
            }
        } else {
            if ($this->activityid == null) {

                switch ($this->xOngoingTasks) {

                    case 0:
                        $OngoingTasks = null;
                        $lastpageOngoingTasks = null;
                        break;
                    case 1:

                        $OngoingTasks = $user->subtasks()
                            ->where('status', 'Incomplete')
                            ->whereDate('subduedate', '>=', now())  // Add this line
                            ->orderBy('subduedate', 'asc') // Sort in ascending order
                            ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                        $lastpageOngoingTasks = $OngoingTasks->lastPage();


                        break;

                    case 2:

                        $OngoingTasks = $user->subtasks()
                            ->where('status', 'Incomplete')
                            ->whereDate('subduedate', '>=', now())  // Add this line
                            ->where('subtask_name', 'like', "%$this->inputSearchOngoingTasks%")
                            ->orderBy('subduedate', 'asc') // Sort in ascending order
                            ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);

                        $lastpageOngoingTasks = $OngoingTasks->lastPage();


                        break;
                }
            } else {
                switch ($this->xOngoingTasks) {

                    case 0:
                        $OngoingTasks = null;
                        $lastpageOngoingTasks = null;
                        break;
                    case 1:
                        if ($this->subtaskid == null) {
                            $OngoingTasks = $user->subtasks()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereDate('subduedate', '>=', now())  // Add this line
                                ->orderBy('subduedate', 'asc') // Sort in ascending order
                                ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                            $lastpageOngoingTasks = $OngoingTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $OngoingTasks = $user->subtasks()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', [$this->subtaskid])
                                ->whereDate('subduedate', '>=', now())  // Add this line
                                ->orderBy('subduedate', 'asc') // Sort in ascending order
                                ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                            $lastpageOngoingTasks = $OngoingTasks->lastPage();
                        }
                        break;

                    case 2:
                        if ($this->subtaskid == null) {
                            $OngoingTasks = $user->subtasks()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->where('subtask_name', 'like', "%$this->inputSearchOngoingTasks%")
                                ->whereDate('subduedate', '>=', now())  // Add this line
                                ->orderBy('subduedate', 'asc') // Sort in ascending order
                                ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                            $lastpageOngoingTasks = $OngoingTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $OngoingTasks = $user->subtasks()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', [$this->subtaskid])
                                ->where('subtask_name', 'like', "%$this->inputSearchOngoingTasks%")
                                ->whereDate('subduedate', '>=', now())  // Add this line
                                ->orderBy('subduedate', 'asc') // Sort in ascending order
                                ->paginate($this->perPageOngoingTasks, ['*'], 'page', $this->currentPageOngoingTasks);



                            $lastpageOngoingTasks = $OngoingTasks->lastPage();
                        }

                        break;
                }
            }
        }
        return view('livewire.ongoing-tasks', [
            'OngoingTasks' => $OngoingTasks,
            'totalPagesOngoingTasks' => $lastpageOngoingTasks
        ]);
    }
}
