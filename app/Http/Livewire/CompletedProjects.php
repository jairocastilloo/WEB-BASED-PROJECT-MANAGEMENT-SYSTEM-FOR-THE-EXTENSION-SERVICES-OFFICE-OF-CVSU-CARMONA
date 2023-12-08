<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompletedProjects extends Component
{
    public $department;
    public $projectid;
    public $xCompletedProjects;
    public $inputSearchCompletedProjects = '';
    public $currentPageCompletedProjects = 1; // The current page number
    public $perPageCompletedProjects = 5;
    public $currentdate;
    public $showOnlyMyCompletedProjects;
    protected $listeners = ['findCompletedProjects' => 'handleFindCompletedProjects'];

    public function mount($department, $projectid, $xCompletedProjects)

    {
        $this->currentdate = now();
        $this->xCompletedProjects = $xCompletedProjects;
        $this->department = str_replace('+', ' ', $department);
        $this->projectid = $projectid;
    }
    public function showCompletedProjects($xCompletedProjects)
    {
        $this->xCompletedProjects = $xCompletedProjects;
    }
    public function refreshDataCompletedProjects()
    {
        $this->xCompletedProjects = 1;
        $this->currentPageCompletedProjects = 1;
    }
    public function changePageCompletedProjects($page)
    {
        $this->currentPageCompletedProjects = $page;
    }
    public function findCompletedProjects($inputSearchCompletedProjects, $xCompletedProjects)
    {
        $this->inputSearchCompletedProjects = $inputSearchCompletedProjects;
        $this->xCompletedProjects = $xCompletedProjects;
        $this->currentPageCompletedProjects = 1;
    }
    public function handleFindCompletedProjects($inputSearchCompletedProjects, $xCompletedProjects)
    {
        $this->findCompletedProjects($inputSearchCompletedProjects, $xCompletedProjects);
    }
    public function toggleSelectionCompletedProjects($isChecked)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isChecked) {

            $user->update([
                'showOnlyMyCompletedProjects' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyCompletedProjects' => 0,
            ]);
        }

        $this->showOnlyMyCompletedProjects = $user->showOnlyMyCompletedProjecs;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyCompletedProjects = $user->showOnlyMyCompletedProjects;

        if ($user->role == "Admin" && $this->showOnlyMyCompletedProjects == 0) {
            if ($this->department == null) {

                switch ($this->xCompletedProjects) {

                    case 0:
                        $CompletedProjects = null;
                        $lastpageCompletedProjects = null;
                        break;
                    case 1:

                        $CompletedProjects = Project::query()
                            ->where('projectstatus', 'Completed')
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                        $lastpageCompletedProjects = $CompletedProjects->lastPage();


                        break;

                    case 2:

                        $CompletedProjects = Project::query()
                            ->where('projectstatus', 'Completed')
                            ->where('projecttitle', 'like', "%$this->inputSearchCompletedProjects%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                        $lastpageCompletedProjects = $CompletedProjects->lastPage();

                        break;
                }
            } else {
                switch ($this->xCompletedProjects) {

                    case 0:
                        $CompletedProjects = null;
                        $lastpageCompletedProjects = null;
                        break;
                    case 1:
                        if ($this->projectid == null) {
                            $CompletedProjects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Completed')
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                            $lastpageCompletedProjects = $CompletedProjects->lastPage();


                            break;
                        } else if ($this->projectid != null) {
                            $CompletedProjects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Completed')
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                            $lastpageCompletedProjects = $CompletedProjects->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->projectid == null) {
                            $CompletedProjects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Completed')
                                ->where('projecttitle', 'like', "%$this->inputSearchCompletedProjects%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                            $lastpageCompletedProjects = $CompletedProjects->lastPage();

                            break;
                        } else if ($this->projectid != null) {
                            $CompletedProjects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Completed')
                                ->where('projecttitle', 'like', "%$this->inputSearchCompletedProjects%")
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                            $lastpageCompletedProjects = $CompletedProjects->lastPage();

                            break;
                        }
                }
            }
        } else {
            if ($this->department == null) {

                switch ($this->xCompletedProjects) {

                    case 0:
                        $CompletedProjects = null;
                        $lastpageCompletedProjects = null;
                        break;
                    case 1:

                        $CompletedProjects = $user->projects()
                            ->where('projectstatus', 'Completed')
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                        $lastpageCompletedProjects = $CompletedProjects->lastPage();


                        break;

                    case 2:

                        $CompletedProjects = $user->projects()
                            ->where('projectstatus', 'Completed')
                            ->where('projecttitle', 'like', "%$this->inputSearchCompletedProjects%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                        $lastpageCompletedProjects = $CompletedProjects->lastPage();

                        break;
                }
            } else {
                switch ($this->xCompletedProjects) {

                    case 0:
                        $CompletedProjects = null;
                        $lastpageCompletedProjects = null;
                        break;
                    case 1:
                        if ($this->projectid == null) {
                            $CompletedProjects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Completed')
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                            $lastpageCompletedProjects = $CompletedProjects->lastPage();


                            break;
                        } else if ($this->projectid != null) {
                            $CompletedProjects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Completed')
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                            $lastpageCompletedProjects = $CompletedProjects->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->projectid == null) {
                            $CompletedProjects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Completed')
                                ->where('projecttitle', 'like', "%$this->inputSearchCompletedProjects%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                            $lastpageCompletedProjects = $CompletedProjects->lastPage();

                            break;
                        } else if ($this->projectid != null) {
                            $CompletedProjects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Completed')
                                ->where('projecttitle', 'like', "%$this->inputSearchCompletedProjects%")
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPageCompletedProjects, ['*'], 'page', $this->currentPageCompletedProjects);

                            $lastpageCompletedProjects = $CompletedProjects->lastPage();

                            break;
                        }
                }
            }
        }
        return view('livewire.completed-projects', [
            'CompletedProjects' => $CompletedProjects,
            'totalPagesCompletedProjects' => $lastpageCompletedProjects
        ]);
    }
}
