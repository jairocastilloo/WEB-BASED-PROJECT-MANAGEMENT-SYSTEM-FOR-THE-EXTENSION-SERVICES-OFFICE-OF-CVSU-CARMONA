<div>
    <div class="basiccont p-3 rounded shadow">

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
                <b class="small"> <i class="bi bi-list"></i> Menu</b>
            </button>
            <div class="dropdown-menu border-warning">
                <a class="dropdown-item small bg-warning border-bottom">
                    <b class="small">Table</b>
                </a>
                <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.members', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                    <b class="small">Team Members</b>
                </a>
                <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.activities', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                    <b class="small">Activities</b>
                </a>
                <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.calendar', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                    <b class="small">Calendar</b>
                </a>
                <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.details', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                    <b class="small">Edit Details</b>
                </a>
                <a class="dropdown-item small hrefnav border-bottom" href="#"><b class="small">Close Project</b></a>
                <!-- if included
    <a class="dropdown-item small hrefnav" href="{{ route('projects.objectives', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
        <b class="small">Edit Objectives</b>
    </a> -->
                <!-- <a class="dropdown-item small hrefnav" href="#" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity"><b class="small">Add Activity</b></a> -->



            </div>
        </div>
        <!--
<button type="button" class="btn btn-sm add-assignees-btn mt-2 shadow rounded border border-2 border-warning" style="background-color: gold;" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity">
<b class="small">Add Activity</b>
</button>
-->

    </div>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Project Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="programTitle" class="form-label">Program Title:</label>
                        <input value="{{ $indexproject->programtitle }}" type="text" class="form-control" id="programTitle" name="programTitle" required disabled>
                    </div>

                    <!-- Program Leader -->
                    <div class="mb-3">
                        <label for="programLeader" class="form-label">Program Leader</label>
                        <select class="form-select" id="programLeader" name="programLeader" required disabled>
                            @foreach ($members as $member)
                            <option value="{{ $member->id }}" @if ($member->id == $indexproject->programleader) selected @endif>
                                {{ $member->name . ' ' . $member->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Project Title -->
                    <div class="mb-3">
                        <label for="projectTitle" class="form-label">Project Title:</label>
                        <input value="{{ $indexproject->projecttitle }}" type="text" class="form-control" id="projectTitle" name="projectTitle" required disabled>
                    </div>

                    <!-- Project Leader -->
                    <div class="mb-3">
                        <label for="projectLeader" class="form-label">Project Leader</label>
                        <select class="form-select" id="projectLeader" name="projectLeader" required disabled>
                            @foreach ($members as $member)
                            <option value="{{ $member->id }}" @if ($member->id == $indexproject->projectleader) selected @endif>
                                {{ $member->name . ' ' . $member->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Project Start Date -->
                    <div class="mb-3">
                        <label for="projectStartDate" class="form-label">Project Start Date:</label>
                        <input value="{{ $indexproject->projectstartdate }}" type="date" class="form-control" id="projectStartDate" name="projectStartDate" required disabled>
                    </div>

                    <!-- Project End Date -->
                    <div class="mb-3">
                        <label for="projectEndDate" class="form-label">Project End Date:</label>
                        <input value="{{ $indexproject->projectenddate }}" type="date" class="form-control" id="projectEndDate" name="projectEndDate" required disabled>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md rounded border border-1 btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-md rounded btn-gold shadow">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>