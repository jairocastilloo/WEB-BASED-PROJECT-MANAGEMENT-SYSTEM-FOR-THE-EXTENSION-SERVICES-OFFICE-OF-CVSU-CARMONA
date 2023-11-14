<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ConfigurationSettings extends Component
{
    public $last_name;
    public $middle_name;
    public $name;
    public $username;
    protected $password;
    public $darkMode;
    public $bio;
    public $social;

    public $notifyInSubtaskDue,
        $notifyInActivityDue,
        $notifyInProjectDue,
        $notifyInSubtaskToDo,
        $notifyInActivityStart,
        $notifyInProjectStart,
        $notifySubtaskAdded,
        $notifyActivityAdded,
        $notifyProjectAdded,
        $emailSubtaskAdded,
        $emailActivityAdded,
        $emailProjectAdded;


    public function mount($user)
    {
        $this->last_name = $user->last_name;
        $this->middle_name = $user->middle_name;
        $this->name = $user->name;
        $this->bio = $user->bio;
        $this->social = $user->social;

        $this->notifyInSubtaskDue = $user->notifyInSubtaskDue;
        $this->notifyInActivityDue = $user->notifyInActivityDue;
        $this->notifyInProjectDue = $user->notifyInProjectDue;
        $this->notifyInSubtaskToDo = $user->notifyInSubtaskToDo;
        $this->notifyInActivityStart = $user->notifyInActivityStart;
        $this->notifyInProjectStart = $user->notifyInProjectStart;
        $this->notifySubtaskAdded = $user->notifySubtaskAdded;
        $this->notifyActivityAdded = $user->notifyActivityAdded;
        $this->notifyProjectAdded = $user->notifyProjectAdded;
        $this->emailSubtaskAdded = $user->emailSubtaskAdded;
        $this->emailActivityAdded = $user->emailActivityAdded;
        $this->emailProjectAdded = $user->emailProjectAdded;

        $this->username = $user->username;

        $this->darkMode = $user->darkMode;
    }
    public function render()
    {
        return view('livewire.configuration-settings');
    }
}
