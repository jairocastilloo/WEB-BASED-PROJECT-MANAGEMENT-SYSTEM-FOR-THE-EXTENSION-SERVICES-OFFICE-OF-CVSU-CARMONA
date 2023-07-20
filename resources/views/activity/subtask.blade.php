@extends('layouts.app')

@section('content')

<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv">
            <input type="number" class="d-none" id="actid" value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Subtask</b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="basiccont p-2">
                    <div class="border-bottom ps-1">
                        <h6 class="fw-bold small">Hours rendered</h6>
                    </div>
                    <h5>{{ $subtask['subtask_name'] }}</h5>
                    Hours Rendered: {{ $subtask['hours_rendered'] }}
                    <hr>
                    Assignees:
                    @foreach($currentassignees as $currentassignee)
                    {{ $currentassignee->name . ' ' . $currentassignee->last_name }}

                    @endforeach


                    <button type="button" class="btn btn-sm btn-outline-secondary" id="add-subtaskassignees">+</button>
                </div>
                <div class="basiccont p-2">
                    <div class="border-bottom ps-1">
                        <h6 class="fw-bold small">Unevaluated Hours rendered</h6>
                    </div>


                </div>
            </div>
            <div class="col-4">
                <div class="basiccont">
                    <div class="border-bottom ps-2 pt-2">
                        <h6 class="fw-bold small">Other Subtask</h6>
                    </div>
                    @foreach ($subtasks as $index => $sub)
                    @if ($sub->subtask_name != $subtask['subtask_name'])
                    @if ($index % 2 == 0)
                    <div class="sidecont1 divhover p-2 subtaskdiv" data-value="{{ $subtask->id }}">{{ $sub->subtask_name }}</div>
                    @else
                    <div class="sidecont2 divhover p-2 subtaskdiv" data-value="{{ $subtask->id }}">{{ $sub->subtask_name }}</div>
                    @endif
                    @endif
                    @endforeach

                </div>
            </div>

        </div>

    </div>
</div>
<!--add activity assignees-->
<div class="modal fade" id="addSubtaskAssigneeModal" tabindex="-1" aria-labelledby="addAssigneeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssigneeModalLabel">Add Assignee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assigneeform" data-url="{{ route('add.subtaskassignee') }}">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="assigneeSelect" class="form-label">Assignee</label>
                        <input type="number" class="d-none" name="subtaskid" value="{{ $subtask['id'] }}">
                        <select class="form-select" id="subtaskassigneeselect" name="userid">
                            <option value="" selected disabled>Select Assignee</option>
                            @foreach($assignees as $assignee)

                            <option value="{{ $assignee->id }}">{{ $assignee->name . ' ' . $assignee->last_name }}</option>
                            @endforeach
                        </select>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmsubtaskassignee-btn">Add Assignee</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    url = "";
    $(document).ready(function() {
        $('#add-subtaskassignees').click(function() {
            $('#addSubtaskAssigneeModal').modal('show');
        });
        $('#confirmsubtaskassignee-btn').click(function(event) {
            event.preventDefault();
            var dataurl = $('#assigneeform').attr('data-url');
            var data1 = $('#assigneeform').serialize();



            // send data via AJAX
            $.ajax({
                url: dataurl,
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response);
                    window.location.href = url;

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);

                }
            });
        });
    });
</script>
@endsection