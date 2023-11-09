@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm">
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
        <div class="step-wrapper containerhover" id="activityhours-btn" data-value="{{ $activity->id }}" data-name="{{ $activity->actname }}">
            <div class="step">
                <span class="fw-bold">Close Activity: {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    Close Activity: {{ $activity['actname'] }}
                </div>
            </div>


        </div>

        <div class="step-wrapper">
            <div class="steps highlight" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                <span class="fw-bold">Accomplishment Report: {{ $activity['actname'] }}</span>
                <div class="message-box">
                    Accomplishment Report: {{ $activity['actname'] }}
                </div>
            </div>


        </div>
    </div>
    <div class="container">
        <div class="row">

            @if($otheractcontribution->isEmpty())
            <div class="col-12">
                @else
                <div class="col-lg-9">
                    @endif
                    <div class="basiccont word-wrap shadow">
                        <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofactsubmission }}</h6>
                        </div>

                        <div class="p-2 pb-0 border-bottom">
                            <p class="lh-1 ps-4"><b>{{ $activity->actname }}</b></p>
                            <p class="lh-1 ps-5"><b>Hours Rendered:</b> {{ $actcontribution->hours_rendered }}</p>
                            <p class="lh-1 ps-5"><b>Rendered Date:</b> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $actcontribution->startdate)->format('F d') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $actcontribution->enddate)->format('F d') }}</p>
                            <p class="lh-1 ps-5"><b>Submitted In:</b> {{ \Carbon\Carbon::parse($actcontribution->created_at)->format('F d, Y') }}</p>
                            <p class="lh-1 ps-5"><b>Submitted By:</b> {{ $submitter[0]->name . ' ' . $submitter[0]->last_name }}</p>
                            <p class="lh-1 ps-5"><b>Contributors:</b>
                                @foreach($actcontributors as $actcontributor)
                                {{ $actcontributor->name . ' ' . $actcontributor->last_name . ' | ' }}
                                @endforeach
                            </p>
                            <p class="lh-1 ps-5"><b>Submission Attachment:</b></p>
                            <div class="mb-2 text-center">
                                <a href="{{ route('downloadactivity.file', ['actcontributionid' => $actcontribution->id, 'filename' => basename($uploadedFiles[0])]) }}" class="btn btn-outline-success shadow rounded w-50">
                                    <i class="bi bi-file-earmark-arrow-down-fill me-2 fs-3"></i><b>{{ basename($uploadedFiles[0]) }}</b>

                                </a>

                            </div>

                            @if( $actcontribution['approval'] != 1)
                            <div class="btn-group dropdown ms-3 mb-3 mt-2 shadow">
                                <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <b class="small">Evaluate Submission</b>
                                </button>
                                @livewire('activity-hours-submission', [ 'actcontributionid' => $actcontribution->id, 'activityid' => $activity->id, 'activityname' => $activity->actname ])

                            </div>
                            @endif
                        </div>

                    </div>
                </div>
                @if(!$otheractcontribution->isEmpty())
                <div class="col-lg-3">

                    @php
                    $countAccepted = 0;

                    $otheractcontribution = $otheractcontribution->map(function ($contri) use (&$countAccepted) {
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
                        @foreach ($otheractcontribution as $submission)

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


            $('#projectdiv').click(function(event) {
                event.preventDefault();
                var projectid = $(this).attr('data-value');
                var department = $(this).attr('data-dept');



                var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';
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

            $('#activityhours-btn').click(function(event) {
                event.preventDefault();
                var activityid = $(this).attr('data-value');
                var activityname = $(this).attr('data-name');


                var url = '{{ route("hours.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
                url = url.replace(':activityid', activityid);
                url = url.replace(':activityname', activityname);


                window.location.href = url;
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

                var activityid = $('.activitydata').attr("data-value");
                var activityname = $('.activitydata').attr("data-name");


                var url = '{{ route("hours.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
                url = url.replace(':activityid', activityid);
                url = url.replace(':activityname', activityname);



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

        });
    </script>

    @endsection