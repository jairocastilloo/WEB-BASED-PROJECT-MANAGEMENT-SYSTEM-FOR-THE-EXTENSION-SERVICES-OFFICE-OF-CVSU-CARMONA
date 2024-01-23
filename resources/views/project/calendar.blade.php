@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
    @php
    $userRole = Auth::user()->role;
    @endphp
    <div class="container p-0">
        <div class="mainnav border-1 border-bottom shadow-sm px-2 small">
            <nav class="navbar navbar-expand-sm p-0">
                <button class="navbar-toggler btn btn-sm m-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMonitoring" aria-controls="navbarMonitoring" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMonitoring">
                    <ul class="navbar-nav me-auto">
                        <a class="nav-link border border-1 p-2 px-4 divhover fw-bold small" href="{{ route('project.show', ['department' => Auth::user()->department]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Projects
                        </a>
                        <a class="nav-link border border-1 p-2 px-4 divhover fw-bold small" href="{{ route('programs.select', [ 'department' => Auth::user()->department ]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Programs
                        </a>



                    </ul>
                </div>
            </nav>
        </div>

    </div>

    <div class="mainnav border-bottom mb-3 shadow-sm">
        @if($program != [])
        <div class="step-wrapper">
            <div class="step divhover programDiv" data-value="{{ $program['id'] }}" data-dept="{{ $program['department'] }}">
                <span class="fw-bold">Program: {{ $program['programName'] }}</span>
                <div class="message-box text-white">
                    {{ $program['programName'] }}
                </div>
            </div>
        </div>
        @endif
        <div class="step-wrapper">
            <div class="step highlight">
                <span class="fw-bold">Project: {{ $indexproject['projecttitle'] }}</span>
                <div class="message-box">
                    {{ $indexproject['projecttitle'] }}
                </div>
            </div>


        </div>

    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-10">

                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Projects</h6>
                    </div>

                    <div class="form-floating m-3 mb-2 mt-2">

                        <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen;" aria-label="Select a department">

                            @foreach ($alldepartments as $alldepartment)
                            <option class="p-2" value="{{ $alldepartment}}" {{ $alldepartment == $department ? 'selected' : '' }}>
                                &nbsp;&nbsp;&nbsp;{{ $alldepartment }}
                            </option>
                            @endforeach

                        </select>
                        <label for="year-select" style="color:darkgreen;">
                            <h6><strong>Choose Department:</strong></h6>
                        </label>
                    </div>
                    @if (Auth::user()->role === 'Admin')
                    <div class="btn-group mt-1 ms-3 mb-2 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addproj">
                            <b class="small">Create Project</b>
                        </button>
                    </div>
                    @endif
                </div>

                <div class="basiccont p-3 rounded shadow">
                    <div class="flexmid"><strong>WORK AND FINANCIAL PLAN</strong></div>
                    @livewire('project-details', [ 'indexproject' => $indexproject, 'members' => $members ])

                    <div class="btn-group dropdown mt-3 shadow">
                        <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <b class="small"> <i class="bi bi-list"></i> Menu</b>
                        </button>
                        <div class="dropdown-menu border-warning">
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.display', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                                <b class="small">Table</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.activities', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                                <b class="small">Activities</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.members', ['projectid' => $indexproject->id, 'department' => $department ]) }}">
                                <b class="small">Staff and Leaders</b>
                            </a>
                            <a class="dropdown-item small bg-warning border-bottom">
                                <b class="small">Calendar</b>
                            </a>
                            @If(Auth::user()->role == "Admin")
                            <a class="dropdown-item small hrefnav border-bottom" id="editIndexproject">
                                <b class="small">Edit Details</b>
                            </a>
                            @endif
                            @If(Auth::user()->role == "Admin" || Auth::user()->role == "Coordinator")
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.close',['projectid' => $indexproject->id, 'department' => $department ]) }}">
                                <b class="small">Close Project</b>
                            </a>
                            @endif
                            @If(Auth::user()->role == "Admin")
                            <a class="dropdown-item small hrefnavDelete border-bottom" data-bs-toggle="modal" data-bs-target="#deleteProjectModal">
                                <b class="small">Delete Project</b>
                            </a>
                            @endif


                            <!-- if included
                        <a class="dropdown-item small hrefnav" href="{{ route('projects.objectives', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
                            <b class="small">Edit Objectives</b>
                        </a> -->
                            <!-- <a class="dropdown-item small hrefnav" href="#" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity"><b class="small">Add Activity</b></a> -->



                        </div>
                    </div>
                    <!--
                <button type="button" class="btn btn-sm add-assignees-btn mt-2 shadow rounded border border-2 border-warning" style="background-color: gold;" id="addactivity" data-bs-toggle="modal" data-bs-target="#newactivity">
                    <b class="small">Add Activity</b>
                </button>
