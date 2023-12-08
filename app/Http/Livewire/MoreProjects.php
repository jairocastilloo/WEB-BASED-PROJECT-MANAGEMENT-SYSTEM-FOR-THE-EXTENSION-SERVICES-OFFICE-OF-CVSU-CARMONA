<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MoreProjects extends Component
{
    use WithPagination;

    public $department;
    public $projectid;
    public $x;
    public $inputSearch = '';
    public $currentPage = 1; // The current page number
    public $perPage = 5;
    public $currentdate;
    public $showOnlyMyOngoingProjects;
    protected $listeners = ['findProject' => 'handleFindProject'];

    public function mount($department, $projectid, $x)

    {
        $this->currentdate = now();
        $this->x = $x;
        $this->department = str_replace('+', ' ', $department);
        $this->projectid = $projectid;
    }
    public function show($x)
    {
        $this->x = $x;
    }
    public function refreshData()
    {
        $this->x = 1;
        $this->currentPage = 1;
    }
    public function changePage($page)
    {
        $this->currentPage = $page;
    }
    public function findProject($inputSearch, $x)
    {
        $this->inputSearch = $inputSearch;
        $this->x = $x;
        $this->currentPage = 1;
    }
    public function handleFindProject($inputSearch, $x)
    {
        $this->findProject($inputSearch, $x);
    }
    public function toggleSelectionOngoingProjects($isChecked)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isChecked) {

            $user->update([
                'showOnlyMyOngoingProjects' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyOngoingProjects' => 0,
            ]);
        }

        $this->showOnlyMyOngoingProjects = $user->showOnlyMyOngoingProjects;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyOngoingProjects = $user->showOnlyMyOngoingProjects;
        if ($user->role == "Admin" && $this->showOnlyMyOngoingProjects == 0) {
            if ($this->department == null) {

                switch ($this->x) {

                    case 0:
                        $moreprojects = null;
                        $lastpage = null;
                        break;
                    case 1:

                        $moreprojects = Project::query()
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectstartdate', '<=', $this->currentdate)
                            ->where('projectenddate', '>=', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                        $lastpage = $moreprojects->lastPage();


                        break;

                    case 2:

                        $moreprojects = Project::query()
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectstartdate', '<=', $this->currentdate)
                            ->where('projectenddate', '>=', $this->currentdate)
                            ->where('projecttitle', 'like', "%$this->inputSearch%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                        $lastpage = $moreprojects->lastPage();

                        break;
                }
            } else {
                switch ($this->x) {

                    case 0:
                        $moreprojects = null;
                        $lastpage = null;
                        break;
                    case 1:
                        if ($this->projectid == null) {
                            $moreprojects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '<=', $this->currentdate)
                                ->where('projectenddate', '>=', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                            $lastpage = $moreprojects->lastPage();


                            break;
                        } else if ($this->projectid != null) {
                            $moreprojects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '<=', $this->currentdate)
                                ->where('projectenddate', '>=', $this->currentdate)
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                            $lastpage = $moreprojects->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->projectid == null) {
                            $moreprojects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '<=', $this->currentdate)
                                ->where('projectenddate', '>=', $this->currentdate)
                                ->where('projecttitle', 'like', "%$this->inputSearch%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                            $lastpage = $moreprojects->lastPage();

                            break;
                        } else if ($this->projectid != null) {
                            $moreprojects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '<=', $this->currentdate)
                                ->where('projectenddate', '>=', $this->currentdate)
                                ->where('projecttitle', 'like', "%$this->inputSearch%")
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                            $lastpage = $moreprojects->lastPage();

                            break;
                        }
                }
            }
        } else {
            if ($this->department == null) {

                switch ($this->x) {

                    case 0:
                        $moreprojects = null;
                        $lastpage = null;
                        break;
                    case 1:

                        $moreprojects = $user->projects()
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectstartdate', '<=', $this->currentdate)
                            ->where('projectenddate', '>=', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                        $lastpage = $moreprojects->lastPage();


                        break;

                    case 2:

                        $moreprojects = $user->projects()
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectstartdate', '<=', $this->currentdate)
                            ->where('projectenddate', '>=', $this->currentdate)
                            ->where('projecttitle', 'like', "%$this->inputSearch%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                        $lastpage = $moreprojects->lastPage();

                        break;
                }
            } else {
                switch ($this->x) {

                    case 0:
                        $moreprojects = null;
                        $lastpage = null;
                        break;
                    case 1:
                        if ($this->projectid == null) {
                            $moreprojects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '<=', $this->currentdate)
                                ->where('projectenddate', '>=', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                            $lastpage = $moreprojects->lastPage();


                            break;
                        } else if ($this->projectid != null) {
                            $moreprojects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '<=', $this->currentdate)
                                ->where('projectenddate', '>=', $this->currentdate)
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                            $lastpage = $moreprojects->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->projectid == null) {
                            $moreprojects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '<=', $this->currentdate)
                                ->where('projectenddate', '>=', $this->currentdate)
                                ->where('projecttitle', 'like', "%$this->inputSearch%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                            $lastpage = $moreprojects->lastPage();

                            break;
                        } else if ($this->projectid != null) {
                            $moreprojects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '<=', $this->currentdate)
                                ->where('projectenddate', '>=', $this->currentdate)
                                ->where('projecttitle', 'like', "%$this->inputSearch%")
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                            $lastpage = $moreprojects->lastPage();

                            break;
                        }
                }
            }
        }


        return view('livewire.more-projects', [
            'moreprojects' => $moreprojects,
            'totalPages' => $lastpage
        ]);
    }
}
