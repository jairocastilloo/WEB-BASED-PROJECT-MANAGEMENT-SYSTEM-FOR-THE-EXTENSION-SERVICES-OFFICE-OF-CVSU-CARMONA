<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AccountApproval extends Component
{
    public $pendingusers;
    public function mount($pendingusers)
    {
        $this->pendingusers = $pendingusers;
    }
    public function render()
    {
        return view('livewire.account-approval');
    }
}
