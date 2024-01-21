<div>
    @php

    $sortedProjects = $projects->sortBy('created_at');
    @endphp

    @foreach ($sortedProjects as $project)

    <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

        <h6 class="fw-bold small">{{ $project['projecttitle'] }} - <span class="text-success">{{ $project['projectstatus'] }}</span></h6>

        @php
        $startDate = date('M d, Y', strtotime($project['projectstartdate']));
        $endDate = date('M d, Y', strtotime($project['projectenddate']));
        @endphp
        <h6 class="text-secondary small">{{ 'Created ' . date('M d Y', strtotime($project['created_at'])) }}</h6>
        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
    </div>

    @endforeach

</div>