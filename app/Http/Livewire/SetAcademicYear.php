<?php

namespace App\Http\Livewire;

use App\Models\AcademicYear;
use Livewire\Component;

class SetAcademicYear extends Component
{
    public $x = 0;
    public $inputSearch = '';
    public $currentPage = 1; // The current page number
    public $perPage = 10;
    public function render()
    {
        $academicyears = AcademicYear::query()
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
        return view('livewire.set-academic-year', [
            'academicyears' => $academicyears,
            'totalPages' => $academicyears->lastPage(),
        ]);
    }
}
