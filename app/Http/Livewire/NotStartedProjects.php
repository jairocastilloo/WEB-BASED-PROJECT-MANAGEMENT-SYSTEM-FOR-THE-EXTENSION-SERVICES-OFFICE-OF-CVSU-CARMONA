<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class NotStartedProjects extends Component
{
    use WithPagination;

    public $department;
    public $projectid;

    public $y;
    public $notstartedinputSearch = '';
    public $notstartedcurrentPage = 1; // The current page number
    public $notstartedperPage = 5;
    public $currentdate;
    public $showOnlyMyUpcomingProjects;
    protected $listeners = ['notstartedfindProject' => 'notstartedhandleFindProject'];

    public function mount($department, $projectid, $y)

    {
        $this->currentdate = now();
        $this->y = $y;
        $this->department = str_replace('+', ' ', $department);
        $this->projectid = $projectid;
    }
    public function notstartedshow($y)
    {
        $this->y = $y;
    }
    public function notstartedrefreshData()
    {
        $this->y = 1;
        $this->notstartedcurrentPage = 1;
    }
    public function notstartedchangePage($page)
    {
        $this->notstartedcurrentPage = $page;
    }
    public function notstartedfindProject($notstartedinputSearch, $y)
    {
        $this->notstartedinputSearch = $notstartedinputSearch;
        $this->y = $y;
        $this->notstartedcurrentPage = 1;
    }
    public function notstartedhandleFindProject($notstartedinputSearch, $y)
    {
        $this->notstartedfindProject($notstartedinputSearch, $y);
    }
    public function toggleSelectionUpcomingProjects($isChecked)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($isChecked) {

            $user->update([
                'showOnlyMyUpcomingProjects' => 1,
            ]);
        } else {
            $user->update([
                'showOnlyMyUpcomingProjectss' => 0,
            ]);
        }

        $this->showOnlyMyUpcomingProjects = $user->showOnlyMyUpcomingProjects;
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->showOnlyMyUpcomingProjects = $user->showOnlyMyUpcomingProjects;
        if ($user->role == "Admin" && $this->showOnlyMyUpcomingProjects == 0) {
            if ($this->department == null) {

                switch ($this->y) {

                    case 0:
                        $notstartedprojects = null;
                        $notstartedlastpage = null;
                        break;
                    case 1:

                        $notstartedprojects = Project::query()
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectstartdate', '>', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                        $notstartedlastpage = $notstartedprojects->lastPage();

                        break;

                    case 2:

                        $notstartedprojects = Project::query()
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectstartdate', '>', $this->currentdate)
                            ->where('projecttitle', 'like', "%$this->notstartedinputSearch%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                        $notstartedlastpage = $notstartedprojects->lastPage();

                        break;
                }
            } else {
                switch ($this->y) {

                    case 0:
                        $notstartedprojects = null;
                        $notstartedlastpage = null;
                        break;
                    case 1:
                        if ($this->projectid == null) {
                            $notstartedprojects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '>', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                            $notstartedlastpage = $notstartedprojects->lastPage();

                            break;
                        } else if ($this->projectid != null) {
                            $notstartedprojects = Project::query()
                                ->where('department', $this->department)
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '>', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                            $notstartedlastpage = $notstartedprojects->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->projectid == null) {
                            $notstartedprojects = Project::query()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '>', $this->currentdate)
                                ->where('projecttitle', 'like', "%$this->notstartedinputSearch%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                            $notstartedlastpage = $notstartedprojects->lastPage();

                            break;
                        } else if ($this->projectid != null) {
                            $notstartedprojects = Project::query()
                                ->where('department', $this->department)
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '>', $this->currentdate)
                                ->where('projecttitle', 'like', "%$this->notstartedinputSearch%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                            $notstartedlastpage = $notstartedprojects->lastPage();

                            break;
                        }
                }
            }
        } else {
            if ($this->department == null) {

                switch ($this->y) {

                    case 0:
                        $notstartedprojects = null;
                        $notstartedlastpage = null;
                        break;
                    case 1:

                        $notstartedprojects = $user->projects()
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectstartdate', '>', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                        $notstartedlastpage = $notstartedprojects->lastPage();

                        break;

                    case 2:

                        $notstartedprojects = $user->projects()
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectstartdate', '>', $this->currentdate)
                            ->where('projecttitle', 'like', "%$this->notstartedinputSearch%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                        $notstartedlastpage = $notstartedprojects->lastPage();

                        break;
                }
            } else {
                switch ($this->y) {

                    case 0:
                        $notstartedprojects = null;
                        $notstartedlastpage = null;
                        break;
                    case 1:
                        if ($this->projectid == null) {
                            $notstartedprojects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '>', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                            $notstartedlastpage = $notstartedprojects->lastPage();

                            break;
                        } else if ($this->projectid != null) {
                            $notstartedprojects = $user->projects()
                                ->where('department', $this->department)
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '>', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                            $notstartedlastpage = $notstartedprojects->lastPage();

                            break;
                        }
                    case 2:
                        if ($this->projectid == null) {
                            $notstartedprojects = $user->projects()
                                ->where('department', $this->department)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '>', $this->currentdate)
                                ->where('projecttitle', 'like', "%$this->notstartedinputSearch%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                            $notstartedlastpage = $notstartedprojects->lastPage();

                            break;
                        } else if ($this->projectid != null) {
                            $notstartedprojects = $user->projects()
                                ->where('department', $this->department)
                                ->whereNotIn('projects.id', [$this->projectid])
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '>', $this->currentdate)
                                ->where('projecttitle', 'like', "%$this->notstartedinputSearch%")
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->notstartedperPage, ['*'], 'page', $this->notstartedcurrentPage);

                            $notstartedlastpage = $notstartedprojects->lastPage();

                            break;
                        }
                }
            }
        }

        return view('livewire.not-started-projects', [
            'notstartedprojects' => $notstartedprojects,
            'notstartedtotalPages' => $notstartedlastpage
        ]);
    }
}
