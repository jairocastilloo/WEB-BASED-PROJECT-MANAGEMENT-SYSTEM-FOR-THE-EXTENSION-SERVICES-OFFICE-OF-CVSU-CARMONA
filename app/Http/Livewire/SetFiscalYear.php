<?php

namespace App\Http\Livewire;

use App\Models\FiscalYear;
use Livewire\Component;

class SetFiscalYear extends Component
{
    public $x = 0;
    public $currentPage = 1; // The current page number
    public $perPage = 10;
    protected $listeners = ['findAccount' => 'handleFindAccount', 'updateData' => 'handleupdateData'];
    public $searchDate;
    public function changePage($page)
    {
        $this->currentPage = $page;
    }
    public function refreshData()
    {
        $this->x = 0;
        $this->currentPage = 1;
    }
    public function decline($id)
    {
        $fiscalyear = FiscalYear::findorFail($id);
        $fiscalyear->delete();
    }
    public function updateData($data, $editOrAdd)
    {
        switch ($editOrAdd) {
            case "edit":
                $fiscalyear = FiscalYear::findOrFail($data['id']); // Use square brackets to access data
                $fiscalyear->update([
                    'fiscalstartdate' => $data['fiscalstartdate'],
                    'fiscalenddate' => $data['fiscalenddate'],

                ]);

                $this->emit('afterUpdateData');
                break;
            case "add":
                FiscalYear::create([
                    'startdate' => $data['fiscalstartdate'],
                    'enddate' => $data['fiscalenddate'],

                ]);
                $this->emit('afterUpdateData');
                break;
        }
    }

    public function handleupdateData($data, $editOrAdd)
    {
        $this->updateData($data, $editOrAdd);
    }
    public function findAccount($searchDate, $x)
    {
        $this->searchDate = $searchDate;
        $this->x = $x;
        $this->currentPage = 1;
    }

    public function handleFindAccount($searchDate, $x)
    {
        $this->findAccount($searchDate, $x);
    }
    public function render()
    {
        switch ($this->x) {
            case 0:
                $fiscalyears = FiscalYear::query()
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
                break;
            case 1:
                $fiscalyears = FiscalYear::query()
                    ->orderBy('created_at', 'desc')
                    ->where('startdate', '<=', $this->searchDate)
                    ->where('enddate', '>=', $this->searchDate)
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

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
