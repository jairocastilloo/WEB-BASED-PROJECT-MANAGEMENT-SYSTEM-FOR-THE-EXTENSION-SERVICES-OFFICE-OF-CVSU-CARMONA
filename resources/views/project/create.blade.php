@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-top-0">
    @php
    $userRole = Auth::user()->role;
    @endphp
    <div class="container p-0">
        <div class="mainnav border-1 border-bottom shadow-sm px-2 small">
            <nav class="navbar navbar-expand-sm p-0">
                <button class="navbar-toggler btn btn-sm m-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarMonitoring" aria-controls="navbarMonitoring" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMonitoring">
                    <ul class="navbar-nav me-auto">


                        <a class="nav-link border border-1 p-2 px-4 divhover fw-bold small"
                        href="{{ route('programs.select', [ 'department' => Auth::user()->department ]) }}"
                        role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                        Programs
                    </a>
                        <a class="nav-link border border-1 p-2 px-4 currentdiv fw-bold small">
                            Projects
                        </a>



                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="container pt-3">
        <div class="row">
            <div class="col-lg-10">

                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Projects</h6>
                    </div>

                    <div class="form-floating m-3 mb-2 mt-2">

                        <select id="year-select" class="form-select fw-bold"
                            style="border: 1px solid darkgreen; color:darkgreen;" aria-label="Select a Department">

                            @foreach ($alldepartments as $alldepartment)
                            <option class="p-2" value="{{ $alldepartment }}"
                                {{ $alldepartment == $department ? 'selected' : '' }}>
                                {{ $alldepartment }}
                            </option>
                            @endforeach

                        </select>
                        <label for="year-select" style="color:darkgreen;">
                            <h6><strong>Department Projects for:</strong></h6>
                        </label>
                    </div>
                    @if ($userRole == 'Admin')
                    <div class="btn-group mt-1 ms-3 mb-2 shadow">
                        <button type="button" class="btn btn-sm rounded btn-gold shadow" id="addproj">
                            <b class="small">Create New Project</b>
                        </button>
                    </div>
                    @endif
                </div>
                @livewire('more-projects', ['department' => $department, 'projectid' => null, 'x' => 1])


            </div>

            <div class="col-lg-2">

                @livewire('not-started-projects', ['department' => $department, 'projectid' => null, 'y' => 1])

                @livewire('past-projects', ['department' => $department, 'projectid' => null, 'z' => 0])
                @livewire('completed-projects', ['department' => $department, 'projectid' => null, 'xCompletedProjects'
                => 0])
            </div>

        </div>
    </div>
</div>

