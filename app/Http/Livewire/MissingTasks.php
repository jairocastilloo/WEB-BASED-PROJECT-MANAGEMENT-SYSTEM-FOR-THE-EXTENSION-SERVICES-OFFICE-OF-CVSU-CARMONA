<?php

namespace App\Http\Livewire;

use App\Models\Subtask;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class MissingTasks extends Component
{

    public $activityid;
    public $xMissingTasks;
    public $inputSearchMissingTasks = '';
    public $currentPageMissingTasks = 1; // The current page number
    public $perPageMissingTasks = 5;
    public $currentdate;
    public $subtaskid;
    public $showOnlyMyOverdueTasks;
    protected $listeners = ['findMissingTasks' => 'handleFindMissingTasks'];

    public function mount($activityid, $subtaskid, $xMissingTasks)

    {


        $this->currentdate = now();
        $this->activityid = $activityid;
        $this->xMissingTasks = $xMissingTasks;
        $this->subtaskid = $subtaskid;
    }
    public function showMissingTasks($xMissingTasks)
    {
        $this->xMissingTasks = $xMissingTasks;
    }
    public function refreshDataMissingTasks()
    {
        $this->xMissingTasks = 1;
        $this->currentPageMissingTasks = 1;
    }
    public function changePageMissingTasks($page)
    {
        $this->currentPageMissingTasks = $page;
    }
    public function findMissingTasks($inputSearchMissingTasks, $xMissingTasks)
    {
        $this->inputSearchMissingTasks = $inputSearchMissingTasks;
        $this->xMissingTasks = $xMissingTasks;
        $this->currentPageMissingTasks = 1;
    }
    public function handleFindMissingTasks($inputSearchMissingTasks, $xMissingTasks)
    {
        $this->findMissingTasks($inputSearchMissingTasks, $xMissingTasks);
    }
    public function toggleSelection($isChecked)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isChecked) {

            $user->update([
                'showOnlyMyOverdueTasks' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyOverdueTasks' => 0,
            ]);
        }

        $this->showOnlyMyOverdueTasks = $user->showOnlyMyOverdueTasks;
    }

    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyOverdueTasks = $user->showOnlyMyOverdueTasks;

        if ($user->role == "Admin" && $this->showOnlyMyOverdueTasks == 0) {

            if ($this->activityid == null) {

                switch ($this->xMissingTasks) {

                    case 0:
                        $MissingTasks = null;
                        $lastpageMissingTasks = null;
                        break;
                    case 1:

                        $MissingTasks = Subtask::query()
                            ->where('status', 'Incomplete')
                            ->whereDate('subduedate', '<', now())  // Add this line
                            ->whereDate('subduedate', '!=', now())
                            ->orderBy('subduedate', 'desc') // Sort in ascending order
                            ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                        $lastpageMissingTasks = $MissingTasks->lastPage();


                        break;

                    case 2:

                        $MissingTasks = Subtask::query()
                            ->where('status', 'Incomplete')
                            ->whereDate('subduedate', '<', now())  // Add this line
                            ->whereDate('subduedate', '!=', now())
                            ->where('subtask_name', 'like', "%$this->inputSearchMissingTasks%")
                            ->orderBy('subduedate', 'desc') // Sort in ascending order
                            ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);

                        $lastpageMissingTasks = $MissingTasks->lastPage();


                        break;
                }
            } else {
                switch ($this->xMissingTasks) {

                    case 0:
                        $MissingTasks = null;
                        $lastpageMissingTasks = null;
                        break;
                    case 1:
                        if ($this->subtaskid == null) {
                            $MissingTasks = Subtask::query()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereDate('subduedate', '<', now())  // Add this line
                                ->whereDate('subduedate', '!=', now())
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                            $lastpageMissingTasks = $MissingTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $MissingTasks = Subtask::query()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', [$this->subtaskid])
                                ->whereDate('subduedate', '<', now())  // Add this line
                                ->whereDate('subduedate', '!=', now())
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                            $lastpageMissingTasks = $MissingTasks->lastPage();
                        }
                        break;

                    case 2:
                        if ($this->subtaskid == null) {
                            $MissingTasks = Subtask::query()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->where('subtask_name', 'like', "%$this->inputSearchMissingTasks%")
                                ->whereDate('subduedate', '<', now())  // Add this line
                                ->whereDate('subduedate', '!=', now())
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                            $lastpageMissingTasks = $MissingTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $MissingTasks = Subtask::query()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', [$this->subtaskid])
                                ->where('subtask_name', 'like', "%$this->inputSearchMissingTasks%")
                                ->whereDate('subduedate', '<', now())  // Add this line
                                ->whereDate('subduedate', '!=', now())
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                            $lastpageMissingTasks = $MissingTasks->lastPage();
                        }

                        break;
                }
            }
        } else {
            if ($this->activityid == null) {

                switch ($this->xMissingTasks) {

                    case 0:
                        $MissingTasks = null;
                        $lastpageMissingTasks = null;
                        break;
                    case 1:

                        $MissingTasks = $user->subtasks()
                            ->where('status', 'Incomplete')
                            ->whereDate('subduedate', '<', now())  // Add this line
                            ->whereDate('subduedate', '!=', now())
                            ->orderBy('subduedate', 'desc') // Sort in ascending order
                            ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                        $lastpageMissingTasks = $MissingTasks->lastPage();


                        break;

                    case 2:

                        $MissingTasks = $user->subtasks()
                            ->where('status', 'Incomplete')
                            ->whereDate('subduedate', '<', now())  // Add this line
                            ->whereDate('subduedate', '!=', now())
                            ->where('subtask_name', 'like', "%$this->inputSearchMissingTasks%")
                            ->orderBy('subduedate', 'desc') // Sort in ascending order
                            ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);

                        $lastpageMissingTasks = $MissingTasks->lastPage();


                        break;
                }
            } else {
                switch ($this->xMissingTasks) {

                    case 0:
                        $MissingTasks = null;
                        $lastpageMissingTasks = null;
                        break;
                    case 1:
                        if ($this->subtaskid == null) {
                            $MissingTasks = $user->subtasks()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereDate('subduedate', '<', now())  // Add this line
                                ->whereDate('subduedate', '!=', now())
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                            $lastpageMissingTasks = $MissingTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $MissingTasks = $user->subtasks()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', [$this->subtaskid])
                                ->whereDate('subduedate', '<', now())  // Add this line
                                ->whereDate('subduedate', '!=', now())
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                            $lastpageMissingTasks = $MissingTasks->lastPage();
                        }
                        break;

                    case 2:
                        if ($this->subtaskid == null) {
                            $MissingTasks = $user->subtasks()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->where('subtask_name', 'like', "%$this->inputSearchMissingTasks%")
                                ->whereDate('subduedate', '<', now())  // Add this line
                                ->whereDate('subduedate', '!=', now())
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                            $lastpageMissingTasks = $MissingTasks->lastPage();
                        } else if ($this->subtaskid != null) {
                            $MissingTasks = $user->subtasks()
                                ->where('status', 'Incomplete')
                                ->where('activity_id', $this->activityid)
                                ->whereNotIn('subtasks.id', [$this->subtaskid])
                                ->where('subtask_name', 'like', "%$this->inputSearchMissingTasks%")
                                ->whereDate('subduedate', '<', now())  // Add this line
                                ->whereDate('subduedate', '!=', now())
                                ->orderBy('subduedate', 'desc') // Sort in ascending order
                                ->paginate($this->perPageMissingTasks, ['*'], 'page', $this->currentPageMissingTasks);



                            $lastpageMissingTasks = $MissingTasks->lastPage();
                        }

                        break;
                }
            }
        }
        return view('livewire.missing-tasks', [
            'MissingTasks' => $MissingTasks,
            'totalPagesMissingTasks' => $lastpageMissingTasks
        ]);
    }
}
