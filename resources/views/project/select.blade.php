@extends('layouts.app')

@section('content')
<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Project: {{ $project['projecttitle'] }}</b></h6>
        </div>

    </div>
    <div class="row">
        <div class="col-10">

            <div class="basiccont m-4 me-0 p-3 rounded">

                <div class="form-floating">
                    <select id="project-select" class="form-select" style="border: 1px solid darkgreen;" aria-label="Select an option">
                        <option value="" selected disabled>Select Project</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ $project->id == $projectid ? 'selected' : '' }}>
                            {{ $project->projecttitle }}
                        </option>
                        @endforeach

                    </select>
                    <label for="project-select" style="color:darkgreen;"><strong>Select Project:</strong></label>
                </div>



                @if ( Auth::user()->role === "Admin")
                <button type="button" class="btn btn-sm mt-3 shadow rounded border border-2 border-warning text-body" style="background-color: gold;" data-bs-toggle="modal" data-bs-target="#newproject"><b class="small">Start New Project</b></button>
                @endif
            </div>

            <div class="basiccont m-4 me-0 p-3 rounded">
                <div class="flexmid"><strong>WORK AND FINANCIAL PLAN</strong></div>
                <div class="flexmid">CY&nbsp;<u>{{ date('Y', strtotime($project['projectenddate'])) }}</u></div>
                <div class="flex-container">
                    <strong><em>Program Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                    <div class="underline-space inline-div ps-2">{{ $project['programtitle'] }}</div>
                </div>
                <div class="flex-container">
                    <strong><em>Program Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                    <div class="underline-space inline-div ps-2">{{ $project['programleader'] }}</div>
                </div>
                <div class="flex-container">
                    <strong><em>Project Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                    <div class="underline-space inline-div ps-2">{{ $project['projecttitle'] }}</div>
                </div>
                <div class="flex-container">
                    <strong><em>Project Leader:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                    <div class="underline-space inline-div ps-2">{{ $project['projectleader'] }}</div>
                </div>
                <div class="flex-container">
                    <strong><em>Duration:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></strong>
                    <div class="underline-space inline-div ps-2">{{ date('F', strtotime($project['projectenddate'])) . '-' . date('F Y', strtotime($project['projectenddate'])) }}</div>
                </div>

                <div class="btn-group dropdown dropend mt-3">
                    <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-2 border-warning text-body" style="background-color: gold;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <b class="small">Edit Project</b>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item small" href="#" style="color:darkgreen;"><b class="small">Edit Details</b></a>
                        <a class="dropdown-item small" href="#" style="color:darkgreen;"><b class="small">Edit Objectives</b></a>
                        <a class="dropdown-item small" href="#" style="color:darkgreen;"><b class="small">Add Activity</b></a>

                    </div>
                </div>
                <!--
        <button type="button" class="btn btn-sm add-assignees-btn mt-2 shadow rounded border border-2 border-warning" style="background-color: gold;" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity">
            <b class="small">Add Activity</b>
        </button>
        -->

            </div>

            <div class="basiccont m-4 me-0 d-flex justify-content-center align-items-center border rounded small">
                <div class="tablecontainer pb-2">

                    <table class="firsttable">
                        <thead>
                            <tr id="objheader">
                                <th>OBJECTIVES</th>
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
                                    <td>
                                        <ul class="list-unstyled">
                                            @foreach($objectives->where('objectiveset_id', $x) as $objective)
                                            <li>
                                                {{ __($y) . '. ' . $objective['name'] }}
                                            </li>
                                            <br>
                                            @php
                                            $y++;
                                            @endphp
                                            @endforeach

                                        </ul>
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
                                <th>ACTIVITIES</th>
                                <th>EXPECTED OUTPUT</th>
                                <th>START DATE</th>
                                <th>END DATE</th>
                                <th>BUDGET</th>
                                <th>SOURCE</th>
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
                                @foreach($activities->where('actobjectives', $x) as $activity)
                                <tr id="activity-{{ $x }}" name="activity-{{ $x }}[]" data-value="{{ $activity['id'] }}">
                                    <td class="pt-2 pb-2 pe-2" data-value=" {{ $activity['id'] }}" id="actid">
                                        <ul>
                                            <li>{{ $activity['actname'] }}</li>
                                        </ul>

                                    </td>
                                    <td>{{ $activity['actoutput'] }}

                                    </td>
                                    <td>{{ date('F d, Y', strtotime($activity['actstartdate'])) }}</td>
                                    <td>{{ date('F d, Y', strtotime($activity['actenddate'])) }}</td>
                                    <td>&#8369;{{ number_format($activity['actbudget'], 2) }}</td>
                                    <td>{{ $activity['actsource'] }}</td>
                                </tr>
                                @endforeach
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
            <div class="basiccont me-4 mt-4 rounded">
                <div class="border-bottom mt-4 ps-3">
                    <h6 class="fw-bold small text-secondary">Projects</h6>
                </div>
                @php
                // Sort the $activities array by actstartdate in ascending order
                $sortedProjects = $projects->sortBy('projectstartdate');
                @endphp
                @foreach($sortedProjects as $project)
                <div class="border-bottom p-2 divhover projectdiv" data-value="{{ $project['id'] }}">
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

