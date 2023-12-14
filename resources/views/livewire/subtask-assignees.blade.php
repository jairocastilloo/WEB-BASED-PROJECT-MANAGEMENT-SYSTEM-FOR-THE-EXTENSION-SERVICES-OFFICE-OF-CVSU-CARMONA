<div class="basiccont word-wrap shadow mt-2">
    <div class="border-bottom ps-3 pt-2 bggreen">
        <h6 class="fw-bold small" style="color:darkgreen;">Assignees</h6>
    </div>
    <div class="container">
        @php $count = 0; @endphp
        @foreach ($assignees as $key=> $assignee)
        @if ($count % 2 == 0)
        <div class="row">
            @endif
            <div class="col-md border-end border-bottom divhover">
                <div class="row">
                    <div class="col-10 checkassignee" data-name="{{ $assignee->name . ' ' . $assignee->last_name }}" data-email="{{ $assignee->email }}" data-role="{{ $assignee->role }}">

                        <p class="m-2 ms-3">
                            {{ $assignee->last_name . ', ' . $assignee->name . ' ' . ($assignee->middle_name ? $assignee->middle_name[0] : 'N/A') . '.' }}
                        </p>

                    </div>
                    <div class="col-2">
                        @If (Auth::user()->role == "Admin" || Auth::user()->role == "Coordinator")
                        <button type="button" class="btn btn-outline-danger fs-5 border float-end" wire:click="unassignAssignees('{{ $assignee->id }}')">
                            <i class="bi bi-person-dash"></i>
                        </button>
                        @endif
                    </div>
                </div>

            </div>

            @if ($count % 2 == 1 || $loop->last)
        </div>
        @endif
        @php $count++; @endphp
        @endforeach
    </div>
    @If (Auth::user()->role == "Admin" || Auth::user()->role == "Coordinator")
    <div class="btn-group ms-3 mt-2 mb-3 shadow">
        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="btnAddAssignee" data-bs-toggle="modal" data-bs-target="#addActivityAssigneeModal">
            <b class="small">Add Assignees</b>
        </button>

    </div>
    @endif
    <span class="ms-2 small loadingMessage" id="loadingSpan" style="display: none;">Sending Email..</span>

    <div class="alert alert-danger alert-dismissible fade show ms-2 mt-1" role="alert" id="emailError" style="display: none;">
        <!-- Your error message goes here -->
        <strong>Error:</strong><span id="errorMessage">The email has not been sent due to an internet issue.</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="redirectToHomepage()"></button>
    </div>


    <div class="modal fade" id="addActivityAssigneeModal" tabindex="-1" aria-labelledby="addActivityAssigneeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addActivityAssigneeModalLabel">Add Assignees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ $activity['actname'] . "'s Assignees" }}</label>

                        <div class="form-check ms-1" @if($addassignees->isEmpty())style="display:none"@endif>
                            <input class="form-check-input border border-primary" type="checkbox" id="selectAllAssignees">
                            <label class="form-check-label" for="selectAllAssignees">Select All</label>
                        </div>

                        @if($addassignees->isEmpty())
                        <h5 class="ms-3"><i>Every Assignees have been added or there`s no assignee for the activity.</i>
                        </h5>
                        @endif
                        @foreach($addassignees as $addassignee)
                        <div class="form-check ms-3">
                            <input class="form-check-input border border-primary" type="checkbox" id="addassignee_{{ $addassignee->id }}" name="addassignee[]" value="{{ $addassignee->id }}">
                            <label class="form-check-label" for="addassignee_{{ $addassignee->id }}">
                                {{ $addassignee->last_name . ', ' . $addassignee->name . ' ' . ($addassignee->middle_name ? $addassignee->middle_name[0] : 'N/A') . '.' }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="addAssigneesCloseButton" data-bs-dismiss="modal">Cancel</button>

                    <button type="button" id="saveAssigneesButton" class="btn btn-primary" @if($addassignees->isEmpty())style="display:none"@endif>Add Assignees</button>


                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="accomplishmentReportModal" tabindex="-1" aria-labelledby="accomplishmentReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accomplishmentReportModalLabel">Upload Accomplishment Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form data-url="{{ route('subtasks.uploadaccomplishment') }}" id="accomplishmentForm">
                        @csrf
                        <input type="hidden" name="subtask-id" value="{{ $subtask->id }}">
                        <input type="hidden" name="submitter-id" value="{{ Auth::user()->id }}">
                        <div class="mb-3">
                            <label class="form-label">Subtask Hours:</label>
                            <input type="number" class="form-control" id="hours-rendered" name="hours-rendered" placeholder="Enter hours rendered" value="0" min="0" step="1">
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="subtaskstartdate" class="form-label">Subtask Start Date</label>
                            <div class="input-group date" id="startDatePicker">
                                <input type="text" class="form-control" id="subtaskstartdate" name="subtaskstartdate" placeholder="mm/dd/yyyy" />

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
                        <div class="mb-3">
                            <label for="subtaskenddate" class="form-label">Subtask End Date</label>
                            <div class="input-group date" id="endDatePicker">
                                <input type="text" class="form-control" id="subtaskenddate" name="subtaskenddate" placeholder="mm/dd/yyyy" />

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
                        <div class="mb-3">
                            <label class="form-label">Related Program: <i> (if any)</i></label>
                            <input type="text" class="form-control" id="related-program" name="related-program">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. of Clientele/Beneficiaries: <i> (if any)</i></label>
                            <input type="number" class="form-control" id="client-numbers" name="client-numbers" placeholder="Enter hours rendered" value="0" min="0" step="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Agency: <i> (if any)</i></label>
                            <input type="text" class="form-control" id="agency" name="agency">
                        </div>
                        <div class="container mb-3 p-0">
                            <label for="implementers" class="form-label">Subtask Contributors</label>

                            <select class="selectpicker w-100 border subtaskcontributors" name="subtaskcontributors[]" id="subtaskcontributors" multiple aria-label="Select Contributors" data-live-search="true">
                                <option value="0" disabled>Select Contributors</option>
                                @foreach ($assignees as $assignee)
                                <option value="{{ $assignee->id }}">
                                    {{ $assignee->last_name . ', ' . $assignee->name . ' ' . ($assignee->middle_name ? $assignee->middle_name[0] : 'N/A') . '.' }}
                                </option>
                                @endforeach

                            </select>

                            <span class="invalid-feedback" id="subtaskcontributorserror" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="accomplishment_file">Choose File:</label>
                            <input type="file" class="form-control" id="accomplishment_file" accept=".docx" name="accomplishment_file">
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submitAccomplishment">Upload</button>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {

            var selectAllAssignees;
            var addAssigneeCheckboxes;
            var saveAssigneesButton;
            selectAllAssignees = document.getElementById('selectAllAssignees');
            addAssigneeCheckboxes = document.querySelectorAll('input[name="addassignee[]"]');
            saveAssigneesButton = document.getElementById('saveAssigneesButton');


            Livewire.on('updateElements', function(selectedAssignees) {
                var selectAllAssignees = document.getElementById('selectAllAssignees');
                var addAssigneeCheckboxes = document.querySelectorAll('input[name="addassignee[]"]');
                var saveAssigneesButton = document.getElementById('saveAssigneesButton');
                selectAllAssignees.checked = false;
                document.getElementById('loadingSpan').style.display = "inline-block";
                document.getElementById('btnAddAssignee').disabled = true;
                //document.getElementById('destroy').click();
                //document.getElementById('reinitialize').click();

                Livewire.emit('sendNotification', selectedAssignees);
            });

            Livewire.on('updateLoading', function() {
                document.getElementById('loadingSpan').style.display = "none";
                document.getElementById('btnAddAssignee').disabled = false;
                window.location.href = "";

            });

            Livewire.on('updateLoadingFailed', function(e) {
                document.getElementById('loadingSpan').style.display = "none";
                document.getElementById('btnAddAssignee').disabled = false;
                document.getElementById('emailError').style.display = "inline-block";

            });

            Livewire.on('updateUnassignElements', function() {
                selectAllAssignees = document.getElementById('selectAllAssignees');
                addAssigneeCheckboxes = document.querySelectorAll('input[name="addassignee[]"]');
                saveAssigneesButton = document.getElementById('saveAssigneesButton');
                selectAllAssignees.checked = false;
                window.location.href = "";
            });

            saveAssigneesButton.addEventListener('click', function() {
                var checkedAddAssigneeCheckboxes = document.querySelectorAll(
                    'input[name="addassignee[]"]:checked');

                var selectedAssignees = Array.from(checkedAddAssigneeCheckboxes).map(
                    checkedAddAssigneeCheckbox => checkedAddAssigneeCheckbox.value);
                document.getElementById('addAssigneesCloseButton').click();
                Livewire.emit('saveAssignees', selectedAssignees);
            });


            selectAllAssignees.addEventListener('change', function() {
                var areAddAssigneeChecked = areAllAddAssigneeChecked();

                if (!areAddAssigneeChecked) {
                    if (this.checked === true) {
                        for (checkbox of addAssigneeCheckboxes) {
                            if (!checkbox.checked) {
                                checkbox.checked = true;
                            }
                        }
                    }
                } else {
                    if (this.checked === false) {

                        for (checkbox of addAssigneeCheckboxes) {
                            if (checkbox.checked) {
                                checkbox.checked = false;
                            }
                        }
                    }
                }
            });

            function areAllAddAssigneeChecked() {
                for (checkbox of addAssigneeCheckboxes) {
                    if (!checkbox.checked) {
                        return false; // Exit the loop early if any checkbox is unchecked
                    }
                }
                return true;
            }


        });
    </script>
</div>