<div>

    <div class="input-container mb-2">
        <input type="text" class="form-control border-success" wire:model="search" placeholder="Search projects...">
        <button type="button" class="btn btn-sm btn-success"> <i class="bi bi-search fs-6"></i> </button>
    </div>



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
            $proj->projectenddate < now(); }); @endphp @if ($InProgressProjects && count($InProgressProjects)> 0)

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color:darkgreen;">
                            <i class="bi bi-kanban"></i>
                            In Progress
                            <span class="bggold text-dark badge">
                                {{ count($InProgressProjects) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>

                        </h6>
                    </div>
                    <div class="toggle-container subtoggle">
                        @foreach ($InProgressProjects as $project)
                        <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}" data-dept="{{ $project['department'] }}">

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
                            Upcoming
                            <span class="bggold text-dark badge">
                                {{ count($UpcomingProjects) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>

                        </h6>
                    </div>
                    <div class="toggle-container subtoggle">
                        @foreach ($UpcomingProjects as $project)
                        <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}" data-dept="{{ $project['department'] }}">

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
                            Scheduled
                            <span class="badge bggold text-dark">
                                {{ count($ScheduledProjects) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>
                    </div>
                    <div class="toggle-container subtoggle">
                        @foreach ($ScheduledProjects as $project)
                        <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}" data-dept="{{ $project['department'] }}">

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
                            Completed
                            <span class="badge bggold text-dark">
                                {{ count($CompletedProjects) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>
                    </div>
                    <div class="toggle-container subtoggle">
                        @foreach ($CompletedProjects as $project)
                        <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}" data-dept="{{ $project['department'] }}">

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
                            Failed
                            <span class="badge bggold text-dark">
                                {{ count($IncompleteProjects) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>
                    </div>
                    <div class="toggle-container subtoggle">
                        @foreach ($IncompleteProjects as $project)
                        <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}" data-dept="{{ $project['department'] }}">

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