@extends('layouts.app')

@section('content')

<div class="container">
    <div class="mainnav mb-2 m-0 ps-3 font-black">
        asd
    </div>
    <div class="row">
        <div class="col-8">

            <div class="basiccont">
                <div class="border-bottom ps-3">
                    <h6 class="fw-bold small">Activity</h6>
                </div>
                <h5><b>{{ $activity['actname'] }}</b></h5>
                Expected Output: {{ $activity['actoutput'] }} <br>
                Start Date: {{ $activity['actstartdate'] }} <br>
                End Date: {{ $activity['actenddate'] }} <br>
                Budget: {{ $activity['actbudget'] }} <br>
                Source: {{ $activity['actsource'] }} <br>
                <div class="border-bottom d-flex justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary stretch-button">Edit Activity</button>
                </div>

            </div>

            <div class="basiccont">
                <div class="border-bottom ps-3">
                    <h6 class="fw-bold small">Assignees</h6>
                </div>
                @php $count = 0; @endphp

                @foreach ($assignees as $key => $assignee)
                @if ($count % 2 == 0)
                <div class="row">
                    @endif
                    <div class="col-6 p-2 border-bottom">
                        {{ $assignee->name . ' ' . $assignee->last_name }}
                    </div>
                    @if ($count % 2 == 1 || $loop->last)
                </div>
                @endif
                @php $count++; @endphp
                @endforeach

                <div class="border-bottom d-flex justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary stretch-button addassignees-btn">Add Assignees</button>
                </div>
            </div>
            <div class="basiccont">
                <div class="border-bottom ps-3">
                    <h6 class="fw-bold small">Output</h6>
                </div>

                @foreach ($outputTypes as $outputType)
                <div class="border-bottom p-2">
                    <h5>{{ $outputType }}:</h5>
                    @foreach ($outputs as $output)
                    @if ($output->output_type === $outputType)
                    {{ $output->output_name }} <br>
                    @endif
                    @endforeach
                </div>
                @endforeach
                <div class="border-bottom d-flex justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary stretch-button">Add Output</button>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="basiccont">
                <div class="border-bottom ps-3">
                    <h6 class="fw-bold small">Subtasks</h6>
                </div>
                <ul class="list-unstyled" id="subtask">
                    @foreach ($subtasks as $subtask)
                    <li class="p-2 border-bottom">{{ $subtask->subtask_name }}</li>
                    @endforeach
                </ul>
                <div class="border-bottom d-flex justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary stretch-button addsubtask-btn">Add Subtask</button>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- add subtask -->
<div class="modal" id="subtask-modal" tabindex="-1" aria-labelledby="new-subtask-modal-label" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="new-subtask-modal-label">New Subtask</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="subtaskform" data-url="{{ route('add.subtask') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="subtask-name" class="form-label">Subtask Name</label>
                        <input type="number" class="d-none" name="activitynumber" value="{{ $activity['id'] }}">
                        <input type="text" class="form-control" id="subtaskname" name="subtaskname" placeholder="Enter Subtask">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="createsubtask-btn">Add Subtask</button>
            </div>


        </div>
    </div>
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
                <form>
                    @csrf
                    <div class="mb-3">
                        <label for="assigneeSelect" class="form-label">Assignee</label>
                        <select class="form-select" id="assigneeSelect" name="assigneeSelect">
                            <option value="" disabled>Select Assignee</option>
                            @foreach($addassignees as $assignee)
                            <option value="{{ $assignee->id }}">{{ $assignee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Assignee</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    var url = "";
    $(document).ready(function() {
        $('.addsubtask-btn').click(function(event) {
            event.preventDefault();
            $('#subtask-modal').modal('show');
        });

        $('.addassignees-btn').click(function(event) {
            event.preventDefault();
            $('#addAssigneeModal').modal('show');
        });
        $('#createsubtask-btn').click(function(event) {
            event.preventDefault();


            var dataurl = $('#subtaskform').attr('data-url');
            var data1 = $('#subtaskform').serialize();


            // send data via AJAX
            $.ajax({
                url: dataurl,
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response);
                    $('#new-subtask-modal').modal('toggle');
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