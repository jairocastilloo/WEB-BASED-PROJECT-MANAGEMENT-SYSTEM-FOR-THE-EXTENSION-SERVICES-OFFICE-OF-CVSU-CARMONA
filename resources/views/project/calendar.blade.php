@extends('layouts.app')

@section('content')

<div class="maincontainer shadow">
    <div class="mainnav mb-3 shadow">
        <div class="col-4 p-2 pt-3 border-end position-triangle text-wrap" data-value="{{ $indexproject['projecttitle'] }}">
            <h6 class="fw-bold">Projects</h6>
        </div>
        <div class="dropdown col-4 border-end text-wrap containerhover">
            <div class="p-2 pt-3" data-bs-toggle="dropdown">
                <h6 class="fw-bold">Activities

                    <i class="bi bi-caret-down-fill text-end"></i>
                </h6>
            </div>
            <ul class="dropdown-menu">
                @php
                // Sort the $activities array by actstartdate in ascending order
                $sortedActivities = $activities->sortBy('actstartdate');
                @endphp
                @foreach ($sortedActivities as $activity)
                <li><a class="dropdown-item" href="{{ route('activities.display', ['activityid' => $activity['id'], 'department' => Auth::user()->department, 'activityname' => $activity['actname']]) }}">{{ $activity['actname'] }}</a></li>
                @endforeach


            </ul>
        </div>

        <div class="col-4 p-2 pt-3 border-end text-wrap text-center" data-value="{{ $indexproject['projecttitle'] }}">
            <h6 class="fw-bold">Subtasks</h6>
        </div>

    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-10">

                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Projects</h6>
                    </div>
                    @if (!$inCurrentYear)
                    <span class="small ms-2"><em>
                            Note: Not the Current Year.
                        </em></span>
                    @endif
                    <div class="form-floating m-3 mb-2 mt-2">

                        <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen; font-size: 19px;" aria-label="Select an calendar year">

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

                <div class="basiccont p-3 rounded shadow">
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
                            <b class="small"> <i class="bi bi-list"></i> Menu</b>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.display', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
                                <b class="small">Table</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.members', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
                                <b class="small">Team Members</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.activities', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
                                <b class="small">Activities</b>
                            </a>
                            <a class="dropdown-item small bg-warning border-bottom">
                                <b class="small">Calendar</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('projects.details', ['projectid' => $indexproject->id, 'department' => Auth::user()->department ]) }}">
                                <b class="small">Edit Details</b>
                            </a>
                            <a class="dropdown-item small hrefnav border-bottom" href="#"><b class="small">Close Project</b></a>
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
                <label class="ms-3 small form-label text-secondary fw-bold">Other Projects</label>
                @if($currentproject->isEmpty())
                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color:darkgreen;">
                            Projects
                            <span class="badge bggold text-dark">
                                {{ count($currentproject) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>

                    </div>
                    <div class="toggle-container subtoggle" style="display: none;">
                        <div class="text-center p-4">
                            <h4><em>No Other Projects Yet.</em></h4>
                        </div>
                    </div>
                </div>
                @endif
                @if ($inProgressProjects && count($inProgressProjects) > 0)

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color:darkgreen;">
                            In Progress
                            <span class="badge bggold text-dark">
                                {{ count($inProgressProjects) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>

                    </div>
                    <div class="toggle-container subtoggle" style="display: none;">
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
                </div>
                @endif

                @if ($scheduledProjects && count($scheduledProjects) > 0)
                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color:darkgreen;">
                            Scheduled
                            <span class="badge bggold text-dark">
                                {{ count($scheduledProjects) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>

                        </h6>

                    </div>
                    <div class="toggle-container subtoggle" style="display: none;">
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
                </div>
                @endif

                @if ($completedProjects && count($completedProjects) > 0)
                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color:darkgreen;">
                            Completed
                            <span class="badge bggold text-dark">
                                {{ count($completedProjects) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>

                    </div>
                    <div class="toggle-container subtoggle" style="display: none;">
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
                </div>
                @endif
                @if ($overdueProjects && count($overdueProjects) > 0)

                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen pe-2 containerhover" id="toggleButton">
                        <h6 class="fw-bold small" style="color:darkgreen;">
                            Incomplete
                            <span class="badge bggold text-dark">
                                {{ count($overdueProjects) }}
                            </span>
                            <i class="bi bi-caret-down-fill text-end"></i>
                        </h6>

                    </div>
                    <div class="toggle-container subtoggle" style="display: none;">
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
                </div>
                @endif

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
                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true" disabled>Project Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false" disabled>Project Objectives</button>
                    </li>.

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
                                    @foreach ($members as $member)
                                    @if ($member->role === 'Coordinator' || $member->role === 'Admin')
                                    <option value="{{ $member->id }}">{{ $member->name . ' ' . $member->last_name }}</option>
                                    @endif
                                    @endforeach
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
                                    @foreach ($members as $member)
                                    @if ($member->role === 'Coordinator' || $member->role === 'Admin')
                                    <option value="{{ $member->id }}">{{ $member->name . ' ' . $member->last_name }}</option>
                                    @endif
                                    @endforeach
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

                        <div class="container-fluid" id="objform">
                            <form id="form2">
                                @csrf
                                <label for="projectobjectives" class="form-label mt-2">List all objectives of the project</label>
                                <div class="container-fluid" id="objectiveset">
                                    <div>
                                        <div class="mb-2 row" id="selectobjectives">
                                            <input type="text" class="col-8 m-1 input-objective autocapital p-2 rounded" id="objective-input" name="projectobjective[]" placeholder="Enter objective">
                                            <input type="number" name="objectivesetid[]" value="0" class="objectivesetid d-none">
                                            <button type="button" class="remove-objective btn btn-sm btn-outline-danger col-3 m-1" id="removeobjective"><b class="small">Remove</b></button>


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


@endsection

@section('scripts')
<script src="{{ asset('js/fullcalendar.global.min.js') }}"></script>
<script src="{{ asset('js/fullcalendarbootstrap5.global.min.js') }}" defer></script>
<script>
    var selectElement = $('#year-select');
    var url = "";

    $(document).ready(function() {



        var currentstep = 0;
        var setcount = 0;

        $('#addmember').hide();

        $('.noselectmember-error strong').hide();
        $('.projectobjective-error strong').hide();

        $('#navbarDropdown').click(function() {
            // Add your function here
            $('#account .dropdown-menu').toggleClass('shows');
        });

        try {
            var activities = <?php echo json_encode($activityArray); ?>;
            if (!Array.isArray(activities)) {
                throw new Error('Invalid activities data');
            }

            var eventsArray = activities.map(function(activity) {
                return {
                    title: activity.actname,
                    start: activity.actstartdate,
                    end: activity.actenddate
                };
            });

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',

                dateClick: function(info) {
                    alert('Clicked on: ' + info.dateStr);
                },

                eventClick: function(info) {
                    alert(info.event.title);
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


        $(".subtoggle").toggle();
        $(document).on('click', '#toggleButton', function(event) {
            $(this).next().slideToggle("fast");
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

        function updateButtons() {
            if (currentstep == 0) {
                $('#prevproject').hide();
                $('#nextproject').show();
                $('#createproject').hide();
                $('#tab1-tab').tab('show');
            } else if (currentstep == 1) {
                $('#prevproject').show();
                $('#nextproject').hide();
                $('#createproject').show();
                $('#tab2-tab').tab('show');
            }

        }

        $('#nextproject').click((event) => {

            event.preventDefault();


            var hasError = handleError();

            if (!hasError) {
                currentstep++;
                updateButtons();
            }


        });
        $('#prevproject').click((event) => {

            event.preventDefault();


            currentstep--;
            updateButtons();


        });

        $('#addproj').click((event) => {

            event.preventDefault();

            updateButtons();
            $('#newproject').modal('show');
        });

        $('#objectiveset').on('click', '.add-objective', function() {
            var setid = $(this).prev().find('div:first .objectivesetid').val();

            var $newInput = $('<input type="text" class="col-8 m-1 input-objective autocapital p-2 rounded" id="objective-input" name="projectobjective[]" placeholder="Enter objective">');
            var $newInput1 = $('<input type="number" id="objectivesetid" name="objectivesetid[]" value="' + setid + '" class="objectivesetid d-none">');

            var $newButton2 = $('<button type="button" class="remove-objective btn btn-sm btn-outline-danger col-3 m-1" id="removeobjective"><b class="small">Remove</b></button>');
            var $newDiv = $('<div class="mb-2 row" id="selectobjectives">').append($newInput, $newInput1, $newButton2);
            $(this).prev().append($newDiv);

        });
        $('#objform form').on('click', '.remove-objective', function() {
            $(this).parent().remove();
        });
        $('#objform form').on('click', '.edit-objective', function() {
            $(this).prev().focus();
        });
        $('#objform form').on('keydown', '.input-objective', function() {
            if (event.keyCode === 13) {
                event.preventDefault();

                $(this).blur();

            }
        });



        $('#addset').click((event) => {
            event.preventDefault();
            setcount++;
            var $newInput = $('<input type="text" class="col-8 m-1 input-objective p-2 rounded autocapital" id="objective-input" name="projectobjective[]" placeholder="Enter objective">');
            var $newInput1 = $('<input type="number" id="objectivesetid" name="objectivesetid[]" value="' + setcount + '" class="objectivesetid d-none">');
            var $newButton2 = $('<button type="button" class="remove-objective btn btn-sm btn-outline-danger col-3 m-1" id="removeobjective"><b class="small">Remove</b></button>');
            var $newDiv = $('<div class="mb-2 row" id="selectobjectives">').append($newInput, $newInput1, $newButton2);
            var $newDiv1 = $('<div>').append($newDiv);
            var $newButton3 = $('<button type="button" class="add-objective btn btn-sm btn-outline-success" id="addobjective"><b class="small">Add Objective</b></button><hr>');
            $('#objectiveset').append($newDiv1, $newButton3);

        });

        $('#createproject').click((event) => {
            event.preventDefault();

            var hasError = handleError();

            if (!hasError) {
                var department = $('#department').val();
                var projectname = $('#projecttitle').val();

                var projecturl = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';

                projecturl = projecturl.replace(':department', department);
                projecturl = projecturl.replace(':projectname', projectname);

                var objectiveindex = $('input[name="projectobjective[]"]').length;

                $('input[name="projectobjective[]"]').each(function(index) {
                    $(this).attr('name', 'projectobjective[' + index + ']');

                });

                $('input[name="objectivesetid[]"]').each(function(index) {
                    $(this).attr('name', 'objectivesetid[' + index + ']');

                });


                $('#objectiveindex').val(objectiveindex);

                var dataurl = $('#form1').attr('data-url');
                var data1 = $('#form1').serialize();
                var data2 = $('#form2').serialize();

                // concatenate serialized data into a single string
                var formData = data1 + '&' + data2;

                // send data via AJAX
                $.ajax({
                    url: dataurl,
                    type: 'POST',
                    data: formData,
                    success: function(response) {

                        var projectId = response.projectid;
                        projecturl = projecturl.replace(':projectid', projectId);
                        window.location.href = projecturl;

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        console.log(status);
                        console.log(error);
                    }
                });
            }
        });

        function handleError() {

            if (currentstep === 0) {

                var hasErrors = false;

                $('.invalid-feedback strong').text('');
                $('.is-invalid').removeClass('is-invalid');

                var projectTitle = $('#projecttitle').val();

                var selectprojlead = $('#projectleader').find(':selected');
                var projectLeader = selectprojlead.val();
                var programTitle = $('#programtitle').val();

                var selectproglead = $('#programleader').find(':selected');
                var programLeader = selectproglead.val();

                var projectStartDate = new Date($('#projectstartdate').val());
                var projectEndDate = new Date($('#projectenddate').val());

                var targetYear = parseInt($('#currentyear').val(), 10);

                // Validation for Project Title
                if (projectTitle.trim() === '') {
                    $('#projecttitle').addClass('is-invalid');
                    $('#projecttitle').next('.invalid-feedback').find('strong').text('Project Title is required.');
                    hasErrors = true;
                }

                // Validation for Project Leader
                if (projectLeader == 0) {
                    $('#projectleader').addClass('is-invalid');
                    $('#projectleader').next('.invalid-feedback').find('strong').text('Project Leader is required.');
                    hasErrors = true;
                }

                // Validation for Program Title
                if (programTitle.trim() === '') {
                    $('#programtitle').addClass('is-invalid');
                    $('#programtitle').next('.invalid-feedback').find('strong').text('Program Title is required.');
                    hasErrors = true;
                }

                // Validation for Program Leader
                if (programLeader == 0) {
                    $('#programleader').addClass('is-invalid');
                    $('#programleader').next('.invalid-feedback').find('strong').text('Program Leader is required.');
                    hasErrors = true;
                }

                // Validation for Project Start Date
                if (projectStartDate.getFullYear() !== targetYear) {
                    $('#projectstartdate').addClass('is-invalid');
                    $('#projectstartdate').next('.invalid-feedback').find('strong').text('Project Start Date must be in ' + targetYear + '.');
                    hasErrors = true;
                }

                // Validation for Project End Date
                if (projectEndDate.getFullYear() !== targetYear || projectEndDate < projectStartDate) {
                    $('#projectenddate').addClass('is-invalid');
                    $('#projectenddate').next('.invalid-feedback').find('strong').text('Project End Date must be in ' + targetYear + ' and after the Start Date.');
                    hasErrors = true;
                }

                return hasErrors;

            } else if (currentstep === 1) {
                var hasErrors = false;

                if ($('input[name="projectobjective[]"]').length === 0) {
                    $('.projectobjective-error strong').show();
                    hasErrors = true;
                } else {
                    $('input[name="projectobjective[]"]').each(function(index, element) {

                        if ($(element).val() === "") {
                            $('.projectobjective-error strong').show();
                            hasErrors = true;
                        }

                    });

                }
                return hasErrors;
            }

        }

    });
</script>
@endsection