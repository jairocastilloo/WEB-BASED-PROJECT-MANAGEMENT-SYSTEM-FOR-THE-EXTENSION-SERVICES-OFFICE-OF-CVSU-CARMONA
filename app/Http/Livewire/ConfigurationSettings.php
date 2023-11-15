<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ConfigurationSettings extends Component
{
    public $last_name;
    public $middle_name;
    public $name;
    public $username;
    protected $password;
    public $fontSize;
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

    protected $listeners = [
        'updateProfile' => 'handleupdateProfile',
        'updateNotification' => 'handleupdateNotification',
        'updateEmailForwarding' => 'handleupdateEmailForwarding',
        'updateDisplay' => 'handleupdateDisplay'
    ];
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

        $this->fontSize = $user->fontSize;
    }
    public function updateProfile($profileData)
    {
        try {
            $user = User::where('username', $this->username)->first();
            $user->update([
                'name' => $profileData['firstName'],
                'middle_name' => $profileData['middleName'],
                'last_name' => $profileData['lastName'],
                'bio' => $profileData['bio'],
                'social' => $profileData['socialProfile']
            ]);
            $this->name = $user->name;
            $this->middle_name = $user->middle_name;
            $this->last_name = $user->last_name;
            $this->bio = $user->bio;
            $this->social = $user->social;
            $this->emit('updateProfileSuccess');
        } catch (\Exception $e) {
            $this->emit('updateProfileFailed', $e->getMessage());
        }
    }

    public function handleupdateProfile($profileData)
    {
        $this->updateProfile($profileData);
    }

    public function updateNotification($notificationData)
    {
        try {
            $user = User::where('username', $this->username)->first();
            $user->update([
                'notifyInSubtaskDue' => $notificationData['notifyInSubtaskDue'],
                'notifyInActivityDue' => $notificationData['notifyInActivityDue'],
                'notifyInProjectDue' => $notificationData['notifyInProjectDue'],
                'notifyInSubtaskToDo' => $notificationData['notifyInSubtaskToDo'],
                'notifyInActivityStart' => $notificationData['notifyInActivityStart'],
                'notifyInProjectStart' => $notificationData['notifyInProjectStart'],
                'notifySubtaskAdded' => $notificationData['notifySubtaskAdded'],
                'notifyActivityAdded' => $notificationData['notifyActivityAdded'],
                'notifyProjectAdded' => $notificationData['notifyProjectAdded'],
            ]);
            $this->notifyInSubtaskDue = $user->notifyInSubtaskDue;
            $this->notifyInActivityDue = $user->notifyInActivityDue;
            $this->notifyInProjectDue = $user->notifyInProjectDue;
            $this->notifyInSubtaskToDo = $user->notifyInSubtaskToDo;
            $this->notifyInActivityStart = $user->notifyInActivityStart;
            $this->notifyInProjectStart = $user->notifyInProjectStart;
            $this->notifySubtaskAdded = $user->notifySubtaskAdded;
            $this->notifyActivityAdded = $user->notifyActivityAdded;
            $this->notifyProjectAdded = $user->notifyProjectAdded;
            $this->emit('updateNotificationSuccess');
        } catch (\Exception $e) {
            $this->emit('updateNotificationFailed', $e->getMessage());
        }
    }

    public function handleupdateNotification($notificationData)
    {
        $this->updateNotification($notificationData);
    }

    public function updateEmailForwarding($emailForwardingData)
    {
        try {
            $user = User::where('username', $this->username)->first();
            $user->update([
                'emailSubtaskAdded' => $emailForwardingData['emailSubtaskAdded'],
                'emailActivityAdded' => $emailForwardingData['emailActivityAdded'],
                'emailProjectAdded' => $emailForwardingData['emailProjectAdded'],
            ]);
            $this->emailSubtaskAdded = $user->emailSubtaskAdded;
            $this->emailActivityAdded = $user->emailActivityAdded;
            $this->emailProjectAdded = $user->emailProjectAdded;

            $this->emit('updateEmailForwardingSuccess');
        } catch (\Exception $e) {
            $this->emit('updateEmailForwardingFailed', $e->getMessage());
        }
    }

    public function handleupdateEmailForwarding($emailForwardingData)
    {
        $this->updateEmailForwarding($emailForwardingData);
    }
    public function updateDisplay($displayData)
    {
        try {
            $user = User::where('username', $this->username)->first();
            $user->update([
                'fontSize' => $displayData['fontSize'],
            ]);
            $this->fontSize = $user->fontSize;
            $this->emit('updateDisplaySuccess');
        } catch (\Exception $e) {
            $this->emit('updateDisplayFailed', $e->getMessage());
        }
    }

    public function handleupdateDisplay($displayData)
    {
        $this->updateDisplay($displayData);
    }

    public function render()
    {
        return view('livewire.configuration-settings');
    }
}
