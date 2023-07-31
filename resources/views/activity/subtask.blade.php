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
            <h6><b>Subtask: {{ $subtask['subtask_name'] }}</b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-8">

                <div class="basiccont word-wrap shadow ms-2 mt-4" data-value="{{ $subtask['id'] }}" data-name="{{ $subtask['subtask_name'] }}">
                    <div class="border-bottom ps-3 pt-2">
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
                    <div class="border-bottom ps-3 pt-2">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Hours Rendered</h6>
                    </div>

                    <ul class="list-unstyled small">

                        @foreach ($unapprovedsubtaskdata as $unapprovedsub)
                        @php
                        $hasSameDate = false;
                        @endphp

                        <li class="ps-4">
                            @foreach ($usersWithSameCreatedAt as $samedateusers)
                            @if($unapprovedsub['created_at'] == $samedateusers->created_at)
                            @php
                            $userIds = explode(',', $samedateusers->user_ids);
                            @endphp


                            <b>Hours rendered:</b> {{ $unapprovedsub['hours_rendered'] }} <br>
                            <b>Date Submitted:</b> {{ \Carbon\Carbon::parse($unapprovedsub['created_at'])->format('F d, Y') }} <br>
                            <b>Contributor:</b>
                            @foreach ($userIds as $userId)
                            @php
                            $user = \App\Models\User::find($userId);
                            @endphp
                            @if ($user)
                            {{ $user->name . ' ' . $user->last_name}}
                            @if (!$loop->last) {{-- Check if it's not the last user in the loop --}}
                            {{ ' | ' }}
                            @endif
                            @endif

                            @endforeach
                            <form id="accepthoursform" data-url="{{ route('hours.accept') }}">
                                @csrf
                                <input type="text" class="d-none" value="{{ $samedateusers->created_at }}" name="acceptids" id="acceptids">
                                <button type="button" class="btn btn-sm btn-outline-success accepthours-btn">Accept</button>
                            </form>
                            <hr>
                            @break
                            @endif

                            @endforeach

                        </li>
                        @endforeach
                    </ul>
                    <hr>

                </div>
            </div>
            <div class="col-4">
                <div class="basiccont word-wrap shadow mt-4 me-2">
                    <div class="border-bottom ps-3 pt-2">
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

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');

            url = '{{ route("get.objectives", ["id" => Auth::user()->id, "projectid" => ":projectid"]) }}';
            url = url.replace(':projectid', projectid);
            window.location.href = url;
        });

        $('#activitydiv').click(function(event) {

            event.preventDefault();

            var activityid = $('#actid').val();

            var url = '{{ route("get.activity", ["id" => Auth::user()->id, "activityid" => ":activityid"]) }}';
            url = url.replace(':activityid', activityid);
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

        $(document).on('click', '.accepthours-btn', function() {
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