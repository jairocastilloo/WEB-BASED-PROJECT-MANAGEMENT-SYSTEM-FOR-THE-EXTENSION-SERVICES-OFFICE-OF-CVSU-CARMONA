@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom">
    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper">
            <div class="step divhover" id="projectdiv" data-value="{{ $project->id }}" data-dept="{{ $project->department }}">
                <span class="fw-bold">Project: {{ $project->projecttitle }}</span>
                <div class="message-box text-white">
                    {{ $project->projecttitle }}
                </div>
            </div>


        </div>

        <div class="step-wrapper">
            <div class="step divhover" id="closeprojectdiv" data-value="{{ $project->id }}" data-dept="{{ $project->department }}">
                <span class="fw-bold">Close Project: {{ $project->projecttitle }}</span>
                <div class="message-box text-white">
                    Close Project: {{ $project->projecttitle }}
                </div>
            </div>
        </div>

        <div class="step-wrapper">
            <div class="steps" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                <span class="fw-bold">Terminal Report: {{ $project->projecttitle }}</span>
                <div class="message-box text-white">
                    Terminal Report: {{ $project->projecttitle }}
                </div>
            </div>
        </div>


    </div>
    <div class="container">
        <div class="row">
            @if($otherprojcontribution->isEmpty())
            <div class="col-12">
                @else
                <div class="col-lg-9">
                    @endif
                    <div class="basiccont word-wrap shadow">
                        <div class="border-bottom p-2 ps-3 pb-0 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofprojsubmission }}</h6>
                        </div>

                        <div class="p-2 pb-0 ps-3 border-bottom">
                            <p class="lh-1"><b>{{ $project->projecttitle }}</b></p>
                            <p class="lh-1">&nbsp;&nbsp;&nbsp;<b>Actual Duration:</b> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $projcontribution->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $projcontribution->enddate)->format('F d, Y') }}</p>
                            <p class="lh-1">&nbsp;&nbsp;&nbsp;<b>Submitted In:</b> {{ \Carbon\Carbon::parse($projcontribution->created_at)->format('F d, Y') }}</p>
                            <p class="lh-1">&nbsp;&nbsp;&nbsp;<b>Submitted By:</b> {{ $submitter->name . ' ' . $submitter->last_name }}</p>

                            <p class="lh-1">&nbsp;&nbsp;&nbsp;<b>Submission Attachment:</b></p>
                            <div class="mb-2 text-center">
                                <a href="{{ route('downloadterminal.file', ['projcontributionid' => $projcontribution->id, 'filename' => basename($uploadedFiles[0])]) }}" class="btn btn-outline-success shadow rounded w-50">
                                    <i class="bi bi-file-earmark-arrow-down-fill me-2 fs-3"></i><b>{{ basename($uploadedFiles[0]) }}</b>

                                </a>

                            </div>


                        </div>
                        @if( $projcontribution['approval'] != 1)
                        <div class="btn-group dropdown m-2 mb-3 shadow">
                            <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b class="small">Evaluate Submission</b>
                            </button>

                            @livewire('project-terminal-submission', [ 'projcontributionid' => $projcontribution->id, 'project' => $project ])

                        </div>
                        @endif

                    </div>
                </div>
                @if(!$otherprojcontribution->isEmpty())
                <div class="col-lg-3">

                    @php
                    $countAccepted = 0;

                    $otherprojcontribution = $otherprojcontribution->map(function ($contri) use (&$countAccepted) {
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
                            <h6 class="fw-bold small" style="color:darkgreen;">Other Terminal Report/s</h6>
                        </div>
                        @foreach ($otherprojcontribution as $submission)

                        <div class="p-2 pb-1 ps-3 divhover border-bottom projsubmission-div small" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                            <p class="lh-1 fw-bold"><em>{{ $submission->submission_remark  }}</em></p>
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

            $('#closeprojectdiv').click(function(event) {
                event.preventDefault();
                var projectid = $(this).attr('data-value');
                var department = $(this).attr('data-dept');



                var url = '{{ route("projects.close", ["projectid" => ":projectid", "department" => ":department" ]) }}';
                url = url.replace(':projectid', projectid);
                url = url.replace(':department', encodeURIComponent(department));
                window.location.href = url;
            });
            $(document).on('click', '.projsubmission-div', function() {
                event.preventDefault();

                var projsubmissionid = $(this).attr("data-id");
                var projapproval = $(this).attr("data-approval");
                var projsubmission;

                if (projapproval === "") {
                    projsubmission = "Unevaluated-Submission";
                } else if (actapproval == 0) {
                    projsubmission = "Rejected-Submission";
                } else if (actapproval == 1) {
                    projsubmission = "Accepted-Submission";
                }


                var url = '{{ route("projsubmission.display", ["projsubmissionid" => ":projsubmissionid", "projsubmissionname" => ":projsubmissionname"]) }}';
                url = url.replace(':projsubmissionid', projsubmissionid);
                url = url.replace(':projsubmissionname', projsubmission);
                window.location.href = url;
            });




        });
    </script>

    @endsection