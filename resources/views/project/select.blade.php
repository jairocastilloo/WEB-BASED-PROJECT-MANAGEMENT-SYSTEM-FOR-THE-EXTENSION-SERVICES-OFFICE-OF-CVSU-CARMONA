@extends('layouts.app')

@section('content')

<input class="d-none" type="number" id="acturl" data-url="{{ route('activities.display', ['activityid' => ':activityid', 'department' => ':department', 'activityname' => ':activityname']) }}">

<input class="d-none" type="number" id="projecturl" data-url="{{ route('projects.display', ['projectid' => ':projectid', 'department' => ':department', 'projectname' => ':projectname']) }}">

<input class="d-none" type="date" id="projsavestartdate" value="{{ $indexproject['projectstartdate'] }}">
<input class="d-none" type="date" id="projsaveenddate" value="{{ $indexproject['projectenddate'] }}">
<div class="maincontainer">
    <div class="mainnav mb-2 shadow">
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle text-wrap">
            <h5 class="fw-bold">Project: {{ $indexproject['projecttitle'] }}</h5>
        </div>

    </div>
    <div class="row">
        <div class="col-10">

            <div class="basiccont mt-2 m-4 me-0 rounded shadow pb-2">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Browse Projects</h6>
                </div>
                @if (!$inCurrentYear)
                <span class="small ms-2"><em>
                        Note: Not the Current Year.
                    </em></span>
                @endif
                <div class="form-floating m-3 mb-2 mt-2">

                    <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen; font-size: 21px;" aria-label="Select an calendar year">

                        @foreach ($calendaryears as $calendaryear)
                        <option value="{{ $calendaryear }}" {{ $calendaryear == $currentyear ? 'selected' : '' }}>
                            &nbsp;&nbsp;&nbsp;{{ $calendaryear }}
                        </option>
                        @endforeach

                    </select>
                    <label for="year-select" style="color:darkgreen;">
                        <h5><strong>Calendar Year:</strong></h5>
                    </label>
                </div>
                <div class="btn-group mt-1 ms-3 mb-2 shadow">
                    <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addproj">
                        <b class="small">Create Project</b>
                    </button>
                </div>

            </div>

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
                        <a class="dropdown-item small hrefnav" href="#"><b class="small">Edit Details</b></a>
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
                <!--
                <button type="button" class="btn btn-sm add-assignees-btn mt-2 shadow rounded border border-2 border-warning" style="background-color: gold;" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity">
                    <b class="small">Add Activity</b>
                </button>
