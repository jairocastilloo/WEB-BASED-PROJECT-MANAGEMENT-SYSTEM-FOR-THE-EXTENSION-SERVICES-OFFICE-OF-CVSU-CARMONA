<div>
    <div class="input-container mb-2">
        <input type="text" class="form-control border-success" wire:model="search" placeholder="Search activities...">
    </div>


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
                            In Progress
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
                            Upcoming
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
                            Scheduled
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
                            Overdue
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
                            Completed
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