<div>
    <input type="hidden" id="projsavestartdate" name="projsavestartdate" value="{{ $projectdate->projectstartdate }}">
    <input type="hidden" id="projsaveenddate" name="projsaveenddate" value="{{ $projectdate->projectenddate }}">
    <p class="lh-sm ms-4 mt-2 me-2"><strong>Name:</strong>
        {{ $activity['actname'] }}
        <em class="text-success fw-bold">( {{ $activity['actremark'] }} )</em>
    </p>

    <p class="lh-sm ms-4 me-2"><strong>Objectives:</strong></p>
    @foreach ($currentobjectives as $currentobjective)

    <p class="ms-4 me-2 lh-1">- {{ $currentobjective['name'] }}</p>

    @endforeach
    <p class="lh-sm ms-4 me-2"><strong>Expected Output:</strong> {{ $activity['actoutput'] }} </p>
    <p class="lh-sm ms-4 me-2"><strong>Start Date:</strong> {{ date('M d, Y', strtotime($activity['actstartdate'])) }}
    </p>
    <p class="lh-sm ms-4 me-2"><strong>Due Date:</strong> {{ date('M d, Y', strtotime($activity['actenddate'])) }}</p>
    <p class="lh-sm ms-4 me-2"><strong>Budget:</strong> &#8369;{{ number_format($activity['actbudget'], 2) }}</p>
    <p class="lh-sm ms-4 me-2"><strong>Source:</strong> {{ $activity['actsource'] }}</p>
    <p class="lh-sm ms-4 me-2"><strong>Participation Hours Rendered:</strong> {{ $activity['totalhours_rendered'] }}</p>
    <div class="btn-group dropdown ms-3 mb-3 shadow">
        <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-3 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <b class="small"> <i class="bi bi-list"></i> Menu</b>
        </button>
        <div class="dropdown-menu border border-1 border-warning">
            <a class="dropdown-item small hrefnav" href="#" data-bs-toggle="modal" data-bs-target="#newactivity"><b class="small">Edit Details</b></a>
            <a class="dropdown-item small hrefnav" href="#" id="completeactivity-btn"><b class="small">Mark as Completed</b></a>
            <a class="dropdown-item small hrefnav" href="#" id="activityhours-btn"><b class="small">Participation Hours</b></a>
        </div>
    </div>
    <div class="modal fade" id="newactivity" tabindex="-1" aria-labelledby="newactivityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newactivityLabel">Edit Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="activityname" class="form-label">Activity Name</label>
                        <input type="text" class="form-control" id="activityname" name="activityname" value="{{ $activity->actname }}">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="objectives" class="form-label">Objectives</label>
                        @php

                        $lastObject = $objectives->last();
                        $lastObjectivesetId = $lastObject['objectiveset_id'];
                        $x = 0;
                        $y = 1;
                        @endphp
                        <div class="custom-dropdown">
                            <input type="hidden" id="selected-option" name="selected-option">
                            <div class="dropdown-text" id="objective-select" onclick="toggleDropdown()">Select objectives<i class="bi bi-caret-down-fill float-end"></i></div>
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                            <ul class="dropdown-options" id="dropdown-options">
                                @while ($x <= $lastObjectivesetId) <li onclick="selectOption({{ $x + 1 }})">@foreach($objectives->where('objectiveset_id', $x) as $objective)

                                    {{ $y . '. ' . $objective['name'] }}<br>
                                    @php
                                    $y++;
                                    @endphp
                                    @endforeach
                                    </li>
                                    @php
                                    $x++;
                                    @endphp

                                    @endwhile
                            </ul>
                        </div>

                    </div>
                    <div class="mb-3">
                        <label for="expectedoutput" class="form-label">Expected Output</label>
                        <input type="text" class="form-control" id="expectedoutput" name="expectedoutput" value="{{ $activity->actoutput }}">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="startdate" class="form-label">Activity Start Date</label>
                        <input type="date" class="form-control" id="activitystartdate" name="activitystartdate" value="{{ $activity->actstartdate }}">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="enddate" class="form-label">Activity End Date</label>
                        <input type="date" class="form-control" id="activityenddate" name="activityenddate" value="{{ $activity->actenddate }}">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label">Budget</label>
                        <input type="number" class="form-control" id="budget" name="budget" value="{{ $activity->actbudget }}">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="Source" class="form-label">Source</label>
                        <input type="text" class="form-control" id="source" name="source" value="{{ $activity->actsource }}">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn shadow rounded border border-1 btn-light" id="closeActivity" data-bs-dismiss="modal">
                        <b class="small">Close</b>
                    </button>
                    <button type="button" class="btn shadow rounded btn-primary" id="confirmactivity">
                        <b class="small">Add activity</b>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const objectiveset_id = <?php echo $currentobjectives[0]->objectiveset_id ?>;
        let selectedOptionId = null;
        var actname;
        var objectivevalue;
        var expectedoutput;
        var actstartdate;
        var actenddate;
        var projstartdate = document.getElementById('projsavestartdate').value;
        var projenddate = document.getElementById('projsaveenddate').value;
        var actbudget;
        var actsource;
        document.addEventListener('livewire:load', function() {
            var selectedOption = document.getElementById("selected-option");
            var dropdownText = document.querySelector(".dropdown-text");
            var option = document.querySelector(`#dropdown-options li:nth-child(${objectiveset_id + 1})`);
            selectedOptionId = objectiveset_id + 1;
            selectedOption.value = option.textContent;
            dropdownText.textContent = option.textContent;

            var confirmActivityBtn = document.getElementById("confirmactivity");
            confirmActivityBtn.addEventListener('click', function() {
                var theresErrors = acthasError();
                if (!theresErrors) {
                    Livewire.emit('saveActivity', {
                        actname: actname,
                        objectivevalue: objectivevalue,
                        expectedoutput: expectedoutput,
                        actstartdate: actstartdate,
                        actenddate: actenddate,
                        actbudget: actbudget,
                        actsource: actsource
                    });
                }
            });
            Livewire.on('closeActivity', function() {
                document.getElementById('closeActivity').click();
                document.getElementById('activityname').value = "";
                selectedOptionId = null;
                document.getElementById('expectedoutput').value = "";
                document.getElementById('activitystartdate').value = "";
                document.getElementById('activityenddate').value = "";
                document.getElementById('budget').value = "";
                document.getElementById('source').value = "";
                actname = "";
                objectivevalue = null;
                expectedoutput = "";
                actstartdate = "";
                actenddate = "";
                actbudget = "";
                actsource = "";
            });
        });

        function toggleDropdown() {
            const dropdown = document.getElementById("dropdown-options");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        function selectOption(optionId) {
            selectedOptionId = optionId - 1;
            const selectedOption = document.getElementById("selected-option");
            const dropdownText = document.querySelector(".dropdown-text");
            const option = document.querySelector(`#dropdown-options li:nth-child(${optionId})`);

            selectedOption.value = option.textContent;
            dropdownText.textContent = option.textContent;
            toggleDropdown();
        }

        function acthasError() {
            var hasErrors = false;
            document.querySelectorAll('.invalid-feedback strong').forEach(function(element) {
                element.textContent = '';
            });
            document.querySelectorAll('.is-invalid').forEach(function(element) {
                element.classList.remove('is-invalid');
            });

            actname = document.getElementById('activityname').value;
            objectivevalue = selectedOptionId;
            expectedoutput = document.getElementById('expectedoutput').value;
            actstartdate = document.getElementById('activitystartdate').value;
            actenddate = document.getElementById('activityenddate').value;

            actbudget = document.getElementById('budget').value;
            actsource = document.getElementById('source').value;

            // Validation for Project Title
            if (actname.trim() === '') {
                document.getElementById('activityname').classList.add('is-invalid');
                document.querySelector('#activityname + .invalid-feedback strong').textContent = 'Activity Name is required.';
                hasErrors = true;
            }

            // Validation for Project Leader
            if (objectivevalue == null) {
                document.getElementById('objective-select').classList.add('is-invalid');
                document.querySelector('#objective-select + .invalid-feedback strong').textContent = 'Make sure that there is an objective selected.';
                hasErrors = true;
            }

            // Validation for Program Title
            if (expectedoutput.trim() === '') {
                document.getElementById('expectedoutput').classList.add('is-invalid');
                document.querySelector('#expectedoutput + .invalid-feedback strong').textContent = 'Expected Output is required.';
                hasErrors = true;
            }

            if (actstartdate === '') {
                document.getElementById('activitystartdate').classList.add('is-invalid');
                document.querySelector('#activitystartdate + .invalid-feedback strong').textContent = 'Activity Start Date is required.';
                hasErrors = true;
            }

            // Validation for Project Start Date
            else if (new Date(projstartdate) > new Date(actstartdate)) {
                document.getElementById('activitystartdate').classList.add('is-invalid');
                document.querySelector('#activitystartdate + .invalid-feedback strong').textContent = 'Activity Start Date must be after ' + new Date(projstartdate).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                }) + '.';
                hasErrors = true;
            }

            if (actenddate === '') {
                document.getElementById('activityenddate').classList.add('is-invalid');
                document.querySelector('#activityenddate + .invalid-feedback strong').textContent = 'Activity End Date is required';
                hasErrors = true;
            } else if (new Date(actenddate) < new Date(actstartdate)) {
                document.getElementById('activityenddate').classList.add('is-invalid');
                document.querySelector('#activityenddate + .invalid-feedback strong').textContent = 'Activity End Date must be after ' + new Date(actstartdate).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                }) + '.';
                hasErrors = true;
            } else if (new Date(projenddate) < new Date(actenddate)) {
                document.getElementById('activityenddate').classList.add('is-invalid');
                document.querySelector('#activityenddate + .invalid-feedback strong').textContent = 'Activity End Date must be before ' + new Date(projenddate).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                }) + '.';
                hasErrors = true;
            }

            if (actbudget.trim() === '') {
                document.getElementById('budget').classList.add('is-invalid');
                document.querySelector('#budget + .invalid-feedback strong').textContent = 'Budget is required.';
                hasErrors = true;
            }
            if (actsource.trim() === '') {
                document.getElementById('source').classList.add('is-invalid');
                document.querySelector('#source + .invalid-feedback strong').textContent = 'Source of budget is required.';
                hasErrors = true;
            }
            return hasErrors;
        }
    </script>
</div>