-->

            </div>

            <div class="basiccont m-4 me-0 d-flex justify-content-center align-items-center border rounded small shadow">

                <div class="tablecontainer pb-2">

                    <table class="firsttable">
                        <thead>
                            <tr id="objheader">
                                <th class="p-2 text-center">OBJECTIVES</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php

                            $lastObject = $objectives->last();
                            $lastObjectivesetId = $lastObject['objectiveset_id'];
                            $sortedactivity = collect($activities)->sortBy('actobjectives')->values();
                            $x = 0;
                            $y = 1;
                            @endphp

                            @while ($x <= $lastObjectivesetId) @php $actcount=$activities->where('actobjectives', $x)->count();
                                @endphp
                                <tr id="objective-{{ $x }}" name="objective-{{ $x }}">
                                    <td class="ps-3 pt-3">

                                        @foreach($objectives->where('objectiveset_id', $x) as $objective)


                                        <p class="lh-sm">{{ __($y) . '. ' . $objective['name'] }}</p>


                                        @php
                                        $y++;
                                        @endphp
                                        @endforeach


                                    </td>
                                </tr>
                                @php
                                $x++;
                                @endphp
                                @endwhile

                        </tbody>
                    </table>

                    <table class="secondtable">
                        <thead>
                            <tr id="actheader">
                                <th class="p-2 text-center">ACTIVITIES</th>
                                <th class="p-2 text-center">EXPECTED OUTPUT</th>
                                <th class="p-2 text-center">START DATE</th>
                                <th class="p-2 text-center">END DATE</th>
                                <th class="p-2 text-center">BUDGET</th>
                                <th class="p-2 text-center">SOURCE</th>
                            </tr>

                        </thead>
                        <tbody>
                            @php

                            $lastObject = $objectives->last();
                            $lastObjectivesetId = $lastObject['objectiveset_id'];
                            $sortedactivity = collect($activities)->sortBy('actobjectives')->values();
                            $x = 0;
                            $y = 1;
                            @endphp

                            @while ($x <= $lastObjectivesetId) @php $actcount=$activities->where('actobjectives', $x)->count();
                                @endphp

                                @if ($actcount > 0)
                                @foreach($activities->where('actobjectives', $x) as $activity)
                                <tr id="activity-{{ $x }}" name="activity-{{ $x }}[]" data-value="{{ $activity['id'] }}" act-name="{{ $activity['actname'] }}">
                                    <td class="pt-4 pb-2 pe-2" data-value=" {{ $activity['id'] }}" id="actid">
                                        <ul>
                                            <li>{{ $activity['actname'] }}</li>
                                        </ul>
                                    </td>
                                    <td class="p-2">{{ $activity['actoutput'] }}</td>
                                    <td class="p-2">{{ date('F d, Y', strtotime($activity['actstartdate'])) }}</td>
                                    <td class="p-2">{{ date('F d, Y', strtotime($activity['actenddate'])) }}</td>
                                    <td class="p-2">&#8369;{{ number_format($activity['actbudget'], 2) }}</td>
                                    <td class="p-2">{{ $activity['actsource'] }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr id="activity-{{ $x }}" name="activity-{{ $x }}[]" data-value="0">
                                    <td class="pt-2 pb-2 pe-2" data-value="0" id="actid">
                                        &nbsp;
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @endif

                                @php
                                $x++;
                                @endphp
                                @endwhile

                        </tbody>
                    </table>

                </div>

            </div>


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
            <div class="basiccont word-wrap shadow mt-2 me-3">
                <div class="border-bottom ps-3 pt-2 bggreen pe-2">
                    <h6 class="fw-bold small" style="color:darkgreen;">Projects</h6>
                </div>
                <div class="text-center p-4">
                    <h4><em>No Other Projects Yet.</em></h4>
                </div>
            </div>
            @endif
            @if ($inProgressProjects && count($inProgressProjects) > 0)

            <div class="basiccont word-wrap shadow mt-2 me-3">
                <div class="border-bottom ps-3 pt-2 bggreen pe-2">
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
            <div class="basiccont word-wrap shadow mt-2 me-3">
                <div class="border-bottom ps-3 pt-2 bggreen pe-2">
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
            <div class="basiccont word-wrap shadow mt-2 me-3">
                <div class="border-bottom ps-3 pt-2 bggreen pe-2">
                    <h6 class="fw-bold small" style="color:darkgreen;">Completed Projects</h6>
                </div>
                @foreach ($completedProjects as $project)
                <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                    <h6 class="fw-bold ">{{ $project['projecttitle'] }}</h6>

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

            <div class="basiccont word-wrap shadow mt-2 me-3">
                <div class="border-bottom ps-3 pt-2 pe-2 bggreen pe-2">
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

</div>
@if ($currentproject)
<!-- New Project -->

<div class="modal fade" id="newproject" tabindex="-1" aria-labelledby="newprojectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newproject">New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true" disabled>Project Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false" disabled>Project Members</button>
                    </li>.
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false" disabled>Project Objectives</button>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <!-- Form for tab 1 -->
                        <form id="form1" data-url="{{ route('project.store') }}">
                            @csrf
                            <input type="text" class="d-none" name="department" id="department" value="{{ Auth::user()->department }}">
                            <input type="text" class="d-none" name="currentyear" id="currentyear" value="{{ $currentyear }}">
                            <input type="number" class="d-none" id="memberindex" name="memberindex">
                            <input type="number" class="d-none" id="objectiveindex" name="objectiveindex">
                            <label for="projectdetails" class="form-label mt-2">Input all the details of the project</label>
                            <div class="mb-3">
                                <label for="projecttitle" class="form-label">Project Title</label>
                                <input type="text" class="form-control autocapital" id="projecttitle" name="projecttitle">

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="projectleader" class="form-label">Project Leader</label>
                                <select class="form-select" name="projectleader" id="projectleader">
                                    <option value="0" selected disabled>Select Project Leader</option>
                                </select>
                                <!--<input type="text" class="form-control" id="projectleader" name="projectleader">-->

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="programtitle" class="form-label">Program Title</label>
                                <input type="text" class="form-control autocapital" id="programtitle" name="programtitle">

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="programleader" class="form-label">Project Leader</label>
                                <select class="form-select" name="programleader" id="programleader">
                                    <option value="0" selected disabled>Select Program Leader</option>

                                </select>

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="projectstartdate" class="form-label">Project Start Date</label>
                                <input type="date" class="form-control" id="projectstartdate" name="projectstartdate">

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="projectenddate" class="form-label">Project End Date</label>
                                <input type="date" class="form-control" id="projectenddate" name="projectenddate">

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </form>


                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <!-- Form for tab 2 -->

                        <div class="container-fluid" id="memberform">
                            <form id="form2">
                                @csrf
                                <label for="projectmember" class="form-label mt-2">Assign Members for the Project</label>
                                <div class="mb-2 row rounded" id="selectmember">
                                    <select class="col-7 m-1 member-select p-2 rounded is-invalid" id="member-select" name="projectmember[]">
                                        <option value="0" selected disabled>Select a Member</option>
                                    </select>

                                    <button type="button" class="remove-member btn btn-sm btn-outline-danger col-2 m-1 float-end" id="removemember">
                                        <b class="small">Remove</b>
                                    </button>


                                </div>

                            </form>


                            <button type="button" class="addmember-button btn btn-sm btn-gold border border-2 border-warning" id="addmember">
                                <b class="small">Add Member</b>
                            </button>
                            <br>
                            <span class="small text-danger nomember-error">
                                <strong>Assign atleast one member.</strong>
                            </span>

                            <span class="small text-danger noselectmember-error">
                                <strong>Please ensure that a member is selected in every dropdown.</strong>
                            </span>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                        <!-- Form for tab 2 -->

                        <div class="container-fluid" id="objform">
                            <form id="form3">
                                @csrf
                                <label for="projectobjectives" class="form-label mt-2">List all objectives of the project</label>
                                <div class="container-fluid" id="objectiveset">
                                    <div>
                                        <div class="mb-2 row" id="selectobjectives">
                                            <input type="text" class="col-8 m-1 input-objective autocapital p-2 rounded" id="objective-input" name="projectobjective[]" placeholder="Enter objective">
                                            <input type="number" name="objectivesetid[]" value="0" class="objectivesetid d-none">
                                            <button type="button" class="remove-objective btn btn-sm btn-outline-danger col-3 m-1" id="removeobjective"><b class="small">Remove</b></button>

                                            <span class="invalid-feedback" role="alert">
                                                <strong>Make</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <button type="button" class="add-objective btn btn-sm btn-outline-success" id="addobjective">
                                        <b class="small">Add Objective</b>
                                    </button>
                                    <br>
                                    <span class="small text-danger projectobjective-error">
                                        <strong>Please ensure that there is objective in every input.</strong>
                                    </span>

                                    <hr>
                                </div>
                            </form>
                            <button type="button" class="addset btn btn-outline-secondary w-100" id="addset">
                                <b class="small">Add Objective Set</b>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn shadow rounded border border-1 btn-light" data-bs-dismiss="modal"><b class="small">Close</b></button>
                <button type="button" class="btn shadow rounded btn-outline-primary" id="prevproject">
                    <b class="small">Previous</b>
                </button>
                <button type="button" class="btn shadow rounded btn-primary" id="nextproject"><b class="small">Next</b></button>
                <button type="button" class="btn shadow rounded btn-primary" id="createproject">
                    <b class="small">Create Project</b>
                </button>

            </div>
        </div>
    </div>
</div>
@endif
<!-- Add activity -->

<div class="modal fade" id="newactivity" tabindex="-1" aria-labelledby="newactivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newactivityLabel">Adding Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="act1" data-url="{{ route('activity.store') }}">
                    @csrf

                    <input type="number" id="projectindex" name="projectindex" value="{{ $indexproject['id'] }}" class="d-none">
                    <input type="text" class="d-none" id="assigneesname" name="assigneesname[0]">
                    <div class="mb-3">
                        <label for="activityname" class="form-label">Activity Name</label>
                        <input type="text" class="form-control" id="activityname" name="activityname">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="objectives" class="form-label">Objectives</label>
                        <select class="form-select" id="objective-select" name="objectives">
                            <option value="" selected disabled>Choose Objectives</option>
                            <option value="0" style="font-weight: bold;">OBJECTIVE SET 1</option>
                        </select>
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="expectedoutput" class="form-label">Expected Output</label>
                        <input type="text" class="form-control" id="expectedoutput" name="expectedoutput">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="startdate" class="form-label">Activity Start Date</label>
                        <input type="date" class="form-control" id="activitystartdate" name="activitystartdate">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="enddate" class="form-label">Activity End Date</label>
                        <input type="date" class="form-control" id="activityenddate" name="activityenddate">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label">Budget</label>
                        <input type="number" class="form-control" id="budget" name="budget">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="Source" class="form-label">Source</label>
                        <input type="text" class="form-control" id="source" name="source">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn shadow rounded border border-1 btn-light" data-bs-dismiss="modal">
                    <b class="small">Close</b>
                </button>
                <button type="button" class="btn shadow rounded btn-primary" id="confirmactivity">
                    <b class="small">Add activity</b>
                </button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<!--<script src="{{ asset('js/selectize.min.js') }}"></script>-->
<script>
    var users = <?php echo json_encode($members);
                ?>;
    var objectives = <?php echo json_encode($objectives);
                        ?>;

    var selectElement = $('#year-select');
    var url = "";
    var objoption = 1;

    $(document).ready(function() {

        var lastItemId = objectives[objectives.length - 1].objectiveset_id;
        var count = 0;

        var rowcount = <?php echo $x; ?>;
        var currentrow = 0;

        $('#objheader').height($('#actheader').height());

        while (currentrow < rowcount) {
            var objectiveheight = $(`#objective-${currentrow}`).height();
            var allactheight = 0;

            $(`tr[name="activity-${currentrow}[]"]`).each(function() {
                allactheight += $(this).height(); // Use outerHeight() instead of height()
            });

            if (objectiveheight < allactheight) {
                $(`#objective-${currentrow}`).css({
                    'height': allactheight, // Set the height directly instead of using height()

                });
            } else if (allactheight < objectiveheight) {
                var heightneeded = objectiveheight - allactheight;
                var addheight = heightneeded / $(`tr[name="activity-${currentrow}[]"]`).length;

                $(`tr[name="activity-${currentrow}[]"]`).each(function() {
                    $(this).css({
                        'height': addheight + $(this).height(),

                    });
                });
            }

            currentrow++;
        }

        $.each(objectives, function(index, objective) {

            if (objective.objectiveset_id === count) {
                $('#objective-select').append($('<option>', {

                    text: '\u00A0\u00A0\u00A0\u00A0' + objoption + "." + objective.name,
                    disabled: true,
                    style: 'font-style: italic;'
                }));
            } else {
                count++;
                var y = count + 1;
                var line = '\u2014\u00A0'.repeat(20);
                $('#objective-select').append($('<option>', {
                    text: line,
                    disabled: true,
                }));
                $('#objective-select').append($('<option>', {
                    value: count,
                    text: "OBJECTIVE SET " + y,
                    style: 'font-weight: bold;'
                }));
                $('#objective-select').append($('<option>', {

                    text: '\u00A0\u00A0\u00A0\u00A0' + objoption + "." + objective.name,
                    disabled: true
                }));
            };
            objoption++;

        });
        var currenthover = 0;
        $('tr[name^="activity-"]').hover(

            function() {
                // Code to run when the mouse enters the 'tr' element
                currenthover = $(this).attr('name').match(/\d+/)[0];
                $(this).css('cursor', 'pointer');
                $(this).css('background-color', '#e6e7e9');
                $(`tr[name="objective-${currenthover}"`).css('background-color', '#e6e7e9');
            },
            function() {
                // Code to run when the mouse leaves the 'tr' element
                $(this).css('cursor', 'default');
                $(this).css('background-color', '');
                $(`tr[name="objective-${currenthover}"`).css('background-color', '');
            }
        );

        $('tr[name^="activity-"]').click(function(event) {
            event.preventDefault();

            var activityid = $(this).data('value');
            var activityname = $(this).attr('act-name');
            var department = $('#department').val();

            if (activityid != 0) {

                var url = '{{ route("activities.display", ["activityid" => ":activityid", "department" => ":department", "activityname" => ":activityname"]) }}';
                url = url.replace(':activityid', activityid);
                url = url.replace(':department', department);
                url = url.replace(':activityname', activityname);
                window.location.href = url;
            }
        });


        $.each(objectives, function(index, item) {
            if (item.objectiveset_id === "1") {
                $('#objective-select').append($('<option>', {
                    value: item.value,
                    text: item.text
                }));
            }
        });

        $(document).on('click', '.projectdiv', function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');
            var projectname = $(this).attr('data-name');
            var department = $('#department').val();


            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));

            window.location.href = url;
        });

        // Add an event listener to the select element
        selectElement.change(function() {
            var selectedOption = $(this).find(':selected');
            var currentyear = selectedOption.val();

            var department = $('#department').val();

            var baseUrl = "{{ route('yearproject.show', ['department' => ':department', 'currentyear' => ':currentyear']) }}";
            var url = baseUrl.replace(':department', department)
                .replace(':currentyear', currentyear);

            window.location.href = url;
        });




    });
</script>
<script src="{{ asset('js/create.js') }}"></script>
<script src="{{ asset('js/select.js') }}"></script>
@endsection