</div>

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
                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Project Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Project Members</button>
                    </li>.
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">Project Objectives</button>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <!-- Form for tab 1 -->
                        <form id="form1" data-url="{{ route('project.store') }}">
                            @csrf
                            <!--<input type="text" name="id" value="{{ Auth::user()->id }}">-->
                            <input type="number" class="d-none" id="memberindex" name="memberindex">
                            <input type="number" class="d-none" id="objectiveindex" name="objectiveindex">
                            <label for="projectdetails" class="form-label mt-2">Input all the details of the project</label>
                            <div class="mb-3">
                                <label for="projecttitle" class="form-label">Project Title</label>
                                <input type="text" class="form-control" id="projecttitle" name="projecttitle">
                            </div>
                            <div class="mb-3">
                                <label for="projectleader" class="form-label">Project Leader</label>
                                <select class="form-select" name="projectleader" id="projectleader">
                                    <option selected disabled>Select Project Leader</option>


                                </select>
                                <!--<input type="text" class="form-control" id="projectleader" name="projectleader">-->
                            </div>
                            <div class="mb-3">
                                <label for="programtitle" class="form-label">Program Title</label>
                                <input type="text" class="form-control" id="programtitle" name="programtitle">
                            </div>
                            <div class="mb-3">
                                <label for="programleader" class="form-label">Program Leader</label>
                                <input type="text" class="form-control" id="programleader" name="programleader">
                            </div>
                            <div class="mb-3">
                                <label for="projectstartdate" class="form-label">Project Start Date</label>
                                <input type="date" class="form-control" id="projectstartdate" name="projectstartdate">
                            </div>
                            <div class="mb-3">
                                <label for="projectenddate" class="form-label">Project End Date</label>
                                <input type="date" class="form-control" id="projectenddate" name="projectenddate">
                            </div>
                        </form>


                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <!-- Form for tab 2 -->

                        <div class="container-fluid" id="memberform">
                            <form id="form2">
                                @csrf
                                <label for="projectmember" class="form-label mt-2">Assign Members for the Project</label>
                                <div class="mb-2 row" id="selectmember">
                                    <select class="col-7 m-1 member-select" id="member-select" name="projectmember[]">
                                        <option value="" selected disabled>Select a Member</option>
                                    </select>
                                    <button type="button" class="remove-member btn btn-danger col-2 m-1 float-end" id="removemember">Remove</button>
                                </div>

                            </form>
                            <button type="button" class="addmember-button btn btn-success w-100" id="addmember">Add Member</button>

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
                                            <input type="text" class="col-7 m-1 input-objective" id="objective-input" name="projectobjective[]" placeholder="Enter objective">
                                            <input type="number" name="objectivesetid[]" value="0" class="objectivesetid d-none">
                                            <button type="button" class="edit-objective btn btn-success col-2 m-1" id="editobjective">Edit</button>
                                            <button type="button" class="remove-objective btn btn-danger col-2 m-1" id="removeobjective">Remove</button>
                                        </div>
                                    </div>
                                    <button type="button" class="add-objective btn btn-success" id="addobjective">Add Objective</button>
                                    <hr>
                                </div>
                            </form>
                            <button type="button" class="addset btn btn-success w-100" id="addset">Add Objective Set</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" id="prevproject">Previous</button>
                <button type="button" class="btn btn-info" id="nextproject">Next</button>
                <button type="button" class="btn btn-primary" id="createproject">Create Project</button>
            </div>
        </div>
    </div>
</div>
<!-- Add activity -->

