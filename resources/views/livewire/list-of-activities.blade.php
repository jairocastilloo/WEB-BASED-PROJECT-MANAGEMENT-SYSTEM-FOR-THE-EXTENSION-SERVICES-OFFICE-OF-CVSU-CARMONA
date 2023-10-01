<div>
    @php
    // Sort the $activities array by actstartdate in ascending order
    $sortedActivities = $activities->sortBy('actstartdate');
    @endphp
    @foreach ($sortedActivities as $activity)

    <div class="border-bottom ps-4 p-2 divhover actdiv" data-value="{{ $activity['id'] }}">

        <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

        @php
        $startDate = date('M d', strtotime($activity['actstartdate']));
        $endDate = date('M d', strtotime($activity['actenddate']));
        @endphp

        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
    </div>

    @endforeach

    <div class="ms-3 mt-2 btn-group shadow">
        <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="modal" data-bs-target="#newactivity">
            <b class="small">Add Activity</b>
        </button>
    </div>
    <!-- Add activity -->

    <div class="modal fade" id="newactivity" tabindex="-1" aria-labelledby="newactivityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                        <div class="custom-dropdown">
                            <input type="hidden" id="selected-option" name="selected-option">
                            <div class="dropdown-text" onclick="toggleDropdown()">Select objectives</div>
                            <ul class="dropdown-options" id="dropdown-options">
                                @foreach($objectives)
                                <li onclick="selectOption(1)">Option 1:<br>This is a long description that spans multiple lines.</li>
                                @endforeach
                            </ul>
                        </div>
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="expectedoutput" class="form-label">Expected Output</label>
                        <input type="text" class="form-control" id="expectedoutput" name="expectedoutput">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="startdate" class="form-label">Activity Start Date</label>
                        <input type="date" class="form-control" id="activitystartdate" name="activitystartdate">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="enddate" class="form-label">Activity End Date</label>
                        <input type="date" class="form-control" id="activityenddate" name="activityenddate">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label">Budget</label>
                        <input type="number" class="form-control" id="budget" name="budget">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="Source" class="form-label">Source</label>
                        <input type="text" class="form-control" id="source" name="source">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn shadow rounded border border-1 btn-light" data-bs-dismiss="modal">
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
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdown-options");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        function selectOption(optionId) {
            const selectedOption = document.getElementById("selected-option");
            const dropdownText = document.querySelector(".dropdown-text");
            const option = document.querySelector(`#dropdown-options li:nth-child(${optionId})`);

            selectedOption.value = option.textContent;
            dropdownText.textContent = option.textContent;

            toggleDropdown();
        }
    </script>
</div>