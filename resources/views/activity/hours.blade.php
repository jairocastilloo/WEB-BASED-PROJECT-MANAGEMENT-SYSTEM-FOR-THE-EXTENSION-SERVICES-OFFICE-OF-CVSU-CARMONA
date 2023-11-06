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
        <div class="step-wrapper divhover" id="activitydiv" data-value="{{ $activity->id }}" data-name="{{ $activity->actname }}">
            <div class="step">
                <span class="fw-bold">Activity: {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    {{ $activity['actname'] }}
                </div>
            </div>


        </div>
        <div class="step-wrapper">
            <div class="step highlight">
                <span class="fw-bold">Close Activity: {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    Close Activity: {{ $activity->actname }}
                </div>
            </div>


        </div>
    </div>
    <div class="container">
        @php
        $countAccepted = 0;

        $activitycontributions = $activitycontributions->map(function ($contri) use (&$countAccepted) {
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
                <h6 class="fw-bold small" style="color:darkgreen;">Close Activity: {{ $activity->actname }}</h6>
            </div>
            <div class="p-2 ps-3 border-bottom">
                <p class="lh-1 fw-bold">{{ $activity->actname }}</p>
                <p class="lh-1">&nbsp;&nbsp;&nbsp;<b>Planned Duration:</b> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $activity->actstartdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $activity->actenddate)->format('F d') }}</p>
                <p class="lh-1 mb-0">&nbsp;&nbsp;&nbsp;<b>Subtasks Completed:</b> <em>{{ $completedSubtasks . ' / ' . $allSubtasks }}</em></p>
                <p class="lh-1 m-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Active: {{ $activeSubtasks }}</em> </p>
                <p class="lh-1 m-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Missing: {{ $missingSubtasks }}</em> </p>
                <p class="lh-1 m-2 mb-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Completed: {{ $completedSubtasks }}</em> </p>
                <p class="lh-1 mb-2">&nbsp;&nbsp;&nbsp;<b>Outputs Completed:</b></p>
                @foreach ($outputTypes as $outputType)
                <p class="lh-1 mb-0 mt-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $outputType }} </p>
                @foreach ($outputs as $output)
                @if ($output->output_type == $outputType)
                <p class="lh-1 m-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <em>{{ $output->output_name . ': ' . $output->totaloutput_submitted . ' / ' . $output->expectedoutput }}</em>
                </p>
                @endif
                @endforeach
                @endforeach


            </div>

            @if ($countAccepted == 0)
            <div class="btn-group m-2 ms-3 mb-3 shadow">
                <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" data-bs-toggle="modal" data-bs-target="#accomplishmentReportModal">
                    <b class="small">Submit Accomplishment Report</b>
                </button>
            </div>
            <div class="modal fade" id="accomplishmentReportModal" tabindex="-1" aria-labelledby="accomplishmentReportModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="accomplishmentReportModalLabel">Upload Accomplishment Report</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form data-url="{{ route('activities.uploadaccomplishment') }}" id="accomplishmentForm">
                                @csrf
                                <input type="hidden" name="activity-id" value="{{ $activity->id }}">
                                <input type="hidden" name="submitter-id" value="{{ Auth::user()->id }}">
                                <div class="mb-3">
                                    <label class="form-label">Activity Hours:</label>
                                    <input type="number" class="form-control" id="hours-rendered" name="hours-rendered" placeholder="Enter hours rendered" value="0" min="0" step="1">
                                </div>
                                <div class="mb-3">
                                    <label for="activitystartdate" class="form-label">Activity Start Date</label>
                                    <div class="input-group date" id="startDatePicker">
                                        <input type="text" class="form-control" id="activitystartdate" name="activitystartdate" placeholder="mm/dd/yyyy" />
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
                                    <label for="activityenddate" class="form-label">Activity End Date</label>
                                    <div class="input-group date" id="endDatePicker">
                                        <input type="text" class="form-control" id="activityenddate" name="activityenddate" placeholder="mm/dd/yyyy" />
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
                                <div class="container mb-3 p-0">
                                    <label for="implementers" class="form-label">Activity Implementers</label>
                                    <select class="selectpicker w-100 border activityimplementers" name="activityimplementers[]" id="activityimplementers" multiple aria-label="Select Implementers" data-live-search="true">
                                        <option value="0" disabled>Select Implementers</option>
                                        @foreach ($implementers as $implementer)

                                        <option value="{{ $implementer->id }}">{{ $implementer->name . ' ' . $implementer->last_name }}</option>

                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="accomplishment_file">Choose File:</label>
                                    <input type="file" class="form-control" id="accomplishment_file" accept=".docx" name="accomplishment_file">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary submitAccomplishment">Upload</button>
                        </div>

                    </div>
                </div>
            </div>
            @endif
        </div>

        <!--
        <div class="basiccont word-wrap shadow">
            <div class="border-bottom ps-3 pt-2 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Submission</h6>
            </div>
            <div class="text-center p-4">
                <h4><em>No Submission Yet.</em></h4>
            </div>
        </div>
    -->

        @if(!$activitycontributions->isEmpty())

        <div class="basiccont word-wrap shadow">
            <div class="border-bottom ps-3 p-2 pb-0 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Accomplishment Report/s</h6>
            </div>
            @foreach ($activitycontributions as $submission)

            <div class="p-2 pb-1 ps-3 divhover border-bottom actsubmission-div small" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                <p class="lh-1 fw-bold"><em>{{ $submission->submission_remark  }}</em></p>
                <p class="lh-1"> &nbsp;&nbsp;&nbsp;Activity Hours: {{ $submission->hours_rendered }} </p>
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

        $('.submitAccomplishment').click(function(event) {
            event.preventDefault();
            var dataurl = $('#accomplishmentForm').attr('data-url');
            // Create a data object with the value you want to send
            var formData = new FormData($("#accomplishmentForm")[0]);
            var goToUrl = "{{ route('actsubmission.display', [ 'actsubmissionid' => ':actsubmissionid', 'actsubmissionname' => 'For Evaluation' ])}}"


            $.ajax({
                url: dataurl, // Replace with your actual AJAX endpoint URL
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    goToUrl = goToUrl.replace(':actsubmissionid', response.actsubmissionid);
                    window.location.href = goToUrl;

                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    console.log(xhr.responseText);
                    console.error(error);
                }
            });
        });
        $(document).on('click', '.submithours-btn', function() {
            var activityid = $('#activitydiv').attr("data-value");
            var activityname = $('#activitydiv').attr("data-name");

            var url = '{{ route("comply.activity", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':activityname', activityname);

            window.location.href = url;
        });


        $('.acceptacthours-btn').click(function(event) {
            event.preventDefault();
            var dataurl = $(this).parent().attr('data-url');
            // Create a data object with the value you want to send
            var data1 = $(this).parent().serialize();

            $.ajax({
                url: dataurl, // Replace with your actual AJAX endpoint URL
                type: 'POST',
                data: data1,
                success: function(response) {
                    window.location.href = url;
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
                actsubmission = "For Evaluation";
            } else if (actapproval == 0) {
                actsubmission = "For Revision";
            } else if (actapproval == 1) {
                actsubmission = "Accepted";
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