<div>
    <div class="text-center">
        @foreach ($allfiscalyears as $allfiscalyear)
        @if (($indexproject->projectstartdate >= $allfiscalyear['startdate'] && $indexproject->projectstartdate <=
            $allfiscalyear['enddate']) || ($indexproject->projectenddate >= $allfiscalyear['startdate'] &&
            $indexproject->projectenddate <= $allfiscalyear['enddate']) || ($indexproject->projectstartdate
                <=$allfiscalyear['startdate'] && $indexproject->projectenddate>= $allfiscalyear['enddate']))
                    <p class="m-0">
                        FY&nbsp;<u>{{ date('Y', strtotime($allfiscalyear['startdate'])) . '-' . date('Y', strtotime($allfiscalyear['enddate'])) }}
                        </u></p>

                    @endif

                    @endforeach


    </div>

    @if ($indexproject['programtitle'] != "")
    <div class="flex-container">
        <strong><em>Program Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
        <div class="underline-space inline-div ps-2">{{ $indexproject['programtitle'] }}</div>
    </div>
    @endif
    @if ($programleaders->isNotEmpty())
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
        <strong><em>Project Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
        <div class="underline-space inline-div ps-2">{{ $indexproject['projecttitle'] }}</div>
    </div>
    <div class="flex-container">
        <strong><em>Project Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
        <div class="underline-space inline-div ps-2">
            @foreach ($projectleaders as $projectleader)
            {{ ucfirst($projectleader->last_name) }}, {{ ucfirst($projectleader->name) }}

            @if ($projectleader->middle_name)
            {{ substr(ucfirst($projectleader->middle_name), 0, 1) }}.
            @else
            {{ "N/A." }}
            @endif

            @if (!$loop->last)
            ,
            @endif
            @endforeach


        </div>
    </div>
    <div class="flex-container">
        <strong><em>Duration:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
        <div class="underline-space inline-div ps-2">
            {{ date('F Y', strtotime($indexproject['projectstartdate'])) . '-' . date('F Y', strtotime($indexproject['projectenddate'])) }}
        </div>
    </div>

    <!-- New Project -->
    @if (Auth::user()->role === 'Admin')
    <div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProject">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <label for="currentprojectdetails" class="form-label mt-2 mx-auto">
                        Input all the changes for project details.
                    </label>
                    @if ($indexproject->programtitle != null)
                    <div class="mb-3">
                        <label for="programtitle" class="form-label">Program Title</label>
                        <input type="text" class="form-control autocapital" id="currentprogramtitle"
                            name="currentprogramtitle" value="{{ $indexproject->programtitle }}">

                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    @endif
                    @if ($programleaders->isNotEmpty())
                    <div class="container mb-3 p-0">
                        <label for="programleader" class="form-label">Program Leader</label>
                        <select class="selectpicker w-100 border currentprogramleader" name="currentprogramleader[]"
                            id="currentprogramleader" multiple aria-label="Select Program Leaders"
                            data-live-search="true">
                            <option value="0" disabled>Select Program Leader</option>
                            @php
                            $programleadersIds = $programleaders->pluck('id')->all();
                            @endphp

                            @foreach ($members as $member)
                            @if ($member->role === 'Coordinator' || $member->role === 'Admin')
                            <option value="{{ $member->id }}" @if(in_array($member->id, $programleadersIds)) selected
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
                    @endif
                    <div class="mb-3">
                        <label for="projecttitle" class="form-label">Project Title</label>
                        <input type="text" class="form-control autocapital" id="currentprojecttitle"
                            name="currentprojecttitle" value="{{ $indexproject->projecttitle }}">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="container mb-3 p-0">
                        <label for="projectleader" class="form-label">Project Leader</label>
                        <select class="selectpicker w-100 border currentprojectleader" name="currentprojectleader[]"
                            id="currentprojectleader" multiple aria-label="Select Project Leaders"
                            data-live-search="true">
                            <option value="0" disabled>Select Project Leader</option>
                            @php
                            $projectleadersIds = $projectleaders->pluck('id')->all();
                            @endphp

                            @foreach ($members as $member)
                            @if ($member->role === 'Coordinator' || $member->role === 'Admin')
                            <option value="{{ $member->id }}" @if(in_array($member->id, $projectleadersIds)) selected
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
                        <label for="currentprojectstartdate" class="form-label">Project Start Date</label>

                        <div class="input-group date" id="currentstartDatePicker">
                            <input type="text" class="form-control" id="currentprojectstartdate"
                                name="currentprojectstartdate" placeholder="mm/dd/yyyy"
                                value="{{ date('m/d/Y', strtotime($indexproject['projectstartdate'])) }}" />
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="bi bi-calendar-event-fill"></i>
                                </span>
                            </span>
                        </div>

                        <!--<input type="date" class="form-control" id="projectstartdate" name="projectstartdate">-->


                    </div>

                    <div class="mb-3">
                        <label for="projectenddate" class="form-label">Project End Date</label>

                        <div class="input-group date" id="currentendDatePicker">
                            <input type="text" class="form-control" id="currentprojectenddate"
                                name="currentprojectenddate" placeholder="mm/dd/yyyy"
                                value="{{ date('m/d/Y', strtotime($indexproject['projectenddate'])) }}" />
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="bi bi-calendar-event-fill"></i>
                                </span>
                            </span>
                        </div>



                    </div>


                </div>
                <div class="modal-footer">
                    <span class="text-danger" id="editprojectError">
                        <strong></strong>
                    </span>
                    <span class="ms-2 small loadingMessage" id="editprojectloadingSpan" style="display: none;">Sending
                        Email..</span>
                    <button type="button" class="btn shadow rounded border border-1 btn-light" id="closeDetails"
                        data-bs-dismiss="modal"><b class="small">Close</b></button>

                    <button type="button" class="btn shadow rounded btn-primary" id="btn-confirmDetails">
                        <b class="small">Confirm</b>
                    </button>

                </div>
            </div>
        </div>
    </div>
    @endif
    <script>
    var titleNgProgram = <?php echo json_encode($indexproject['programtitle']); ?>;
    document.addEventListener('livewire:load', function() {
        btnConfirmDetails = document.getElementById('btn-confirmDetails');

        btnConfirmDetails.addEventListener('click', function() {
            var hasError = handleError();
            if (!hasError) {
                var valProgramTitle = null;
                var valProgramLeaders = [];
                if (titleNgProgram != "") {
                    valProgramTitle = document.getElementById("currentprogramtitle").value;
                    var programLeaderSelect = document.getElementById("currentprogramleader");
                    for (var i = 0; i < programLeaderSelect.options.length; i++) {
                        if (programLeaderSelect.options[i].selected) {
                            valProgramLeaders.push(programLeaderSelect.options[i].value);
                        }
                    }
                }
                var valProjectTitle = document.getElementById("currentprojecttitle").value;
                var valProjectLeaders = [];
                var projectLeaderSelect = document.getElementById("currentprojectleader");
                for (var i = 0; i < projectLeaderSelect.options.length; i++) {
                    if (projectLeaderSelect.options[i].selected) {
                        valProjectLeaders.push(projectLeaderSelect.options[i].value);
                    }
                }
                var valProjectStartDate = document.getElementById("currentprojectstartdate").value;
                var valProjectEndDate = document.getElementById("currentprojectenddate").value;
                var projectDetails = [
                    valProgramTitle,
                    valProjectTitle,
                    valProjectStartDate,
                    valProjectEndDate,
                    valProgramLeaders,
                    valProjectLeaders,
                ];
                document.getElementById('closeDetails').click();


                Livewire.emit('saveProjectDetails', projectDetails);
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

            var projectTitle = document.getElementById('currentprojecttitle').value;
            var projectLeader = document.getElementById('currentprojectleader').options;

            var projectStartDate = formatDate(document.getElementById('currentprojectstartdate').value);
            var projectEndDate = formatDate(document.getElementById('currentprojectenddate').value);

            if (titleNgProgram != "") {
                var programTitle = document.getElementById("currentprogramtitle").value;
                var programLeader = document.getElementById("currentprogramleader").options;
                if (programTitle.trim() === '') {
                    document.getElementById('currentprogramtitle').classList.add('is-invalid');
                    document.getElementById('currentprogramtitle').nextElementSibling.querySelector(
                        '.invalid-feedback strong').textContent = 'Program Title is required.';
                    hasErrors = true;
                }

                // Validation for Project Leader
                if (programLeader.length === 0) {
                    document.querySelector('.currentprogramleader').classList.add('is-invalid');
                    document.querySelector('.currentprogramleader').nextElementSibling.querySelector(
                        '.invalid-feedback strong').textContent = 'Program Leader is required.';
                    hasErrors = true;
                }
            }

            // Validation for Project Title
            if (projectTitle.trim() === '') {
                document.getElementById('currentprojecttitle').classList.add('is-invalid');
                document.getElementById('currentprojecttitle').nextElementSibling.querySelector(
                    '.invalid-feedback strong').textContent = 'Project Title is required.';
                hasErrors = true;
            }

            // Validation for Project Leader
            if (projectLeader.length === 0) {
                document.querySelector('.currentprojectleader').classList.add('is-invalid');
                document.querySelector('.currentprojectleader').nextElementSibling.querySelector(
                    '.invalid-feedback strong').textContent = 'Project Leader is required.';
                hasErrors = true;
            }

            // Validation for Project Start Date
            if (document.getElementById('currentprojectstartdate').value === '') {
                document.getElementById('currentprojectstartdate').parentElement.classList.add('is-invalid');
                document.getElementById('currentprojectstartdate').parentElement.nextElementSibling
                    .querySelector('.invalid-feedback strong').textContent = 'Project Start Date is required.';
                hasErrors = true;
            }

            // Validation for Project End Date
            if (document.getElementById('currentprojectenddate').value === '') {

                document.getElementById('currentprojectenddate').parentElement.classList.add('is-invalid');
                document.getElementById('currentprojectenddate').parentElement.nextElementSibling.querySelector(
                    '.invalid-feedback strong').textContent = 'Project End Date is required.';
                hasErrors = true;
            }

            // Check if End Date is after Start Date
            if (projectEndDate <= projectStartDate) {
                document.getElementById('currentprojectenddate').parentElement.classList.add('is-invalid');
                document.getElementById('currentprojectenddate').parentElement.nextElementSibling.querySelector(
                        '.invalid-feedback strong').textContent =
                    'Project End Date must be after the Start Date.';
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
