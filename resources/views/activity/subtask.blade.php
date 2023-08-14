@extends('layouts.app')

@section('content')

<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv" data-name="{{ $activity['actname'] }}">
            <input type="number" class="d-none" id="actid" value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Subtask: {{ $subtask['subtask_name'] }}</b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-8">

                <div class="basiccont word-wrap shadow ms-2 mt-4" data-value="{{ $subtask['id'] }}" data-name="{{ $subtask['subtask_name'] }}">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Subtask Hours</h6>
                    </div>
                    <p class="ps-4 lh-1 pt-2"><b>{{ $subtask['subtask_name'] }}</b></p>
                    <p class="ps-5 lh-1">Total Hours Rendered: {{ $subtask['hours_rendered'] }}</p>
                    <p class="ps-5 lh-1">Assignees:
                        @foreach($currentassignees as $currentassignee)
                        {{ $currentassignee->name . ' ' . $currentassignee->last_name . ' |'}}

                        @endforeach
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-1" id="add-subtaskassignees">+</button>
                    </p>
                    <div class="btn-group ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="submithoursrendered-btn">
                            <b class="small">Submit Hours</b>
                        </button>
                    </div>

                </div>
                <div class="basiccont word-wrap shadow ms-2 mt-4">
                    @if($unapprovedhours)
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Hours</h6>
                    </div>
                    <div class="p-2 ps-4 pb-0 border-bottom">

                        <p class="lh-1"> Hours Rendered: {{ $unapprovedhours->hours_rendered }}</p>
                        <p class="lh-1"> Date: {{ \Carbon\Carbon::parse($unapprovedhours->date)->format('F d, Y') }}</p>
                        <p class="lh-1">Participants:
                            @foreach($contributors as $contributor)
                            {{ $contributor->name . ' ' . $contributor->last_name . ' | ' }}
                            @endforeach
                        </p>

                    </div>
                    <div class="btn-group ms-3 mb-3 mt-2 shadow">
                        <form id="accepthoursform" data-url="{{ route('hours.accept') }}">
                            @csrf
                            <input type="text" class="d-none" value="{{ $unapprovedhours->id }}" name="acceptids" id="acceptids">
                            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow accepthours-btn">
                                <b class="small">Accept</b>
                            </button>
                        </form>

                    </div>
                    @elseif($approvedhours)
                    <div class="border-bottom ps-3 pt-2 pe-2" style="background-color:lightgray;">
                        <h6 class="fw-bold small" style="color:darkgreen;">Approved Hours</h6>
                    </div>
                    <div class="p-2 ps-4" style="background-color:lightgray;">

                        <p class="lh-1"> Hours Rendered: {{ $approvedhours->hours_rendered }}</p>
                        <p class="lh-1"> {{ \Carbon\Carbon::parse($approvedhours->date)->format('F d, Y') }} </p>
                        <p class="lh-1">Participants:
                            @foreach($contributors as $contributor)
                            {{ $contributor->name . ' ' . $contributor->last_name . ' | ' }}
                            @endforeach
                        </p>
                    </div>
                    @elseif($approvedhours == null && $unapprovedhours == null)
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Submitted Hours</h6>
                    </div>
                    <div class="p-2 ps-4 pb-0 border-bottom">
                        <h5><em>No Submitted Hours Yet.</em></h5>

                    </div>
                    @endif


                </div>
            </div>
            <div class="col-4">
                <div class="basiccont word-wrap shadow mt-4 me-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Other Subtasks</h6>
                    </div>
                    @foreach ($subtasks as $sub)
                    @if ($sub->subtask_name != $subtask['subtask_name'])

                    <div class="divhover p-2 ps-4 subtaskdiv" data-value="{{ $sub->id }}" data-name="{{ $sub->subtask_name }}">
                        <b class="small">{{ $sub->subtask_name }}</b>
                    </div>

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

            <div class="modal-body">
                <form id="assigneeform" data-url="{{ route('add.subtaskassignee') }}">
                    @csrf
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
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmsubtaskassignee-btn">Add Assignee</button>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    url = "";
    $(document).ready(function() {

        $('#navbarDropdown').click(function(event) {
            // Add your function here
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
        });

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');
            var projectname = $(this).attr('data-name');
            var department = $('#department').val();


            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department", "projectname" => ":projectname"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));
            url = url.replace(':projectname', encodeURIComponent(projectname));
            window.location.href = url;
        });

        $('#activitydiv').click(function(event) {

            event.preventDefault();

            var actid = $('#actid').val();
            var activityname = $(this).attr('data-name');
            var department = $('#department').val();

            var url = '{{ route("activities.display", ["activityid" => ":activityid", "department" => ":department", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':department', department);
            url = url.replace(':activityname', activityname);
            window.location.href = url;
        });

        $(document).on('click', '.subtaskdiv', function() {
            event.preventDefault();

            var subtaskname = $(this).attr("data-name");
            var subtaskid = $(this).attr("data-value");

            var url = '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);
            window.location.href = url;
        });

        $('#add-subtaskassignees').click(function() {
            $('#addSubtaskAssigneeModal').modal('show');
        });
        $('#submithoursrendered-btn').click(function(event) {
            event.preventDefault();
            var subtaskid = $(this).closest('[data-value]').attr('data-value');
            var subtaskname = $(this).closest('[data-name]').attr('data-name');



            var url = '{{ route("comply.subtask", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);

            window.location.href = url;
        });

        $('.accepthours-btn').click(function(event) {
            event.preventDefault();
            var acceptIdsValue = $(this).prev().val();
            var dataurl = $(this).parent().attr('data-url');
            // Create a data object with the value you want to send
            var data1 = $(this).parent().serialize();

            $.ajax({
                url: dataurl, // Replace with your actual AJAX endpoint URL
                type: 'POST',
                data: data1,
                success: function(response) {

                    console.log(response);
                    window.location.href = url;
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    console.log(xhr.responseText);
                    console.error(error);
                }
            });
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