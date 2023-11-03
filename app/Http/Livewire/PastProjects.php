<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PastProjects extends Component
{
    use WithPagination;

    public $department;
    public $projectid;
    public $z;
    public $pastinputSearch = '';
    public $pastcurrentPage = 1; // The current page number
    public $pastperPage = 5;
    public $currentdate;
    protected $listeners = ['pastfindProject' => 'pasthandleFindProject'];

    public function mount($department, $projectid, $z)

    {
        $this->currentdate = now();
        $this->z = $z;
        $this->department = str_replace('+', ' ', $department);
        $this->projectid = $projectid;
    }
    public function pastshow($z)
    {
        $this->z = $z;
    }
    public function pastrefreshData()
    {
        $this->z = 1;
        $this->pastcurrentPage = 1;
    }
    public function pastchangePage($pastpage)
    {
        $this->pastcurrentPage = $pastpage;
    }
    public function pastfindProject($pastinputSearch, $z)
    {
        $this->pastinputSearch = $pastinputSearch;
        $this->z = $z;
        $this->pastcurrentPage = 1;
    }
    public function pasthandleFindProject($pastinputSearch, $z)
    {
        $this->pastfindProject($pastinputSearch, $z);
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($this->department == null) {

            // for home
            switch ($this->z) {

                case 0:
                    $pastmoreprojects = null;
                    $pastlastpage = null;
                    break;
                    // for showing initial
                case 1:

                    $pastmoreprojects = $user->projects()
                        ->where('projectstatus', 'Incomplete')
                        ->where('projectenddate', '<', $this->currentdate)
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                    $pastlastpage = $pastmoreprojects->lastPage();

                    break;
                    // for searching
                case 2:


                    $pastmoreprojects = $user->projects()
                        ->where('projectstatus', 'Incomplete')
                        ->where('projectenddate', '<', $this->currentdate)
                        ->where('projecttitle', 'like', "%$this->pastinputSearch%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                    $pastlastpage = $pastmoreprojects->lastPage();

                    break;
            }
        } else if ($user->role === "Admin") {
            // for select and create as admin
            switch ($this->z) {

                case 0:
                    $pastmoreprojects = null;
                    $pastlastpage = null;
                    break;
                    // for showing initial
                case 1:
                    if ($this->projectid == null) {
                        // for create
                        $pastmoreprojects = Project::query()
                            ->where('department', $this->department)
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectenddate', '<', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                        $pastlastpage = $pastmoreprojects->lastPage();

                        break;
                    } else if ($this->projectid != null) {
                        // for select
                        $pastmoreprojects = Project::query()
                            ->where('department', $this->department)
                            ->whereNotIn('id', [$this->projectid])
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectenddate', '<', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                        $pastlastpage = $pastmoreprojects->lastPage();

                        break;
                    }
                    // for searching
                case 2:

                    if ($this->projectid == null) {
                        // for create
                        $pastmoreprojects = Project::query()
                            ->where('department', $this->department)
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectenddate', '<', $this->currentdate)
                            ->where('projecttitle', 'like', "%$this->pastinputSearch%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                        $pastlastpage = $pastmoreprojects->lastPage();

                        break;
                    } else if ($this->projectid != null) {
                        // for select
                        $pastmoreprojects = Project::query()
                            ->where('department', $this->department)
                            ->whereNotIn('id', [$this->projectid])
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectenddate', '<', $this->currentdate)
                            ->where('projecttitle', 'like', "%$this->pastinputSearch%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                        $pastlastpage = $pastmoreprojects->lastPage();

                        break;
                    }
            }
        } else {
            // for select and create as user
            switch ($this->z) {

                case 0:
                    $pastmoreprojects = null;
                    $pastlastpage = null;
                    break;
                case 1:
                    if ($this->projectid == null) {
                        $pastmoreprojects = $user->projects()
                            ->where('department', $this->department)
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectenddate', '<', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                        $pastlastpage = $pastmoreprojects->lastPage();

                        break;
                    } else  if ($this->projectid != null) {
                        $pastmoreprojects = $user->projects()
                            ->where('department', $this->department)
                            ->whereNotIn('projects.id', [$this->projectid])
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectenddate', '<', $this->currentdate)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                        $pastlastpage = $pastmoreprojects->lastPage();

                        break;
                    }
                case 2:
                    if ($this->projectid == null) {

                        $pastmoreprojects = $user->projects()
                            ->where('department', $this->department)
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectenddate', '<', $this->currentdate)
                            ->where('projecttitle', 'like', "%$this->pastinputSearch%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                        $pastlastpage = $pastmoreprojects->lastPage();

                        break;
                    } else if ($this->projectid != null) {
                        $pastmoreprojects = $user->projects()
                            ->where('department', $this->department)
                            ->whereNotIn('projects.id', [$this->projectid])
                            ->where('projectstatus', 'Incomplete')
                            ->where('projectenddate', '<', $this->currentdate)
                            ->where('projecttitle', 'like', "%$this->pastinputSearch%")
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                        $pastlastpage = $pastmoreprojects->lastPage();

                        break;
                    }
            }
        }

        return view('livewire.past-projects', [
            'pastmoreprojects' => $pastmoreprojects,
            'pasttotalPages' => $pastlastpage
        ]);
    }
}
