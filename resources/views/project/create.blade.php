@extends('layouts.app')

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
                        <option value="{{ $project->id }}">
                            {{ $project->projecttitle }}
                        </option>
                        @endforeach

                    </select>

                </div>
            </div>
            <div class="col-8"></div>
        </section>


        <!-- New Project -->
        <button type="button" class="btn btn-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#newproject" id="addproj">Add Project</button>
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
                                            <select class="col-7 m-1 member-select" id="member-select" name="projectmember[]">
                                                <option value="" selected disabled>Select a Member</option>
                                            </select>
                                            <button type="button" class="remove-member btn btn-danger col-2 m-1 float-end" id="removemember">Remove</button>
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
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-secondary" id="prevproject">Previous</button>
                        <button type="button" class="btn btn-info" id="nextproject">Next</button>
                        <button type="button" class="btn btn-primary" id="createproject">Create Project</button>

                    </div>
                </div>
            </div>
        </div>



        <div class="table-responsive m-4">
            <table class="table table-bordered table-dark table-hover rounded">
                <thead>
                    <tr>
                        <th class="col-5">
                            <label class="mt-2 ms-2">
                                <h4><b>Activities</b></h4>
                            </label>


                        </th>
                        <th class="col-2"><label class="mt-2">
                                <h4><b>Due Date</b></h4>
                            </label></th>
                        <th class="col-2"><label class="mt-2">
                                <h4><b>Assignees</b></h4>
                            </label></th>
                        <th class="col-3"><label class="mt-2">
                                <h4><b>Activity Info</b></h4>
                            </label></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>


    </div>
    <div class="col-1"></div>
</div>



@endsection
@section('scripts')

<script>
    var users = <?php echo json_encode($members);
                ?>;

    var selectElement = $('#project-select');

    // Add an event listener to the select element
    selectElement.change(function() {
        // Get the currently selected option

        var selectedOption = $(this).find(':selected');
        var projectid = selectedOption.val();

        var url = '{{ route("get.objectives", ["id" => Auth::user()->id, "projectid" => ":projectid"]) }}';
        url = url.replace(':projectid', projectid);
        window.location.href = url;



    });
</script>
<script src="{{ asset('js/create.js') }}"></script>
@endsection