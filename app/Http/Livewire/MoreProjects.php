<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MoreProjects extends Component
{
    use WithPagination;

    public $department;
    public $projectid;
    public $fiscalyearid;
    public $status;
    public $x;
    public $inputSearch = '';
    public $currentPage = 1; // The current page number
    public $perPage = 5;
    public $currentdate;

    public function mount($department, $projectid, $fiscalyearid, $status, $x)

    {
        $this->currentdate = now();
        $this->x = $x;
        $this->department = str_replace('+', ' ', $department);
        $this->projectid = $projectid;
        $this->fiscalyearid = $fiscalyearid;
        $this->status = $status;
    }
    public function show($x)
    {
        $this->x = $x;
    }
    public function render()
    {
        if (Auth::user()->role === "Admin") {

            switch ($this->x) {

                case 0:
                    $moreprojects = null;
                    $lastpage = null;
                    break;
                case 1:
                    switch ($this->status) {
                        case "In Progress":
                            $moreprojects = Project::query()
                                ->where('department', $this->department)
                                ->whereNotIn('id', [$this->projectid])
                                ->where('fiscalyear', $this->fiscalyearid)
                                ->where('projectstatus', 'Incomplete')
                                ->where('projectstartdate', '<=', $this->currentdate)
                                ->where('projectenddate', '>=', $this->currentdate)
                                ->orderBy('created_at', 'desc')
                                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                            $lastpage = $moreprojects->lastPage();
                            break;
                    }
                    break;
            }
        }

        return view('livewire.more-projects', [
            'moreprojects' => $moreprojects,
            'totalPages' => $lastpage
        ]);
    }
}
