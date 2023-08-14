@extends('layouts.app')

@section('content')
<div class="maincontainer">
    &nbsp;
    <input type="text" class="d-none" id="userdept" value="{{ Auth::user()->department }}">
    <input type="text" class="d-none" id="username" value="{{ Auth::user()->username }}">
    <div class="row">
        <div class="col-8">
            <div class="basiccont mt-2 m-4 me-0 rounded shadow pb-2">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Browse Duties</h6>
                </div>
                @if (!$inCurrentYear)
                <span class="small ms-2"><em>
                        Note: Not the current Academic Year
                    </em></span>
                @endif
                <div class="form-floating m-3 mb-1 mt-2">

                    <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen; font-size: 21px;" aria-label="Select an academic year">

                        @foreach ($calendaryears as $calendaryear)
                        <option value="{{ $calendaryear }}" {{ $calendaryear == $currentYear ? 'selected' : '' }}>
                            &nbsp;&nbsp;&nbsp;{{ $calendaryear }}
                        </option>
                        @endforeach


                    </select>
                    <label for="year-select" style="color:darkgreen;">
                        <h5><strong>Calendar Year:</strong></h5>
                    </label>
                </div>

            </div>
            <div class="basiccont word-wrap shadow rounded ms-4 mt-2">

                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color: darkgreen;">My Tasks</h6>
                </div>
                @if($subtasks->isNotEmpty())
                @forelse($subtasks as $subtask)
                @php
                $totalhoursrendered = 0;
                @endphp

                @foreach ($contributions as $contribution)
                @if($contribution['subtask_id'] === $subtask['id'])
                @php
                $totalhoursrendered += $contribution['hours_rendered'];
                @endphp
                @endif
                @endforeach

                <div class="border-bottom ps-4 p-2 divhover subtaskdiv" data-value="{{ $subtask['id'] }}">
                    <h6><b>{{ $subtask['subtask_name'] }}</b></h6>
                    <h6>{{ $totalhoursrendered }} hours rendered</h6>
                </div>
                @empty
                <div class="text-center p-4">
                    <h4><em>No Assigned Tasks.</em></h4>
                </div>
                @endforelse
                @else
                <div class="text-center p-4">
                    <h4><em>No Assigned Tasks.
                        </em></h4>
                </div>
                @endif

            </div>
        </div>

        <div class="col-2">


            @php
            // Sort the $activities array by actstartdate in ascending order
            $sortedActivities = $activities->sortBy('actstartdate');

            $inProgressActivities = $sortedActivities->filter(function ($activity) {
            return $activity['actremark'] === 'In Progress';
            });
            $pendingActivities = $sortedActivities->filter(function ($activity) {
            return $activity['actremark'] === 'Pending';
            });
            $scheduledActivities = $sortedActivities->filter(function ($activity) {
            return $activity['actremark'] === 'Scheduled';
            });
            $overdueActivities = $sortedActivities->filter(function ($activity) {
            return $activity['actremark'] === 'Overdue';
            });
            $completedActivities = $sortedActivities->filter(function ($activity) {
            return $activity['actremark'] === 'Completed';
            });
            @endphp
            @if($activities->isEmpty())
            <div class="basiccont word-wrap shadow mt-2">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Activities</h6>
                </div>
                <div class="text-center p-4">
                    <h4><em>No Assigned Activities.</em></h4>
                </div>
            </div>
            @endif
            @if ($inProgressActivities && count($inProgressActivities) > 0)

            <div class="basiccont word-wrap shadow mt-2">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">In Progress Activities</h6>
                </div>
                @foreach ($inProgressActivities as $activity)
                <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">

                    <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($activity['actstartdate']));
                    $endDate = date('M d, Y', strtotime($activity['actenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>
            @endif
            @if ($pendingActivities && count($pendingActivities) > 0)

            <div class="basiccont word-wrap shadow mt-2">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Pending Activities</h6>
                </div>
                @foreach ($pendingActivities as $activity)
                <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">
                    <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($activity['actstartdate']));
                    $endDate = date('M d, Y', strtotime($activity['actenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>

            @endif
            @if ($scheduledActivities && count($scheduledActivities) > 0)
            <div class="basiccont word-wrap shadow mt-2">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Scheduled Activities</h6>
                </div>
                @foreach ($scheduledActivities as $activity)
                <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">

                    <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($activity['actstartdate']));
                    $endDate = date('M d, Y', strtotime($activity['actenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>
            @endif
            @if ($overdueActivities && count($overdueActivities) > 0)

            <div class="basiccont word-wrap shadow mt-2">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Overdue Activities</h6>
                </div>
                @foreach ($overdueActivities as $activity)
                <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">

                    <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($activity['actstartdate']));
                    $endDate = date('M d, Y', strtotime($activity['actenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>
            @endif
            @if ($completedActivities && count($completedActivities) > 0)
            <div class="basiccont word-wrap shadow mt-2">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Completed Activities</h6>
                </div>
                @foreach ($completedActivities as $activity)
                <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">

                    <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($activity['actstartdate']));
                    $endDate = date('M d, Y', strtotime($activity['actenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>
            @endif


        </div>
        <div class="col-2">

            @php

            $sortedProjects= $currentproject->sortBy('projectstartdate');

            $inProgressProjects = $sortedProjects->filter(function ($project) {
            return $project['projectstatus'] === 'In Progress';
            });
            $scheduledProjects = $sortedProjects->filter(function ($project) {
            return $project['projectstatus'] === 'Scheduled';
            });
            $overdueProjects = $sortedProjects->filter(function ($project) {
            return $project['projectstatus'] === 'Incomplete';
            });
            $completedProjects = $sortedProjects->filter(function ($project) {
            return $project['projectstatus'] === 'Completed';
            });
            @endphp
            @if($currentproject->isEmpty())
            <div class="basiccont word-wrap shadow mt-2 me-4">
                <div class="border-bottom ps-3 pe-2 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Projects</h6>
                </div>
                <div class="text-center p-4">
                    <h4><em>No Project Created Yet.</em></h4>
                </div>
            </div>
            @endif
            @if ($inProgressProjects && count($inProgressProjects) > 0)

            <div class="basiccont word-wrap shadow mt-2 me-4">
                <div class="border-bottom ps-3 pe-2 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">In Progress Projects</h6>
                </div>
                @foreach ($inProgressProjects as $project)
                <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                    <h6 class="fw-bold">{{ $project['projecttitle'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($project['projectstartdate']));
                    $endDate = date('M d, Y', strtotime($project['projectenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>
            @endif

            @if ($scheduledProjects && count($scheduledProjects) > 0)
            <div class="basiccont word-wrap shadow mt-2 me-4">
                <div class="border-bottom ps-3 pe-2 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Scheduled Projects</h6>
                </div>
                @foreach ($scheduledProjects as $project)
                <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                    <h6 class="fw-bold">{{ $project['projecttitle'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($project['projectstartdate']));
                    $endDate = date('M d, Y', strtotime($project['projectenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>
            @endif

            @if ($completedProjects && count($completedProjects) > 0)
            <div class="basiccont word-wrap shadow mt-2 me-4">
                <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Completed Projects</h6>
                </div>
                @foreach ($completedProjects as $project)
                <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                    <h6 class="fw-bold">{{ $project['projecttitle'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($project['projectstartdate']));
                    $endDate = date('M d, Y', strtotime($project['projectenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>
            @endif
            @if ($overdueProjects && count($overdueProjects) > 0)

            <div class="basiccont word-wrap shadow mt-2 me-4">
                <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Incomplete Projects</h6>
                </div>
                @foreach ($overdueProjects as $project)
                <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                    <h6 class="fw-bold">{{ $project['projecttitle'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($project['projectstartdate']));
                    $endDate = date('M d, Y', strtotime($project['projectenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    &nbsp;
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#year-select').change(function() {
            var selectedOption = $(this).find(':selected');
            var currentYear = selectedOption.val();

            var username = $('#username').val();

            var baseUrl = "{{ route('acadtasks.show', ['username' => ':username', 'currentYear' => ':currentYear']) }}";
            var url = baseUrl.replace(':username', username)
                .replace(':currentYear', currentYear);

            window.location.href = url;
        });
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

        $(document).on('click', '.activitydiv', function(event) {
            event.preventDefault();

            var activityname = $(this).find("h6:first").text();
            var activityid = $(this).attr("data-value");
            var department = $('#userdept').val();

            var url = '{{ route("activities.display", ["activityid" => ":activityid", "department" => ":department", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':department', department);
            url = url.replace(':activityname', activityname);
            window.location.href = url;
        });

        $(document).on('click', '.projectdiv', function(event) {
            event.preventDefault();

            var projectname = $(this).find("h6:first").text();
            var projectid = $(this).attr("data-value");
            var department = $('#userdept').val();

            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department", "projectname" => ":projectname"]) }}';
            url = url.replace(':projectid', projectid)
                .replace(':department', department)
                .replace(':projectname', projectname);
            window.location.href = url;
        });

    });
</script>
@endsection