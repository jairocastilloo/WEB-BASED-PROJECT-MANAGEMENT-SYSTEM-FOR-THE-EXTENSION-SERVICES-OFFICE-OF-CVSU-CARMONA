<div>
    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color: darkgreen;">
                Projects
                <span class="badge bggold text-dark">
                    {{ count($currentproject) }}
                </span>
            </h6>
        </div>


        <div class="input-container m-2">
            <input type="text" class="form-control" wire:model="search" placeholder="Search projects...">
        </div>

        @foreach ($currentproject as $project)
        <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">
            <h6 class="fw-bold">{{ $project['projecttitle'] }} - <span class="text-success">{{ $project['projectstatus'] }}</span></h6>
            @php
            $startDate = date('M d, Y', strtotime($project['projectstartdate']));
            $endDate = date('M d, Y', strtotime($project['projectenddate']));
            @endphp
            <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
        </div>
        @endforeach

    </div>
</div>