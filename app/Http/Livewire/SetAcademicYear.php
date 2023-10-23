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

    public $searchDate;

    protected $listeners = ['findAccount' => 'handleFindAccount', 'updateData' => 'handleupdateData'];
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
        $academicyear = AcademicYear::findorFail($id);
        $academicyear->delete();
    }
    public function updateData($data, $editOrAdd)
    {
        switch ($editOrAdd) {
            case "edit":
                $academicyear = AcademicYear::findOrFail($data['id']); // Use square brackets to access data
                $academicyear->update([
                    'acadstartdate' => $data['aystartdate'],
                    'acadenddate' => $data['ayenddate'],
                    'firstsem_startdate' => $data['firstsemstartdate'],
                    'firstsem_enddate' => $data['firstsemenddate'],
                    'secondsem_startdate' => $data['secondsemstartdate'],
                    'secondsem_enddate' => $data['secondsemenddate'],
                ]);

                $this->emit('afterUpdateData');
                break;
            case "add":
                AcademicYear::create([
                    'acadstartdate' => $data['aystartdate'],
                    'acadenddate' => $data['ayenddate'],
                    'firstsem_startdate' => $data['firstsemstartdate'],
                    'firstsem_enddate' => $data['firstsemenddate'],
                    'secondsem_startdate' => $data['secondsemstartdate'],
                    'secondsem_enddate' => $data['secondsemenddate'],
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
                $academicyears = AcademicYear::query()
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
                break;
            case 1:
                $academicyears = AcademicYear::query()
                    ->orderBy('created_at', 'desc')
                    ->where('acadstartdate', '<=', $this->searchDate)
                    ->where('acadenddate', '>=', $this->searchDate)
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

                break;
            case 2:
                $academicyears = AcademicYear::query()
                    ->orderBy('created_at', 'desc')
                    ->where('firstsem_startdate', '<=', $this->searchDate)
                    ->where('firstsem_enddate', '>=', $this->searchDate)
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
                break;
            case 3:
                $academicyears = AcademicYear::query()
                    ->orderBy('created_at', 'desc')
                    ->where('secondsem_startdate', '<=', $this->searchDate)
                    ->where('secondsem_enddate', '>=', $this->searchDate)
                    ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
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
