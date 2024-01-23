<?php

namespace App\Http\Livewire;

use App\Models\EmailLogs;
use Livewire\Component;
use Livewire\WithPagination;

class ResendEmail extends Component
{
    public $currentPage = 1; // The current page number
    public $perPage = 10;
    use WithPagination;
    public function render()
    {
        $emailLogs = EmailLogs::query()
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

        return view(
            'livewire.resend-email',
            [
                'emailLogs' => $emailLogs,
                'totalPages' => $emailLogs->lastPage(),
            ]
        );
    }
}
