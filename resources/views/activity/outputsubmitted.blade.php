@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom">
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
            <div class="col-lg-8">
                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofsubmission }}</h6>
                    </div>

                    <div class="p-2">
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
            <div class="col-lg-4">
                @php

                $unevaluatedSubmittedOutput = $othersubmittedoutput->filter(function ($suboutput) {
                return $suboutput['approval'] === null;
                });
                $acceptedSubmittedOutput = $othersubmittedoutput->filter(function ($suboutput) {
                return $suboutput['approval'] === 1;
                });
                $rejectedSubmittedOutput = $othersubmittedoutput->filter(function ($suboutput) {
                return $suboutput['approval'] === 0;
                });

                $groupedUnevaluatedSubmittedOutput = $unevaluatedSubmittedOutput->groupBy(function ($item) {
                return $item['created_at']->format('Y-m-d H:i:s');
                });
                $groupedAcceptedSubmittedOutput = $acceptedSubmittedOutput->groupBy(function ($item) {
                return $item['created_at']->format('Y-m-d H:i:s');
                });
                $groupedRejectedSubmittedOutput = $rejectedSubmittedOutput->groupBy(function ($item) {
                return $item['created_at']->format('Y-m-d H:i:s');
                });

                @endphp


                @if($othersubmittedoutput->isEmpty())
                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Submitted Output</h6>
                    </div>
                    <div class="text-center p-4">
                        <h4><em>No Submitted Output Yet.</em></h4>
                    </div>
                </div>
                @endif

                @if (count($unevaluatedSubmittedOutput) > 0)

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Submission</h6>
                    </div>
                    @foreach ($groupedUnevaluatedSubmittedOutput as $date => $group)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="Unevaluated-Submission">
                        <p class="lh-1 fw-bold">Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>

                        @foreach ($group as $index => $item)
                        <p class="lh-1 ps-4"> {{ 'Submitted ' . $outputs[$index]->output_name . ': ' . $item['output_submitted'] }}</p>
                        <!-- Display other attributes as needed -->
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @endif

                @if (count($acceptedSubmittedOutput) > 0)

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Accepted Submission</h6>
                    </div>
                    @foreach ($groupedAcceptedSubmittedOutput as $date => $group)
                    <div class="p-2 pb-1 ps-4 divhover small border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="Accepted-Submission">
                        <p class="lh-1 fw-bold">Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>

                        @foreach ($group as $index => $item)
                        <p class="lh-1 ps-4"> {{ 'Submitted ' . $outputs[$index]->output_name . ': ' . $item['output_submitted'] }}</p>
                        <!-- Display other attributes as needed -->
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @endif

                @if (count($rejectedSubmittedOutput) > 0)

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Rejected Submission</h6>
                    </div>
                    @foreach ($groupedRejectedSubmittedOutput as $date => $group)
                    <div class="p-2 pb-1 ps-4 divhover small border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="Rejected-Submission">
                        <p class="lh-1 fw-bold">Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>


                        @foreach ($group as $index => $item)
                        <p class="lh-1 ps-4"> {{ 'Submitted ' . $outputs[$index]->output_name . ': ' . $item['output_submitted'] }}</p>
                        <!-- Display other attributes as needed -->
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @endif
            </div>

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



            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));

            window.location.href = url;
        });

        $('#activitydiv').click(function(event) {

            event.preventDefault();
            var actid = $(this).attr('data-value');
            var activityname = $(this).attr('data-name');

            var url = '{{ route("activities.display", ["activityid" => ":activityid", "department" => ":department", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':department', department);
            url = url.replace(':activityname', activityname);
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