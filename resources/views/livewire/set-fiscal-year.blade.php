<div>
    <div>

        <div class="m-2 p-2 border" style="width:345px;">
            <div class="text-end">
                <button wire:click="refreshData" type="button" class="btn btn-sm btn-light border small">
                    Refresh
                </button>
            </div>
            <div class="ms-2 small form-label text-secondary fw-bold">
                <label>Find Fiscal Year</label>
            </div>
            <label class="form-label">Search Date</label>
            <div class="input-group date datepicker mb-2" id="searchDatePicker">

                <input type="text" class="form-control" id="searchDate" name="searchDate" placeholder="mm/dd/yyyy" />
                <span class="input-group-append">
                    <span class="input-group-text bg-light d-block">
                        <i class="bi bi-calendar-event-fill"></i>
                    </span>
                </span>
            </div>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
                Please enter a date to find its fiscal year.
            </span>

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


        <div class="container-fluid fiscalcontainer border">
            <table class="approvaltable">
                <thead>
                    <tr>
                        <th class="p-2 text-center bg-light acadname">FISCAL YEAR</th>
                        <th class="p-2 text-center bg-light acadname">FISCAL YEAR START DATE</th>
                        <th class="p-2 text-center bg-light acadname">FISCAL YEAR END DATE</th>
                        <th class="p-2 text-center bg-light editactions">ACTIONS</th>
                        <th class="p-2 text-center bg-light cancel"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($fiscalyears as $fiscalyear)
                    <tr data-id="{{ $fiscalyear->id }}">

                        <td class="p-2 acadname fiscalyear">{{ date('Y', strtotime($fiscalyear->startdate)) . ' - ' . date('Y', strtotime($fiscalyear->enddate)) }}</td>
                        <td class="p-2 acadname fiscalyearstartdate">{{ date('m/d/Y', strtotime($fiscalyear->startdate)) }}</td>
                        <td class="p-2 acadname fiscalyearenddate">{{ date('m/d/Y', strtotime($fiscalyear->enddate)) }}</td>

                        <td class="p-2 editactions">

                            <div class="text-center">

                                <button type="button" class="btn btn-sm btn-outline-primary border editdates">
                                    <b class="small">Edit Dates</b>
                                </button>

                            </div>
                        </td>
                        <td class="p-2 cancel text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger border" wire:click="decline('{{ $fiscalyear->id }}')">
                                <i class="bi bi-trash fs-5"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="fiscalModal" tabindex="-1" aria-labelledby="fiscalModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fiscalModalLabel">Edit Dates for </h5><span class="fs-4" id="fiscalyear"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <input type="hidden" id="fiscalyearid" name="fiscalyearid">

                        <label class="form-label">Fiscal Year Start Date</label>
                        <div class="input-group date datepicker mb-2" id="fiscalStartDatePicker">

                            <input type="text" class="form-control" id="fiscalstartdate" name="fiscalstartdate" placeholder="mm/dd/yyyy" />
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="bi bi-calendar-event-fill"></i>
                                </span>
                            </span>
                        </div>

                        <label class="form-label">Fiscal Year End Date</label>
                        <div class="input-group date datepicker mb-2" id="fiscalEndDatePicker">

                            <input type="text" class="form-control" id="fiscalenddate" name="fiscalenddate" placeholder="mm/dd/yyyy" />
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
                            var fiscalStartDateInput = document.getElementById('fiscalstartdate');
                            var fiscalStartDateValue = fiscalStartDateInput.value;
                            var fiscalStartDate = formatDate(fiscalStartDateValue);

                            var fiscalEndDateInput = document.getElementById('fiscalenddate');
                            var fiscalEndDateValue = fiscalEndDateInput.value;
                            var fiscalEndDate = formatDate(fiscalEndDateValue);



                            var data = {
                                'id': document.getElementById('fiscalyearid').value,
                                'fiscalstartdate': fiscalStartDate,
                                'fiscalenddate': fiscalEndDate,

                            };
                            Livewire.emit('updateData', data, editOrAdd);
                            break;
                        case 'add':
                            var fiscalStartDateInput = document.getElementById('fiscalstartdate');
                            var fiscalStartDateValue = fiscalStartDateInput.value;
                            var fiscalStartDate = formatDate(fiscalStartDateValue);

                            var fiscalEndDateInput = document.getElementById('fiscalenddate');
                            var fiscalEndDateValue = fiscalEndDateInput.value;
                            var fiscalEndDate = formatDate(fiscalEndDateValue);


                            var data = {
                                'fiscalstartdate': fiscalStartDate,
                                'fiscalenddate': fiscalEndDate,

                            };
                            Livewire.emit('updateData', data, editOrAdd);
                            break;

                    }
                });

                function formatDate(inputDate) {
                    // Split the inputDate by the '/' character
                    var parts = inputDate.split('/');

                    // Rearrange the parts into the "YYYY-MM-DD" format
                    var formattedDate = parts[2] + '-' + parts[0] + '-' + parts[1];

                    return formattedDate;
                }
                Livewire.on('afterUpdateData', function() {
                    document.getElementById('closeEdit').click();
                });

                btnSearch.addEventListener('click', function() {


                    var searchDateData = formatDate(searchDate.value);


                    if (searchDateData != "") {
                        searchDate.classList.remove('is-invalid');

                        Livewire.emit('findAccount', searchDateData, 1)

                    } else {
                        searchDate.classList.add('is-invalid');
                    }
                });
                searchDate.addEventListener('keydown', function(event) {
                    // Check if the pressed key is "Enter" (key code 13)
                    if (event.keyCode === 13) {

                        var searchDateData = formatDate(searchDate.value);

                        if (searchDateData != "") {
                            searchDate.classList.remove('is-invalid');

                            Livewire.emit('findAccount', searchDateData, 1)

                        } else {
                            searchDate.classList.add('is-invalid');
                        }
                    }
                });
            });
        </script>
    </div>
</div>