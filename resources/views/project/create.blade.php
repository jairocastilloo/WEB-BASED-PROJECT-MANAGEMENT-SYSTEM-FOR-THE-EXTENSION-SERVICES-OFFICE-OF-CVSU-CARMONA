@extends('layouts.app')

@section('content')

@php


@endphp
<input class="d-none" type="number" id="projecturl" data-url="{{ route('projects.display', ['projectid' => ':projectid', 'department' => ':department', 'projectname' => ':projectname']) }}">

<div class="maincontainer">
    &nbsp;
    <!--
    <div class="basiccont mt-2 m-4 p-3 rounded shadow">

        <div class="form-floating">
            

            <label for="project-select" style="color:darkgreen;"><strong>Display the Project for:</strong></label>
        </div>

        <div class="btn-group mt-3 shadow">
            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addproj">
                <b class="small">Start New Project</b>
            </button>
        </div>-->
    <!--
        <button type="button" class="btn btn-sm mt-3 shadow rounded border border-2 border-warning text-body" style="background-color: gold;" data-bs-toggle="modal" data-bs-target="#departmentModal">
            <b class="small">Start New Project</b>
        </button>
        <button type="button" class="btn btn-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#newproject" id="addproj">Add Project</button>
-->
    <!--
    </div>-->



    <div class="row">
        <div class="col-10">

            <div class="basiccont mt-2 m-4 me-0 rounded shadow">
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
                        <b class="small">Start New Project</b>
                    </button>
                </div>



                <!--
        <div class="btn-group mt-3 shadow">
            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addproj">
                <b class="small">Start New Project</b>
            </button>
        </div>
-->
                <!--
        <button type="button" class="btn btn-sm mt-3 shadow rounded border border-2 border-warning text-body" style="background-color: gold;" data-bs-toggle="modal" data-bs-target="#departmentModal">
            <b class="small">Start New Project</b>
        </button>
        <button type="button" class="btn btn-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#newproject" id="addproj">Add Project</button>
-->
            </div>

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
            <div class="basiccont word-wrap shadow mt-2 ms-4">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Projects</h6>
                </div>
                <div class="text-center p-4">
                    <h4><em>No Project Created Yet.</em></h4>
                </div>
            </div>
            @endif
            @if ($inProgressProjects && count($inProgressProjects) > 0)

            <div class="basiccont word-wrap shadow mt-2 ms-4">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">In Progress Projects</h6>
                </div>
                @foreach ($inProgressProjects as $project)
                <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                    <h5 class="fw-bold">{{ $project['projecttitle'] }}</h5>

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
            <div class="basiccont word-wrap shadow mt-2 ms-4">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Scheduled Projects</h6>
                </div>
                @foreach ($scheduledProjects as $project)
                <div class="border-bottom ps-4 p-2 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}">

                    <h5 class="fw-bold">{{ $project['projecttitle'] }}</h5>

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

        <div class="col-2">
            @if ($completedProjects && count($completedProjects) > 0)
            <div class="basiccont word-wrap shadow mt-2 me-4">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Completed Projects</h6>
                </div>
                @foreach ($completedProjects as $project)
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
            @if ($overdueProjects && count($overdueProjects) > 0)

            <div class="basiccont word-wrap shadow mt-2 me-4">
                <div class="border-bottom ps-3 pt-2 bggreen">
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
            @if($currentproject && count($overdueProjects) == 0 && count($overdueProjects) == 0)
            <div class="basiccont word-wrap shadow mt-2 me-4">
                <div class="border-bottom ps-3 pt-2 bggreen pe-2">
                    <h6 class="fw-bold small" style="color:darkgreen;">Projects</h6>
                </div>
                <div class="text-center p-4">
                    <h4><em>No Projects Ended Yet.</em></h4>
                </div>
            </div>
            @endif

        </div>

    </div>

</div>

<!--
<div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departmentModalLabel">New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-floating">
                        <select class="form-select" id="departmentSelect" name="department" aria-label="Select department" style="border: 1px solid darkgreen;">

                            <option value="Department of Industrial and Information Technology">Department of Industrial and Information Technology</option>
                            <option value="Department of Teacher Education">Department of Teacher Education</option>
                            <option value="Department of Management">Department of Management</option>
                            <option value="Departments of Arts and Science">Departments of Arts and Science</option>
                        </select>

                        <label for="project-select" style="color:darkgreen;"><strong>Create New Project for:</strong></label>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmnewproject">Create New Project</button>
            </div>
        </div>
    </div>
</div>
-->
<!--
        <button type="button" class="btn btn-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#newproject" id="addproj">Add Project</button>
         -->


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

@endsection
@section('scripts')

<script>
    var users = <?php echo json_encode($members);
                ?>;

    var selectElement = $('#year-select');
    var url = "";

    $(document).ready(function() {


        selectElement.change(function() {
            var selectedOption = $(this).find(':selected');
            var currentyear = selectedOption.val();

            var department = $('#department').val();

            var baseUrl = "{{ route('yearproject.show', ['department' => ':department', 'currentyear' => ':currentyear']) }}";
            var url = baseUrl.replace(':department', department)
                .replace(':currentyear', currentyear);

            window.location.href = url;
        });

        /** selecting which department first (exclusive for admin)
                $('#confirmnewproject').click(function(event) {
                    event.preventDefault();
                    var selectedOption = $('#departmentSelect').find(':selected');
                    var department = selectedOption.val();

                    var url = '{{ route("projects.new", ["department" => ":department"]) }}';
                    url = url.replace(':department', department);
                    window.location.href = url;


                });

                */

        $(document).on('click', '.projectdiv', function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');
            var projectname = $(this).attr('data-name');
            var department = $('#department').val();


            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department", "projectname" => ":projectname"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));
            url = url.replace(':projectname', encodeURIComponent(projectname));
            window.location.href = url;
        });
    });
    // Add an event listener to the select element
</script>
<script src="{{ asset('js/create.js') }}"></script>
@endsection