<?php

namespace App\Http\Livewire;

use App\Models\FiscalYear;
use Livewire\Component;

class SetFiscalYear extends Component
{
    public $x = 0;
    public $currentPage = 1; // The current page number
    public $perPage = 10;
    public function render()
    {
        switch ($this->x) {
            case 0:
                $fiscalyears = FiscalYear::query()
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

        return view('livewire.set-fiscal-year', [
            'fiscalyears' => $fiscalyears,
            'totalPages' => $fiscalyears->lastPage(),
        ]);
    }
}
