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
    public $fiscalyearid;
    public $z;
    public $pastinputSearch = '';
    public $pastcurrentPage = 1; // The current page number
    public $pastperPage = 5;
    public $currentdate;
    protected $listeners = ['pastfindProject' => 'pasthandleFindProject'];

    public function mount($department, $projectid, $fiscalyearid, $z)

    {
        $this->currentdate = now();
        $this->z = $z;
        $this->department = str_replace('+', ' ', $department);
        $this->projectid = $projectid;
        $this->fiscalyearid = $fiscalyearid;
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
        if ($user->role === "Admin") {

            switch ($this->z) {

                case 0:
                    $pastmoreprojects = null;
                    $pastlastpage = null;
                    break;
                case 1:

                    $pastmoreprojects = Project::query()
                        ->where('department', $this->department)
                        ->whereNotIn('id', [$this->projectid])
                        ->where('fiscalyear', $this->fiscalyearid)
                        ->where('projectstatus', 'Incomplete')
                        ->where('projectenddate', '<', $this->currentdate)
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                    $pastlastpage = $pastmoreprojects->lastPage();

                    break;
                case 2:


                    $pastmoreprojects = Project::query()
                        ->where('department', $this->department)
                        ->whereNotIn('id', [$this->projectid])
                        ->where('fiscalyear', $this->fiscalyearid)
                        ->where('projectstatus', 'Incomplete')
                        ->where('projectenddate', '<', $this->currentdate)
                        ->where('projecttitle', 'like', "%$this->pastinputSearch%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                    $pastlastpage = $pastmoreprojects->lastPage();

                    break;
            }
        } else {
            switch ($this->z) {

                case 0:
                    $pastmoreprojects = null;
                    $pastlastpage = null;
                    break;
                case 1:

                    $pastmoreprojects = $user->projects()
                        ->where('department', $this->department)
                        ->whereNotIn('id', [$this->projectid])
                        ->where('fiscalyear', $this->fiscalyearid)
                        ->where('projectstatus', 'Incomplete')
                        ->where('projectenddate', '<', $this->currentdate)
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                    $pastlastpage = $pastmoreprojects->lastPage();

                    break;
                case 2:


                    $pastmoreprojects = $user->projects()
                        ->where('department', $this->department)
                        ->whereNotIn('id', [$this->projectid])
                        ->where('fiscalyear', $this->fiscalyearid)
                        ->where('projectstatus', 'Incomplete')
                        ->where('projectenddate', '<', $this->currentdate)
                        ->where('projecttitle', 'like', "%$this->pastinputSearch%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->pastperPage, ['*'], 'page', $this->pastcurrentPage);

                    $pastlastpage = $pastmoreprojects->lastPage();

                    break;
            }
        }

        return view('livewire.past-projects', [
            'pastmoreprojects' => $pastmoreprojects,
            'pasttotalPages' => $pastlastpage
        ]);
    }
}
