@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-top-0">
    @php
    $role = Auth::user()->role;
    @endphp

    <div class="container p-0">

        <div class="mainnav border-1 border-bottom shadow-sm px-2 small">
            <nav class="navbar navbar-expand-sm p-0">
                <button class="navbar-toggler btn btn-sm m-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMonitoring" aria-controls="navbarMonitoring" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMonitoring">
                    <ul class="navbar-nav me-auto">

                        <a class="nav-link border border-1 p-2 px-4 currentdiv fw-bold small">
                            My Duties
                        </a>

                        <a class="nav-link border border-1 p-2 px-4 divhover fw-bold small" href="{{ route('taskscalendar.show', [ 'username' => Auth::user()->username ]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            My Tasks Calendar
                        </a>

                        @livewire('notifications')


                    </ul>
                </div>
            </nav>





        </div>
    </div>

    <div class="container mt-3">

        <input type="text" class="d-none" id="username" value="{{ Auth::user()->username }}">
        <div class="row">
            <div class="col-lg-3">
                <label class="ms-3 small form-label text-secondary fw-bold">
                    @if($role == "Admin")
                    Programs
                    @else
                    My Program
                    @endif
                </label>
                @livewire('ongoing-program', ['department' => null, 'programid' => null, 'xOngoingPrograms' => 1])
                @livewire('upcoming-program', ['department' => null, 'programid' => null, 'yUpcomingPrograms' => 1])
                @livewire('overdue-program', ['department' => null, 'programid' => null, 'zOverduePrograms' => 0])
                @livewire('completed-program', ['department' => null, 'programid' => null, 'xCompletedPrograms' => 0])
                @livewire('terminated-program', ['department' => null, 'programid' => null, 'xTerminatedPrograms' => 0])
            </div>
            <div class="col-lg-3">
                <label class="ms-3 small form-label text-secondary fw-bold">
                    @if($role == "Admin")
                    Projects
                    @else
                    My Projects
                    @endif
                </label>
                @livewire('more-projects', ['department' => null, 'projectid' => null, 'x' => 1])
                @livewire('not-started-projects', ['department' => null, 'projectid' => null, 'y' => 1])
                @livewire('past-projects', ['department' => null, 'projectid' => null, 'z' => 0])
                @livewire('completed-projects', ['department' => null, 'projectid' => null, 'xCompletedProjects' => 0])
                
            </div>
            <div class="col-lg-3">
                <label class="ms-3 small form-label text-secondary fw-bold">
                    @if($role == "Admin")
                    Activities
                    @else
                    My Activities
                    @endif
                </label>
                @livewire('in-progress-activities', ['projectid' => null, 'activityid' => null, 'xInProgressActivities' => 1])
                @livewire('not-started-activities', ['projectid' => null, 'activityid' => null, 'xNotStartedActivities' => 1])
                @livewire('past-activities', ['projectid' => null, 'activityid' => null, 'xPastActivities' => 0])
                @livewire('completed-activities', ['projectid' => null, 'activityid' => null, 'xCompletedActivities' => 0])
                @livewire('check-output')

            </div>
            <div class="col-lg-3">

                <label class="ms-3 small form-label text-secondary fw-bold">
                    @if($role == "Admin")
                    Tasks
                    @else
                    My Tasks
                    @endif
                </label>

                @livewire('scheduled-subtasks', ['xScheduledTasks' => 1])

                @livewire('ongoing-tasks', ['activityid' => null, 'subtaskid' => null, 'xOngoingTasks' => 1])
                @livewire('missing-tasks', ['activityid' => null, 'subtaskid' => null, 'xMissingTasks' => 0])
                @livewire('completed-tasks', ['activityid' => null, 'subtaskid' => null, 'xCompletedTasks' => 0])

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
        $(document).on('click', '.activitydiv button', function(event) {
            event.stopPropagation(); // Prevent the click event from propagating to the parent .subtaskdiv
            // Add your button click logic here
        });
        $(document).on('click', '.programDiv', function(event) {
            var department = $(this).attr('data-dept');
            var programId = $(this).attr('data-value');
            var url = '{{ route("programs.display", ["programid" => ":programid", "department" => ":department" ]) }}';
            url = url.replace(':department', encodeURIComponent(department));
            url = url.replace(':programid', programId);
            window.location.href = url;
        });
        $(document).on('click', '.activitydiv .dropdown-menu', function(event) {
            event.stopPropagation();
        });
        $(document).on('click', '.checkOutput', function(event) {
            $('#checkActId').val($(this).attr('data-id'));
            $('#checkActName').text($(this).attr('data-name'));
            $('#outputCheckModal').modal('show');
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

            var url = '{{ route("activities.display", ["activityid" => ":activityid"]) }}';
            url = url.replace(':activityid', activityid);
            window.location.href = url;
        });

        $(document).on('click', '.projectdiv', function(event) {
            event.preventDefault();

            var projectid = $(this).attr("data-value");
            var department = $(this).attr("data-dept");

            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department"]) }}';
            url = url.replace(':projectid', projectid)
            url = url.replace(':department', encodeURIComponent(department));
            window.location.href = url;
        });

    });
</script>
@endsection
