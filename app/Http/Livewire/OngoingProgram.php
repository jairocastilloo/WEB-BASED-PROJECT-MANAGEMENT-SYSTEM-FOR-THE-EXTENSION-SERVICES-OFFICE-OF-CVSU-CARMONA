<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Program;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class OngoingProgram extends Component
{
    use WithPagination;

    public $department;
    public $programid;
    public $xOngoingPrograms;
    public $inputSearchOngoingPrograms = '';
    public $currentPageOngoingPrograms = 1; // The current page number
    public $perPageOngoingPrograms = 5;
    public $currentdate;
    public $showOnlyMyOngoingPrograms;
    protected $listeners = ['findOngoingPrograms' => 'handleFindOngoingPrograms'];
    public function mount($department, $programid, $xOngoingPrograms)

    {
        $this->currentdate = now();
        $this->xOngoingPrograms = $xOngoingPrograms;
        $this->department = str_replace('+', ' ', $department);
        $this->programid = $programid;
    }
    public function showOngoingPrograms($xOngoingPrograms)
    {
        $this->xOngoingPrograms = $xOngoingPrograms;
    }
    public function refreshDataOngoingPrograms()
    {
        $this->xOngoingPrograms = 1;
        $this->currentPageOngoingPrograms = 1;
    }
    public function changePageOngoingPrograms($pageOngoingPrograms)
    {
        $this->currentPageOngoingPrograms = $pageOngoingPrograms;
    }
    public function findOngoingPrograms($inputSearchOngoingPrograms, $xOngoingPrograms)
    {
        $this->inputSearchOngoingPrograms = $inputSearchOngoingPrograms;
        $this->xOngoingPrograms = $xOngoingPrograms;
        $this->currentPageOngoingPrograms = 1;
    }
    public function handleFindOngoingPrograms($inputSearchOngoingPrograms, $xOngoingPrograms)
    {
        $this->findOngoingPrograms($inputSearchOngoingPrograms, $xOngoingPrograms);
    }
    public function toggleSelectionOngoingPrograms($isCheckedOngoingPrograms)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isCheckedOngoingPrograms) {

            $user->update([
                'showOnlyMyOngoingPrograms' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyOngoingPrograms' => 0,
            ]);
        }

        $this->showOnlyMyOngoingPrograms = $user->showOnlyMyOngoingPrograms;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyOngoingPrograms = $user->showOnlyMyOngoingPrograms;

        if ($user->role == "Admin" && $this->showOnlyMyOngoingPrograms == 0) {
            if ($this->department == null) {

                switch ($this->xOngoingPrograms) {

                    case 0:
                        $ongoingPrograms = null;
                        $lastpageOngoingPrograms = null;
                        break;
                    case 1:

                        $ongoingPrograms = Program::query()
                            ->where('status', 'Incomplete')
                            ->where('startDate', '<=', $this->currentdate)
                            ->where('endDate', '>=', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                        $lastpageOngoingPrograms = $ongoingPrograms->lastPage();


                        break;

                    case 2:

                        $ongoingPrograms = Program::query()
                            ->where('status', 'Incomplete')
                            ->where('startDate', '<=', $this->currentdate)
                            ->where('endDate', '>=', $this->currentdate)
                            ->where('programName', 'like', "%$this->inputSearchOngoingPrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                        $lastpageOngoingPrograms = $ongoingPrograms->lastPage();

                        break;
                }
            } else {
                switch ($this->xOngoingPrograms) {

                    case 0:
                        $ongoingPrograms = null;
                        $lastpageOngoingPrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $ongoingPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '<=', $this->currentdate)
                                ->where('endDate', '>=', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                            $lastpageOngoingPrograms = $ongoingPrograms->lastPage();


                            break;
                        } else if ($this->programid != null) {
                            $ongoingPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '<=', $this->currentdate)
                                ->where('endDate', '>=', $this->currentdate)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                            $lastpageOngoingPrograms = $ongoingPrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {
                            $ongoingPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '<=', $this->currentdate)
                                ->where('enddate', '>=', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchOngoingPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                            $lastpageOngoingPrograms = $ongoingPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $ongoingPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '<=', $this->currentdate)
                                ->where('endDate', '>=', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchOngoingPrograms%")
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                            $lastpageOngoingPrograms = $ongoingPrograms->lastPage();

                            break;
                        }
                }
            }
        } else {
            if ($this->department == null) {

                switch ($this->xOngoingPrograms) {

                    case 0:
                        $ongoingPrograms = null;
                        $lastpageOngoingPrograms = null;
                        break;
                    case 1:

                        $ongoingPrograms = $user->programs()
                            ->where('status', 'Incomplete')
                            ->where('startDate', '<=', $this->currentdate)
                            ->where('endDate', '>=', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                        $lastpageOngoingPrograms = $ongoingPrograms->lastPage();


                        break;

                    case 2:

                        $ongoingPrograms = $user->programs()
                            ->where('status', 'Incomplete')
                            ->where('startDate', '<=', $this->currentdate)
                            ->where('endDate', '>=', $this->currentdate)
                            ->where('programName', 'like', "%$this->inputSearchOngoingPrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                        $lastpageOngoingPrograms = $ongoingPrograms->lastPage();

                        break;
                }
            } else {
                switch ($this->xOngoingPrograms) {

                    case 0:
                        $ongoingPrograms = null;
                        $lastpageOngoingPrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $ongoingPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '<=', $this->currentdate)
                                ->where('endDate', '>=', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                            $lastpageOngoingPrograms = $ongoingPrograms->lastPage();


                            break;
                        } else if ($this->programid != null) {
                            $ongoingPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '<=', $this->currentdate)
                                ->where('endDate', '>=', $this->currentdate)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                            $lastpageOngoingPrograms = $ongoingPrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {
                            $ongoingPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '<=', $this->currentdate)
                                ->where('endDate', '>=', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchOngoingPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                            $lastpageOngoingPrograms = $ongoingPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $ongoingPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '<=', $this->currentdate)
                                ->where('endDate', '>=', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchOngoingPrograms%")
                                ->whereNotIn('programs.id', [$this->programid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageOngoingPrograms, ['*'], 'page', $this->currentPageOngoingPrograms);

                            $lastpageOngoingPrograms = $ongoingPrograms->lastPage();

                            break;
                        }
                }
            }
        }


        return view('livewire.ongoing-program', [
            'ongoingPrograms' => $ongoingPrograms,
            'totalPagesOngoingPrograms' => $lastpageOngoingPrograms
        ]);
    }
}