<div class="modal fade" id="newactivity" tabindex="-1" aria-labelledby="newactivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newactivityLabel">Adding Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="assignees-tab" data-bs-toggle="tab" data-bs-target="#assignees" type="button" role="tab" aria-controls="assignees" aria-selected="false">Assignees</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="output-tab" data-bs-toggle="tab" data-bs-target="#output" type="button" role="tab" aria-controls="output" aria-selected="false">Output</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <form id="act1" data-url="{{ route('activity.store') }}">
                            <input type="number" class="d-none" id="assigneesindex" name="assigneesindex">
                            <input type="number" class="d-none" id="outputindex" name="outputindex">
                            <input type="number" class="d-none" id="projectindex" name="projectindex">
                            <input type="text" class="d-none" id="assigneesname" name="assigneesname[0]">
                            <div class="mb-3">
                                <label for="activityname" class="form-label">Activity Name</label>
                                <input type="text" class="form-control" id="activityname" name="activityname">
                            </div>
                            <div class="mb-3">
                                <label for="objectives" class="form-label">Objectives</label>
                                <select class="form-select" id="objective-select" name="objectives">
                                    <option value="" selected disabled>Choose Objectives</option>
                                    <option value="0" style="font-weight: bold;">OBJECTIVE SET 1</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="expectedoutput" class="form-label">Expected Output</label>
                                <input type="text" class="form-control" id="expectedoutput" name="expectedoutput">
                            </div>
                            <div class="mb-3">
                                <label for="startdate" class="form-label">Activity Start Date</label>
                                <input type="date" class="form-control" id="activitystartdate" name="activitystartdate">
                            </div>
                            <div class="mb-3">
                                <label for="enddate" class="form-label">Activity End Date</label>
                                <input type="date" class="form-control" id="activityenddate" name="activityenddate">
                            </div>
                            <div class="mb-3">
                                <label for="budget" class="form-label">Budget</label>
                                <input type="number" class="form-control" id="budget" name="budget">
                            </div>
                            <div class="mb-3">
                                <label for="Source" class="form-label">Source</label>
                                <input type="text" class="form-control" id="Source" name="source">
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="assignees" role="tabpanel" aria-labelledby="assignees-tab">
                        <div class="container-fluid" id="assigneesform">
                            <form id="act2">
                                @csrf
                                <label for="assignees" class="form-label mt-2">Assign project members for the activity</label>
                                <div class="mb-2 row" id="selectassignees">
                                    <select class="col-9 m-1" id="assignees-select" name="assignees[]">
                                        <option value="" selected disabled>Select a Member</option>
                                    </select>
                                    <button type="button" class="remove-assignees btn btn-danger col-2 m-1" id="removeassignees">Remove</button>
                                </div>


                            </form>
                            <button type="button" class="addassignees-button btn btn-success" id="addassignees">Add Assignees</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="output" role="tabpanel" aria-labelledby="output-tab">
                        <div class="container-fluid" id="outputform">
                            <form id="act3">
                                @csrf
                                <label for="output" class="form-label mt-2">Select what output should be submitted to this activity.</label>
                                <div class="mb-2 row" id="selectoutput">
                                    <select class="col-9 m-1" id="output-select" name="output[]">
                                        <option value="" selected disabled>Select Output Type</option>
                                        <option value="Capacity building">Capacity building</option>
                                        <option value="IEC Material">IEC Material</option>
                                        <option value="Advisory services">Advisory services</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <button type="button" class="remove-output btn btn-danger col-2 m-1" id="removeoutput">Remove</button>
                                </div>
                            </form>
                            <button type="button" class="addoutput-button btn btn-success" id="addoutput">Add Output</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmactivity">Add activity</button>
            </div>
        </div>
    </div>
</div>

</div>
<!--subtask -->

