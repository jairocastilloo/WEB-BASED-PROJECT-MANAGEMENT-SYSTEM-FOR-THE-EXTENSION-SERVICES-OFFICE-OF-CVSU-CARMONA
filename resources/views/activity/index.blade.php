@extends('layouts.app')

@section('content')

<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}">
            <h6><b>Project: {{ $projectName }} </b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Activity</b></h6>
        </div>


    </div>
    <div class="container">

        <div class="row">
            <div class="col-8">

                <div class="basiccont p-2">
                    <div class="border-bottom ps-3">
                        <h6 class="fw-bold small">Activity</h6>
                    </div>
                    <h5><b>{{ $activity['actname'] }}</b></h5>
                    Expected Output: {{ $activity['actoutput'] }} <br>
                    Objectives:
                    @foreach ($objectives as $objective)
                    {{ $objective['name'] }} </br>
                    @endforeach
                    Start Date: {{ $activity['actstartdate'] }} <br>
                    End Date: {{ $activity['actenddate'] }} <br>
                    Budget: {{ $activity['actbudget'] }} <br>
                    Source: {{ $activity['actsource'] }} <br>
                    <div class="border-bottom d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary stretch-button">Edit Activity</button>
                    </div>

                </div>

                <div class="basiccont p-2">
                    <div class="border-bottom ps-3">
                        <h6 class="fw-bold small">Assignees</h6>
                    </div>
                    @php $count = 0; @endphp
                    <form id="unassignassigneeform" data-url="{{ route('unassign.assignee') }}">
                        @csrf
                        <input type="number" id="unassignassigneeid" name="unassignassigneeid" class="d-none">
                        <input type="number" id="unassignactivityid" name="unassignactivityid" class="d-none" value="{{ $activity['id'] }}">
                    </form>
                    @foreach ($assignees as $key=> $assignee)
                    @if ($count % 2 == 0)
                    <div class="row p-0">
                        @endif
                        <div class="col border-bottom m-2 p-2 divhover checkassignee" value="{{ $assignee->id }}">

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
                <div class="basiccont p-2">
                    <div class="border-bottom ps-3">
                        <h6 class="fw-bold small">Output</h6>
                    </div>
                    @php
                    $outputarray = ['Capacity Building', 'IEC Material', 'Advisory Services', 'Others'];
                    @endphp
                    @foreach ($outputTypes as $outputType)
                    <div class="border-bottom p-2 divhover selectoutputdiv" data-value="{{ $outputType }}">
                        @php
                        $outputarray = array_diff($outputarray, [$outputType]);
                        @endphp
                        <h5>{{ $outputType }}</h5>
                        @foreach ($outputs as $output)
                        @if ($output->output_type === $outputType)
                        {{ $output->output_name . ': ' .  $output->output_submitted }} <br>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                    <div class="border-bottom d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary stretch-button addoutput-btn">Add Output</button>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="basiccont">
                    <div class="border-bottom ps-3">
                        <h6 class="fw-bold small">Subtasks</h6>
                    </div>
                    @foreach ($subtasks as $index => $subtask)
                    @if ($index % 2 == 0)
                    <div class="sidecont1 divhover p-2">{{ $subtask->subtask_name }}</div>
                    @else
                    <div class="sidecont2 divhover p-2">{{ $subtask->subtask_name }}</div>
                    @endif
                    @endforeach


                    <div class="border-bottom d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary stretch-button addsubtask-btn">Add Subtask</button>
                    </div>
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
                        <input type="number" class="d-none" name="activitynumber" id="actid" value="{{ $activity['id'] }}">
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
                <form id="assigneeform" data-url="{{ route('add.assignee') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="assigneeSelect" class="form-label">Assignee</label>
                        <input type="number" class="d-none" name="assigneeactnumber" value="{{ $activity['id'] }}">
                        <select class="form-select" id="assigneeselect" name="assigneeselect">
                            <option value="" selected disabled>Select Assignee</option>
                            @foreach($addassignees as $assignee)

                            <option value="{{ $assignee->id }}">{{ $assignee->name . ' ' . $assignee->last_name }}</option>
                            @endforeach
                        </select>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="addassignee-btn">Add Assignee</button>
            </div>
        </div>
    </div>
</div>
<!-- add output -->
<div class="modal fade" id="addoutputmodal" tabindex="-1" aria-labelledby="addoutputmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssigneeModalLabel">Add Output</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="outputform" data-url="{{ route('add.output') }}">
                    @csrf
                    <input type="number" class="d-none" name="outputactnumber" value="{{ $activity['id'] }}">
                    <input type="number" class="d-none" name="outputindex" id="outputindex">
                    <div class="mb-3">
                        <label for="assigneeSelect" class="form-label">Select the type of output to be submitted.</label>
                        <select class="form-select" id="outputtype-select" name="outputtype">
                            <option value="" selected disabled>Select Output Type</option>
                            @foreach($outputarray as $outputarr)
                            <option value="{{ $outputarr }}">{{ $outputarr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="form-label">Output</label>

                    <div class="divhover pt-2 pb-1 ps-1 outputnamediv d-none">
                        <h6></h6>
                    </div>
                    <div class="row divhover p-2 mt-1 ps-1 outputinputdiv d-none">
                        <div class="col-9">
                            <input type="text" class="form-control w-100" name="newoutput[]" id="output-input">
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-danger btn-sm removeoutput-btn">Remove</button>
                        </div>

                    </div>


                </form>
                <div class="w-60">
                    <button type="button" class="btn btn-success addmoreoutput-btn btn-sm d-none"> Add more Output </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="createoutput-btn">Add Output</button>
            </div>
        </div>
    </div>
</div>
<!--assignees details-->
<div class="modal fade" id="assigneedetails" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong></p>
                <p id="assigneename"> John Doe</p>
                <p><strong>Email:</strong></p>
                <p id="assigneeemail"> johndoe@example.com</p>
                <p><strong>Role:</strong> </p>
                <p id="assigneerole">Developer</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" id="unassignassignee-btn">Unassign</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    var url = "";
    var unassignassigneeid;
    var assignees = <?php echo json_encode($assignees) ?>;
    $(document).ready(function() {

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');

            url = '{{ route("get.objectives", ["id" => Auth::user()->id, "projectid" => ":projectid"]) }}';
            url = url.replace(':projectid', projectid);
            window.location.href = url;
        });

        $(document).on('click', '.selectoutputdiv', function() {
            var outputtype = $(this).attr('data-value');
            var actid = $('#actid').val();

            var url = '{{ route("get.output", ["id" => Auth::user()->id, "activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);
            window.location.href = url;
        });

    });
</script>
<script src="{{ asset('js/activityindex.js') }}"></script>
@endsection