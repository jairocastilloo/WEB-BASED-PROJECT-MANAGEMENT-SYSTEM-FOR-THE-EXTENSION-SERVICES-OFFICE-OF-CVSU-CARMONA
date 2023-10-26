<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PastActivities extends Component
{
    public $projectid;
    public $xPastActivities;
    public $inputSearchPastActivities = '';
    public $currentPagePastActivities = 1; // The current page number
    public $perPagePastActivities = 5;
    public $currentdate;

    protected $listeners = ['findPastActivities' => 'handleFindPastActivities'];

    public function mount($projectid, $xPastActivities)

    {
        $this->currentdate = now();
        $this->xPastActivities = $xPastActivities;
        $this->projectid = $projectid;
    }
    public function showPastActivities($xPastActivities)
    {
        $this->xPastActivities = $xPastActivities;
    }
    public function refreshDataPastActivities()
    {
        $this->xPastActivities = 1;
        $this->currentPagePastActivities = 1;
    }
    public function changePagePastActivities($page)
    {
        $this->currentPagePastActivities = $page;
    }
    public function findPastActivities($inputSearchPastActivities, $xPastActivities)
    {
        $this->inputSearchPastActivities = $inputSearchPastActivities;
        $this->xPastActivities = $xPastActivities;
        $this->currentPagePastActivities = 1;
    }
    public function handleFindPastActivities($inputSearchPastActivities, $xPastActivities)
    {
        $this->findPastActivities($inputSearchPastActivities, $xPastActivities);
    }
    public function render()
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($this->projectid == null) {
            switch ($this->xPastActivities) {

                case 0:
                    $PastActivities = null;
                    $lastpagePastActivities = null;
                    break;
                case 1:

                    $PastActivities = $user->activities()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '<=', $this->currentdate)
                        ->where('actenddate', '>=', $this->currentdate)
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPagePastActivities, ['*'], 'page', $this->currentPagePastActivities);

                    $lastpagePastActivities = $PastActivities->lastPage();


                    break;

                case 2:

                    $PastActivities = $user->activities()
                        ->where('actremark', 'Incomplete')
                        ->where('actstartdate', '<=', $this->currentdate)
                        ->where('actenddate', '>=', $this->currentdate)
                        ->where('actname', 'like', "%$this->inputSearchPastActivities%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($this->perPagePastActivities, ['*'], 'page', $this->currentPagePastActivities);

                    $lastpagePastActivities = $PastActivities->lastPage();

                    break;
            }
        }
        return view('livewire.past-activities', [
            'PastActivities' => $PastActivities,
            'totalPagesPastActivities' => $lastpagePastActivities
        ]);
    }
}
