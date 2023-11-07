<?php

namespace App\Http\Livewire;

use App\Mail\ApproveAccount;
use App\Mail\DeclineAccount;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
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
    public $declineEmail;
    public $declineName;
    protected $listeners = ['sendEmailDecline' => 'handlesendEmailDecline', 'decline' => 'handleDecline', 'findAccount' => 'handleFindAccount', 'sendEmail' => 'handlesendEmail'];

    public function findAccount($inputSearch, $x)
    {
        $this->inputSearch = $inputSearch;
        $this->x = $x;
        $this->currentPage = 1;
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

        $user->update(['role' => 'Coordinator']);

        $this->emit('updateElements', $id);
    }
    public function approveAsImplementer($id)
    {
        $user = User::findorFail($id);
        $user->update(['role' => 'Implementer']);
        $this->emit('updateElements', $id);
    }
    public function sendEmail($id)
    {
        try {
            $user = User::findorFail($id);
            $email = $user->email;
            $name = $user->name . ' ' . $user->last_name;
            $role = $user->role;
            $username = $user->username;
            $user->update(['approval' => 1]);
            Mail::to($email)->send(new ApproveAccount($name, $role, $username, $email));
            $this->emit('updateLoading', $id);
        } catch (\Exception $e) {
            $this->emit('updateLoadingFailed', $id, $e);
        }
    }
    public function handlesendEmail($id)
    {
        $this->sendEmail($id);
    }
    public function refreshData()
    {
        $this->x = 0;
        $this->currentPage = 1;
    }
    public function decline($id)
    {
        $user = User::findorFail($id);
        $this->declineEmail = $user->email;
        $this->declineName = $user->name . ' ' . $user->last_name;
        $user->delete();
        $this->emit('updateElementsDecline', $id);
        /* $this->pendingusers = User::where('approval', 0)
            ->get();*/
    }
    public function handleDecline($id)
    {
        $this->decline($id);
    }
    public function sendEmailDecline($id, $declineReason)
    {
        try {
            $user = User::findorFail($id);
            $declineEmail = $user->email;
            $declineName = $user->name . ' ' . $user->last_name;
            $user->delete();
            Mail::to($declineEmail)->send(new DeclineAccount($declineName, $declineReason));
            $this->emit('updateLoadingDecline', $id);
        } catch (\Exception $e) {
            $this->emit('updateLoadingFailedDecline', $id, $e);
        }
    }
    public function handlesendEmailDecline($id, $declineReason)
    {
        $this->sendEmailDecline($id, $declineReason);
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
                $pendingusers = User::query()
                    ->where('approval', 0)
                    ->where('name', 'like', "%$this->inputSearch%")
                    ->orWhere('middle_name', 'like', "%$this->inputSearch%")
                    ->orWhere('last_name', 'like', "%$this->inputSearch%")
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                break;
            case 2:
                $pendingusers = User::query()
                    ->where('approval', 0)
                    ->where('email', 'like', "%$this->inputSearch%")
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
                break;
            case 3:
                $pendingusers = User::query()
                    ->where('approval', 0)
                    ->where('department', 'like', "%$this->inputSearch%")
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
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
