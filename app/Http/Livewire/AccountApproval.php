<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class AccountApproval extends Component
{
    public $pendingusers;
    public function mount($pendingusers)
    {
        $this->pendingusers = $pendingusers;
    }
    public function approveAsCoordinator($id)
    {
        $user = User::findorFail($id);
        $user->update(['approval' => 1, 'role' => 'Coordinator']);
        $this->pendingusers = User::where('approval', 0)
            ->get();
    }
    public function approveAsImplementer($id)
    {
        $user = User::findorFail($id);
        $user->update(['approval' => 1, 'role' => 'Implementer']);
        $this->pendingusers = User::where('approval', 0)
            ->get();
    }
    public function decline($id)
    {
        $user = User::findorFail($id);
        $user->delete();
        $this->pendingusers = User::where('approval', 0)
            ->get();
    }
    public function render()
    {
        return view('livewire.account-approval');
    }
}
