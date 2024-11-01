<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class EditAccount extends Component
{
    use WithPagination;
    // public $pendingusers;
    public $x = 0;
    public $inputSearch = '';
    public $currentPage = 1; // The current page number
    public $perPage = 10;
    public $data;
    protected $listeners = ['updateData' => 'handleupdateData', 'findAccount' => 'handleFindAccount', 'addData' => 'handleAddData'];

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
    public function refreshData()
    {
        $this->x = 0;
        $this->currentPage = 1;
    }
    public function decline($id)
    {
        $user = User::findorFail($id);
        $user->delete();
    }
    public function updateData($data)
    {
        $user = User::findOrFail($data['id']); // Use square brackets to access data
        $user->update([
            'name' => $data['title'] . ' ' . $data['firstname'],
            'middle_name' => $data['middlename'],
            'last_name' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'department' => $data['department'],
            'role' => $data['role']
        ]);

        $this->emit('afterUpdateData');
    }

    public function handleupdateData($data)
    {
        $this->updateData($data);
    }
    public function addData($data)
    {
     

        $newAccount = new User;
        $newAccount->name = $data['addtitle'] . ' ' . $data['addfirstname'];
        $newAccount->middle_name = $data['addmiddlename'];
        $newAccount->last_name = $data['addlastname'];
        $newAccount->username = $data['addusername'];
        $newAccount->password = $data['addpassword'];
        $newAccount->email = $data['addemail'];
        $newAccount->department = $data['adddepartment'];
        $newAccount->role = $data['addrole'];
        $newAccount->approval = 1;
        $newAccount->email_verified_at = now(); // Corrected timestamp function call
        $newAccount->save();
        

        $this->emit('afterAddData');
    }

    public function handleAddData($data)
    {
        $this->addData($data);
    }
    public function render()
    {
        switch ($this->x) {
            case 0:
                $allusers = User::query()
                    ->where('approval', 1)
                    ->where('role', '!=', 'Admin')
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
                break;
            case 1:
                $allusers = User::query()
                    ->where('approval', 1)
                    ->where('name', 'like', "%$this->inputSearch%")
                    ->orWhere('middle_name', 'like', "%$this->inputSearch%")
                    ->orWhere('last_name', 'like', "%$this->inputSearch%")
                    ->where('role', '!=', 'Admin')
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                break;
            case 2:
                $allusers = User::query()
                    ->where('approval', 1)
                    ->where('email', 'like', "%$this->inputSearch%")
                    ->where('role', '!=', 'Admin')
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
                break;
            case 3:
                $allusers = User::query()
                    ->where('approval', 1)
                    ->where('department', 'like', "%$this->inputSearch%")
                    ->where('role', '!=', 'Admin')
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
                break;
            default:

                break;
        }

        return view('livewire.edit-account', [
            'allusers' => $allusers,
            'totalPages' => $allusers->lastPage(),
        ]);
    }
}
