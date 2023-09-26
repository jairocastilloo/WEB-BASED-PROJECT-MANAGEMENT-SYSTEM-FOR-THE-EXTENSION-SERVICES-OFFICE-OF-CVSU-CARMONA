<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProjectDetails extends Component
{
    public $indexproject;
    public $members;
    protected $listeners = ['saveMembers' => 'handleSaveMembers', 'sendNotification' => 'handleSendNotification'];
    public function mount($indexproject, $members)
    {
        $this->indexproject = $indexproject;
        $this->members = $members;
    }

    public function render()
    {
        return view('livewire.project-details');
    }
}
