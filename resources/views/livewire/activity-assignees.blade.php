<div class="basiccont shadow p-2 mt-4 ms-2 mb-4">
    <div class="border-bottom ps-2 bggreen">
        <h6 class="fw-bold small" style="color:darkgreen;">Assignees</h6>
    </div>
    @php $count = 0; @endphp
    <form id="unassignassigneeform" data-url="{{ route('unassign.assignee') }}">
        @csrf
        <input type="number" id="unassignassigneeid" name="unassignassigneeid" class="d-none">
        <input type="number" id="unassignactivityid" name="unassignactivityid" class="d-none" value="{{ $activity['id'] }}">
    </form>
    @foreach ($assignees as $key=> $assignee)
    @if ($count % 2 == 0)
    <div class="row p-1" data-value="">
        @endif
        <div class="col border-bottom p-1 divhover checkassignee hoverassignee" value="{{ $assignee->id }}">

            <p class="m-2 ms-3">{{ $assignee->name . ' ' . $assignee->last_name }}</p>
        </div>
        @if ($count % 2 == 1 || $loop->last)
    </div>
    @endif
    @php $count++; @endphp
    @endforeach
    <div class="btn-group ms-2 mt-2 mb-2 shadow">
        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow addassignees-btn">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="addassignee-btn">Add Assignee</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
</div>