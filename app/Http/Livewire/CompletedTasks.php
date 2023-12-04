<?php

namespace App\Http\Livewire;

use App\Models\Subtask;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompletedTasks extends Component
{
    public $activityid;
    public $xCompletedTasks;
    public $inputSearchCompletedTasks = '';
    public $currentPageCompletedTasks = 1; // The current page number
    public $perPageCompletedTasks = 5;
    public $currentdate;
    public $subtaskid;
    public $showOnlyMyCompletedTasks;
    protected $listeners = ['findCompletedTasks' => 'handleFindCompletedTasks'];

    public function mount($activityid, $subtaskid, $xCompletedTasks)

    {
        $this->currentdate = now();
        $this->activityid = $activityid;
        $this->xCompletedTasks = $xCompletedTasks;
        $this->subtaskid = $subtaskid;
    }
    public function showCompletedTasks($xCompletedTasks)
    {
        $this->xCompletedTasks = $xCompletedTasks;
    }
    public function refreshDataCompletedTasks()
    {
        $this->xCompletedTasks = 1;
        $this->currentPageCompletedTasks = 1;
    }
    public function changePageCompletedTasks($page)
    {
        $this->currentPageCompletedTasks = $page;
    }
    public function findCompletedTasks($inputSearchCompletedTasks, $xCompletedTasks)
    {
        $this->inputSearchCompletedTasks = $inputSearchCompletedTasks;
        $this->xCompletedTasks = $xCompletedTasks;
        $this->currentPageCompletedTasks = 1;
    }
    public function handleFindCompletedTasks($inputSearchCompletedTasks, $xCompletedTasks)
    {
        $this->findCompletedTasks($inputSearchCompletedTasks, $xCompletedTasks);
    }
    public function toggleSelectionCompleted($isChecked)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isChecked) {

            $user->update([
                'showOnlyMyCompletedTasks' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyCompletedTasks' => 0,
            ]);
        }

        $this->showOnlyMyCompletedTasks = $user->showOnlyMyCompletedTasks;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyCompletedTasks = $user->showOnlyMyCompletedTasks;

        if ($user->role == "Admin" && $this->showOnlyMyCompletedTasks == 0) {
            if ($this->activityid == null) {

                switch ($this->xCompletedTasks) {

                    case 0:
                        $CompletedTasks = null;
                        $lastpageCompletedTasks = null;
                        break;
                    case 1:

                        $CompletedTasks = Subtask::query()
                            ->where('status', 'Completed')
                            ->orderBy('subduedate', 'desc') // Sort in ascending order
                            ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                        $lastpageCompletedTasks = $CompletedTasks->lastPage();

                        break;

                    case 2:

                        $CompletedTasks = Subtask::query()
                            ->where('status', 'Completed')
                            ->where('subduedate', '>=', now())  // Add this line
                            ->where('subtask_name', 'like', "%$this->inputSearchCompletedTasks%")
                            ->orderBy('subduedate', 'desc') // Sort in ascending order
                            ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                        $lastpageCompletedTasks = $CompletedTasks->lastPage();


                        break;
                }
            } else {
                switch ($this->xCompletedTasks) {

                    case 0:
                        $CompletedTasks = null;
                        $lastpageCompletedTasks = null;
                        break;
                    case 1:
                        if ($this->subtaskid == null) {
                            $CompletedTasks = Subtask::query()
                                ->where('status', 'Completed')
                                ->where('activity_id', $this->activityid)
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                            $lastpageCompletedTasks = $CompletedTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $CompletedTasks = Subtask::query()
                                ->where('status', 'Completed')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', $this->subtaskid)
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                            $lastpageCompletedTasks = $CompletedTasks->lastPage();
                        }
                        break;

                    case 2:
                        if ($this->subtaskid == null) {
                            $CompletedTasks = Subtask::query()
                                ->where('status', 'Completed')
                                ->where('subduedate', '>=', now())  // Add this line
                                ->where('activity_id', $this->activityid)
                                ->where('subtask_name', 'like', "%$this->inputSearchCompletedTasks%")
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                            $lastpageCompletedTasks = $CompletedTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $CompletedTasks = Subtask::query()
                                ->where('status', 'Completed')
                                ->where('subduedate', '>=', now())  // Add this line
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', $this->subtaskid)
                                ->where('subtask_name', 'like', "%$this->inputSearchCompletedTasks%")
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                            $lastpageCompletedTasks = $CompletedTasks->lastPage();
                        }

                        break;
                }
            }
        } else {
            if ($this->activityid == null) {

                switch ($this->xCompletedTasks) {

                    case 0:
                        $CompletedTasks = null;
                        $lastpageCompletedTasks = null;
                        break;
                    case 1:

                        $CompletedTasks = $user->subtasks()
                            ->where('status', 'Completed')
                            ->orderBy('subduedate', 'desc') // Sort in ascending order
                            ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                        $lastpageCompletedTasks = $CompletedTasks->lastPage();

                        break;

                    case 2:

                        $CompletedTasks = $user->subtasks()
                            ->where('status', 'Completed')
                            ->where('subduedate', '>=', now())  // Add this line
                            ->where('subtask_name', 'like', "%$this->inputSearchCompletedTasks%")
                            ->orderBy('subduedate', 'desc') // Sort in ascending order
                            ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                        $lastpageCompletedTasks = $CompletedTasks->lastPage();


                        break;
                }
            } else {
                switch ($this->xCompletedTasks) {

                    case 0:
                        $CompletedTasks = null;
                        $lastpageCompletedTasks = null;
                        break;
                    case 1:
                        if ($this->subtaskid == null) {
                            $CompletedTasks = $user->subtasks()
                                ->where('status', 'Completed')
                                ->where('activity_id', $this->activityid)
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                            $lastpageCompletedTasks = $CompletedTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $CompletedTasks = $user->subtasks()
                                ->where('status', 'Completed')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', $this->subtaskid)
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                            $lastpageCompletedTasks = $CompletedTasks->lastPage();
                        }
                        break;

                    case 2:
                        if ($this->subtaskid == null) {
                            $CompletedTasks = $user->subtasks()
                                ->where('status', 'Completed')
                                ->where('subduedate', '>=', now())  // Add this line
                                ->where('activity_id', $this->activityid)
                                ->where('subtask_name', 'like', "%$this->inputSearchCompletedTasks%")
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                            $lastpageCompletedTasks = $CompletedTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $CompletedTasks = $user->subtasks()
                                ->where('status', 'Completed')
                                ->where('subduedate', '>=', now())  // Add this line
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', $this->subtaskid)
                                ->where('subtask_name', 'like', "%$this->inputSearchCompletedTasks%")
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageCompletedTasks, ['*'], 'page', $this->currentPageCompletedTasks);

                            $lastpageCompletedTasks = $CompletedTasks->lastPage();
                        }

                        break;
                }
            }
        }
        return view('livewire.completed-tasks', [
            'CompletedTasks' => $CompletedTasks,
            'totalPagesCompletedTasks' => $lastpageCompletedTasks
        ]);
    }
}
