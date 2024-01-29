<?php

namespace App\Http\Livewire;

use App\Models\activityContribution;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ActivitiesSubmission extends Component
{
    public $currentPageActivityContribution = 1; // The current page number
    public $perPageActivityContribution = 5;
    public function changePageActivityContribution($page)
    {
        $this->currentPageActivityContribution = $page;
    }
    public function render()
    {
        $activityContribution = ActivityContribution::query()
        ->orderBy('created_at', 'desc')
        ->paginate($this->perPageActivityContribution, ['*'], 'page', $this->currentPageActivityContribution);

    $lastpageActivityContribution = $activityContribution->lastPage();
    return view('livewire.activities-submission', [
        'activityContribution' => $activityContribution,
        'totalPagesActivityContribution' => $lastpageActivityContribution
    ]);
    }
}
