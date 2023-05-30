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
                        {{ $project->projecttitle }}</i>
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


    <div class="table-responsive mt-2">
        <table class="table table-bordered table-dark table-hover rounded">
            <thead>
                <tr>
                    <th class="col-3">
                        <label class="mt-2 ms-2">
                            <h6><b>Objective</b></h6>
                        </label>


                    </th>
                    <th class="col-3"><label class="mt-2">
                            <h6><b>Activity</b></h6>
                        </label></th>
                    <th class="col-2"><label class="mt-2">
                            <h6><b>Expected Output</b></h6>
                        </label></th>
                    <th class="col-1"><label class="mt-2">
                            <h6><b>Start Date</b></h6>
                        </label></th>
                    <th class="col-1"><label class="mt-2">
                            <h6><b>End Date</b></h6>
                        </label></th>
                    <th class="col-1"><label class="mt-2">
                            <h6><b>Budget</b></h6>
                        </label></th>
                    <th class="col-1"><label class="mt-2">
                            <h6><b>Source</b></h6>
                        </label></th>
                </tr>
            </thead>
            <tbody>


                @foreach ($activities as $activity)
                <tr>
                    <td data-activity="{{ $activity->id }}" id="selectedactivity"><b>{{ $activity->actname }}</b>


                        <!--<ul class="list-unstyled ms-2 small">
                            <p style="display: inline; margin: 0; color: #3dd18d;">Subtasks List:</p>
                            @foreach($subtasks->where('activity_id', $activity->id) as $subtask)
                            <li value="{{ $subtask->subtask_name }}" class="ms-2">{{ $subtask->subtask_name }} - <p style="display: inline; margin: 0; color: #3dd18d;">{{ $subtask->subtask_assignee }}</p>
                            </li>
                            @endforeach

                        </ul>
                        <ul class="list-unstyled d-none">
                            @foreach($activityassignees->where('activity_id', $activity->id) as $activityassignee)
                            <li value="{{ $activityassignee->assignees_name }}">{{ $activityassignee->assignees_name }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-success btn-sm mt-auto align-self-end add-subtask-btn" id="addsubtask">Add Subtask</button>
-->
                    </td>
                    <td>{{ $activity->actenddate }}</td>
                    <td>
                        <ul class="list-unstyled m-2">
                            @foreach($activityassignees->where('activity_id', $activity->id) as $activityassignee)
                            <li>{{ $activityassignee->assignees_name }}</li>
                            @endforeach

                        </ul>
                    </td>
                    <td>
                        <ul class="list-unstyled">

                            <li>
                                <p style="display: inline; margin: 0; color: #3dd18d;">Objectives:</p> {{ $activity->actobjectives }}
                            </li>

                            <li>
                                <p style="display: inline; margin: 0; color: #3dd18d;">Output:</p> {{ $activity->actoutput }}
                            </li>
                            <li>
                                <p style="display: inline; margin: 0; color: #3dd18d;">Start Date:</p> {{ $activity->actstartdate }}
                            </li>
                            <li>
                                <p style="display: inline; margin: 0; color: #3dd18d;">End Date:</p> {{ $activity->actenddate }}
                            </li>
                            <li>
                                <p style="display: inline; margin: 0; color: #3dd18d;">Budget:</p> {{ $activity->actbudget }}
                            </li>
                            <li>
                                <p style="display: inline; margin: 0; color: #3dd18d;">Source:</p> {{ $activity->actsource }}
                            </li>
                        </ul>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
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
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <form id="act1" data-url="{{ route('activity.store') }}">
                                <input type="number" class="d-none" id="assigneesindex" name="assigneesindex">
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

    var selectElement = $('#project-select');
    var url = "";
    var objoption = 1;

    $(document).ready(function() {

        var lastItemId = objectives[objectives.length - 1].objectiveset_id;
        var count = 0;
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