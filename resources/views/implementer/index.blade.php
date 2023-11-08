@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-top-0">
    <div class="container pt-3">

        <input type="text" class="d-none" id="username" value="{{ Auth::user()->username }}">
        <div class="row">
            <div class="col-lg-6">

                <label class="ms-3 small form-label text-secondary fw-bold">My Tasks</label>
                @livewire('scheduled-subtasks', ['xScheduledTasks' => 1])
                @livewire('ongoing-tasks', ['activityid' => null, 'subtaskid' => null, 'xOngoingTasks' => 1])
                @livewire('missing-tasks', ['activityid' => null, 'subtaskid' => null, 'xMissingTasks' => 0])
                @livewire('completed-tasks', ['activityid' => null, 'subtaskid' => null, 'xCompletedTasks' => 0])

            </div>

            <div class="col-lg-3">
                <label class="ms-3 small form-label text-secondary fw-bold">My Activities</label>
                @livewire('in-progress-activities', ['projectid' => null, 'activityid' => null, 'xInProgressActivities' => 1])
                @livewire('not-started-activities', ['projectid' => null, 'activityid' => null, 'xNotStartedActivities' => 1])
                @livewire('past-activities', ['projectid' => null, 'activityid' => null, 'xPastActivities' => 0])
                @livewire('completed-activities', ['projectid' => null, 'activityid' => null, 'xCompletedActivities' => 0])

            </div>
            <div class="col-lg-3">
                <label class="ms-3 small form-label text-secondary fw-bold">My Projects</label>
                @livewire('more-projects', ['department' => null, 'projectid' => null, 'x' => 1])
                @livewire('not-started-projects', ['department' => null, 'projectid' => null, 'y' => 1])
                @livewire('past-projects', ['department' => null, 'projectid' => null, 'z' => 0])
                @livewire('completed-projects', ['department' => null, 'projectid' => null, 'xCompletedProjects' => 0])
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '#toggleButton', function(event) {
            $(this).next().slideToggle("fast");
        });

        $('#scheduleDatePicker').datepicker();

        $('#scheduleDatePicker').datepicker().on('change', function(e) {
            $('#scheduleDatePicker').datepicker('hide');
        });
        /*
                $('#year-select').change(function() {
                    var selectedOption = $(this).find(':selected');
                    var currentYear = selectedOption.val();

                    var username = $('#username').val();

                    var baseUrl = "{{ route('acadtasks.show', ['username' => ':username', 'currentYear' => ':currentYear']) }}";
                    var url = baseUrl.replace(':username', username)
                        .replace(':currentYear', currentYear);

                    window.location.href = url;
                });
                */
        $('#navbarDropdown').click(function(event) {
            // Add your function here
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
        });

        $(document).on('click', '.subtaskdiv', function(event) {
            event.preventDefault();

            var subtaskname = $(this).find("h6:first").text();
            var subtaskid = $(this).attr("data-value");

            var url = '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);
            window.location.href = url;
        });

        $(document).on('click', '.subtaskdiv button', function(event) {
            event.stopPropagation(); // Prevent the click event from propagating to the parent .subtaskdiv
            // Add your button click logic here
        });

        $(document).on('click', '.subtaskdiv .dropdown-menu', function(event) {
            event.stopPropagation();
        });
        $(document).on('click', '.setSchedule', function(event) {
            var subtaskName = $(this).attr('data-name');
            var subtaskId = $(this).attr('data-id');

            $('#scheduleSubtaskName').text(subtaskName);
            $('#scheduleSubtaskId').val(subtaskId);

            // Show the modal with the ID 'scheduleModal'
            $('#scheduleModal').modal('show');
        });


        $(document).on('click', '.activitydiv', function(event) {
            event.preventDefault();

            var activityname = $(this).find("h6:first").text();
            var activityid = $(this).attr("data-value");

            var url = '{{ route("activities.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':activityname', activityname);
            window.location.href = url;
        });

        $(document).on('click', '.projectdiv', function(event) {
            event.preventDefault();

            var projectname = $(this).attr("data-name");
            var projectid = $(this).attr("data-value");
            var department = $(this).attr("data-dept");

            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department"]) }}';
            url = url.replace(':projectid', projectid)
            url = url.replace(':department', department);
            window.location.href = url;
        });

    });
</script>
@endsection