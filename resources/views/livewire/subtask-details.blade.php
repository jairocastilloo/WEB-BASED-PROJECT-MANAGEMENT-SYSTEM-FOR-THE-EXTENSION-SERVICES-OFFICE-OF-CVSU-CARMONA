<div>
    <div class="basiccont word-wrap shadow" data-value="{{ $subtask['id'] }}" data-name="{{ $subtask['subtask_name'] }}">
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
        @If (Auth::user()->role == "Admin" || Auth::user()->role == "Coordinator")
        <div class="btn-group dropdown ms-3 mb-3 shadow">
            <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <b class="small"> <i class="bi bi-list"></i> Menu</b>
            </button>
            <div class="dropdown-menu border border-1 border-warning">
                @If ($subtask['status'] == "Incomplete")
                <a class="dropdown-item small hrefnav" href="#" data-bs-toggle="modal" data-bs-target="#accomplishmentReportModal"><b class="small">Submit Accomplishment Report</b></a>
                <a class="dropdown-item small hrefnav" href="#" data-bs-toggle="modal" data-bs-target="#markAsCompletedModal">
                    <b class="small">Mark as Completed</b>
                </a>
                @endif
                <a class="dropdown-item small hrefnav" href="#" id="editdetails-btn">
                    <b class="small">Edit Details</b></a>
                <a class="dropdown-item small hrefnavDelete border-bottom" data-bs-toggle="modal" data-bs-target="#deleteSubtaskModal">
                    <b class="small">Delete Subtask</b>
                </a>
            </div>
        </div>
        @endif

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
                    <button type="button" class="btn btn-md rounded border border-1 btn-light" data-bs-dismiss="modal" id="closeModal">Cancel</button>
                    <button type="button" class="btn btn-md rounded btn-gold shadow" wire:click="markAsCompleted">Mark Completed</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('closeModal', function() {
                document.getElementById('closeModal').click();
            });
        });
    </script>

</div>