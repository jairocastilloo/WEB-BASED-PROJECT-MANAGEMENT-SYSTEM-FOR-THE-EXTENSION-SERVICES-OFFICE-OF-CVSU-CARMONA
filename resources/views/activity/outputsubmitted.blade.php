@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper divhover" id="projectdiv" data-value="{{ $project->id }}" data-name="{{ $project->projecttitle }}" data-dept="{{ $project->department }}">
            <div class="step">
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
        <div class="step-wrapper selectoutputdiv divhover" data-value="{{ $outputs[0]->output_type }}">
            <div class="step">
                <span class="fw-bold">Output: {{ $outputs[0]->output_type }}</span>
                <div class="message-box text-white">
                    {{ $outputs[0]->output_type }}
                </div>
            </div>


        </div>
        <div class="step-wrapper">
            <div class="steps" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                <span class="fw-bold">Submitting {{ $outputs[0]->output_type }} for {{ $activity['actname'] }}</span>
                <div class="message-box">
                    Submitting {{ $outputs[0]->output_type }} for {{ $activity['actname'] }}
                </div>
            </div>


        </div>
    </div>
    <div class="container">
        <div class="row">
            @if(count($othersubmittedoutput) > 0)
            <div class="col-lg-9">
                @else
                <div class="col-lg-12">
                    @endif
                    <div class="basiccont word-wrap shadow">
                        <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofsubmission }}</h6>
                        </div>

                        <div class="p-2" id="typeofOutput" data-value="{{ $outputtype }}">
                            <p class="ps-4 lh-1 pt-2"><b>{{ $outputs[0]->output_type }}</b></p>
                            @foreach ($outputs as $index => $output)
                            <p class="lh-1 ps-5">{{ 'Submitted ' . $output->output_name . ': ' .  $submittedoutputs[$index]->output_submitted }}</p>

                            @endforeach

                            <p class="lh-1 ps-5"> Submitted in: {{ \Carbon\Carbon::parse($submittedoutputs[0]->created_at)->format('F d, Y') }} </p>
                            @if($submitter)
                            <p class="lh-1 ps-5"> Submitted by: {{ $submitter[0]->name . ' ' . $submitter[0]->last_name }} </p>
                            @endif
                            <p class="lh-1 ps-5">Submission Attachment:</p>
                            <div class="mb-2 text-center">
                                <a href="{{ route('downloadoutput.file', ['submittedoutputid' => $submittedoutputs[0]->id, 'filename' => basename($uploadedFiles[0])]) }}" class="btn btn-outline-success shadow rounded w-50">
                                    <i class="bi bi-file-earmark-arrow-down-fill me-2 fs-3"></i><b>{{ basename($uploadedFiles[0]) }}</b>

                                </a>

                            </div>

                            @if( $submittedoutputs[0]->approval != 1)
                            <div class="btn-group dropdown ms-3 mb-3 mt-2 shadow">
                                <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <b class="small">Evaluate Submission</b>
                                </button>
                                @livewire('output-submission', [ 'acceptids' => $submittedoutputs[0]->created_at, 'activityindex' => $outputs[0]->activity_id, 'typeofoutput' => $outputs[0]->output_type ])

                            </div>
                            @endif
                        </div>
                    </div>

                </div>

                @php
                $countAccepted = 0;

                $othersubmittedoutput = $othersubmittedoutput->map(function ($contri) use (&$countAccepted) {
                if ($contri['approval'] === null) {
                $contri['submission_remark'] = 'For Approval';
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

                $groupedSubmittedOutput = $othersubmittedoutput->groupBy(function ($item) {
                return $item['created_at']->format('Y-m-d H:i:s');
                });
                @endphp

                @if (count($groupedSubmittedOutput) > 0)
                <div class="col-lg-3">
                    <div class="basiccont word-wrap shadow">
                        <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">{{ $outputtype }}'s Reports</h6>
                        </div>
                        @foreach ($groupedSubmittedOutput as $date => $group)
                        <div class="p-2 pb-1 ps-3 small divhover border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="{{ $group[0]->approval }}">

                            <p class="lh-1 fw-bold @if($group[0]->submission_remark == 'For Approval') text-success @elseif($group[0]->submission_remark == 'For Revision') text-danger @else text-primary @endif"><em>
                                    {{ $group[0]->submission_remark  }}
                                </em></p>
                            @foreach ($group as $index => $item)
                            <p class="lh-1">&nbsp;&nbsp;&nbsp;{{ $outputNames[$index] . ': ' . $item['output_submitted'] }}</p>
                            <!-- Display other attributes as needed -->
                            @endforeach
                            @if ( $group[0]->notes != null)
                            <p class="lh-1"> &nbsp;&nbsp;&nbsp;<em>Notes: {{ $group[0]->notes }} </em></p>
                            @endif
                            <p class="lh-1">&nbsp;&nbsp;&nbsp;Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>
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

            $(document).on('click', '.outputsubmitteddiv', function() {
                var submittedoutputid = $(this).attr('data-value');
                var approval = $(this).attr('data-approval');
                var outputtype = $('#typeofOutput').attr('data-value');

                var submission;

                if (approval === "") {
                    submission = "For Approval";
                } else if (approval == 0) {
                    submission = "For Revision";
                } else if (approval == 1) {
                    submission = "Accepted";
                }

                outputtype = outputtype.replace(' ', '-');
                var url = '{{ route("submittedoutput.display", ["submittedoutputid" => ":submittedoutputid", "outputtype" => ":outputtype", "submissionname" => ":approval"]) }}';
                url = url.replace(':submittedoutputid', submittedoutputid);
                url = url.replace(':outputtype', outputtype);
                url = url.replace(':approval', submission);
                window.location.href = url;
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

                var url = '{{ route("activities.display", ["activityid" => ":activityid"]) }}';
                url = url.replace(':activityid', actid);
                window.location.href = url;
            });
            $(document).on('click', '.selectoutputdiv', function() {
                var outputtype = $(this).attr('data-value');
                var actid = $('#activitydiv').attr('data-value')

                var url = '{{ route("get.output", ["activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
                url = url.replace(':activityid', actid);
                url = url.replace(':outputtype', outputtype);
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
                var formData = $('#acceptoutputform').serialize(); // Serialize form data
                var dataurl = $('#acceptoutputform').data('url'); // Get the form data-url attribute
                var actid = $('#actid').val();
                var outputtype = $('#outputtype').val();

                var url = '{{ route("get.output", ["activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
                url = url.replace(':activityid', actid);
                url = url.replace(':outputtype', outputtype);



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