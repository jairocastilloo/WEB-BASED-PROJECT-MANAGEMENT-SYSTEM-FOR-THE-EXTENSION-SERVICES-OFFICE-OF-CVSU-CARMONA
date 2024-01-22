<?php

namespace App\Http\Livewire;

use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompletedProgram extends Component
{
    public $department;
    public $programid;
    public $xCompletedPrograms;
    public $inputSearchCompletedPrograms = '';
    public $currentPageCompletedPrograms = 1; // The current page number
    public $perPageCompletedPrograms = 5;
    public $currentdate;
    public $showOnlyMyCompletedPrograms;
    protected $listeners = ['findCompletedPrograms' => 'handleFindCompletedPrograms'];
    public function mount($department, $programid, $xCompletedPrograms)

    {
        $this->currentdate = now();
        $this->xCompletedPrograms = $xCompletedPrograms;
        $this->department = str_replace('+', ' ', $department);
        $this->programid = $programid;
    }
    public function showCompletedPrograms($xCompletedPrograms)
    {
        $this->xCompletedPrograms = $xCompletedPrograms;
    }
    public function refreshDataCompletedPrograms()
    {
        $this->xCompletedPrograms = 1;
        $this->currentPageCompletedPrograms = 1;
    }
    public function changePageCompletedPrograms($pageCompletedPrograms)
    {
        $this->currentPageCompletedPrograms = $pageCompletedPrograms;
    }
    public function findCompletedPrograms($inputSearchCompletedPrograms, $xCompletedPrograms)
    {
        $this->inputSearchCompletedPrograms = $inputSearchCompletedPrograms;
        $this->xCompletedPrograms = $xCompletedPrograms;
        $this->currentPageCompletedPrograms = 1;
    }
    public function handleFindCompletedPrograms($inputSearchCompletedPrograms, $xCompletedPrograms)
    {
        $this->findCompletedPrograms($inputSearchCompletedPrograms, $xCompletedPrograms);
    }
    public function toggleSelectionCompletedPrograms($isChecked)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isChecked) {

            $user->update([
                'showOnlyMyCompletedPrograms' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyCompletedPrograms' => 0,
            ]);
        }

        $this->showOnlyMyCompletedPrograms = $user->showOnlyMyCompletedPrograms;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyCompletedPrograms = $user->showOnlyMyCompletedPrograms;

        if ($user->role == "Admin" && $this->showOnlyMyCompletedPrograms == 0) {
            if ($this->department == null) {

                switch ($this->xCompletedPrograms) {

                    case 0:
                        $completedPrograms = null;
                        $lastpageCompletedPrograms = null;
                        break;
                    case 1:

                        $completedPrograms = Program::query()
                            ->where('status', 'Completed')
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                        $lastpageCompletedPrograms = $completedPrograms->lastPage();


                        break;

                    case 2:

                        $completedPrograms = Program::query()
                            ->where('status', 'Completed')
                            ->where('programName', 'like', "%$this->inputSearchCompletedPrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                        $lastpageCompletedPrograms = $completedPrograms->lastPage();

                        break;
                }
            } else {
                switch ($this->xCompletedPrograms) {

                    case 0:
                        $completedPrograms = null;
                        $lastpageCompletedPrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $completedPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Completed')
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                            $lastpageCompletedPrograms = $completedPrograms->lastPage();


                            break;
                        } else if ($this->programid != null) {
                            $completedPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Completed')
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                            $lastpageCompletedPrograms = $completedPrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {
                            $completedPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Completed')
                                ->where('programName', 'like', "%$this->inputSearchCompletedPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                            $lastpageCompletedPrograms = $completedPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $completedPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Completed')
                                ->where('programName', 'like', "%$this->inputSearchCompletedPrograms%")
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                            $lastpageCompletedPrograms = $completedPrograms->lastPage();

                            break;
                        }
                }
            }
        } else {
            if ($this->department == null) {

                switch ($this->xCompletedPrograms) {

                    case 0:
                        $completedPrograms = null;
                        $lastpageCompletedPrograms = null;
                        break;
                    case 1:

                        $completedPrograms = $user->programs()
                            ->where('status', 'Completed')
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                        $lastpageCompletedPrograms = $completedPrograms->lastPage();


                        break;

                    case 2:

                        $completedPrograms = $user->programs()
                            ->where('status', 'Completed')
                            ->where('programName', 'like', "%$this->inputSearchCompletedPrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                        $lastpageCompletedPrograms = $completedPrograms->lastPage();

                        break;
                }
            } else {
                switch ($this->xCompletedPrograms) {

                    case 0:
                        $completedPrograms = null;
                        $lastpageCompletedPrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $completedPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Completed')
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                            $lastpageCompletedPrograms = $completedPrograms->lastPage();


                            break;
                        } else if ($this->programid != null) {
                            $completedPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Completed')
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                            $lastpageCompletedPrograms = $completedPrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {
                            $completedPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Completed')
                                ->where('programName', 'like', "%$this->inputSearchCompletedPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                            $lastpageCompletedPrograms = $completedPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $completedPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Completed')
                                ->where('programName', 'like', "%$this->inputSearchCompletedPrograms%")
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedPrograms, ['*'], 'page', $this->currentPageCompletedPrograms);

                            $lastpageCompletedPrograms = $completedPrograms->lastPage();

                            break;
                        }
                }
            }
        }
        return view('livewire.completed-program', [
            'completedPrograms' => $completedPrograms,
            'totalPagesCompletedPrograms' => $lastpageCompletedPrograms
        ]);
    }
}
