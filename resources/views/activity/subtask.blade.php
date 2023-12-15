@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
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
                $countAccepted = 0;

                $contributions = $contributions->map(function ($contri) use (&$countAccepted) {
                if ($contri['approval'] === null) {
                $contri['submission_remark'] = 'For Evaluation';
                } elseif ($contri['approval'] === 1) {
                $countAccepted++;
                $contri['submission_remark'] = 'Accepted';
                } elseif ($contri['approval'] === 0) {
                $contri['submission_remark'] = 'For Revision';
                } else {
                $contri['submission_remark'] = 'Unknown'; // Handle other cases if needed
                }

                return $contri;
                });
                @endphp


                @livewire('subtask-details', ['subtask' => $subtask ])
                <!--
                    <div class="btn-group m-2 ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" data-bs-toggle="modal" data-bs-target="#accomplishmentReportModal">
                            <b class="small">Submit Accomplishment Report</b>
                        </button>
                    </div>
                -->


                @if(!$contributions->isEmpty())

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 p-2 pb-0 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Accomplishment Report/s</h6>
                    </div>
                    @foreach ($contributions as $submission)

                    <div class="p-2 pb-1 ps-3 divhover border-bottom submission-div small" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold @if($submission->submission_remark == 'For Approval') text-success @elseif($submission->submission_remark == 'For Revision') text-danger @else text-primary @endif">
                            <em>{{ $submission->submission_remark  }}</em>
                        </p>
                        <p class="lh-1"> &nbsp;&nbsp;&nbsp;Activity Hours: {{ $submission->hours_rendered }} </p>
                        <p class="lh-1"> &nbsp;&nbsp;&nbsp;Task Duration:
                            {{ \Carbon\Carbon::parse($submission->date)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }}
                        </p>
                        <p class="lh-1"> &nbsp;&nbsp;&nbsp;Submitted in:
                            {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }}
                        </p>
                        @if ( $submission->notes != null)
                        <p class="lh-1"> &nbsp;&nbsp;&nbsp;<em>Notes: {{ $submission->notes }} </em></p>
                        @endif
                    </div>

                    @endforeach
                </div>
                @endif
                @livewire('subtask-assignees', ['subtask' => $subtask, 'activity' => $activity ])
            </div>

            <div class="col-lg-3">
                <label class="ms-3 small form-label text-secondary fw-bold">Other Subtasks</label>

                @livewire('ongoing-tasks', ['activityid' => $activity->id, 'subtaskid' => $subtask->id, 'xOngoingTasks'
                => 1])
                @livewire('missing-tasks', ['activityid' => $activity->id, 'subtaskid' => $subtask->id, 'xMissingTasks'
                => 1])
                @livewire('completed-tasks', ['activityid' => $activity->id, 'subtaskid' => $subtask->id,
                'xCompletedTasks' => 0])



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

    function redirectToHomepage() {
        window.location.href = ""; // Change the URL to your desired destination
    }
    $(document).ready(function() {
        $('.step span').each(function() {
            var $span = $(this);
            if ($span.text().length > 15) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 15) + '...'); // Truncate and add ellipsis
            }
        });



        $('#navbarDropdown').click(function(event) {
            // Add your function here
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
        });

        $('#startDatePicker').datepicker();

        $('#startDatePicker').datepicker().on('change', function(e) {
            $('#startDatePicker').datepicker('hide');
        });
        $('#endDatePicker').datepicker();

        $('#endDatePicker').datepicker().on('change', function(e) {
            $('#endDatePicker').datepicker('hide');
        });

        $('#subtaskcontributors').selectpicker('refresh');

        $('.submitAccomplishment').click(function(event) {
            event.preventDefault();
            $(this).prop('disabled', true);
            var hasError = submitFileError();
            $(this).prop('disabled', false);
            if (!hasError) {
                var dataurl = $('#accomplishmentForm').attr('data-url');
                // Create a data object with the value you want to send
                var formData = new FormData($("#accomplishmentForm")[0]);
                var goToUrl =
                    "{{ route('submission.display', [ 'submissionid' => ':submissionid', 'submissionname' => 'For Evaluation' ])}}"


                $.ajax({
                    url: dataurl, // Replace with your actual AJAX endpoint URL
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        goToUrl = goToUrl.replace(':submissionid', response.submissionid);
                        window.location.href = goToUrl;

                    },
                    error: function(xhr, status, error) {
                        // Handle the error here
                        console.log(xhr.responseText);
                        console.error(error);
                    }
                });
            }
        });

        function submitFileError() {
            var hasError = false;
            $('#accomplishmentForm div span.invalid-feedback').hide();
            $('#accomplishmentForm input').removeClass('is-invalid');


            // File validation
            var fileInput = $('#accomplishment_file')[0];


            if ($('#hours-rendered').val() == "" || $('#hours-rendered').val() == 0) {
                $('#hours-rendered').addClass('is-invalid');
                $('#hours-rendered').next().text('Please input hours.').show();
                hasError = true;
            }
            if ($('#subtaskstartdate').val() == "") {
                $('#subtaskstartdate').addClass('is-invalid');
                $('#subtaskstartdate').parent().next().text('Please input subtask start date.').show();
                hasError = true;
            }
            if ($('#subtaskenddate').val() == "") {
                $('#subtaskenddate').addClass('is-invalid');
                $('#subtaskenddate').parent().next().text('Please input subtask end date.').show();
                hasError = true;
            }
            var selectedOptionsContri = $('#subtaskcontributors :selected');
            if (selectedOptionsContri.length === 0) {

                $('#subtaskcontributorserror').text('Please add subtask contributor.').show();
            }
            if (fileInput.files && fileInput.files.length > 0) {
                var fileSize = fileInput.files[0].size;
                var fileType = fileInput.files[0].type;

                if (fileType !== 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    $('#accomplishment_file').addClass('is-invalid');
                    $('#accomplishment_file').next().text('Please upload a .docx file.').show();

                    hasError = true;
                }

                if (fileSize > 10 * 1024 * 1024) {
                    $('#accomplishment_file').addClass('is-invalid');
                    $('#accomplishment_file').next().text('File size must be less than 10MB.').show();
                    hasError = true;
                }
            } else {
                $('#accomplishment_file').addClass('is-invalid');
                $('#accomplishment_file').next().text('Please select a file.').show();
                hasError = true;
            }

            return hasError;
        }
        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');
            var projectname = $(this).attr('data-name');
            var department = $(this).attr('data-dept');


            var url =
                '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));
            window.location.href = url;
        });

        $('#activitydiv').click(function(event) {

            event.preventDefault();
            var actid = $(this).attr('data-value');
            var activityname = $(this).attr('data-name');

            var url =
                '{{ route("activities.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':activityname', activityname);
            window.location.href = url;
        });

        $(document).on('click', '.subtaskdiv', function() {
            event.preventDefault();

            var subtaskname = $(this).attr("data-name");
            var subtaskid = $(this).attr("data-value");

            var url =
                '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
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



            var url =
                '{{ route("comply.subtask", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
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
                submission = "For Evaluation";
            } else if (approval == 0) {
                submission = "For Revision";
            } else if (approval == 1) {
                submission = "Accepted";
            }


            var url =
                '{{ route("submission.display", ["submissionid" => ":submissionid", "submissionname" => ":submissionname"]) }}';
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