<!-- New Project -->
@if ($userRole == 'Admin')
<div class="modal fade" id="newproject" tabindex="-1" aria-labelledby="newprojectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button"
                            role="tab" aria-controls="tab2" aria-selected="false" disabled>Project Objectives</button>
                    </li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <!-- Form for tab 1 -->
                        <form id="form1" data-url="{{ route('project.store') }}">
                            @csrf
                            <input type="text" class="d-none" name="department" id="department"
                                value="{{ $department }}">
                            <input type="number" class="d-none" id="memberindex" name="memberindex">
                            <input type="number" class="d-none" id="objectiveindex" name="objectiveindex">
                            <label for="projectdetails" class="form-label mt-2">Input all the details of the
                                project</label>



                            <div class="mb-3">
                                <label for="projecttitle" class="form-label">Project Title</label>
                                <input type="text" class="form-control autocapital" id="projecttitle" name="projecttitle">

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="container mb-3 p-0">
                                <label for="projectleader" class="form-label">Project Leader</label>
                                <select class="selectpicker w-100 border projectleader" name="projectleader[]"
                                    id="projectleader" multiple aria-label="Select Project Leaders"
                                    data-live-search="true">
                                    <option value="0" disabled>Select Project Leader</option>
                                    @foreach ($members as $member)
                                    @if ($member->role === 'Coordinator' || $member->role === 'Admin')
                                    <option value="{{ $member->id }}">
                                        {{ $member->last_name . ', ' . $member->name . ' ' . ($member->middle_name ? $member->middle_name[0] : 'N/A') . '.' }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>


                            <div class="container mb-3 p-0">
                                <label for="programtitle" class="form-label">Program Title <span
                                        class="text-secondary">( if applicable )</span></label>
                                <select class="selectpicker w-100 border" name="programtitle" id="programtitle"
                                    aria-label="Enter Program Title" data-live-search="true">

                                    <option value="0" selected>Not Assigned to Any Program</option>
                                    @foreach ($allPrograms as $program)

                                    <option value="{{ $program->id }}">
                                        {{ $program->programName }}
                                    </option>

                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>

                            <!--<div class="container mb-3 p-0 programleaderdiv" style="display:none;">-->
                            <div class="container mb-3 p-0">
                                <label for="programleader" class="form-label">Program Leader</label>
                                <select class="selectpicker w-100 border programleader" name="programleader[]"
                                    id="programleader" multiple aria-label="Select Program Leaders"
                                    data-live-search="true">

                                    @foreach ($members as $member)
                                    @if ($member->role === 'Admin')
                                    <option value="{{ $member->id }}" disabled>
                                        {{ $member->last_name . ', ' . $member->name . ' ' . ($member->middle_name ? $member->middle_name[0] : 'N/A') . '.' }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="projectstartdate" class="form-label">Project Start Date</label>

                                <div class="input-group date" id="startDatePicker">
                                    <input type="text" class="form-control" id="projectstartdate"
                                        name="projectstartdate" placeholder="mm/dd/yyyy" />
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="bi bi-calendar-event-fill"></i>
                                        </span>
                                    </span>
                                </div>



                                <!--<input type="date" class="form-control" id="projectstartdate" name="projectstartdate">-->


                            </div>

                            <div class="mb-3">
                                <label for="projectenddate" class="form-label">Project End Date</label>

                                <div class="input-group date" id="endDatePicker">
                                    <input type="text" class="form-control" id="projectenddate" name="projectenddate"
                                        placeholder="mm/dd/yyyy" />
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="bi bi-calendar-event-fill"></i>
                                        </span>
                                    </span>
                                </div>

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>

                                <!--<input type="date" class="form-control" id="projectenddate" name="projectenddate">-->


                            </div>
                        </form>


                    </div>


                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <!-- Form for tab 2 -->

                        <div class="container-fluid" id="objform">
                            <form id="form2">
                                @csrf

                                <label for="projectobjectives" class="form-label mt-2">List all objectives of the
                                    project</label>
                                <div class="container-fluid objectiveSetContainer mb-2 p-2" data-value="0">
                                    <div>
                                        <div class="input-group mb-2 objectiveName-input">

                                            <textarea class="form-control" aria-label="With textarea"
                                                name="objectiveName[]" placeholder="Write objective here.."></textarea>

                                            <input type="number" name="objectiveSetNumber[]"
                                                class="objectiveSetNumber d-none" value="0">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger removeObjectiveName-btn"><i
                                                    class="bi bi-x-lg"></i></button>
                                        </div>
                                    </div>
                                    <button type="button" class="addObjective-btn btn btn-sm btn-green"><b
                                            class="small">Add Objective</b>
                                    </button>
                                    <button type="button"
                                        class="removeObjectiveSet-btn btn btn-sm btn-red px-5 d-block mx-auto"><b
                                            class="small">Remove Objective Set</b>
                                    </button>


                                </div>
                            </form>
                            <button type="button" class="btn btn-md btn-green w-100" id="addObjectiveSet-btn"><b
                                    class="small">Add Objective Set</b>
                            </button>
                            <span class="text-danger small fw-bold" id="objectiveInput-error">Please ensure that there
                                is objective in every input.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="text-danger" id="createprojectError">
                    <strong></strong>
                </span>
                <span class="ms-2 small loadingMessage" id="loadingSpan" style="display: none;">Sending Email..</span>
                <button type="button" class="btn btn-md rounded border border-1 btn-light shadow"
                    data-bs-dismiss="modal"><b class="small">Close</b></button>
                <button type="button" class="btn btn-md rounded btn-gold shadow" id="prevproject"><b
                        class="small">Previous</b>
                </button>
                <button type="button" class="btn btn-md rounded btn-gold shadow" id="nextproject"><b
                        class="small">Next</b></button>
                <button type="button" class="btn btn-md rounded btn-gold shadow" id="createproject"><b
                        class="small">Create Project</b>
                </button>

            </div>
        </div>
    </div>
</div>
@endif
<div class="modal" id="mailNotSent" tabindex="-1" aria-labelledby="mailNotSentLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal content goes here -->
                <h4>Project Created, but Email Not Sent Due to Internet Issue!</h4>
                <p>Redirecting in <span id="countdown">5</span> seconds...</p>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
var projecturl = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';
var baseUrl = "{{ route('project.show', ['department' => ':department']) }}";
var programLeaders = <?php echo json_encode($programLeaders); ?>;

$(document).ready(function() {
    // select program when there's a selection
    $('#startDatePicker').datepicker();

    $('#startDatePicker').datepicker().on('change', function(e) {
        $('#startDatePicker').datepicker('hide');
    });
    $('#endDatePicker').datepicker();

    $('#endDatePicker').datepicker().on('change', function(e) {
        $('#endDatePicker').datepicker('hide');
    });

    $('#programtitle').change(function() {
        var selectedOptionValue = $(this).find('option:selected').val();

        var userIDs = programLeaders
            .filter(function(leader) {
                return leader.program_id == selectedOptionValue;
            })
            .map(function(leader) {
                return leader.user_id.toString(); // Convert to string if needed
            });

        // Now you have an array of user_ids for the selected program_id

        // Select all options in #programleader with values in userIDs
        $('#programleader').val(userIDs);
        $('#programleader').selectpicker('refresh');
    });
});
</script>
<script src="{{ asset('js/project-create.js') }}"></script>

@endsection
