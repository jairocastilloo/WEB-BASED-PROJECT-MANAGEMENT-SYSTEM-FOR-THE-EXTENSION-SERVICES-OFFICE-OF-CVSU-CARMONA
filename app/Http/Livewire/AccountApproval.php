<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AccountApproval extends Component
{
    use WithPagination;
    // public $pendingusers;
    public $x = 0;
    public $inputSearch = '';
    public $currentPage = 1; // The current page number
    public $perPage = 10;
    public $data;
    protected $listeners = ['findAccount' => 'handleFindAccount'];

    public function findAccount($inputSearch, $x)
    {
        $this->inputSearch = $inputSearch;
        $this->x = $x;
    }

    public function handleFindAccount($inputSearch, $x)
    {
        $this->findAccount($inputSearch, $x);
    }
    public function changePage($page)
    {
        $this->currentPage = $page;
    }
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

        switch ($this->x) {
            case 0:
                $pendingusers = User::query()
                    ->where('approval', 0)
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
                break;
            case 1:
                break;
            case 2:
                break;
            case 3:
                break;
            default:

                break;
        }

        return view('livewire.account-approval', [
            'pendingusers' => $pendingusers,
            'totalPages' => $pendingusers->lastPage(),
        ]);
    }
}
