<div>
    <input type="hidden" id="projsavestartdate" name="projsavestartdate" value="{{ $indexproject->projectstartdate }}">
    <input type="hidden" id="projsaveenddate" name="projsaveenddate" value="{{ $indexproject->projectenddate }}">
    @php
    // Sort the $activities array by actstartdate in ascending order
    $sortedActivities = $activities->sortBy('actstartdate');
    @endphp

    @foreach ($sortedActivities as $activity)

    <div class="border-bottom ps-4 p-2 divhover actdiv" data-value="{{ $activity['id'] }}"
        data-name="{{ $activity['actname'] }}">

        <h6 class="fw-bold small">{{ $activity['actname'] }} - <span
                class="text-success">{{ $activity['actremark'] }}</span></h6>

        @php
        $startDate = date('M d, Y', strtotime($activity['actstartdate']));
        $endDate = date('M d, Y', strtotime($activity['actenddate']));
        @endphp

        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
    </div>

    @endforeach
    @If(Auth::user()->role == "Admin")
    <div class="ms-3 mt-2 btn-group shadow">
        <button type="button" class="btn btn-sm rounded btn-gold shadow" data-bs-toggle="modal"
            data-bs-target="#newactivity">
            <b class="small">Add Activity</b>
        </button>
    </div>
    @endif
    <!-- Add activity -->

    <div class="modal fade" id="newactivity" tabindex="-1" aria-labelledby="newactivityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newactivityLabel">Adding Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="activityname" class="form-label">Activity Name</label>
                        <input type="text" class="form-control" id="activityname" name="activityname">
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
                            <div class="dropdown-text" id="objective-select" onclick="toggleDropdown()">Select
                                objectives<i class="bi bi-caret-down-fill float-end"></i></div>
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                            <ul class="dropdown-options" id="dropdown-options">
                                @while ($x <= $lastObjectivesetId) <li onclick="selectOption({{ $x + 1 }})">
                                    @foreach($objectives->where('objectiveset_id', $x) as $objective)

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
                    <div class="mb-1" id="outputContainer">
                        <label for="expectedoutput" class="form-label">Expected Output</label>
                        <div class="input-group mb-1 expectedOutput-input">
                            <input type="text" class="form-control" name="expectedoutput[]">
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-danger removeExpectedOutput-btn"><i
                                    class="bi bi-x-lg"></i></button>
                        </div>

                    </div>
                    <button type="button" class="btn btn-sm btn-green mb-3" id="addExpectedOutput-btn">Add
                        Expected Output</button>

                    <div class="mb-3">
                        <label for="activitystartdate" class="form-label">Activity Start Date</label>

                        <div class="input-group date" id="activitystartDatePicker">
                            <input type="text" class="form-control" id="activitystartdate" name="activitystartdate"
                                placeholder="mm/dd/yyyy" />
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

                    <div class="mb-3">
                        <label for="activityenddate" class="form-label">Activity End Date</label>

                        <div class="input-group date" id="activityendDatePicker">
                            <input type="text" class="form-control" id="activityenddate" name="activityenddate"
                                placeholder="mm/dd/yyyy" />
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

                    <div class="mb-1" id="budgetContainer">
                        <label for="budget" class="form-label">Budget</label>
                        <div class="text-center d-none" id="tinipid">
                            <h5><em>
                                    No Budget Applicable
                                </em></h5>
                        </div>
                        <div class="input-group mb-1 budget-input">
                            <input type="text" class="form-control me-2" name="budgetItem[]" placeholder="Item">
                            <i class="bi bi-dash-lg pt-2"></i>
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                            <input type="number" class="form-control ms-2" min="0" name="budgetPrice[]"
                                placeholder="Price (PhP)">
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-danger removeBudget-btn"><i
                                    class="bi bi-x-lg"></i></button>
                        </div>

                    </div>
                    <button type="button" class="btn btn-sm btn-green mb-3" id="addBudget-btn">Add
                        Budget</button>


                    <div class="mb-3" id="sourceDiv">
                        <label for="Source" class="form-label">Source</label>
                        <input type="text" class="form-control" id="source" name="source">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md rounded border border-1 btn-light shadow" id="closeActivity"
                        data-bs-dismiss="modal"><b class="small">Close</b>
                    </button>
                    <button type="button" class="btn btn-md rounded btn-gold shadow" id="confirmactivity"><b
                            class="small">Add activity</b>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
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
        var confirmActivityBtn = document.getElementById("confirmactivity");
        confirmActivityBtn.addEventListener('click', function() {
            var theresErrors = acthasError();

            if (!theresErrors) {
                this.disabled = true;

                var expectedoutput = [];
                var budgetItem = [];
                var budgetPrice = [];

                document.querySelectorAll('input[name="expectedoutput[]"]').forEach(function(element) {
                    expectedoutput.push(element.value);
                });
                if (document.querySelectorAll('input[name="budgetItem[]"]').length > 0) {
                    // Collect values from input elements with name "budgetItem[]"
                    document.querySelectorAll('input[name="budgetItem[]"]').forEach(function(element) {
                        if (element.value.trim() !== '') {
                            budgetItem.push(element.value);
                        }
                    });
                }

                if (document.querySelectorAll('input[name="budgetPrice[]"]').length > 0) {
                    // Collect values from input elements with name "budgetPrice[]"
                    document.querySelectorAll('input[name="budgetPrice[]"]').forEach(function(element) {
                        if (element.value.trim() !== '') {
                            budgetPrice.push(element.value);
                        }
                    });
                }
                Livewire.emit('saveActivity', {
                    actname: actname,
                    objectivevalue: objectivevalue,
                    expectedoutput: expectedoutput,
                    actstartdate: actstartdate,
                    actenddate: actenddate,
                    actBudgetItem: budgetItem,
                    actBudgetPrice: budgetPrice,
                    actsource: actsource
                });
            }
        });

        Livewire.on('closeActivity', function() {
            document.getElementById('confirmactivity').disabled = false;
            document.getElementById('closeActivity').click();
            document.getElementById('activityname').value = "";
            selectedOptionId = null;

            var expectedOutputs = document.querySelectorAll('input[name="expectedoutput[]"]');
            var budgetItem = document.querySelectorAll('input[name="budgetItem[]"]');
            var budgetPrice = document.querySelectorAll('input[name="budgetPrice[]"]');

            if (expectedOutputs.length > 1) {
                for (var i = 1; i < expectedOutputs.length; i++) {
                    expectedOutputs[i].remove();
                }
            }

            if (expectedOutputs.length > 0) {
                expectedOutputs[0].value = "";
            }

            if (budgetItem.length > 1) {
                for (var i = 1; i < budgetItem.length; i++) {
                    budgetItem[i].remove();
                }
            }

            if (budgetItem.length > 0) {
                budgetItem[0].value = "";
            }
            if (budgetPrice.length > 1) {
                for (var i = 1; i < budgetPrice.length; i++) {
                    budgetPrice[i].remove();
                }
            }

            if (budgetPrice.length > 0) {
                budgetPrice[0].value = "";
            }

            document.getElementById('activitystartdate').value = "";
            document.getElementById('activityenddate').value = "";

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
        actstartdate = document.getElementById('activitystartdate').value;

        actenddate = document.getElementById('activityenddate').value;
        actsource = document.getElementById('source').value;

        // Validation for Project Title
        if (actname.trim() === '') {
            document.getElementById('activityname').classList.add('is-invalid');
            document.querySelector('#activityname + .invalid-feedback strong').textContent =
                'Activity Name is required.';
            hasErrors = true;
        }

        // Validation for Project Leader
        if (objectivevalue == null) {
            document.getElementById('objective-select').classList.add('is-invalid');
            document.querySelector('#objective-select + .invalid-feedback strong').textContent =
                'Make sure that there is an objective selected.';
            hasErrors = true;
        }

        document.querySelectorAll('input[name="expectedoutput[]"]').forEach(function(element) {
            if (element.value === "") {
                element.classList.add('is-invalid');
                // Fix the line below by removing quotes around 'element'
                document.querySelector(element + ' + .invalid-feedback strong').textContent =
                    'Expected Output is required.';
                hasErrors = true;
            }
        });


        if (actstartdate === '') {
            document.getElementById('activitystartdate').classList.add('is-invalid');
            document.querySelector('#activitystartdate + .invalid-feedback strong').textContent =
                'Activity Start Date is required.';
            hasErrors = true;
        } else if (!((new Date(projstartdate) - (24 * 60 * 60 * 1000)) < new Date(actstartdate))) {
            document.querySelector('#activitystartdate + .invalid-feedback strong').textContent =
                'Activity Start Date must be after ' + new Date(projstartdate).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                }) + '.';
            hasErrors = true;
        }


        if (actenddate === '') {
            document.getElementById('activityenddate').classList.add('is-invalid');
            document.querySelector('#activityenddate + .invalid-feedback strong').textContent =
                'Activity End Date is required';
            hasErrors = true;
        } else if (new Date(actenddate) < new Date(actstartdate)) {
            document.getElementById('activityenddate').classList.add('is-invalid');
            document.querySelector('#activityenddate + .invalid-feedback strong').textContent =
                'Activity End Date must be after ' + new Date(actstartdate).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                }) + '.';
            hasErrors = true;
        } else if (new Date(projenddate) < new Date(actenddate)) {
            document.getElementById('activityenddate').classList.add('is-invalid');
            document.querySelector('#activityenddate + .invalid-feedback strong').textContent =
                'Activity End Date must be before ' + new Date(projenddate).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                }) + '.';
            hasErrors = true;
        }

        document.querySelectorAll('input[name="budgetItem[]"]').forEach(function(element) {
            if (element.value === "") {
                element.classList.add('is-invalid');
                // Fix the line below by removing quotes around 'element'
                document.querySelector(element + ' + .invalid-feedback strong').textContent =

                    'Budget Item is required.';
                hasErrors = true;
            }
        });

        document.querySelectorAll('input[name="budgetPrice[]"]').forEach(function(element) {
            if (element.value === "") {
                element.classList.add('is-invalid');
                // Fix the line below by removing quotes around 'element'
                document.querySelector(element + ' + .invalid-feedback strong').textContent =
                    'Budget Price is required.';
                hasErrors = true;
            }
        });
        /**
                    if (actsource.trim() === '') {
                        document.getElementById('source').classList.add('is-invalid');
                        document.querySelector('#source + .invalid-feedback strong').textContent = 'Source of budget is required.';
                        hasErrors = true;
                    }*/
        return hasErrors;
    }
    </script>
</div>