<div class="modal" id="new-subtask-modal" tabindex="-1" aria-labelledby="new-subtask-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="subtaskform" data-url="{{ route('subtask.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="new-subtask-modal-label">New Subtask</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="subtask-name" class="form-label">Subtask Name</label>
                        <input type="text" class="form-control" id="subtaskname" name="subtaskname" placeholder="Enter Subtask">
                    </div>
                    <div class="mb-3">
                        <label for="assignee" class="form-label">Subtask Assignee</label>
                        <select class="form-select" id="subtaskassignee" name="subtaskassignee">
                            <option value="" selected disabled>Select subtask assignee</option>
                        </select>
                        <input type="number" class="form-control d-none" id="activitynumber" name="activitynumber">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="createsubtask">Add Subtask</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--assignees-->
<div class="modal fade" id="assigneesModal" tabindex="-1" aria-labelledby="namesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="namesModalLabel">Assignees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label id="labeltoselect"></label>
                <form id="activityassigneesform">
                    <div class="mb-2 row firstselect" id="selectactivityassignees">
                        <select class="col-9 m-1" id="firstactivityassignees" name="activityassignees[]" disabled>
                        </select>
                        <button type="button" class="delete-activityassignees btn btn-sm btn-danger col-2 m-1 btn-hover-toggle d-none btn-sm">Delete</button>
                    </div>
                </form>
                <div class="row mb-2 btn-activityassignees">
                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-sm btn-primary btn-hover-outline-primary add-activityassignees">Add Assignees</button>
                    </div>
                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-sm btn-danger" id="remove-activityassignees">Remove Assignees</button>
                    </div>
                </div>
                <div class="row mb-2 d-none btn-confirmremoveactivityassignees">

                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-sm btn-primary btn-hover-outline-primary confirm-removeactivityassignees">Confirm Deleting</button>
                    </div>
                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-sm btn-danger cancel-activityassignees">Cancel Deleting</button>
                    </div>
                </div>
                <div class="row mb-2 d-none btn-confirmaddactivityassignees">
                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-sm btn-primary btn-hover-outline-primary confirm-addactivityassignees">Confirm Adding</button>
                    </div>

                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-sm btn-danger cancel-activityassignees">Cancel Removing</button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--output-->
<div class="modal fade" id="output-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="outputmodallabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="outputformdiv">
                <form id="outputformsubmit" data-url="{{ route('output.submit') }}">
                    @csrf
                    <input type="number" class="d-none" id="submitoutputindex" name="submitoutputindex">
                    <div class="mb-2 row" id="firstoutput-container">
                        <label class="col-7 m-1 output-label"></label>
                        <input type="number" class="col-4 m-1" name="output-number[0]">
                        <input type="text" class="d-none firstoutput-name" name="out-name[0]">
                        <input type="text" class="d-none firstoutput-type" name="out-type[0]">
                    </div>
                </form>


            </div>
            <form method="POST" action="{{ route('upload.file') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".docx">
                <button type="submit">Upload report</button>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitoutput">Submit output</button>
            </div>
        </div>
    </div>
</div>

<!--hours rendered -->

<div class="modal fade" id="hours-rendered-modal" tabindex="-1" aria-labelledby="hours-rendered-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hours-rendered-modal-label">Add Hours Rendered</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="hoursform" data-url="{{ route('hoursrendered.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="hours-rendered-input" class="form-label">Hours Rendered:</label>
                        <input type="number" class="form-control" name="hours-rendered-input" id="hours-rendered-input" placeholder="Enter hours rendered" min="0" step="0.5">
                        <input type="text" class="d-none hours-subname" name="hours-subname">
                        <input type="text" class="d-none hours-actid" name="hours-actid">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submithours">Submit hours</button>
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
    var assignees = <?php echo json_encode($assignees);
                    ?>;
    var activityassignees = <?php echo json_encode($activityassignees);
                            ?>;
    var outputs = <?php echo json_encode($outputs);
                    ?>;

    var selectElement = $('#project-select');
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

            var url = '{{ route("get.activity", ["id" => Auth::user()->id, "activityid" => ":activityid"]) }}';
            url = url.replace(':activityid', activityid);
            window.location.href = url;
        });


        $.each(objectives, function(index, item) {
            if (item.objectiveset_id === "1") {
                $('#objective-select').append($('<option>', {
                    value: item.value,
                    text: item.text
                }));
            }
        });

        $.each(assignees, function(index, assignee) {
            $('#assigneesform form div:last #assignees-select').append($('<option>', {
                value: assignee.id,
                text: assignee.name
            }));
        });

        // Add an event listener to the select element
        selectElement.change(function() {
            // Get the currently selected option

            var selectedOption = $(this).find(':selected');
            var projectid = selectedOption.val();

            url = '{{ route("get.objectives", ["id" => Auth::user()->id, "projectid" => ":projectid"]) }}';
            url = url.replace(':projectid', projectid);
            window.location.href = url;

        });


    });
</script>
<script src="{{ asset('js/create.js') }}"></script>
<script src="{{ asset('js/select.js') }}"></script>
@endsection