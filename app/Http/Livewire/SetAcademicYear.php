<?php

namespace App\Http\Livewire;

use App\Models\AcademicYear;
use Livewire\Component;

class SetAcademicYear extends Component
{
    public $x = 0;
    public $inputSearch = '';
    public $currentPage = 1; // The current page number
    public $perPage = 1;

    public function changePage($page)
    {
        $this->currentPage = $page;
    }
    public function refreshData()
    {
        $this->x = 0;
        $this->currentPage = 1;
    }
    public function render()
    {

        switch ($this->x) {
            case 0:
                $academicyears = AcademicYear::query()
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

        return view('livewire.set-academic-year', [
            'academicyears' => $academicyears,
            'totalPages' => $academicyears->lastPage(),
        ]);
    }
}
