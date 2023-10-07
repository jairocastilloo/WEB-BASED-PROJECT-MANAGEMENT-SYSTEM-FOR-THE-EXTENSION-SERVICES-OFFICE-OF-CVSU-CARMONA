@extends('layouts.app')

@section('content')
<div class="maincontainer border border-start border-end">
    <div class="container">
        &nbsp;

        <input type="text" class="d-none" id="userdept" value="{{ Auth::user()->department }}">
        <input type="text" class="d-none" id="username" value="{{ Auth::user()->username }}">
        <div class="row">
            <div class="col-lg-6 p-2 pt-0">
                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Duties</h6>
                    </div>
                    @if (!$inCurrentYear)
                    <span class="small ms-2"><em>
                            Note: Not the current Calendar Year
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

                @php
                $currentDate = strtotime('today');
                $formattedCurrentDate = date('Y-m-d', $currentDate);
                @endphp
                @if($subtasks->isEmpty())
                <div class="basiccont word-wrap shadow rounded">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2">
                        <h6 class="fw-bold small" style="color: darkgreen;">Tasks</h6>
                    </div>
                    <div class="text-center p-4">
                        <h4><em>No Tasks.
                            </em></h4>
                    </div>
                </div>
                @endif

                @if($subtasks->isNotEmpty())

                @php

                $subtasks = $subtasks->sortBy('subduedate');
                $overduesubtasks = $overduesubtasks->sortBy('subduedate');
                @endphp
                <div class="basiccont word-wrap shadow rounded">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">

                        <h6 class="fw-bold small" style="color: darkgreen;">
                            <i class="bi bi-list-task"></i>
                            Tasks
                            <span class="badge bggold text-dark">
                                {{ count($subtasks) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>
                    </div>
                    <div class="toggle-container subtoggle" style="display: none;">
                        @foreach($subtasks as $subtask)

                        <div class="border-bottom p-2 divhover subtaskdiv" data-value="{{ $subtask['id'] }}">
                            @php
                            $subduedate = strtotime($subtask['subduedate']);
                            $subcreatedat = strtotime($subtask['created_at']);

                            $formattedSubduedate = date('Y-m-d', $subduedate);
                            $formattedSubcreatedat = date('Y-m-d', $subcreatedat);
                            @endphp

                            <h6 class="ps-4 lh-1 small" style="color: #4A4A4A;"><b>{{ $subtask['subtask_name'] }}</b></h6>

                            @if ($formattedSubcreatedat === $formattedCurrentDate)
                            <h6 class="ps-4 lh-1 text-secondary small">{{ 'Created Today, ' . date('M d', $subcreatedat) }}</h6>
                            @elseif (date('Y-m-d', strtotime('-1 day', $currentDate)) === $formattedSubcreatedat)
                            <h6 class="ps-4 lh-1 text-secondary small">{{ 'Created Yesterday, ' . date('M d', $subcreatedat) }}</h6>
                            @else
                            <h6 class="ps-4 lh-1 text-secondary small">{{ 'Created ' . date('D, M d', $subcreatedat) }}</h6>
                            @endif




                            @if ($formattedSubduedate === $formattedCurrentDate)
                            <h6 class="ps-5 text-success fw-bold small lh-1">{{ 'Due Today, ' . date('M d', $subduedate) }}</h6>
                            @elseif (date('Y-m-d', strtotime('+1 day', $currentDate)) === $formattedSubduedate)
                            <h6 class="ps-5 text-success fw-bold small lh-1">{{ 'Due Tomorrow, ' . date('M d', $subduedate) }}</h6>
                            @else
                            <h6 class="ps-5 text-success fw-bold small lh-1">{{ 'Due ' . date('D, M d', $subduedate) }}</h6>
                            @endif

                        </div>

                        @endforeach
                    </div>
                </div>
                @endif

                @if($overduesubtasks->isNotEmpty())

                @php

                $overduesubtasks = $overduesubtasks->sortBy('subduedate');

                @endphp
                <div class="basiccont word-wrap shadow rounded">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color: darkgreen;">
                            <i class="bi bi-list-task"></i>
                            Missing
                            <span class="badge bggold text-dark">
                                {{ count($overduesubtasks) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>

                        </h6>
                    </div>
                    <!-- overdue -->
                    <div class="toggle-container subtoggle" style="display: none;">
                        @foreach($overduesubtasks as $overduesubtask)

                        <div class="border-bottom p-2 divhover subtaskdiv" data-value="{{ $overduesubtask['id'] }}">
                            @php
                            $subduedate = strtotime($overduesubtask['subduedate']);
                            $subcreatedat = strtotime($overduesubtask['created_at']);

                            $formattedSubduedate = date('Y-m-d', $subduedate);
                            $formattedSubcreatedat = date('Y-m-d', $subcreatedat);
                            @endphp

                            <h6 class="ps-4 lh-1 small" style="color: #4A4A4A;"><b>{{ $overduesubtask['subtask_name'] }}</b></h6>

                            <h6 class="ps-4 lh-1 text-secondary small">{{ 'Created ' . date('D, M d', $subcreatedat) }}</h6>
                            <h6 class="ps-5 text-success fw-bold small lh-1">{{ 'Due ' . date('D, M d', $subduedate) }}</h6>

                        </div>

                        @endforeach
                    </div>


                </div>
                @endif

                @if($completedsubtasks->isNotEmpty())

                @php

                $completedsubtasks = $completedsubtasks->sortBy('subduedate');

                @endphp
                <div class="basiccont word-wrap shadow rounded">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color: darkgreen;">
                            <i class="bi bi-list-task"></i>
                            Done
                            <span class="badge bggold text-dark">
                                {{ count($completedsubtasks) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>

                        </h6>
                    </div>
                    <!-- overdue -->
                    <div class="toggle-container subtoggle" style="display: none;">
                        @foreach($completedsubtasks as $completedsubtask)

                        <div class="border-bottom p-2 divhover subtaskdiv" data-value="{{ $completedsubtask['id'] }}">
                            @php
                            $subduedate = strtotime($completedsubtask['subduedate']);
                            $subcreatedat = strtotime($completedsubtask['created_at']);

                            $formattedSubduedate = date('Y-m-d', $subduedate);
                            $formattedSubcreatedat = date('Y-m-d', $subcreatedat);
                            @endphp

                            <h6 class="ps-4 lh-1 small" style="color: #4A4A4A;"><b>{{ $completedsubtask['subtask_name'] }}</b></h6>

                            <h6 class="ps-4 lh-1 text-secondary small">{{ 'Created ' . date('D, M d', $subcreatedat) }}</h6>
                            <h6 class="ps-5 text-success fw-bold small lh-1">{{ 'Due ' . date('D, M d', $subduedate) }}</h6>

                        </div>

                        @endforeach
                    </div>


                </div>
                @endif
            </div>

            <div class="col-lg-3 p-2 pt-0">



                @php

                $InProgressActivities = $activities->filter(function ($activity) {
                return $activity->actremark === 'Incomplete' &&
                $activity->actstartdate <= now() && $activity->actenddate >= now();
                    });
                    $CompletedActivities = $activities->filter(function ($activity) {
                    return $activity->actremark === 'Completed';
                    });

                    $UpcomingActivities = $activities->filter(function ($activity) {

                    $actStartDate = \Carbon\Carbon::parse($activity->actstartdate);

                    // Clone the $actStartDate to avoid modifying the original date
                    $threeDaysBeforeAct = $actStartDate->copy()->subDays(3);

                    return $activity->actremark === 'Incomplete' &&
                    $threeDaysBeforeAct <= now() && $actStartDate> now();
                        });

                        $ScheduledActivities = $activities->filter(function ($activity) {


                        return $activity->actremark === 'Incomplete' &&
                        $activity->actstartdate > now();
                        });

                        $OverdueActivities = $activities->filter(function ($activity) {


                        return $activity->actremark === 'Incomplete' &&
                        $activity->actenddate < now(); }); $upcoming=count($UpcomingActivities); $scheduled=count($ScheduledActivities);$inprogress=count($InProgressActivities);$overdue=count($OverdueActivities);$completed=count($CompletedActivities);@endphp <input id="department" class="d-none" type="text" value="{{ Auth::user()->department }}">


                            @if($activities->isEmpty())
                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pt-2 bggreen pe-2">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Activities</h6>
                                </div>
                                <div class="text-center p-4">
                                    <h4><em>No Assigned Activities.</em></h4>
                                </div>
                            </div>
                            @endif
                            @if ($InProgressActivities && count($InProgressActivities) > 0)

                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-activity"></i>
                                        In Progress Activities
                                        <span class="badge bggold text-dark">
                                            {{ count($InProgressActivities) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>

                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($InProgressActivities as $activity)
                                    <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">

                                        <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($activity['actstartdate']));
                                        $endDate = date('M d', strtotime($activity['actenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($UpcomingActivities && count($UpcomingActivities) > 0)

                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-activity"></i>
                                        Upcoming Activities
                                        <span class="badge bggold text-dark">
                                            {{ count($UpcomingActivities) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>

                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($UpcomingActivities as $activity)
                                    <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">

                                        <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($activity['actstartdate']));
                                        $endDate = date('M d', strtotime($activity['actenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if ($ScheduledActivities && count($ScheduledActivities) > 0)
                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-activity"></i>
                                        Scheduled Activities
                                        <span class="bggold text-dark badge">
                                            {{ count($ScheduledActivities) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>

                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($ScheduledActivities as $activity)
                                    <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">

                                        <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($activity['actstartdate']));
                                        $endDate = date('M d', strtotime($activity['actenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($OverdueActivities && count($OverdueActivities) > 0)

                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-activity"></i>
                                        Overdue Activities
                                        <span class="badge bggold text-dark">
                                            {{ count($OverdueActivities) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>

                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($OverdueActivities as $activity)
                                    <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">

                                        <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($activity['actstartdate']));
                                        $endDate = date('M d', strtotime($activity['actenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($CompletedActivities && count($CompletedActivities) > 0)
                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-activity"></i>
                                        Completed Activities
                                        <span class="badge bggold text-dark">
                                            {{ count($CompletedActivities) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>
                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($CompletedActivities as $activity)
                                    <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">

                                        <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($activity['actstartdate']));
                                        $endDate = date('M d', strtotime($activity['actenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif


            </div>
            <div class="col-lg-3 p-2 pt-0">

                @php

                $InProgressProjects = $currentproject->filter(function ($proj) {
                return $proj->projectstatus === 'Incomplete' &&
                $proj->projectstartdate <= now() && $proj->projectenddate >= now();
                    });
                    $CompletedProjects = $currentproject->filter(function ($proj) {
                    return $proj->projectstatus === 'Completed';
                    });

                    $UpcomingProjects = $currentproject->filter(function ($proj) {

                    $projStartDate = \Carbon\Carbon::parse($proj->projectstartdate);

                    // Clone the $actStartDate to avoid modifying the original date
                    $weekBeforeAct = $projStartDate->copy()->subDays(7);

                    return $proj->projectstatus === 'Incomplete' &&
                    $weekBeforeAct <= now() && $projStartDate> now();
                        });

                        $ScheduledProjects = $currentproject->filter(function ($proj) {


                        return $proj->projectstatus === 'Incomplete' &&
                        $proj->projectstartdate > now();
                        });

                        $IncompleteProjects = $currentproject->filter(function ($proj) {


                        return $proj->projectstatus === 'Incomplete' &&
                        $proj->projectenddate < now(); }); @endphp @if($currentproject->isEmpty())
                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Projects</h6>
                                </div>
                                <div class="text-center p-4">
                                    <h4><em>No Project Created Yet.</em></h4>
                                </div>
                            </div>
                            @endif

                            @if ($InProgressProjects && count($InProgressProjects) > 0)

                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-kanban"></i>
                                        In Progress Projects
                                        <span class="bggold text-dark badge">
                                            {{ count($InProgressProjects) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>

                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($InProgressProjects as $project)
                                    <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                                        <h6 class="fw-bold small">{{ $project['projecttitle'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($project['projectstartdate']));
                                        $endDate = date('M d', strtotime($project['projectenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($UpcomingProjects && count($UpcomingProjects) > 0)

                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-kanban"></i>
                                        Upcoming Projects
                                        <span class="bggold text-dark badge">
                                            {{ count($UpcomingProjects) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>

                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($UpcomingProjects as $project)
                                    <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                                        <h6 class="fw-bold small">{{ $project['projecttitle'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($project['projectstartdate']));
                                        $endDate = date('M d', strtotime($project['projectenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($ScheduledProjects && count($ScheduledProjects) > 0)
                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-kanban"></i>
                                        Scheduled Projects
                                        <span class="badge bggold text-dark">
                                            {{ count($ScheduledProjects) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>
                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($ScheduledProjects as $project)
                                    <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                                        <h6 class="fw-bold small">{{ $project['projecttitle'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($project['projectstartdate']));
                                        $endDate = date('M d', strtotime($project['projectenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if ($CompletedProjects && count($CompletedProjects) > 0)
                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pt-2 pe-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-kanban"></i>
                                        Completed Projects
                                        <span class="badge bggold text-dark">
                                            {{ count($CompletedProjects) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>
                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($CompletedProjects as $project)
                                    <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                                        <h6 class="fw-bold small">{{ $project['projecttitle'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($project['projectstartdate']));
                                        $endDate = date('M d', strtotime($project['projectenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($IncompleteProjects && count($IncompleteProjects) > 0)

                            <div class="basiccont word-wrap shadow">
                                <div class="border-bottom ps-3 pt-2 pe-2 bggreen pe-2 containerhover" id="toggleButton">
                                    <h6 class="fw-bold small" style="color:darkgreen;">
                                        <i class="bi bi-kanban"></i>
                                        Incomplete Projects
                                        <span class="badge bggold text-dark">
                                            {{ count($IncompleteProjects) }}
                                        </span>
                                        <i class="bi bi-caret-down-fill text-end"></i>
                                    </h6>
                                </div>
                                <div class="toggle-container subtoggle" style="display: none;">
                                    @foreach ($IncompleteProjects as $project)
                                    <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                                        <h6 class="fw-bold small">{{ $project['projecttitle'] }}</h6>

                                        @php
                                        $startDate = date('M d', strtotime($project['projectstartdate']));
                                        $endDate = date('M d', strtotime($project['projectenddate']));
                                        @endphp

                                        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
            </div>
        </div>

        &nbsp;
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(".subtoggle").toggle();
        $(document).on('click', '#toggleButton', function(event) {
            $(this).next().slideToggle("fast");
        });

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