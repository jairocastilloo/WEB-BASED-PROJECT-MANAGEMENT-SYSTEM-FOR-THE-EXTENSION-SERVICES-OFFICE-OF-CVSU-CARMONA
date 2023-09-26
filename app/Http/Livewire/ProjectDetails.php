<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProjectDetails extends Component
{
    public $indexproject;
    public $projectid;
    protected $listeners = ['saveMembers' => 'handleSaveMembers', 'sendNotification' => 'handleSendNotification'];
    public function mount($indexproject, $projectid)
    {
        $this->indexproject = $indexproject;
        $this->projectid = $projectid;
    }

    public function render()
    {
        return view('livewire.project-details');
    }
}
