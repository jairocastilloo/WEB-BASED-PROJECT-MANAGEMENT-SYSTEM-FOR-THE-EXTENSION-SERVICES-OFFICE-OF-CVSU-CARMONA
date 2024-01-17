@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
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
        $countAccepted = 0;

        $projectTerminal = $projectTerminal->map(function ($contri) use (&$countAccepted) {
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


        <div class="basiccont word-wrap shadow">
            <div class="border-bottom p-2 ps-3 pb-0 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Close Project: {{ $project->projecttitle }}</h6>
            </div>

            <div class="p-2 pb-0 ps-3 border-bottom">
                <p class="lh-1 fw-bold">{{ $project->projecttitle }}</p>
                <p class="lh-1">&nbsp;&nbsp;&nbsp;<b>Planned Duration:</b> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $project->projectstartdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $project->projectenddate)->format('F d, Y') }}</p>
                <p class="lh-1 mb-0">&nbsp;&nbsp;&nbsp;<b>Activities Completed:</b> {{ $completedActivities . ' out of ' . $allActivities }}</p>
                <p class="lh-1 m-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>In Progress: {{ $inProgressActivities }}</em> </p>
                <p class="lh-1 m-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Not Started: {{ $notStartedActivities }}</em> </p>
                <p class="lh-1 m-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Completed: {{ $completedActivities }}</em> </p>
                <p class="lh-1 m-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Overdue: {{ $overdueActivities }}</em></p>
            </div>
            @if ($countAccepted == 0)
            <div class="btn-group m-2 ms-3 mb-3 shadow">
                <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" data-bs-toggle="modal" data-bs-target="#terminalReportModal">
                    <b class="small">Submit Terminal Report</b>
                </button>
            </div>

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
                                    <input type="file" class="form-control" id="terminal_file" accept=".pdf, .docx" name="terminal_file">
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
            @endif

        </div>


        <!--
        <div class="basiccont word-wrap shadow">
            <div class="border-bottom p-2 pb-0 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Terminal Report/s</h6>
            </div>
            <div class="text-center p-4">
                <h4><em>No Submitted Terminal Report/s Yet.</em></h4>
            </div>
        </div>
    -->
        @if(!$projectTerminal->isEmpty())

        <div class="basiccont word-wrap shadow">
            <div class="border-bottom p-2 pb-0 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Terminal Report/s</h6>
            </div>
            @foreach ($projectTerminal as $submission)

            <div class="p-2 pb-1 ps-3 divhover border-bottom projsubmission-div small" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                <p class="lh-1 fw-bold @if($submission->submission_remark == 'For Approval') text-success @elseif($submission->submission_remark == 'For Revision') text-danger @else text-primary @endif"><em>{{ $submission->submission_remark  }}</em></p>
                <p class="lh-1"> &nbsp;&nbsp;&nbsp;Actual Duration: {{ \Carbon\Carbon::parse($submission->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }} </p>
                <p class="lh-1"> &nbsp;&nbsp;&nbsp;Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>
                @if ( $submission->notes != null)
                <p class="lh-1"> &nbsp;&nbsp;&nbsp;<em>Notes: {{ $submission->notes }} </em></p>
                @endif
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

        $('.submitTerminal').click(function(event) {
            event.preventDefault();
            var dataurl = $('#terminalForm').attr('data-url');
            // Create a data object with the value you want to send
            var formData = new FormData($("#terminalForm")[0]);
            var goToUrl = "{{ route('projsubmission.display', [ 'projsubmissionid' => ':projsubmissionid', 'projsubmissionname' => 'For Evaluation' ])}}"


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

        $(document).on('click', '.projsubmission-div', function() {
            event.preventDefault();

            var projsubmissionid = $(this).attr("data-id");
            var projapproval = $(this).attr("data-approval");
            var projsubmission;

            if (projapproval === "") {
                projsubmission = "For Evaluation";
            } else if (projapproval == 0) {
                projsubmission = "For Revision";
            } else if (projapproval == 1) {
                projsubmission = "Accepted";
            }


            var url = '{{ route("projsubmission.display", ["projsubmissionid" => ":projsubmissionid", "projsubmissionname" => ":projsubmissionname"]) }}';
            url = url.replace(':projsubmissionid', projsubmissionid);
            url = url.replace(':projsubmissionname', projsubmission);
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

        $('#navbarDropdown').click(function() {
            // Add your function here
            $('#account .dropdown-menu').toggleClass('shows');
        });
    });
</script>

@endsection