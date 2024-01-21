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
    <script>
        var titleNgProgram = document.getElementById('progTitle').value;
        document.addEventListener('livewire:load', function() {
            /*
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
*/
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