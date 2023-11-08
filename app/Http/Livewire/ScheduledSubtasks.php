<?php

namespace App\Http\Livewire;

use App\Models\ScheduledTasks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ScheduledSubtasks extends Component
{

    public $xScheduledTasks;
    public $inputSearchScheduledTasks = '';
    public $currentPageScheduledTasks = 1; // The current page number
    public $perPageScheduledTasks = 5;
    public $currentdate;

    protected $listeners = ['findScheduledTasks' => 'handleFindScheduledTasks', 'saveScheduledTasks' => 'handlesaveScheduledTasks'];
    public function mount($xScheduledTasks)

    {
        $this->currentdate = now();
        $this->xScheduledTasks = $xScheduledTasks;
    }
    public function showScheduledTasks($xScheduledTasks)
    {
        $this->xScheduledTasks = $xScheduledTasks;
    }
    public function refreshDataScheduledTasks()
    {
        $this->xScheduledTasks = 1;
        $this->currentPageScheduledTasks = 1;
    }
    public function changePageScheduledTasks($page)
    {
        $this->currentPageScheduledTasks = $page;
    }
    public function findScheduledTasks($inputSearchScheduledTasks, $xScheduledTasks)
    {
        $this->inputSearchScheduledTasks = $inputSearchScheduledTasks;
        $this->xScheduledTasks = $xScheduledTasks;
        $this->currentPageScheduledTasks = 1;
    }
    public function handleFindScheduledTasks($inputSearchScheduledTasks, $xScheduledTasks)
    {
        $this->findScheduledTasks($inputSearchScheduledTasks, $xScheduledTasks);
    }
    public function saveScheduledTasks($subtaskId, $toDoDate)
    {
        $toDoDate = date("Y-m-d", strtotime($toDoDate));
        ScheduledTasks::create(
            [
                'subtask_id' => $subtaskId,
                'user_id' => Auth::user()->id,
                'scheduledDate' => $toDoDate
            ]
        );
        $this->xScheduledTasks = 1;
        $this->currentPageScheduledTasks = 1;
        $this->emit('updatesaveScheduledTasks');
    }
    public function handlesaveScheduledTasks($subtaskId, $toDoDate)
    {
        $this->saveScheduledTasks($subtaskId, $toDoDate);
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        switch ($this->xScheduledTasks) {

            case 0:
                $ScheduledTasks = null;
                $lastpageScheduledTasks = null;
                break;
            case 1:

                $ScheduledTasks = $user->scheduledSubtasks()
                    ->join('subtasks as st1', 'scheduled_tasks.subtask_id', '=', 'st1.id')
                    ->where('st1.status', 'Incomplete')
                    ->where('st1.subduedate', '>=', now())
                    ->orderBy('scheduled_tasks.scheduledDate', 'asc')
                    ->select('st1.subtask_name', 'st1.subduedate', 'st1.created_at', 'scheduled_tasks.scheduledDate')
                    ->paginate($this->perPageScheduledTasks, ['*'], 'page', $this->currentPageScheduledTasks);


                $lastpageScheduledTasks = $ScheduledTasks->lastPage();



                break;

            case 2:

                $ScheduledTasks = $user->scheduledSubtasks()
                    ->join('subtasks as st1', 'scheduled_tasks.subtask_id', '=', 'st1.id')
                    ->where('st1.status', 'Incomplete')
                    ->where('st1.subduedate', '>=', now())
                    ->where('st1.subtask_name', 'like', "%$this->inputSearchScheduledTasks%")
                    ->orderBy('scheduled_tasks.scheduledDate', 'asc')
                    ->select('st1.subtask_name', 'st1.subduedate', 'st1.created_at', 'scheduled_tasks.scheduledDate')
                    ->paginate($this->perPageScheduledTasks, ['*'], 'page', $this->currentPageScheduledTasks);


                $lastpageScheduledTasks = $ScheduledTasks->lastPage();



                break;
        }
        return view('livewire.scheduled-subtasks', [
            'ScheduledTasks' => $ScheduledTasks,
            'totalPagesScheduledTasks' => $lastpageScheduledTasks
        ]);
    }
}
