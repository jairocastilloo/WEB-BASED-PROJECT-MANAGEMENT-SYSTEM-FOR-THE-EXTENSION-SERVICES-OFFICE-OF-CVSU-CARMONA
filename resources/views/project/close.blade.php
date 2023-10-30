@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom">
    <div class="mainnav shadow mb-3 shadow-sm">
        <div class="step-wrapper">
            <div class="step divhover" id="projectdiv" data-value="{{ $project->id }}" data-dept="{{ $project->department }}">
                <span class="fw-bold">Project: {{ $project->projecttitle }}</span>
                <div class="message-box text-white">
                    {{ $project->projecttitle }}
                </div>
            </div>
        </div>
        <div class="step-wrapper">
            <div class="step highlight">
                <span class="fw-bold">Close Project: {{ $project->projecttitle }}</span>
                <div class="message-box text-white">
                    Close Project: {{ $project->projecttitle }}
                </div>
            </div>
        </div>

    </div>
    <div class="container">
        @php

        $unevaluatedSubmission = $projectTerminal->filter(function ($contri) {
        return $contri['approval'] === null;
        });
        $acceptedSubmission = $projectTerminal->filter(function ($contri) {
        return $contri['approval'] === 1;
        });
        $rejectedSubmission = $projectTerminal->filter(function ($contri) {
        return $contri['approval'] === 0;
        });

        @endphp
        <div class="basiccont word-wrap shadow">
            <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Close Project: {{ $project->projecttitle }}</h6>
            </div>

            <div class="p-2 pb-0 ps-5 border-bottom">
                <p class="lh-1">Project Title: {{ $project->projecttitle }}</p>
                <p class="lh-1">Project Duration: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $project->projectstartdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $project->projectenddate)->format('F d, Y') }}</p>
                <p class="lh-1">Activities in this project: {{ $allActivities }}</p>
                <p class="lh-1">In Progress: {{ $inProgressActivities }} </p>
                <p class="lh-1">Not Started: {{ $notStartedActivities }} </p>
                <p class="lh-1">Completed: {{ $completedActivities }} </p>
                <p class="lh-1">Overdue: {{ $overdueActivities }}</p>
            </div>
            @if (count($acceptedSubmission) == 0)
            <div class="btn-group ms-3 mb-3 mt-2 shadow">
                <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" data-bs-toggle="modal" data-bs-target="#terminalReportModal">
                    <b class="small">Submit Terminal Report</b>
                </button>
            </div>
            @endif
            <div class="modal fade" id="terminalReportModal" tabindex="-1" aria-labelledby="terminalReportModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="terminalReportModalLabel">Upload Terminal Report</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form data-url="{{ route('projects.uploadterminal') }}" id="terminalForm">
                                @csrf
                                <input type="hidden" name="project-id" value="{{ $project->id }}">
                                <input type="hidden" name="submitter-id" value="{{ Auth::user()->id }}">
                                <div class="mb-3">
                                    <label for="projectstartdate" class="form-label">Project Start Date</label>
                                    <div class="input-group date" id="startDatePicker">
                                        <input type="text" class="form-control" id="projectstartdate" name="projectstartdate" placeholder="mm/dd/yyyy" />
                                        <span class="input-group-append">
                                            <span class="input-group-text bg-light d-block">
                                                <i class="bi bi-calendar-event-fill"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label for="projectenddate" class="form-label">Project End Date</label>
                                    <div class="input-group date" id="endDatePicker">
                                        <input type="text" class="form-control" id="projectenddate" name="projectenddate" placeholder="mm/dd/yyyy" />
                                        <span class="input-group-append">
                                            <span class="input-group-text bg-light d-block">
                                                <i class="bi bi-calendar-event-fill"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="terminal_file">Choose File:</label>
                                    <input type="file" class="form-control" id="terminal_file" accept=".docx" name="terminal_file">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary submitTerminal">Upload</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>



        @if($projectTerminal->isEmpty())
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
            <div class="p-2 pb-1 ps-4 small divhover border-bottom actsubmission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">


                <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }} </p>
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
            <div class="p-2 pb-1 ps-4 small divhover border-bottom actsubmission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">


                <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }} </p>
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
            <div class="p-2 pb-1 ps-4 small divhover border-bottom actsubmission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                <p class="lh-1 fw-bold"> Notes: {{ $submission->notes }}</p>
                <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }} </p>
                <p class="lh-1 ps-4"> Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>

            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection

@section('scripts')

<script>
    var url = "";

    $(document).ready(function() {

        $('#startDatePicker').datepicker();

        $('#startDatePicker').datepicker().on('change', function(e) {
            $('#startDatePicker').datepicker('hide');
        });
        $('#endDatePicker').datepicker();

        $('#endDatePicker').datepicker().on('change', function(e) {
            $('#endDatePicker').datepicker('hide');
        });

        $(document).on('click', '.submithours-btn', function() {
            var activityid = $('#activitydiv').attr("data-value");
            var activityname = $('#activitydiv').attr("data-name");

            var url = '{{ route("comply.activity", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':activityname', activityname);

            window.location.href = url;
        });


        $('.submitTerminal').click(function(event) {
            event.preventDefault();
            var dataurl = $('#terminalForm').attr('data-url');
            // Create a data object with the value you want to send
            var formData = new FormData($("#terminalForm")[0]);
            var goToUrl = "{{ route('projsubmission.display', [ 'projsubmissionid' => ':projsubmissionid', 'projsubmissionname' => 'Unevaluated-Submission' ])}}"


            $.ajax({
                url: dataurl, // Replace with your actual AJAX endpoint URL
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    goToUrl = goToUrl.replace(':projsubmissionid', response.projsubmissionid);
                    window.location.href = goToUrl;

                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    console.log(xhr.responseText);
                    console.error(error);
                }
            });
        });

        $(document).on('click', '.actsubmission-div', function() {
            event.preventDefault();

            var actsubmissionid = $(this).attr("data-id");
            var actapproval = $(this).attr("data-approval");
            var actsubmission;

            if (actapproval === "") {
                actsubmission = "Unevaluated-Submission";
            } else if (actapproval == 0) {
                actsubmission = "Rejected-Submission";
            } else if (actapproval == 1) {
                actsubmission = "Accepted-Submission";
            }


            var url = '{{ route("actsubmission.display", ["actsubmissionid" => ":actsubmissionid", "actsubmissionname" => ":actsubmissionname"]) }}';
            url = url.replace(':actsubmissionid', actsubmissionid);
            url = url.replace(':actsubmissionname', actsubmission);
            window.location.href = url;
        });

        $('.step span').each(function() {
            var $span = $(this);
            if ($span.text().length > 16) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 16) + '...'); // Truncate and add ellipsis
            }
        });

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');
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
        $('#navbarDropdown').click(function() {
            // Add your function here
            $('#account .dropdown-menu').toggleClass('shows');
        });
    });
</script>

@endsection