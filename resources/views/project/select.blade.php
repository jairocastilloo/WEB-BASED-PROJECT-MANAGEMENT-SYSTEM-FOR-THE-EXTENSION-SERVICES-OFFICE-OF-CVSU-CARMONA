@extends('layouts.app')

@section('content')
<div id="#projectdropdown">
    <select id="project-select" class="form-select form-select-lg m-3">
        <option value="" selected disabled>Select a Project</option>

        @foreach($projects as $project)
        <option value="{{ $project->id }}" {{ $project->id == $projectid ? 'selected' : '' }}>
            {{ $project->projecttitle }}
        </option>
        @endforeach

    </select>

</div>
<!-- Add activity -->
<button type="button" class="btn btn-primary" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity">Add Activity</button>
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
                        <form>
                            <div class="mb-3">
                                <label for="activityname" class="form-label">Activity Name</label>
                                <input type="text" class="form-control" id="activityname">
                            </div>
                            <div class="mb-3">
                                <label for="objectives" class="form-label">Objectives</label>
                                <select class="form-select" id="objective-select" name="objectives">
                                    <option value="" disable selected>Choose Objective</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="expectedoutput" class="form-label">Expected Output</label>
                                <input type="text" class="form-control" id="expectedoutput">
                            </div>
                            <div class="mb-3">
                                <label for="startdate" class="form-label">Activity Start Date</label>
                                <input type="text" class="form-control" id="activitystartdate">
                            </div>
                            <div class="mb-3">
                                <label for="enddate" class="form-label">Activity End Date</label>
                                <input type="text" class="form-control" id="activityenddate">
                            </div>
                            <div class="mb-3">
                                <label for="budget" class="form-label">Budget</label>
                                <input type="number" class="form-control" id="budget">
                            </div>
                            <div class="mb-3">
                                <label for="Source" class="form-label">Source</label>
                                <input type="text" class="form-control" id="Source">
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="assignees" role="tabpanel" aria-labelledby="assignees-tab">
                        <div class="container-fluid" id="assigneesform">
                            <form>
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
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- New Project -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newproject">Add Project</button>
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
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script>
    var users = <?php echo json_encode($members); ?>;
    var objectives = <?php echo json_encode($objectives); ?>;
    var assignees = <?php echo json_encode($assignees); ?>;
    var selectElement = $('#project-select');
    $(document).ready(function() {

        $.each(objectives, function(index, objective) {
            $('#objective-select').append($('<option>', {
                value: objective.id,
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

            var url = '{{ route("get.objectives", ["id" => Auth::user()->id, "projectid" => ":projectid"]) }}';
            url = url.replace(':projectid', projectid);
            window.location.href = url;



        });


    });
</script>
<script src="{{ asset('js/create.js') }}"></script>
<script src="{{ asset('js/select.js') }}"></script>
@endsection