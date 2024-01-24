<?php

namespace App\Http\Livewire;

use App\Models\ProjectTerminal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectsSubmission extends Component
{
    public $currentPageProjectTerminal = 1; // The current page number
    public $perPageProjectTerminal = 10;
    public function changePageProjectTerminal($page)
    {
        $this->currentPageProjectTerminal = $page;
    }
    public function render()
    {
        $projectTerminal = ProjectTerminal::query()
        ->orderBy('created_at', 'desc')
        ->paginate($this->perPageProjectTerminal, ['*'], 'page', $this->currentPageProjectTerminal);

    $lastpageProjectTerminal = $projectTerminal->lastPage();
    return view('livewire.projects-submission', [
        'projectTerminal' => $projectTerminal,
        'totalPagesProjectTerminal' => $lastpageProjectTerminal
    ]);
    }
}
