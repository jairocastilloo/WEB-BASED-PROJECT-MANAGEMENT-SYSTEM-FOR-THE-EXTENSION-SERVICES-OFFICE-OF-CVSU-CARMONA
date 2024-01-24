<div>
    <div class="basiccont word-wrap shadow pb-2" data-value="{{ $subtask['id'] }}" data-name="{{ $subtask['subtask_name'] }}">
        <div class="border-bottom ps-3 pt-2 bggreen">
            <h6 class="fw-bold small" style="color:darkgreen;">Subtask</h6>
        </div>
        {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
        <p class="ps-4 lh-1 pt-2"><b>Name:</b> {{ $subtask['subtask_name'] }}
            <span class="text-success fw-bold"><i>{{ " ( " . $subtask['status'] .  " )" }}</i></span>
        </p>


        <p class="ps-4 lh-1"><b>Total Hours Rendered:</b> {{ $subtask['hours_rendered'] }}
        </p>
        <p class="ps-4 lh-1"><b>Due Date:</b>
            {{ \Carbon\Carbon::parse($subtask->subduedate)->format('F d, Y') }}
        </p>

        <div class="btn-group dropdown ms-3 shadow">
            <button type="button" class="btn btn-sm rounded btn-gold shadow dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <b class="small"> <i class="bi bi-list"></i> Menu</b>
            </button>
            <div class="dropdown-menu border border-1 border-warning">
                @If ($subtask['status'] == "Incomplete")
                <a class="dropdown-item small hrefnav" href="#" data-bs-toggle="modal" data-bs-target="#accomplishmentReportModal"><b class="small">Submit Accomplishment Report</b></a>
                @If (Auth::user()->role == "Admin")
                <a class="dropdown-item small hrefnav" href="#" data-bs-toggle="modal" data-bs-target="#markAsCompletedModal">
                    <b class="small">Mark as Completed</b>
                </a>
                @endif
                @endif
                <a class="dropdown-item small hrefnav" href="#" id="editdetails-btn" data-bs-toggle="modal" data-bs-target="#subtask-modal">
                    <b class="small">Edit Details</b></a>
                <a class="dropdown-item small hrefnavDelete border-bottom" data-bs-toggle="modal" data-bs-target="#deleteSubtaskModal">
                    <b class="small">Delete Subtask</b>
                </a>
            </div>
        </div>

        <div class="modal" id="subtask-modal" tabindex="-1" aria-labelledby="new-subtask-modal-label" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="new-subtask-modal-label">Edit Subtask</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form id="subtaskform" data-url="{{ route('add.subtask') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="subtask-name" class="form-label">Subtask Name</label>
                                <input type="number" class="d-none" name="activitynumber" id="actid" value="{{ $activity->id }}">
                                <input type="date" class="d-none" id="activityStartDate" value="{{ $activity->actstartdate }}">
                                <input type="date" class="d-none" id="activityEndDate" value="{{ $activity->actenddate }}">
                                <input type="text" class="form-control" id="subtaskname" name="subtaskname" placeholder="Enter Subtask" value="{{ $subtask->subtask_name }}">
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="subtask-duedate" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="subtaskduedate" name="subtaskduedate" placeholder="Enter Due Date" value="{{ $subtask->subduedate }}">
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md rounded border border-1 btn-light shadow" id="closeEditSubtask" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-md rounded btn-gold shadow" id="editsubtaskdetails-btn">Edit
                            Subtask</button>
                    </div>


                </div>
            </div>
        </div>


    </div>


    <div class="modal fade" id="markAsCompletedModal" tabindex="-1" aria-labelledby="markAsCompletedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markAsCompletedModalLabel">Mark Task as Completed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to mark "{{ $subtask['subtask_name'] }}" as completed?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md rounded border border-1 btn-light shadow" data-bs-dismiss="modal" id="closeModal">Cancel</button>
                    <button type="button" class="btn btn-md rounded btn-gold shadow" wire:click="markAsCompleted">Mark
                        Completed</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('closeModal', function() {
                document.getElementById('closeModal').click();
            });
            Livewire.on('saveSubtaskSuccess', function() {
                document.getElementById('closeEditSubtask').click();
            });
            var editSubtaskBtn = document.getElementById("editsubtaskdetails-btn");
            editSubtaskBtn.addEventListener('click', function() {
                var theresErrors = subtaskHasError();
                if (!theresErrors) {
                    this.disabled = true;


                    Livewire.emit('saveSubtask', {
                        subtask_name: document.getElementById('subtaskname').value,
                        subduedate: document.getElementById('subtaskduedate').value,


                    });
                }
            });

            function subtaskHasError() {
                var hasErrors = false;
                document.querySelectorAll('.invalid-feedback strong').forEach(function(element) {
                    element.textContent = '';
                });
                document.querySelectorAll('.is-invalid').forEach(function(element) {
                    element.classList.remove('is-invalid');
                });
                subduedate = document.getElementById('subtaskduedate').value;
                actstartdate = document.getElementById('activityStartDate').value;
                actenddate = document.getElementById('activityEndDate').value;
                if (subduedate === '') {
                    document.getElementById('subtaskduedate').classList.add('is-invalid');
                    document.querySelector('#subtaskduedate + .invalid-feedback strong').textContent =
                        'Subtask Due Date is required';
                    hasErrors = true;
                } else if (!(new Date(actstartdate) <= new Date(subduedate)) && (new Date(actenddate) >= new Date(subduedate))) {
                    document.getElementById('subtaskduedate').classList.add('is-invalid');
                    document.querySelector('#subtaskduedate + .invalid-feedback strong').textContent =
                        'Subtask Due Date must be in between ' + new Date(actstartdate).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        }) + ' and ' + new Date(actstartdate).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        }) + '.';
                    hasErrors = true;

                }

                return hasErrors;
            }
        });
    </script>

</div>
