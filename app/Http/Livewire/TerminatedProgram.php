<?php

namespace App\Http\Livewire;

use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TerminatedProgram extends Component
{
    public $department;
    public $programid;
    public $xTerminatedPrograms;
    public $inputSearchTerminatedPrograms = '';
    public $currentPageTerminatedPrograms = 1; // The current page number
    public $perPageTerminatedPrograms = 5;
    public $currentdate;
    public $showOnlyMyTerminatedPrograms;
    protected $listeners = ['findTerminatedPrograms' => 'handleFindTerminatedPrograms'];

    public function mount($department, $programid, $xTerminatedPrograms)

    {
        $this->currentdate = now();
        $this->xTerminatedPrograms = $xTerminatedPrograms;
        $this->department = str_replace('+', ' ', $department);
        $this->programid = $programid;
    }
    public function showTerminatedPrograms($xTerminatedPrograms)
    {
        $this->xTerminatedPrograms= $xTerminatedPrograms;
    }
    public function refreshDataTerminatedPrograms()
    {
        $this->xTerminatedPrograms = 1;
        $this->currentPageTerminatedPrograms = 1;
    }
    public function changePageTerminatedPrograms($pageTerminatedPrograms)
    {
        $this->currentPageTerminatedPrograms = $pageTerminatedPrograms;
    }
    public function findTerminatedPrograms($inputSearchTerminatedPrograms, $xTerminatedPrograms)
    {
        $this->inputSearchTerminatedPrograms = $inputSearchTerminatedPrograms;
        $this->xTerminatedPrograms = $xTerminatedPrograms;
        $this->currentPageTerminatedPrograms = 1;
    }
    public function handleFindTerminatedPrograms($inputSearchTerminatedPrograms, $xTerminatedPrograms)
    {
        $this->findTerminatedPrograms($inputSearchTerminatedPrograms, $xTerminatedPrograms);
    }
    public function toggleSelectionTerminatedPrograms($isChecked)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isChecked) {

            $user->update([
                'showOnlyMyTerminatedPrograms' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyTerminatedPrograms' => 0,
            ]);
        }

        $this->showOnlyMyTerminatedPrograms = $user->showOnlyMyTerminatedPrograms;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyTerminatedPrograms = $user->showOnlyMyTerminatedPrograms;

        if ($user->role == "Admin" && $this->showOnlyMyTerminatedPrograms == 0) {
            if ($this->department == null) {

                switch ($this->xTerminatedPrograms) {

                    case 0:
                        $TerminatedPrograms = null;
                        $lastpageTerminatedPrograms = null;
                        break;
                    case 1:

                        $TerminatedPrograms = Program::query()
                            ->where('status', 'Terminated')
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                        $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();


                        break;

                    case 2:

                        $TerminatedPrograms = Program::query()
                            ->where('status', 'Terminated')
                            ->where('programName', 'like', "%$this->inputSearchTerminatedPrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                        $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();

                        break;
                }
            } else {
                switch ($this->xTerminatedPrograms) {

                    case 0:
                        $TerminatedPrograms = null;
                        $lastpageTerminatedPrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $TerminatedPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Terminated')
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                            $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();


                            break;
                        } else if ($this->programid != null) {
                            $TerminatedPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Terminated')
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                            $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {
                            $TerminatedPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Terminated')
                                ->where('programName', 'like', "%$this->inputSearchTerminatedPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                            $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $TerminatedPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Terminated')
                                ->where('programName', 'like', "%$this->inputSearchTerminatedPrograms%")
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                            $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();

                            break;
                        }
                }
            }
        } else {
            if ($this->department == null) {

                switch ($this->xTerminatedPrograms) {

                    case 0:
                        $TerminatedPrograms = null;
                        $lastpageTerminatedPrograms = null;
                        break;
                    case 1:

                        $TerminatedPrograms = $user->programs()
                            ->where('status', 'Terminated')
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                        $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();


                        break;

                    case 2:

                        $TerminatedPrograms = $user->programs()
                            ->where('status', 'Terminated')
                            ->where('programName', 'like', "%$this->inputSearchTerminatedPrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                        $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();

                        break;
                }
            } else {
                switch ($this->xTerminatedPrograms) {

                    case 0:
                        $TerminatedPrograms = null;
                        $lastpageTerminatedPrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $TerminatedPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Terminated')
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                            $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();


                            break;
                        } else if ($this->programid != null) {
                            $TerminatedPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Terminated')
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                            $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {
                            $TerminatedPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Terminated')
                                ->where('programName', 'like', "%$this->inputSearchTerminatedPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                            $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $TerminatedPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Terminated')
                                ->where('programName', 'like', "%$this->inputSearchTerminatedPrograms%")
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageTerminatedPrograms, ['*'], 'page', $this->currentPageTerminatedPrograms);

                            $lastpageTerminatedPrograms = $TerminatedPrograms->lastPage();

                            break;
                        }
                }
            }
        }
        return view('livewire.terminated-program', [
            'TerminatedPrograms' => $TerminatedPrograms,
            'totalPagesTerminatedPrograms' => $lastpageTerminatedPrograms
        ]);
}
}