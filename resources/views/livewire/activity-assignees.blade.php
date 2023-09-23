<div class="basiccont shadow p-2 mt-4 ms-2 mb-4">

    <div class="border-bottom ps-2 bggreen">
        <h6 class="fw-bold small" style="color:darkgreen;">Assignees</h6>
    </div>

    <form id="unassignassigneeform" data-url="{{ route('unassign.assignee') }}">
        @csrf
        <input type="number" id="unassignassigneeid" name="unassignassigneeid" class="d-none">
        <input type="number" id="unassignactivityid" name="unassignactivityid" class="d-none" value="{{ $activityid }}">
    </form>
    @livewire('list-act-assignees', ['activityid' => $activityid])
    <div class="btn-group ms-2 mt-2 mb-2 shadow">
        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow addassignees-btn" id="ediwow">
            <b class="small">Add Assignees</b>
        </button>
    </div>

    <!--add activity assignees-->
    <div class="modal fade" id="addAssigneeModal" tabindex="-1" aria-labelledby="addAssigneeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAssigneeModalLabel">Add Assignee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ $projectName . "'s Team Members" }}</label>
                        <div class="form-check ms-1">
                            <input class="form-check-input border border-primary" type="checkbox" id="" name="" value="">
                            <label class="form-check-label" for="">Select All</label>
                        </div>
                        @foreach($addassignees as $assignee)
                        <div class="form-check ms-3">
                            <input class="form-check-input border border-primary" type="checkbox" id="assignee_{{ $assignee->id }}" name="assignees[]" value="{{ $assignee->id }}">
                            <label class="form-check-label" for="assignee_{{ $assignee->id }}">{{ $assignee->name . ' ' . $assignee->last_name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="myModalCloseButton" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="saveAssigneeButton" class="btn btn-primary">Save Assignee</button>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            const saveAssigneeButton = document.getElementById('saveAssigneeButton');

            saveAssigneeButton.addEventListener('click', function() {

                const checkboxes = document.querySelectorAll('input[name="assignees[]"]:checked');

                // Extract their values and store them in an array
                var selectedAssignees = Array.from(checkboxes).map(checkbox => checkbox.value);

                Livewire.emit('saveAssignees', selectedAssignees);

            });
            Livewire.on('updateAssignees', function() {

                // Remove the 'shows' class from the notificationBar span

                document.getElementById('myModalCloseButton').click();
                document.getElementById('updatedata').click();


            });

        });
    </script>
</div>