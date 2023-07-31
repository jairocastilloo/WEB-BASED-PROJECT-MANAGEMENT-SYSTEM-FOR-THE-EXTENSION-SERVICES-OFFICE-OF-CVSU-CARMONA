@extends('layouts.app')

@section('content')
<div class="maincontainer">
    &nbsp;
    <input type="text" class="d-none" id="userdept" value="{{ Auth::user()->department }}">
    <div class="row">
        <div class="col-6">

            <div class="basiccont word-wrap shadow ms-4 mt-2">
                <div class="border-bottom ps-3 pt-2">
                    <h6 class="fw-bold small" style="color:darkgreen;">My Tasks</h6>
                </div>
                @foreach($subtasks as $subtask)
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
                @endforeach

            </div>
        </div>

        <div class="col-3">


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
            @if ($inProgressActivities && count($inProgressActivities) > 0)

            <div class="basiccont word-wrap shadow mt-2">
                <div class="border-bottom ps-3 pt-2">
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
                <div class="border-bottom ps-3 pt-2">
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
                <div class="border-bottom ps-3 pt-2">
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
                <div class="border-bottom ps-3 pt-2">
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
                <div class="border-bottom ps-3 pt-2">
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
        <div class="col-3">

            <div class="basiccont word-wrap shadow mt-2 me-4">
                <div class="border-bottom ps-3 pt-2">
                    <h6 class="fw-bold small" style="color:darkgreen;">Projects</h6>
                </div>
                @php
                // Sort the $activities array by actstartdate in ascending order
                $sortedProjects = $projects->sortBy('projectstartdate');
                @endphp
                @foreach($sortedProjects as $project)
                <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}">
                    <h6 class="small fw-bold">{{ $project['projecttitle'] }}</h6>

                    @php
                    $startDate = date('M d, Y', strtotime($project['projectstartdate']));
                    $endDate = date('M d, Y', strtotime($project['projectenddate']));
                    @endphp

                    <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>

                </div>
                @endforeach
            </div>
        </div>
    </div>

    &nbsp;
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
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