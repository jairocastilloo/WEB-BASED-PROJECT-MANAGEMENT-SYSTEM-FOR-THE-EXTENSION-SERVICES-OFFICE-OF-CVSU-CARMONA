<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Program;
use App\Models\ProgramLeader;

class ProgramDetails extends Component
{
    public $indexprogram;
    public $members;
    public $department;
    public $programleaders;


    protected $listeners = ['saveProgramDetails' => 'handleSaveProgramDetails'];
    public function mount($indexprogram, $members)
    {
        $this->indexprogram = $indexprogram;
        $this->members = $members;
        $this->department = $indexprogram->department;
        $this->programleaders = $indexprogram->programleaders;
    }
    public function saveProgramDetails($programDetails)
    {
        $programstartdate = date("Y-m-d", strtotime($programDetails[2]));
        $programenddate = date("Y-m-d", strtotime($programDetails[3]));
        Program::where('id', $this->indexprogram->id)
            ->update([
                'programName' => $programDetails[0],

                'startDate' => $programstartdate,
                'endDate' => $programenddate
            ]);
        ProgramLeader::where('program_id', $this->indexprogram->id)->delete();

        foreach ($programDetails[1] as $userid) {
            ProgramLeader::create(
                [
                    'program_id' => $this->indexprogram->id,
                    'user_id' => $userid,
                ]
            );
        }
        $this->indexprogram = Program::findOrFail($this->indexprogram->id);
        $this->programleaders = $this->indexprogram->programleaders;
    }
    public function handleSaveProgramDetails($programDetails)
    {
        $this->saveProgramDetails($programDetails);
    }


    public function render()
    {
        return view('livewire.program-details');
    }
}
