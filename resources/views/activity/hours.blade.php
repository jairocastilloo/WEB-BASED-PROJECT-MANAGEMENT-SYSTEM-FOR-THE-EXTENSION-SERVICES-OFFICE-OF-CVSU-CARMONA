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
                <span class="fw-bold">Participation Hours for {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    Participation Hours for {{ $activity['actname'] }}
                </div>
            </div>


        </div>
    </div>
    <div class="container">

        @php

        $unevaluatedSubmission = $activitycontributions->filter(function ($contri) {
        return $contri['approval'] === null;
        });
        $acceptedSubmission = $activitycontributions->filter(function ($contri) {
        return $contri['approval'] === 1;
        });
        $rejectedSubmission = $activitycontributions->filter(function ($contri) {
        return $contri['approval'] === 0;
        });

        @endphp

        <div class="basiccont word-wrap shadow">
            <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Participation Hours</h6>
            </div>

            <div class="p-2 pb-0 ps-5 border-bottom">
                <p class="lh-1">Activity Name: {{ $activity->actname }}</p>
                <p class="lh-1">Activity Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $activity->actstartdate)->format('F d') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $activity->actenddate)->format('F d') }}</p>
                <p class="lh-1">Hours Rendered: {{ $activity->totalhours_rendered }}</p>
            </div>
            @if (count($acceptedSubmission) == 0)
            <div class="btn-group ms-3 mb-3 mt-2 shadow">
                <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow submithours-btn">
                    <b class="small">Submit Hours</b>
                </button>
            </div>
            @endif
        </div>



        @if($activitycontributions->isEmpty())
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

                <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
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

                <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
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

                <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
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

                    console.log(response);
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