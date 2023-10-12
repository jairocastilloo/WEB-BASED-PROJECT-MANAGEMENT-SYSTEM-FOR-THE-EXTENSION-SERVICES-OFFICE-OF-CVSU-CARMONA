<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class EditAccount extends Component
{
    public $allusers;
    protected $listeners = ['updateData' => 'handleupdateData'];

    public function mount($allusers)
    {
        $this->allusers = $allusers;
    }
    public function delete($id)
    {
        $user = User::findorFail($id);
        $user->delete();
        $this->allusers = User::where('approval', 1)
            ->where('role', '!=', 'Admin')
            ->get();
    }
    public function updateData($data)
    {
        $user = User::findOrFail($data['id']); // Use square brackets to access data
        $user->update([
            'name' => $data['firstname'],
            'middle_name' => $data['middlename'],
            'last_name' => $data['lastname'],
            'username' => $data['username'],
            'department' => $data['department'],
            'role' => $data['role']
        ]);
        $this->allusers = User::where('approval', 1)
            ->where('role', '!=', 'Admin')
            ->get();
        $this->emit('afterUpdateData');
    }

    public function handleupdateData($data)
    {
        $this->updateData($data);
    }
    public function render()
    {
        return view('livewire.edit-account');
    }
}
