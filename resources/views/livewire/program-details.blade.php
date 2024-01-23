<div>


    @if ($indexprogram != null)
    <div class="flex-container">
        <strong><em>Program Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
        <div class="underline-space inline-div ps-2">{{ $indexprogram['programName'] }}</div>
    </div>
    @endif
    @if ($programleaders != null)
    <div class="flex-container">
        <strong><em>Program Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
        <div class="underline-space inline-div ps-2">

            @foreach ($programleaders as $programleader)
            {{ ucfirst($programleader->last_name) }}, {{ ucfirst($programleader->name) }}

            @if ($programleader->middle_name)
            {{ substr(ucfirst($programleader->middle_name), 0, 1) }}.
            @else
            {{ "N/A." }}
            @endif

            @if (!$loop->last)
            ,
            @endif
            @endforeach

        </div>


    </div>
    @endif

    <div class="flex-container">
        <strong><em>Duration:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
        <div class="underline-space inline-div ps-2">
            {{ date('F Y', strtotime($indexprogram['startDate'])) . '-' . date('F Y', strtotime($indexprogram['endDate'])) }}
        </div>
    </div>


    @if ($indexprogram != null)
    <input value="{{ $indexprogram['programName'] }}" id="progTitle" name="progTitle" type="hidden">
    @endif

    <div class="modal fade" id="editProgramModal" tabindex="-1" aria-labelledby="editProgramModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProgramModalLabel">Edit Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for creating a new program -->
                    <form>


                        <div class="mb-3">
                            <label for="currentprogramtitle" class="form-label">Program Title </label>
                            <input type="text" class="form-control autocapital" id="currentprogramtitle"
                                name="currentprogramtitle" value="{{ $indexprogram['programName'] }}">

                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        @php
                        $programleadersIds = $programleaders->pluck('id')->all();
                        @endphp
                        <div class="container mb-3 p-0">
                            <label for="currentprogramleader" class="form-label">Program Leader</label>
                            <select class="selectpicker w-100 border" name="currentprogramleader[]"
                                id="currentprogramleader" multiple aria-label="Select Program Leaders"
                                data-live-search="true">
                                <option value="0" disabled>Select Program Leader</option>
                                @foreach ($members as $member)
                                @if ($member->role === 'Admin')
                                <option value="{{ $member->id }}" @if(in_array($member->id, $programleadersIds))
                                    selected
                                    @endif>
                                    {{ $member->last_name . ', ' . $member->name . ' ' . ($member->middle_name ? $member->middle_name[0] : 'N/A') . '.' }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="currentprogramstartdate" class="form-label">Program Start Date</label>

                            <div class="input-group date" id="programstartDatePicker">
                                <input type="text" class="form-control" id="currentprogramstartdate"
                                    name="currentprogramstartdate" placeholder="mm/dd/yyyy"
                                    value="{{ date('m/d/Y', strtotime($indexprogram['startDate'])) }}" />


                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="bi bi-calendar-event-fill"></i>
                                    </span>
                                </span>
                            </div>
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>


                            <!--<input type="date" class="form-control" id="projectstartdate" name="projectstartdate">-->


                        </div>

                        <div class="mb-3">
                            <label for="currentprogramenddate" class="form-label">Program End Date</label>

                            <div class="input-group date" id="currentprogramendDatePicker">
                                <input type="text" class="form-control" id="currentprogramenddate"
                                    name="currentprogramenddate" placeholder="mm/dd/yyyy"
                                    value="{{ date('m/d/Y', strtotime($indexprogram['endDate'])) }}" />

                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="bi bi-calendar-event-fill"></i>
                                    </span>
                                </span>
                            </div>

                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <span class="text-danger" id="editProgramError">
                        <strong></strong>
                    </span>
                    <span class="ms-2 small loadingMessage" id="currenteditprogramloadingSpan"
                        style="display: none;">Sending Email..</span>
                    <button type="button" class="btn btn-md rounded border border-1 btn-light shadow" id="closeDetails"
                        data-bs-dismiss="modal"><b class="small">Close</b></button>

                    <button type="button" class="btn btn-md rounded btn-gold shadow" id="btn-confirmDetails">
                        <b class="small">Confirm</b>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <script>
    var titleNgProgram = document.getElementById('progTitle').value;
    document.addEventListener('livewire:load', function() {

        btnConfirmDetails = document.getElementById('btn-confirmDetails');

        btnConfirmDetails.addEventListener('click', function() {
            var hasError = handleError();
            if (!hasError) {

                var valProgramTitle = document.getElementById("currentprogramtitle").value;
                var valProgramLeaders = [];
                var programLeaderSelect = document.getElementById("currentprogramleader");
                for (var i = 0; i < programLeaderSelect.options.length; i++) {
                    if (programLeaderSelect.options[i].selected) {
                        valProgramLeaders.push(programLeaderSelect.options[i].value);
                    }
                }
                var valProgramStartDate = document.getElementById("currentprogramstartdate").value;
                var valProgramEndDate = document.getElementById("currentprogramenddate").value;
                var programDetails = [
                    valProgramTitle,
                    valProgramLeaders,
                    valProgramStartDate,
                    valProgramEndDate,


                ];
                document.getElementById('closeDetails').click();


                Livewire.emit('saveProgramDetails', programDetails);
            }


        });

        function handleError() {
            var hasErrors = false;

            document.querySelectorAll('.invalid-feedback strong').forEach(function(strong) {
                strong.textContent = '';
            });

            document.querySelectorAll('.is-invalid').forEach(function(element) {
                element.classList.remove('is-invalid');
            });

            var programTitle = document.getElementById('currentprogramtitle').value;
            var programLeader = document.getElementById('currentprogramleader').options;

            var programStartDate = formatDate(document.getElementById('currentprogramstartdate').value);
            var programEndDate = formatDate(document.getElementById('currentprogramenddate').value);



            // Validation for Project Title
            if (programTitle.trim() === '') {
                document.getElementById('currentprogramtitle').classList.add('is-invalid');
                document.getElementById('currentprogramtitle').nextElementSibling.querySelector(
                    '.invalid-feedback strong').textContent = 'Program Title is required.';
                hasErrors = true;
            }

            // Validation for Project Leader
            if (programLeader.length === 0) {
                document.getElementById('currentprogramleader').classList.add('is-invalid');
                document.getElementById('currentprogramleader').nextElementSibling.querySelector(
                    '.invalid-feedback strong').textContent = 'Program Leader is required.';
                hasErrors = true;
            }

            // Validation for Project Start Date
            if (document.getElementById('currentprogramstartdate').value === '') {
                document.getElementById('currentprogramstartdate').parentElement.classList.add('is-invalid');
                document.getElementById('currentprogramstartdate').parentElement.nextElementSibling
                    .querySelector('.invalid-feedback strong').textContent = 'Program Start Date is required.';
                hasErrors = true;
            }

            // Validation for Project End Date
            if (document.getElementById('currentprogramenddate').value === '') {

                document.getElementById('currentprogramenddate').parentElement.classList.add('is-invalid');
                document.getElementById('currentprogramenddate').parentElement.nextElementSibling.querySelector(
                    '.invalid-feedback strong').textContent = 'Program End Date is required.';
                hasErrors = true;
            }

            // Check if End Date is after Start Date
            if (programEndDate <= programStartDate) {
                document.getElementById('currentprogramenddate').parentElement.classList.add('is-invalid');
                document.getElementById('currentprogramenddate').parentElement.nextElementSibling.querySelector(
                        '.invalid-feedback strong').textContent =
                    'Program End Date must be after the Start Date.';
                hasErrors = true;
            }

            return hasErrors;
        }

        function formatDate(inputDate) {
            // Split the inputDate by the '/' character
            var parts = inputDate.split('/');

            // Rearrange the parts into the "YYYY-MM-DD" format
            var formattedDate = parts[2] + '-' + parts[0] + '-' + parts[1];

            return formattedDate;
        }
    });
    </script>
</div>