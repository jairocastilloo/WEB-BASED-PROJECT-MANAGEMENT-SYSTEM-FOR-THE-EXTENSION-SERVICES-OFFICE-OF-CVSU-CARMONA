<?php

namespace App\Http\Livewire;


use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OverdueProgram extends Component
{

    use WithPagination;

    public $department;
    public $programid;
    public $zOverduePrograms;
    public $inputSearchOverduePrograms = '';
    public $currentPageOverduePrograms = 1; // The current page number
    public $perPageOverduePrograms = 5;
    public $currentdate;
    public $showOnlyMyOverduePrograms;
    protected $listeners = ['findOverduePrograms' => 'handlefindOverduePrograms'];

    public function mount($department, $programid, $zOverduePrograms)

    {
        $this->currentdate = now();
        $this->zOverduePrograms = $zOverduePrograms;
        $this->department = str_replace('+', ' ', $department);
        $this->programid = $programid;
    }
    public function showOverduePrograms($zOverduePrograms)
    {
        $this->zOverduePrograms = $zOverduePrograms;
    }
    public function refreshDataOverduePrograms()
    {
        $this->zOverduePrograms = 1;
        $this->currentPageOverduePrograms = 1;
    }
    public function pastchangePage($pageOverduePrograms)
    {
        $this->currentPageOverduePrograms = $pageOverduePrograms;
    }
    public function findOverduePrograms($inputSearchOverduePrograms, $zOverduePrograms)
    {
        $this->inputSearchOverduePrograms = $inputSearchOverduePrograms;
        $this->zOverduePrograms = $zOverduePrograms;
        $this->currentPageOverduePrograms = 1;
    }
    public function handlefindOverduePrograms($inputSearchOverduePrograms, $zOverduePrograms)
    {
        $this->findOverduePrograms($inputSearchOverduePrograms, $zOverduePrograms);
    }
    public function toggleSelectionOverduePrograms($isCheckedOverduePrograms)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isCheckedOverduePrograms) {

            $user->update([
                'showOnlyMyOverduePrograms' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyOverduePrograms' => 0,
            ]);
        }

        $this->showOnlyMyOverduePrograms = $user->showOnlyMyOverduePrograms;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyOverduePrograms = $user->showOnlyMyOverduePrograms;
        if ($user->role == "Admin" && $this->showOnlyMyOverduePrograms == 0) {
            if ($this->department == null) {
                // for home
                switch ($this->zOverduePrograms) {

                    case 0:
                        $overduePrograms = null;
                        $lastpageOverduePrograms = null;
                        break;
                        // for showing initial
                    case 1:

                        $overduePrograms = Program::query()
                            ->where('status', 'Incomplete')
                            ->where('endDate', '<', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                        $lastpageOverduePrograms = $overduePrograms->lastPage();

                        break;
                        // for searching
                    case 2:


                        $overduePrograms = Program::query()
                            ->where('status', 'Incomplete')
                            ->where('endDate', '<', $this->currentdate)
                            ->where('programName', 'like', "%$this->inputSearchOverduePrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                        $lastpageOverduePrograms = $overduePrograms->lastPage();

                        break;
                }
            } else {
                // for select and create as user
                switch ($this->zOverduePrograms) {

                    case 0:
                        $overduePrograms = null;
                        $lastpageOverduePrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $overduePrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('endDate', '<', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                            $lastpageOverduePrograms = $overduePrograms->lastPage();

                            break;
                        } else  if ($this->programid != null) {
                            $overduePrograms = Program::query()
                                ->where('department', $this->department)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->where('status', 'Incomplete')
                                ->where('endDate', '<', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                            $lastpageOverduePrograms = $overduePrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {

                            $overduePrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('endDate', '<', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchOverduePrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                            $lastpageOverduePrograms = $overduePrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $overduePrograms = Program::query()
                                ->where('department', $this->department)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->where('status', 'Incomplete')
                                ->where('endDate', '<', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchOverduePrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                            $lastpageOverduePrograms = $overduePrograms->lastPage();

                            break;
                        }
                }
            }
        } else {
            if ($this->department == null) {
                // for home
                switch ($this->zOverduePrograms) {

                    case 0:
                        $overduePrograms = null;
                        $lastpageOverduePrograms = null;
                        break;
                        // for showing initial
                    case 1:

                        $overduePrograms = $user->programs()
                            ->where('status', 'Incomplete')
                            ->where('endDate', '<', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                        $lastpageOverduePrograms = $overduePrograms->lastPage();

                        break;
                        // for searching
                    case 2:


                        $overduePrograms = $user->programs()
                            ->where('status', 'Incomplete')
                            ->where('endDate', '<', $this->currentdate)
                            ->where('programName', 'like', "%$this->inputSearchOverduePrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                        $lastpageOverduePrograms = $overduePrograms->lastPage();

                        break;
                }
            } else {
                // for select and create as user
                switch ($this->zOverduePrograms) {

                    case 0:
                        $overduePrograms = null;
                        $lastpageOverduePrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $overduePrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('endDate', '<', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                            $lastpageOverduePrograms = $overduePrograms->lastPage();

                            break;
                        } else  if ($this->programid != null) {
                            $overduePrograms = $user->programs()
                                ->where('department', $this->department)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->where('status', 'Incomplete')
                                ->where('endDate', '<', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                            $lastpageOverduePrograms = $overduePrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {

                            $overduePrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('endDate', '<', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchOverduePrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                            $lastpageOverduePrograms = $overduePrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $overduePrograms = $user->programs()
                                ->where('department', $this->department)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->where('status', 'Incomplete')
                                ->where('endDate', '<', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchOverduePrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOverduePrograms, ['*'], 'page', $this->currentPageOverduePrograms);

                            $lastpageOverduePrograms = $overduePrograms->lastPage();

                            break;
                        }
                }
            }
        }
        return view('livewire.overdue-program', [
            'overduePrograms' => $overduePrograms,
            'totalPagesOverduePrograms' => $lastpageOverduePrograms
        ]);
    }
}
