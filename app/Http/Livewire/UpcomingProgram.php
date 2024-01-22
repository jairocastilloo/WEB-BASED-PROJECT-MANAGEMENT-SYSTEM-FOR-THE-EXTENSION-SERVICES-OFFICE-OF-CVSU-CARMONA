<?php

namespace App\Http\Livewire;

use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UpcomingProgram extends Component
{
    use WithPagination;

    public $department;
    public $programid;

    public $yUpcomingPrograms;
    public $inputSearchUpcomingPrograms = '';
    public $currentPageUpcomingPrograms = 1; // The current page number
    public $perPageUpcomingPrograms = 5;
    public $currentdate;
    public $showOnlyMyUpcomingPrograms;
    protected $listeners = ['findUpcomingPrograms' => 'handleFindUpcomingPrograms'];

    public function mount($department, $programid, $yUpcomingPrograms)

    {
        $this->currentdate = now();
        $this->yUpcomingPrograms = $yUpcomingPrograms;
        $this->department = str_replace('+', ' ', $department);
        $this->programid = $programid;
    }
    public function showUpcomingPrograms($yUpcomingPrograms)
    {
        $this->yUpcomingPrograms = $yUpcomingPrograms;
    }
    public function refreshDataUpcomingPrograms()
    {
        $this->yUpcomingPrograms = 1;
        $this->currentPageUpcomingPrograms = 1;
    }
    public function changePageUpcomingPrograms($pageUpcomingPrograms)
    {
        $this->currentPageUpcomingPrograms = $pageUpcomingPrograms;
    }
    public function findProject($inputSearchUpcomingPrograms, $yUpcomingPrograms)
    {
        $this->inputSearchUpcomingPrograms = $inputSearchUpcomingPrograms;
        $this->yUpcomingPrograms = $yUpcomingPrograms;
        $this->currentPageUpcomingPrograms = 1;
    }
    public function handleFindUpcomingPrograms($inputSearchUpcomingPrograms, $yUpcomingPrograms)
    {
        $this->findUpcomingPrograms($inputSearchUpcomingPrograms, $yUpcomingPrograms);
    }
    public function toggleSelectionUpcomingPrograms($isCheckedUpcomingPrograms)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isCheckedUpcomingPrograms) {

            $user->update([
                'showOnlyMyUpcomingPrograms' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyUpcomingPrograms' => 0,
            ]);
        }

        $this->showOnlyMyUpcomingPrograms = $user->showOnlyMyUpcomingPrograms;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyUpcomingPrograms = $user->showOnlyMyUpcomingPrograms;
        if ($user->role == "Admin" && $this->showOnlyMyUpcomingPrograms == 0) {
            if ($this->department == null) {

                switch ($this->yUpcomingPrograms) {

                    case 0:
                        $upcomingPrograms = null;
                        $lastpageUpcomingPrograms = null;
                        break;
                    case 1:

                        $upcomingPrograms = Program::query()
                            ->where('status', 'Incomplete')
                            ->where('startDate', '>', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                        $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                        break;

                    case 2:

                        $upcomingPrograms = Program::query()
                            ->where('status', 'Incomplete')
                            ->where('startDate', '>', $this->currentdate)
                            ->where('programName', 'like', "%$this->inputSearchUpcomingPrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                        $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                        break;
                }
            } else {
                switch ($this->yUpcomingPrograms) {

                    case 0:
                        $upcomingPrograms = null;
                        $lastpageUpcomingPrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $upcomingPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '>', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                            $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $upcomingPrograms = Program::query()
                                ->where('department', $this->department)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->where('status', 'Incomplete')
                                ->where('startDate', '>', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                            $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {
                            $upcomingPrograms = Program::query()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '>', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchUpcomingPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                            $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $upcomingPrograms = Program::query()
                                ->where('department', $this->department)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->where('status', 'Incomplete')
                                ->where('startDate', '>', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchUpcomingPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                            $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                            break;
                        }
                }
            }
        } else {
            if ($this->department == null) {

                switch ($this->yUpcomingPrograms) {

                    case 0:
                        $upcomingPrograms = null;
                        $lastpageUpcomingPrograms = null;
                        break;
                    case 1:

                        $upcomingPrograms = $user->programs()
                            ->where('status', 'Incomplete')
                            ->where('startDate', '>', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                        $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                        break;

                    case 2:

                        $upcomingPrograms = $user->programs()
                            ->where('status', 'Incomplete')
                            ->where('startDate', '>', $this->currentdate)
                            ->where('programName', 'like', "%$this->inputSearchUpcomingPrograms%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                        $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                        break;
                }
            } else {
                switch ($this->yUpcomingPrograms) {

                    case 0:
                        $upcomingPrograms = null;
                        $lastpageUpcomingPrograms = null;
                        break;
                    case 1:
                        if ($this->programid == null) {
                            $upcomingPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '>', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                            $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $upcomingPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->where('status', 'Incomplete')
                                ->where('startDate', '>', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                            $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->programid == null) {
                            $upcomingPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->where('status', 'Incomplete')
                                ->where('startDate', '>', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchUpcomingPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                            $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                            break;
                        } else if ($this->programid != null) {
                            $upcomingPrograms = $user->programs()
                                ->where('department', $this->department)
                                ->whereNotIn('programs.id', [$this->programid])
                                ->where('status', 'Incomplete')
                                ->where('startDate', '>', $this->currentdate)
                                ->where('programName', 'like', "%$this->inputSearchUpcomingPrograms%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageUpcomingPrograms, ['*'], 'page', $this->currentPageUpcomingPrograms);

                            $lastpageUpcomingPrograms = $upcomingPrograms->lastPage();

                            break;
                        }
                }
            }
        }

        return view('livewire.upcoming-program', [
            'upcomingPrograms' => $upcomingPrograms,
            'totalPagesUpcomingPrograms' => $lastpageUpcomingPrograms
        ]);
    }
}
