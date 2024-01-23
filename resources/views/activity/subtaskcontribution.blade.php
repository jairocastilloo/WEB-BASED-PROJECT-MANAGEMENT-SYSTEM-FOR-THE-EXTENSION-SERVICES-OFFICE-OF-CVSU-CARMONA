@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper divhover" id="projectdiv" data-value="{{ $project->id }}"
            data-name="{{ $project->projecttitle }}" data-dept="{{ $project->department }}">
            <div class="step">
                <span class="fw-bold">Project: {{ $project->projecttitle }}</span>
                <div class="message-box text-white">
                    {{ $project->projecttitle }}
                </div>
            </div>


        </div>
        <div class="step-wrapper divhover" id="activitydiv" data-value="{{ $activity->id }}"
            data-name="{{ $activity->actname }}">
            <div class="step">
                <span class="fw-bold">Activity: {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    {{ $activity['actname'] }}
                </div>
            </div>


        </div>
        <div class="step-wrapper divhover" id="subtaskdiv" data-value="{{ $subtask->id }}"
            data-name="{{ $subtask->subtask_name }}">
            <div class="step">
                <span class="fw-bold">Subtask: {{ $subtask['subtask_name'] }}</span>
                <div class="message-box text-white">
                    {{ $subtask['subtask_name'] }}
                </div>
            </div>


        </div>
        <div class="step-wrapper">
            <div class="steps" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                <span class="fw-bold">Accomplishment Report: {{ $subtask['subtask_name'] }}</span>
                <div class="message-box">
                    Accomplishment Report: {{ $subtask['subtask_name'] }}
                </div>
            </div>


        </div>
    </div>
    <div class="container">
        <div class="row">
            @if($othercontribution->isEmpty())
            <div class="col-12">
                @else
                <div class="col-lg-9">
                    @endif
                    <div class="basiccont word-wrap shadow">
                        <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofsubmission }}</h6>
                        </div>

                        <div class="p-2 pb-0 border-bottom">
                            <p class="lh-1 ps-4"><b>{{ $subtask['subtask_name'] }}</b></p>
                            <p class="lh-1 ps-5"><b>Hours Rendered:</b> {{ $contribution->hours_rendered }}</p>
                            <p class="lh-1 ps-5"><b>Rendered Date:</b>
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $contribution->date)->format('F d') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $contribution->enddate)->format('F d') }}
                            </p>
                            <p class="lh-1 ps-5"><b>Related Program <i> (if any)</i>:</b>
                                {{ $contribution->relatedPrograms }}
                            </p>
                            <p class="lh-1 ps-5"><b>Numbers of Clientele/Beneficiaries <i>(if any)</i>:</b>
                                {{ $contribution->clientNumbers }}
                            </p>
                            <p class="lh-1 ps-5"><b>Agency <i>(if any)</i>:</b> {{ $contribution->agency }}</p>

                            <p class="lh-1 ps-5"><b>Submitted In:</b>
                                {{ \Carbon\Carbon::parse($contribution->created_at)->format('F d, Y') }}
                            </p>
                            <p class="lh-1 ps-5"><b>Submitted By:</b>
                                {{ $submitter[0]->name . ' ' . $submitter[0]->last_name }}
                            </p>
                            <p class="lh-1 ps-5"><b>Contributors:</b>
                                @foreach($contributors as $contributor)
                                {{ $contributor->name . ' ' . $contributor->last_name . ' | ' }}
                                @endforeach
                            </p>
                            <p class="lh-1 ps-5">
                                <b>Submission Attachment:</b>
                            </p>
                            @if ( $uploadedFiles != null)
                            <div class="mb-2 text-center">
                                <a href="{{ route('download.file', ['contributionid' => $contribution->id, 'filename' => basename($uploadedFiles[0])]) }}"
                                    class="btn btn-outline-success shadow rounded w-50">
                                    <i
                                        class="bi bi-file-earmark-arrow-down-fill me-2 fs-3"></i><b>{{ basename($uploadedFiles[0]) }}</b>

                                </a>

                            </div>
                            @else
                            <div class="mb-2 text-center">
                                <a class="btn btn-outline-success shadow rounded w-50">
                                    <i class="bi bi-file-earmark-arrow-down-fill me-2 fs-3"></i><b>No Files
                                        Detected.</b>

                                </a>

                            </div>
                            @endif


                            @if( $contribution['approval'] != 1)
                            <div class="btn-group dropdown ms-3 mb-3 mt-2 shadow">
                                <button type="button" class="btn btn-sm rounded btn-gold shadow dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <b class="small">Evaluate Submission</b>
                                </button>
                                @livewire('subtask-hours-submission',[ 'contributionid' => $contribution->id,
                                'subtaskid' => $subtask['id'], 'subtaskname' => $subtask['subtask_name'] ])
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
                @if(!$othercontribution->isEmpty())
                <div class="col-lg-3">

                    @php
                    $countAccepted = 0;

                    $othercontribution = $othercontribution->map(function ($contri) use (&$countAccepted) {
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
                        <div class="border-bottom p-2 pb-0 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Other Accomplishment Report/s</h6>
                        </div>
                        @foreach ($othercontribution as $submission)

                        <div class="p-2 pb-1 ps-3 divhover border-bottom submission-div small"
                            data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                            <p
                                class="lh-1 fw-bold @if($submission->submission_remark == 'For Approval') text-success @elseif($submission->submission_remark == 'For Revision') text-danger @else text-primary @endif">
                                <em>{{ $submission->submission_remark  }}</em>
                            </p>
                            <p class="lh-1"> &nbsp;&nbsp;&nbsp;Activity Hours: {{ $submission->hours_rendered }} </p>
                            <p class="lh-1"> &nbsp;&nbsp;&nbsp;Actual Duration:
                                {{ \Carbon\Carbon::parse($submission->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }}
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


                </div>
                @endif

            </div>
        </div>
    </div>

    @endsection

    @section('scripts')

    <script>
    $(document).ready(function() {
        $('#navbarDropdown').click(function() {
            // Add your function here
            $('#account .dropdown-menu').toggleClass('shows');
        });
        $('.step span').each(function() {
            var $span = $(this);
            if ($span.text().length > 16) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 16) + '...'); // Truncate and add ellipsis
            }
        });
        $('.steps span').each(function() {
            var $span = $(this);
            if ($span.text().length > 16) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 16) + '...'); // Truncate and add ellipsis
            }
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
            var subtaskname = $('#subname').val();
            var subtaskid = $('#subid').val();

            var url =
                '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);


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

            if (approval === "") {
                submission = "For Approval";
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

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');
            var department = $(this).attr('data-dept');



            var url =
                '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));
            window.location.href = url;
        });

        $('#activitydiv').click(function(event) {

            event.preventDefault();
            var
                actid = $(this).attr('data-value');
            var activityname = $(this).attr('data-name');

            var url =
                '{{ route("activities.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':activityname', activityname);
            window.location.href = url;
        });
        $('#subtaskdiv').click(function() {
            event.preventDefault();

            var subtaskname = $(this).attr("data-name");
            var subtaskid = $(this).attr("data-value");

            var
 url =
                '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);
            window.location.href = url;
        });
    });
    </script>

    @endsection