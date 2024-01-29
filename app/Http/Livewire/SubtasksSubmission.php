<?php

namespace App\Http\Livewire;

use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SubtasksSubmission extends Component
{
    public $currentPageSubtaskContribution = 1; // The current page number
    public $perPageSubtaskContribution = 5;
    public function changePageSubtaskContribution($page)
    {
        $this->currentPageSubtaskContribution = $page;
    }
    public function render()
    {
        $subtaskContribution = Contribution::query()
        ->orderBy('created_at', 'desc')
        ->paginate($this->perPageSubtaskContribution, ['*'], 'page', $this->currentPageSubtaskContribution);

    $lastpageSubtaskContribution = $subtaskContribution->lastPage();
    return view('livewire.subtasks-submission', [
        'subtaskContribution' => $subtaskContribution,
        'totalPagesSubtaskContribution' => $lastpageSubtaskContribution
    ]);
    }
}
