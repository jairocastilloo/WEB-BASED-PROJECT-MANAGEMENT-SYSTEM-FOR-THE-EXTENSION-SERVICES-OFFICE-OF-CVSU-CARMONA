<div>
    <div class="basiccont m-4 me-0 p-3 rounded shadow">
        <div class="flexmid"><strong>WORK AND FINANCIAL PLAN</strong></div>
        <div class="flexmid">CY&nbsp;<u>{{ date('Y', strtotime($indexproject['projectenddate'])) }}</u></div>
        <div class="flex-container">
            <strong><em>Program Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">{{ $indexproject['programtitle'] }}</div>
        </div>
        <div class="flex-container">
            <strong><em>Program Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">
                @php
                use App\Models\User;
                $programleader = User::where('id', $indexproject['programleader'])->first(['name', 'middle_name', 'last_name']);
                $projectleader = User::where('id', $indexproject['projectleader'])->first(['name', 'middle_name', 'last_name']);
                @endphp

                @if ($programleader)
                {{ $programleader->name }}
                @if ($programleader->middle_name)
                {{ substr(ucfirst($programleader->middle_name), 0, 1) }}.
                @endif
                {{ ucfirst($programleader->last_name) }}
                @endif
            </div>


        </div>
        <div class="flex-container">
            <strong><em>Project Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">{{ $indexproject['projecttitle'] }}</div>
        </div>
        <div class="flex-container">
            <strong><em>Project Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">

                @if ($projectleader)
                {{ $projectleader->name }}
                @if ($projectleader->middle_name)
                {{ substr(ucfirst($projectleader->middle_name), 0, 1) }}.
                @endif
                {{ ucfirst($projectleader->last_name) }}
                @endif
            </div>
        </div>
        <div class="flex-container">
            <strong><em>Duration:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
            <div class="underline-space inline-div ps-2">{{ date('F Y', strtotime($indexproject['projectstartdate'])) . '-' . date('F Y', strtotime($indexproject['projectenddate'])) }}</div>
        </div>

        <div class="btn-group dropdown mt-3 shadow">
            <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <b class="small">Menu</b>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item small hrefnav" href="{{ route('projects.details', ['projectid' => $projectid, 'department' => Auth::user()->department ]) }}">
                    <b class="small">Edit Details</b>
                </a>
                <a class="dropdown-item small hrefnav" href="#"><b class="small">Edit Objectives</b></a>
                <a class="dropdown-item small hrefnav" href="#" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity"><b class="small">Add Activity</b></a>
                <a class="dropdown-item small hrefnav" href="{{ route('projects.calendar', ['projectid' => $projectid, 'department' => Auth::user()->department ]) }}">
                    <b class="small">View Activity Calendar</b>
                </a>
                <a class="dropdown-item small hrefnav" href="#"><b class="small">Close Project</b></a>
                <a class="dropdown-item small hrefnav" href="{{ route('projects.members', ['projectid' => $projectid, 'department' => Auth::user()->department ]) }}">
                    <b class="small">Team Members</b>
                </a>

            </div>
        </div>
    </div>

    <div class="basiccont m-4 me-0 p-3 rounded shadow">

    </div>
</div>