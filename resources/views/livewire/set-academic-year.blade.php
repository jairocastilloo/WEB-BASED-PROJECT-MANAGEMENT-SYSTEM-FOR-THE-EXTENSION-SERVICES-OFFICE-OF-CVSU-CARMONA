<div>

    <div class="m-2 p-2 border" style="width:345px;">
        <div class="text-end">
            <button wire:click="refreshData" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        <div class="ms-2 small form-label text-secondary fw-bold">
            <label>Find Academic Year</label>
        </div>
        <label class="form-label">Search Date</label>
        <div class="input-group date datepicker mb-2">

            <input type="text" class="form-control" id="searchDate" name="searchDate" placeholder="mm/dd/yyyy" />
            <span class="input-group-append">
                <span class="input-group-text bg-light d-block">
                    <i class="bi bi-calendar-event-fill"></i>
                </span>
            </span>
        </div>
        <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
            Please enter a date to find its academic year.
        </span>
        <div class="mt-2 text-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input border border-success" type="radio" name="searchCriteria" id="searchByAcademicYear" value="academic-year" checked>
                <label class="form-check-label" for="searchByAcademicYear">Academic Year</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input border border-success" type="radio" name="searchCriteria" id="searchByFirstSemester" value="first-semester">
                <label class="form-check-label" for="searchByFirstSemester">First Semester</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input border border-success" type="radio" name="searchCriteria" id="searchBySecondSemester" value="second-semester">
                <label class="form-check-label" for="searchBySecondSemester">Second Semester</label>
            </div>
        </div>
        <div class="text-end">
            <button type="button" class="btn btn-primary" id="btnSearch">Search</button>
        </div>

    </div>


    <div class="text-center">
        <button type="button" class="btn btn-success" id="addDates">Set a New Dates</button>
    </div>
    <input type="hidden" id="editOrAdd">

    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" wire:click="changePage(1)">First</a>
            </li>
            @if ($currentPage === 1)
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-compact-left"></i></span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" wire:click="changePage({{ $currentPage - 1 }})" rel="prev"><i class="bi bi-chevron-compact-left"></i></a>
            </li>
            @endif

            @for ($i = 1; $i <= $totalPages; $i++) <li class="page-item {{ $i === $currentPage ? 'active disabled' : '' }}" aria-current="{{ $i === $currentPage ? 'page' : '' }}">
                <a class="page-link" wire:click="changePage({{ $i }})">{{ $i }}</a>
                </li>
                @endfor

                @if ($currentPage === $totalPages)
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-compact-right"></i></span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" wire:click="changePage({{ $currentPage + 1 }})"><i class="bi bi-chevron-compact-right"></i></a>
                </li>
                @endif
                <li class="page-item">
                    <a class="page-link" wire:click="changePage({{ $totalPages }})">Last</a>
                </li>
        </ul>
    </nav>


    <div class="container-fluid approvalcontainer">
        <table class="approvaltable">
            <thead>
                <tr>
                    <th class="p-2 text-center bg-light acadname">ACADEMIC YEAR</th>
                    <th class="p-2 text-center bg-light acadname">ACADEMIC YEAR START DATE</th>
                    <th class="p-2 text-center bg-light acadname">ACADEMIC YEAR END DATE</th>
                    <th class="p-2 text-center bg-light acadname">FIRST SEMESTER START DATE</th>
                    <th class="p-2 text-center bg-light acadname">FIRST SEMESTER END DATE</th>
                    <th class="p-2 text-center bg-light acadname">SECOND SEMESTER START DATE</th>
                    <th class="p-2 text-center bg-light acadname">SECOND SEMESTER END DATE</th>
                    <th class="p-2 text-center bg-light editactions">ACTIONS</th>
                    <th class="p-2 text-center bg-light cancel"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($academicyears as $academicyear)
                <tr data-id="{{ $academicyear->id }}">

                    <td class="p-2 acadname academicyear">{{ date('Y', strtotime($academicyear->acadstartdate)) . ' - ' . date('Y', strtotime($academicyear->acadenddate)) }}</td>
                    <td class="p-2 acadname academicyearstartdate">{{ date('m/d/Y', strtotime($academicyear->acadstartdate)) }}</td>
                    <td class="p-2 acadname academicyearenddate">{{ date('m/d/Y', strtotime($academicyear->acadenddate)) }}</td>
                    <td class="p-2 acadname firstsemstartdate">{{ date('m/d/Y', strtotime($academicyear->firstsem_startdate)) }}</td>
                    <td class="p-2 acadname firstsemenddate">{{ date('m/d/Y', strtotime($academicyear->firstsem_enddate)) }}</td>
                    <td class="p-2 acadname secondsemstartdate">{{ date('m/d/Y', strtotime($academicyear->secondsem_startdate)) }}</td>
                    <td class="p-2 acadname secondsemenddate">{{ date('m/d/Y', strtotime($academicyear->secondsem_enddate)) }}</td>
                    <td class="p-2 editactions">

                        <div class="text-center">

                            <button type="button" class="btn btn-sm btn-outline-primary border editdates">
                                <b class="small">Edit Dates</b>
                            </button>

                        </div>
                    </td>
                    <td class="p-2 cancel text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger border" wire:click="decline('{{ $academicyear->id }}')">
                            <i class="bi bi-trash fs-5"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="AYModal" tabindex="-1" aria-labelledby="AYModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AYModalLabel">Edit Dates for </h5><span class="fs-4" id="academicyear"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <input type="hidden" id="academicyearid" name="academicyearid">

                    <label class="form-label">Academic Year Start Date</label>
                    <div class="input-group date datepicker mb-2">

                        <input type="text" class="form-control" id="aystartdate" name="aystartdate" placeholder="mm/dd/yyyy" />
                        <span class="input-group-append">
                            <span class="input-group-text bg-light d-block">
                                <i class="bi bi-calendar-event-fill"></i>
                            </span>
                        </span>
                    </div>

                    <label class="form-label">Academic Year End Date</label>
                    <div class="input-group date datepicker mb-2">

                        <input type="text" class="form-control" id="ayenddate" name="ayenddate" placeholder="mm/dd/yyyy" />
                        <span class="input-group-append">
                            <span class="input-group-text bg-light d-block">
                                <i class="bi bi-calendar-event-fill"></i>
                            </span>
                        </span>
                    </div>

                    <label class="form-label">First Semester Start Date</label>
                    <div class="input-group date datepicker mb-2">

                        <input type="text" class="form-control" id="firstsemstartdate" name="firstsemstartdate" placeholder="mm/dd/yyyy" />
                        <span class="input-group-append">
                            <span class="input-group-text bg-light d-block">
                                <i class="bi bi-calendar-event-fill"></i>
                            </span>
                        </span>
                    </div>

                    <label class="form-label">First Semester End Date</label>
                    <div class="input-group date datepicker mb-2">

                        <input type="text" class="form-control" id="firstsemenddate" name="firstsemenddate" placeholder="mm/dd/yyyy" />
                        <span class="input-group-append">
                            <span class="input-group-text bg-light d-block">
                                <i class="bi bi-calendar-event-fill"></i>
                            </span>
                        </span>
                    </div>
                    <label class="form-label">Second Semester Start Date</label>
                    <div class="input-group date datepicker mb-2">

                        <input type="text" class="form-control" id="secondsemstartdate" name="secondsemstartdate" placeholder="mm/dd/yyyy" />
                        <span class="input-group-append">
                            <span class="input-group-text bg-light d-block">
                                <i class="bi bi-calendar-event-fill"></i>
                            </span>
                        </span>
                    </div>
                    <label class="form-label">Second Semester End Date</label>
                    <div class="input-group date datepicker mb-2">

                        <input type="text" class="form-control" id="secondsemenddate" name="secondsemenddate" placeholder="mm/dd/yyyy" />
                        <span class="input-group-append">
                            <span class="input-group-text bg-light d-block">
                                <i class="bi bi-calendar-event-fill"></i>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeEdit">Close</button>
                    <button type="submit" class="btn btn-primary" id="confirmEditDates">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {

            const confirmEditDates = document.getElementById('confirmEditDates');
            const searchDate = document.getElementById('searchDate');
            const btnSearch = document.getElementById('btnSearch');
            confirmEditDates.addEventListener('click', function() {
                var editOrAdd = document.getElementById('editOrAdd').value;
                switch (editOrAdd) {
                    case 'edit':
                        var ayStartDateInput = document.getElementById('aystartdate');
                        var ayStartDateValue = ayStartDateInput.value;
                        var ayStartDate = formatDate(ayStartDateValue);

                        var ayEndDateInput = document.getElementById('ayenddate');
                        var ayEndDateValue = ayEndDateInput.value;
                        var ayEndDate = formatDate(ayEndDateValue);

                        var firstSemStartDateInput = document.getElementById('firstsemstartdate');
                        var firstSemStartDateValue = firstSemStartDateInput.value;
                        var firstSemStartDate = formatDate(firstSemStartDateValue);

                        var firstSemEndDateInput = document.getElementById('firstsemenddate');
                        var firstSemEndDateValue = firstSemEndDateInput.value;
                        var firstSemEndDate = formatDate(firstSemEndDateValue);

                        var secondSemStartDateInput = document.getElementById('secondsemstartdate');
                        var secondSemStartDateValue = secondSemStartDateInput.value;
                        var secondSemStartDate = formatDate(secondSemStartDateValue);

                        var secondSemEndDateInput = document.getElementById('secondsemenddate');
                        var secondSemEndDateValue = secondSemEndDateInput.value;
                        var secondSemEndDate = formatDate(secondSemEndDateValue);

                        var data = {
                            'id': document.getElementById('academicyearid').value,
                            'aystartdate': ayStartDate,
                            'ayenddate': ayEndDate,
                            'firstsemstartdate': firstSemStartDate,
                            'firstsemenddate': firstSemEndDate,
                            'secondsemstartdate': secondSemStartDate,
                            'secondsemenddate': secondSemEndDate,
                        };
                        Livewire.emit('updateData', data, editOrAdd);
                        break;
                    case 'add':
                        var ayStartDateInput = document.getElementById('aystartdate');
                        var ayStartDateValue = ayStartDateInput.value;
                        var ayStartDate = formatDate(ayStartDateValue);

                        var ayEndDateInput = document.getElementById('ayenddate');
                        var ayEndDateValue = ayEndDateInput.value;
                        var ayEndDate = formatDate(ayEndDateValue);

                        var firstSemStartDateInput = document.getElementById('firstsemstartdate');
                        var firstSemStartDateValue = firstSemStartDateInput.value;
                        var firstSemStartDate = formatDate(firstSemStartDateValue);

                        var firstSemEndDateInput = document.getElementById('firstsemenddate');
                        var firstSemEndDateValue = firstSemEndDateInput.value;
                        var firstSemEndDate = formatDate(firstSemEndDateValue);

                        var secondSemStartDateInput = document.getElementById('secondsemstartdate');
                        var secondSemStartDateValue = secondSemStartDateInput.value;
                        var secondSemStartDate = formatDate(secondSemStartDateValue);

                        var secondSemEndDateInput = document.getElementById('secondsemenddate');
                        var secondSemEndDateValue = secondSemEndDateInput.value;
                        var secondSemEndDate = formatDate(secondSemEndDateValue);

                        var data = {
                            'aystartdate': ayStartDate,
                            'ayenddate': ayEndDate,
                            'firstsemstartdate': firstSemStartDate,
                            'firstsemenddate': firstSemEndDate,
                            'secondsemstartdate': secondSemStartDate,
                            'secondsemenddate': secondSemEndDate,
                        };
                        Livewire.emit('updateData', data, editOrAdd);
                        break;

                }
            });

            function formatDate(inputDate) {
                var parsedDate = new Date(inputDate);
                var formattedDate = parsedDate.toISOString().slice(0, 10);
                return formattedDate;
            }
            Livewire.on('afterUpdateData', function() {
                document.getElementById('closeEdit').click();
            });

            btnSearch.addEventListener('click', function() {
                const searchCriteria = document.querySelector('input[name="searchCriteria"]:checked').value;

                var searchDateData = formatDate(searchDate.value);

                if (searchDateData != "") {
                    searchDate.classList.remove('is-invalid');
                    switch (searchCriteria) {
                        case 'academic-year':
                            Livewire.emit('findAccount', searchDateData, 1)
                            break;
                        case 'first-semester':
                            Livewire.emit('findAccount', searchDateData, 2)
                            break;
                        case 'second-semester':
                            Livewire.emit('findAccount', searchDateData, 3)
                            break;
                        default:
                            // Handle the default case or show an error message
                            break;
                    }
                } else {
                    searchDate.classList.add('is-invalid');
                }
            });
            searchDate.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
                    const searchCriteria = document.querySelector('input[name="searchCriteria"]:checked').value;
                    var searchDateData = formatDate(searchDate.value);

                    if (searchDateData != "") {
                        searchDate.classList.remove('is-invalid');
                        switch (searchCriteria) {
                            case 'academic-year':
                                Livewire.emit('findAccount', searchDateData, 1)
                                break;
                            case 'first-semester':
                                Livewire.emit('findAccount', searchDateData, 2)
                                break;
                            case 'second-semester':
                                Livewire.emit('findAccount', searchDateData, 3)
                                break;
                            default:
                                // Handle the default case or show an error message
                                break;
                        }
                    } else {
                        searchDate.classList.add('is-invalid');
                    }
                }
            });
        });
    </script>
</div>