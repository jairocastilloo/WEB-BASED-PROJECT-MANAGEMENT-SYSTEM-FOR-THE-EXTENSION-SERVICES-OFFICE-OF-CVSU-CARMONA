<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EditAccount extends Component
{
    public $allusers;

    public function mount($allusers)
    {
        $this->allusers = $allusers;
    }
    public function render()
    {
        return view('livewire.edit-account');
    }
}
