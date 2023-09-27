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
                <a class="dropdown-item small hrefnav" href="{{ route('projects.details', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
                    <b class="small">Edit Details</b>
                </a>
                <a class="dropdown-item small hrefnav" href="#"><b class="small">Edit Objectives</b></a>
                <a class="dropdown-item small hrefnav" href="#" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity"><b class="small">Add Activity</b></a>
                <a class="dropdown-item small hrefnav" href="{{ route('projects.calendar', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
                    <b class="small">View Activity Calendar</b>
                </a>
                <a class="dropdown-item small hrefnav" href="#"><b class="small">Close Project</b></a>
                <a class="dropdown-item small hrefnav" href="{{ route('projects.members', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
                    <b class="small">Team Members</b>
                </a>

            </div>
        </div>
    </div>

    <div class="basiccont m-4 me-0 rounded shadow">
        <div class="border-bottom ps-3 pt-2 bggreen">
            <h6 class="fw-bold small" style="color:darkgreen;">Edit Project Details</h6>
        </div>
        <div class="px-4 pt-2 pb-3">
            <form id="form-projectDetails">
                <!-- Program Title -->
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
            </form>
            <div class="btn-group mt-1 mb-2 shadow" id="div-editDetails">
                <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" id="btn-editDetails" aria-haspopup="true" aria-expanded="false">
                    <b class="small">Edit Details</b>
                </button>
            </div>


            <div class="container text-center mb-2 d-none" id="div-cancelDetails">
                <!-- Use 'justify-content-center' to center-align items horizontally -->
                <button type="button" class="btn shadow btn-light text-primary border-primary" id="btn-cancelDetails" aria-haspopup="true" aria-expanded="false">
                    Cancel
                </button>
            </div>
            <div class="container text-center d-none" id="div-confirmDetails">
                <button type="button" class="btn shadow btn-primary" id="btn-confirmDetails" aria-haspopup="true" aria-expanded="false">
                    Confirm
                </button>
            </div>

        </div>

    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            var programTitle;
            var programLeader;
            var projectTitle;
            var projectLeader;
            var projectStartDate;
            var projectEndDate;
            programTitle = document.getElementById('programTitle');
            programLeader = document.getElementById('programLeader');
            projectTitle = document.getElementById('projectTitle');
            projectLeader = document.getElementById('projectLeader');
            projectStartDate = document.getElementById('projectStartDate');
            projectEndDate = document.getElementById('projectEndDate');
            btnConfirmDetails = document.getElementById('btn-confirmDetails');


            btnConfirmDetails.addEventListener('click', function() {
                var valProgramTitle = programTitle.value;
                var valProgramLeader = programLeader.value;
                var valProjectTitle = projectTitle.value;
                var valProjectLeader = projectLeader.value;
                var valProjectStartDate = projectStartDate.value;
                var valProjectEndDate = projectEndDate.value;
                var projectDetails = [
                    valProgramTitle,
                    valProgramLeader,
                    valProjectTitle,
                    valProjectLeader,
                    valProjectStartDate,
                    valProjectEndDate
                ];
                document.activeElement.blur();
                Livewire.emit('saveProjectDetails', projectDetails);
            });

        });
    </script>
</div>