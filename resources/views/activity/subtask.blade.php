@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom">
    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper divhover" id="projectdiv" data-value="{{ $project->id }}" data-name="{{ $project->projecttitle }}" data-dept="{{ $project['department'] }}">
            <div class="step">
                <span class="fw-bold">Project: {{ $project['projecttitle'] }}</span>
                <div class="message-box text-white">
                    {{ $project['projecttitle'] }}
                </div>
            </div>


        </div>
        <div class="step-wrapper divhover" id="activitydiv" data-value="{{ $activity->id }}" data-name="{{ $activity->actname }}">
            <div class="step">
                <span class="fw-bold">Activity: {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    {{ $activity['actname'] }}
                </div>
            </div>


        </div>
        <div class="step-wrapper divhover">
            <div class="step highlight">
                <span class="fw-bold">Subtask: {{ $subtask['subtask_name'] }}</span>
                <div class="message-box">
                    {{ $subtask['subtask_name'] }}
                </div>
            </div>


        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @php

                $unevaluatedSubmission = $contributions->filter(function ($contri) {
                return $contri['approval'] === null;
                });
                $acceptedSubmission = $contributions->filter(function ($contri) {
                return $contri['approval'] === 1;
                });
                $rejectedSubmission = $contributions->filter(function ($contri) {
                return $contri['approval'] === 0;
                });

                @endphp

                <div class="basiccont word-wrap shadow pb-2" data-value="{{ $subtask['id'] }}" data-name="{{ $subtask['subtask_name'] }}">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Subtask</h6>
                    </div>
                    <p class="ps-4 lh-1 pt-2"><b>Name:</b> {{ $subtask['subtask_name'] }}</p>
                    <p class="ps-4 lh-1"><b>Total Hours Rendered:</b> {{ $subtask['hours_rendered'] }}</p>
                    <p class="ps-4 lh-1"><b>Due Date:</b> {{ \Carbon\Carbon::parse($subtask->subduedate)->format('F d, Y') }}
                    </p>
                    @if (count($acceptedSubmission) == 0)
                    <div class="btn-group ms-3 mb-1 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="submithoursrendered-btn">
                            <b class="small">Submit Hours</b>
                        </button>
                    </div>
                    @endif

                </div>

                @if($contributions->isEmpty())
                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Submission</h6>
                    </div>
                    <div class="text-center p-4">
                        <h4><em>No Submission Yet.</em></h4>
                    </div>
                </div>
                @endif

                @if (count($unevaluatedSubmission) > 0)

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Submission</h6>
                    </div>
                    @foreach ($unevaluatedSubmission as $submission)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom submission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
                        <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->date)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-4"> Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>

                    </div>

                    @endforeach
                </div>
                @endif
                @if (count($acceptedSubmission) > 0)

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Accepted Submission</h6>
                    </div>
                    @foreach ($acceptedSubmission as $submission)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom submission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
                        <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->date)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-4"> Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>

                    </div>
                    @endforeach
                </div>
                @endif
                @if (count($rejectedSubmission) > 0)

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">For Revision</h6>
                    </div>
                    @foreach ($rejectedSubmission as $submission)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom submission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
                        <p class="lh-1 fw-bold"> Notes: {{ $submission->notes }}</p>
                        <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->date)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-4"> Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>

                    </div>
                    @endforeach
                </div>
                @endif
                @livewire('subtask-assignees', ['subtask' => $subtask, 'activity' => $activity ])
            </div>

            <div class="col-lg-3">
                <label class="ms-3 small form-label text-secondary fw-bold">Other Subtasks</label>

                @livewire('ongoing-tasks', ['activityid' => $activity->id, 'subtaskid' => $subtask->id, 'xOngoingTasks' => 1])
                @livewire('missing-tasks', ['activityid' => $activity->id, 'subtaskid' => $subtask->id, 'xMissingTasks' => 1])
                @livewire('completed-tasks', ['activityid' => $activity->id, 'subtaskid' => $subtask->id, 'xCompletedTasks' => 0])



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
                <input type="hidden" id="assigneedataid" name="assigneedataid">
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" id="unassignassignee-dismiss" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    var url = "";
    $(document).ready(function() {
        $('.step span').each(function() {
            var $span = $(this);
            if ($span.text().length > 16) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 16) + '...'); // Truncate and add ellipsis
            }
        });

        $('#navbarDropdown').click(function(event) {
            // Add your function here
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
        });

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');
            var projectname = $(this).attr('data-name');
            var department = $(this).attr('data-dept');


            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));
            window.location.href = url;
        });

        $('#activitydiv').click(function(event) {

            event.preventDefault();
            var actid = $(this).attr('data-value');
            var activityname = $(this).attr('data-name');

            var url = '{{ route("activities.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', actid);
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

        $('.accept-link').on('click', function(event) {
            event.preventDefault();
            $('#isApprove').val('true'); // Set the value for "isApprove" input
            submitForm();
        });

        // Event listener for the "Reject" link
        $('.reject-link').on('click', function(event) {
            event.preventDefault();
            $('#isApprove').val('false'); // Set the value for "isApprove" input
            submitForm();
        });

        function submitForm() {
            var formData = $('#accepthoursform').serialize(); // Serialize form data
            var dataurl = $('#accepthoursform').data('url'); // Get the form data-url attribute

            $.ajax({
                type: 'POST',
                url: dataurl,
                data: formData,
                success: function(response) {
                    window.location.href = url;
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error:', error);
                }
            });
        }

        $(document).on('click', '.submission-div', function() {
            event.preventDefault();

            var submissionid = $(this).attr("data-id");
            var approval = $(this).attr("data-approval");
            var submission;
            console.log(approval);
            if (approval === "") {
                submission = "Unevaluated-Submission";
            } else if (approval == 0) {
                submission = "Rejected-Submission";
            } else if (approval == 1) {
                submission = "Accepted-Submission";
            }


            var url = '{{ route("submission.display", ["submissionid" => ":submissionid", "submissionname" => ":submissionname"]) }}';
            url = url.replace(':submissionid', submissionid);
            url = url.replace(':submissionname', submission);
            window.location.href = url;
        });


        $(document).on('click', '.checkassignee', function(event) {


            $('#assigneename').text($(this).attr('data-name'));
            $('#assigneeemail').text($(this).attr('data-email'));
            $('#assigneerole').text($(this).attr('data-role'));
            $('#assigneedataid').val($(this).attr('data-id'));
            // Open the modal or perform other actions
            $('#assigneedetails').modal('show');
        });
    });
</script>
@endsection