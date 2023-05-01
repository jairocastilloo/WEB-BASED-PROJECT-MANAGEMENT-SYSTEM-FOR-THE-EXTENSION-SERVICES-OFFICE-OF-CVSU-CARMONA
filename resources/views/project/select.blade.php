@extends('layouts.app')
<!--@php
use Illuminate\Support\Facades\Auth;
@endphp-->
@section('content')
<div class="row">
    <div class="col-1"></div>
    <div class="col-10">
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
            <div class="col-8"></div>
        </section>


        <!-- New Project -->
        <button type="button" class="btn btn-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#newproject">Add Project</button>
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
                                        <label for="projectmembers" class="form-label mt-2">Assign Members for the Project</label>
                                        <div class="mb-2 row" id="selectmember">
                                            <select class="col-9 m-1" id="member-select" name="projectmember[]">
                                                <option value="" selected disabled>Select a Member</option>
                                            </select>
                                            <button type="button" class="remove-member btn btn-danger col-2 m-1" id="removemember">Remove</button>
                                        </div>

                                    </form>
                                    <button type="button" class="addmember-button btn btn-success" id="addmember">Add Member</button>

                                </div>

                            </div>

                            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                <!-- Form for tab 2 -->

                                <div class="container-fluid" id="objectiveform">
                                    <form id="form3">
                                        @csrf
                                        <label for="projectobjectives" class="form-label mt-2">List all objectives of the project</label>
                                        <div class="mb-2 row" id="#selectobjectives">
                                            <input type="text" class="col-7 m-1 input-objective" id="objective-input" name="projectobjective[]" placeholder="Enter objective">
                                            <button type="button" class="edit-objective btn btn-success col-2 m-1" id="editobjective">Edit</button>
                                            <button type="button" class="remove-objective btn btn-danger col-2 m-1" id="removeobjective">Remove</button>
                                        </div>

                                    </form>
                                    <button type="button" class="addobjective-button btn btn-success" id="addobjective">Add Objective</button>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="createproject">Create Project</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-responsive m-4">
            <table class="table table-bordered border-white table-dark table-hover">
                <thead>
                    <tr>
                        <th class="col-5">
                            <label class="ms-3">Activity</label>
                            <button type="button" class="btn btn-dark float-end " id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity">
                                Add Activity
                            </button>

                        </th>
                        <th class="col-2 ">Due Date</th>
                        <th class="col-2">Assignees</th>
                        <th class="col-3">Activity Info</th>
                    </tr>
                </thead>
                <tbody>


                    @foreach ($activities as $activity)
                    <tr>
                        <td value="{{ $activity->id }}">{{ $activity->actname }}
                            <button type="button" class="btn btn-success btn-sm float-end" id="addsubtask" data-bs-toggle="modal" data-bs-target="#new-subtask-modal">Add Subtask</button>
                            <ul class="list-unstyled m-2">
                                <li>Objectives: {{ $activity->actobjectives }}</li>
                                <li>Output: {{ $activity->actoutput }}</li>
                                <li>Start Date: {{ $activity->actstartdate }}</li>
                                <li>End Date: {{ $activity->actenddate }}</li>
                                <li>Budget: {{ $activity->actbudget }}</li>
                                <li>Source: {{ $activity->actsource }}</li>
                            </ul>
                        </td>
                        <td>{{ $activity->actenddate }}</td>
                        <td>555-555-1234</td>
                        <td>
                            <ul class="list-unstyled">
                                <li>Objectives: {{ $activity->actobjectives }}</li>
                                <li>Output: {{ $activity->actoutput }}</li>
                                <li>Start Date: {{ $activity->actstartdate }}</li>
                                <li>End Date: {{ $activity->actenddate }}</li>
                                <li>Budget: {{ $activity->actbudget }}</li>
                                <li>Source: {{ $activity->actsource }}</li>
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
                                            <option value="" disable selected>Choose Objective</option>
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

    <div class="modal fade" id="new-subtask-modal" tabindex="-1" aria-labelledby="new-subtask-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="new-subtask-modal-label">New Subtask</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="subtask-name" class="form-label">Subtask Name</label>
                            <input type="text" class="form-control" id="subtask-name" name="subtask-name">
                        </div>
                        <div class="mb-3">
                            <label for="assignee" class="form-label">Assignee</label>
                            <input type="text" class="form-control" id="assignee" name="assignee">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Subtask</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-1">

    </div>


</div>


<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script>
    var users = <?php echo json_encode($members); ?>;
    var objectives = <?php echo json_encode($objectives); ?>;
    var assignees = <?php echo json_encode($assignees); ?>;
    var selectElement = $('#project-select');
    var url = "";
    $(document).ready(function() {

        $.each(objectives, function(index, objective) {
            $('#objective-select').append($('<option>', {
                value: objective.name,
                text: objective.name
            }));
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