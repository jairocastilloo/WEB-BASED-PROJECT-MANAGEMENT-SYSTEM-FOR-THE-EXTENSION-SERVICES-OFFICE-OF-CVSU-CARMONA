<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AccountApproval extends Component
{
    use WithPagination;
    // public $pendingusers;
    /*
    public function mount()
    {
        $this->pendingusers = User::where('approval', 0)
        ->paginate(10);
    } */
    public function approveAsCoordinator($id)
    {
        $user = User::findorFail($id);
        $user->update(['approval' => 1, 'role' => 'Coordinator']);
        /*$this->pendingusers = User::where('approval', 0)
            ->get();*/
    }
    public function approveAsImplementer($id)
    {
        $user = User::findorFail($id);
        $user->update(['approval' => 1, 'role' => 'Implementer']);
        /* $this->pendingusers = User::where('approval', 0)
            ->get();*/
    }
    public function decline($id)
    {
        $user = User::findorFail($id);
        $user->delete();
        /* $this->pendingusers = User::where('approval', 0)
            ->get();*/
    }
    public function render()
    {
        $pendingusers = User::where('approval', 0)
            ->paginate(10);
        return view('livewire.account-approval', [
            'pendingusers' => $pendingusers,
        ]);
    }
}
