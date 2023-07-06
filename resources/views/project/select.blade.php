@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <section class="row">

        <div class="col-4 mb-2">
            <div class="position-relative" id="#projectdropdown">
                <label class="text-white">Select Project:</label>
                <select id="project-select" class="form-select" aria-label="Select an option" style="background-color: #d9d9d9;">
                    <option value="" selected disabled>Select Project</option>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $project->id == $projectid ? 'selected' : '' }}>
                        {{ $project->projecttitle }}
                    </option>
                    @endforeach

                </select>

            </div>

        </div>
        <div class="col-8">
            <button type="button" class="btn btn-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#newproject">Add Project</button>
            <button type="button" class="btn btn-sm add-assignees-btn text-success shadow m-1 bg-body rounded" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity">
                <b>Add Activity</b>
            </button>
        </div>
    </section>


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
                                    <input type="text" class="form-control" id="projectleader" name="projectleader">
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
    <!--
    <div class="container-fluid table-responsive">
        <table class="table">
            <thead>
                <tr class="fixed-width-column">
                    <th class="fw-bold text-center border border-dark border-1">Objectives</th>
                    <th class="fw-bold text-center border border-dark border-1">Activities</th>
                    <th class="fw-bold text-center border border-dark border-1">Expected Output</th>
                    <th class="fw-bold text-center border border-dark border-1">Start Date</th>
                    <th class="fw-bold text-center border border-dark border-1">End Date</th>
                    <th class="fw-bold text-center border border-dark border-1">Budget</th>
                    <th class="fw-bold text-center border border-dark border-1">Source</th>
                </tr>
            </thead>
            <tbody>
                @php
                $lastObject = $objectives->last();
                $lastObjectivesetId = $lastObject['objectiveset_id'];
                $x = 0;
                $y = 1;
                @endphp

                @foreach ($sortedActivities as $activity)
                <tr class="fixed-width-column">
                    @if ($x <= $lastObjectivesetId) <td id="objective-{{ $x }}" name="objective-{{ $x }}" class="border border-dark border-1 bgbg">
                        <ul class="list-unstyled">
                            @foreach ($objectives->where('objectiveset_id', $x) as $objective)
                            <li>{{ $y . '. ' . $objective['name'] }}</li>
                            <br>
                            @php
                            $y++;
                            @endphp
                            @endforeach

                        </ul>
                        </td>
                        @else
                        <td class="border-0"></td>
                        @endif
                        <td class="border border-dark border-1" name="activity-{{ $activity->actobjectives }}[]" id="activity-{{ $activity->actobjectives }}">{{ $activity->actname }}</td>
                        <td class="border border-dark border-1">{{ $activity->actoutput }}</td>
                        <td class="border border-dark border-1">{{ $activity->actstartdate }}</td>
                        <td class="border border-dark border-1">{{ $activity->actenddate }}</td>
                        <td class="border border-dark border-1">{{ $activity->actbudget }}</td>
                        <td class="border border-dark border-1">{{ $activity->actsource }}</td>
                </tr>
                @php
                $x++;
                @endphp
                @endforeach
-->
    <!-- Additional rows here -->
    <!--</tbody>
        </table>
    </div>
-->

    <div class="container-fluid table-responsive">
        <div class="row">
            <div class="col-2 p-0">
                <table class="table border border-dark border-1">
                    <thead>
                        <tr class="table-success border border-dark border-1">
                            <th class="fw-bold text-center border border-dark border-1">OBJECTIVES</th>
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
                            <tr id="objective-{{ $x }}" name="objective-{{ $x }}" class="bgbg">
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
            </div>
            <div class="col-10 p-0">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-success">
                            <th class="fw-bold text-center fixed-width-column border border-dark border-start-0 border-1">ACTIVITIES</th>
                            <th class="fw-bold text-center fixed-width-column border border-dark border-1">EXPECTED OUTPUT</th>
                            <th class="fw-bold text-center fixed-width-column border border-dark border-1">START DATE</th>
                            <th class="fw-bold text-center fixed-width-column border border-dark border-1">END DATE</th>
                            <th class="fw-bold text-center fixed-width-column border border-dark border-1">BUDGET</th>
                            <th class="fw-bold text-center fixed-width-column border border-dark border-1">SOURCE</th>
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
                            <tr class="fixed-width-column" id="activity-{{ $x }}" name="activity-{{ $x }}[]">
                                <td class="bullet-cell border border-dark border-start-0 border-1" data-value="{{ $activity['id'] }}" id="actid">
                                    {{ $activity['actname'] }}
                                    <div class="w-100">
                                        <button type="button" class="btn btn-success btn-sm float-end show-assignees">Assignees</button>
                                        <button type="button" class="btn btn-success btn-sm float-end me-2" data-bs-toggle="modal" data-bs-target="#new-subtask-modal">
                                            Subtasks
                                        </button>


                                    </div>
                                </td>
                                <td class="border border-dark border-1">{{ $activity['actoutput'] }}
                                    <div id="outputdropdown" class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="myDropdownButton">
                                            Output
                                        </button>

                                        <ul class="dropdown-menu" aria-labelledby="myDropdownButton">
                                            @php
                                            $uniqueOutputTypes = [];
                                            @endphp
                                            @foreach ($outputs as $output)
                                            @if ($output->activity_id == $activity['id'] && !in_array($output->output_type, $uniqueOutputTypes))
                                            <li value="{{ $activity['id'] }}"><a class="dropdown-item output-link">{{ $output->output_type }}</a></li>
                                            @php
                                            $uniqueOutputTypes[] = $output->output_type;
                                            @endphp
                                            @endif
                                            @endforeach

                                        </ul>
                                    </div>

                                </td>
                                <td class="border border-dark border-1">{{ date('F d, Y', strtotime($activity['actstartdate'])) }}</td>
                                <td class="border border-dark border-1">{{ date('F d, Y', strtotime($activity['actenddate'])) }}</td>
                                <td class="border border-dark border-1">&#8369;{{ number_format($activity['actbudget'], 2) }}</td>
                                <td class="border border-dark border-1">{{ $activity['actsource'] }}</td>
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
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="outputform">
                <form>
                    <div class="mb-2 row" id="firstoutput-container">
                        <label class="col-7 m-1 output-label"></label>
                        <input type="number" class="col-4 m-1" name="output-number[0]">
                        <input type="text" class="d-none firstoutput-name" name="out-name[0]">
                        <input type="text" class="d-none firstoutput-type" name="out-type[0]">
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Changes</button>
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


        while (currentrow < rowcount) {

            var objectiveheight = $(`#objective-${currentrow}`).height();
            var allactheight = 0;

            $(`tr[name="activity-${currentrow}[]"]`).each(function() {
                allactheight = allactheight + $(this).height();

            });

            if (objectiveheight < allactheight) {
                $(`#objective-${currentrow}`).height(allactheight);

            } else if (allactheight < objectiveheight) {
                var heightneeded = objectiveheight - allactheight;
                var addheight = heightneeded / $(`tr[name="activity-${currentrow}[]"]`).length;

                $('#activity-' + currentrow).each(function() {
                    var actheight = $(this).height();
                    $(this).height(addheight + actheight);

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

                $(`tr[name="objective-${currenthover}"`).css('background-color', '#e6e7e9');
            },
            function() {
                // Code to run when the mouse leaves the 'tr' element
                $(`tr[name="objective-${currenthover}"`).css('background-color', '');
            }
        );

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