-->

                </div>
                <div class="basiccont rounded shadow">

                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Calendar</h6>
                    </div>

                    <div class="p-2" id="calendar"></div>


                </div>

            </div>

            <div class="col-lg-2">
                <label class="ms-3 small form-label text-secondary fw-bold">Other Projects</label>
                @livewire('more-projects', ['department' => $department, 'projectid' => $indexproject->id, 'x' => 1])
                @livewire('not-started-projects', ['department' => $department, 'projectid' => $indexproject->id, 'y' =>
                1])
                @livewire('past-projects', ['department' => $department, 'projectid' => $indexproject->id, 'z' => 0])

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
                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true" disabled>Project
                            Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false" disabled>Project Objectives</button>
                    </li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <!-- Form for tab 1 -->
                        <form id="form1" data-url="{{ route('project.store') }}">
                            @csrf
                            <input type="text" class="d-none" name="department" id="department" value="{{ $department }}">
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
                                <select class="selectpicker w-100 border projectleader" name="projectleader[]" id="projectleader" multiple aria-label="Select Project Leaders" data-live-search="true">
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
                                <label for="programtitle" class="form-label">Program Title <span class="text-secondary">( if applicable )</span></label>
                                <select class="selectpicker w-100 border" name="programtitle" id="programtitle" aria-label="Enter Program Title" data-live-search="true">

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
                                <select class="selectpicker w-100 border programleader" name="programleader[]" id="programleader" multiple aria-label="Select Program Leaders" data-live-search="true">

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
                                    <input type="text" class="form-control" id="projectstartdate" name="projectstartdate" placeholder="mm/dd/yyyy" />
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
                                    <input type="text" class="form-control" id="projectenddate" name="projectenddate" placeholder="mm/dd/yyyy" />
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

                                            <textarea class="form-control" aria-label="With textarea" name="objectiveName[]" placeholder="Write objective here.."></textarea>

                                            <input type="number" name="objectiveSetNumber[]" class="objectiveSetNumber d-none" value="0">
                                            <button type="button" class="btn btn-sm btn-outline-danger removeObjectiveName-btn"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    </div>
                                    <button type="button" class="addObjective-btn btn btn-sm btn-green">
                                        <b class="small">Add Objective</b>
                                    </button>
                                    <button type="button" class="removeObjectiveSet-btn btn btn-sm btn-red px-5 d-block mx-auto">
                                        <b class="small">Remove Objective Set</b>
                                    </button>


                                </div>
                            </form>
                            <button type="button" class="btn btn-md btn-green w-100" id="addObjectiveSet-btn">
                                <b class="small">Add Objective Set</b>
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
                <button type="button" class="btn btn-md rounded border border-1 btn-light shadow" data-bs-dismiss="modal"><b class="small">Close</b></button>
                <button type="button" class="btn btn-md rounded btn-gold shadow" id="prevproject">
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
<div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProjectModalLabel">Delete Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this project?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="deleteProjectForm" method="get" action="{{ route('projects.delete', $indexproject['id']) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete Project</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="mailNotSent" tabindex="-1" aria-labelledby="mailNotSentLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
<script src="{{ asset('js/fullcalendar.global.min.js') }}"></script>
<script src="{{ asset('js/fullcalendarbootstrap5.global.min.js') }}"></script>
<script>
    var selectElement = $('#year-select');
    var url = "";
    var projecturl = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';
    var baseUrl = "{{ route('project.show', ['department' => ':department']) }}";
    var programLeaders = <?php echo json_encode($programLeaders); ?>;
    $(document).ready(function() {



        $('.programDiv').click(function() {
            var department = $(this).attr('data-dept');
            var programId = $(this).attr('data-value');
            var url =
                '{{ route("programs.display", ["programid" => ":programid", "department" => ":department" ]) }}';
            url = url.replace(':department', encodeURIComponent(department));
            url = url.replace(':programid', programId);
            window.location.href = url;
        });

        $('#startDatePicker').datepicker();

        $('#startDatePicker').datepicker().on('change', function(e) {
            $('#startDatePicker').datepicker('hide');
        });
        $('#endDatePicker').datepicker();

        $('#endDatePicker').datepicker().on('change', function(e) {
            $('#endDatePicker').datepicker('hide');
        });


        $('#currentstartDatePicker').datepicker();

        $('#currentstartDatePicker').datepicker().on('change', function(e) {
            $('#currentstartDatePicker').datepicker('hide');
        });
        $('#currentendDatePicker').datepicker();

        $('#currentendDatePicker').datepicker().on('change', function(e) {
            $('#currentendDatePicker').datepicker('hide');
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

        $('.step span').each(function() {
            var $span = $(this);
            if ($span.text().length > 15) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 15) + '...'); // Truncate and add ellipsis
            }
        });

        $('#editIndexproject').click(function() {
            $('#editProjectModal').modal('show');
        });
        try {
            var activities = <?php echo json_encode($activityArray); ?>;
            if (!Array.isArray(activities)) {
                throw new Error('Invalid activities data');
            }

            var eventsArray = activities.map(function(activity) {
                return {
                    id: activity.id,
                    title: activity.actname,
                    start: activity.actstartdate,
                    end: activity.actenddate
                };
            });

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',
                /*
                                dateClick: function(info) {
                                    alert('Clicked on: ' + info.dateStr);
                                },
                */
                eventClick: function(info) {
                    var url = '{{ route("activities.display", ["activityid" => ":activityid"]) }}';
                    url = url.replace(':activityid', info.event.id);
                    window.location.href = url;
                },

                eventContent: function(arg) {
                    return {
                        html: '<div class="event-content fcnavhover" style="color: white;">' + arg.event.title + '</div>'
                    };
                },

                events: eventsArray
            });

            calendar.render();
        } catch (error) {
            console.error(error);
        }

        $(document).on('input', '.autocapital', function() {
            var inputValue = $(this).val();
            if (inputValue.length > 0) {
                $(this).val(inputValue.charAt(0).toUpperCase() + inputValue.slice(1));
            }
        });



        $(document).on('click', '.projectdiv', function(event) {
            event.preventDefault();
            var department = $(this).attr('data-dept');
            var projectid = $(this).attr('data-value');


            var url =
                '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));

            window.location.href = url;
        });




    });
</script>
<script src="{{ asset('js/project-create.js') }}"></script>
@endsection
