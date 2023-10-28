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
                <span class="fw-bold">Closing {{ $project->projecttitle }}</span>
                <div class="message-box text-white">
                    Closing {{ $project->projecttitle }}
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
                <h6 class="fw-bold small" style="color:darkgreen;">Close {{ $project->projecttitle }}</h6>
            </div>

            <div class="p-2 pb-0 ps-5 border-bottom">
                <p class="lh-1">Project Title: {{ $project->projecttitle }}</p>
                <p class="lh-1">Project Duration: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $project->projectstartdate)->format('F d') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $project->projectenddate)->format('F d') }}</p>
                <p class="lh-1">Activities in this project: {{ $allActivities }}</p>
                <p class="lh-1">In Progress: {{ $inProgressActivities }} </p>
                <p class="lh-1">Not Started: {{ $notStartedActivities }} </p>
                <p class="lh-1">Completed: {{ $completedActivities }} </p>
                <p class="lh-1">Overdue: {{ $overdueActivities }}</p>
            </div>

        </div>

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