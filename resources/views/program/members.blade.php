@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-top-0">
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

        <div class="step-wrapper">
            <div class="step highlight">
                <span class="fw-bold">Program: {{ $indexprogram['programName'] }}</span>
                <div class="message-box">
                    {{ $indexprogram['programName'] }}
                </div>
            </div>


        </div>

    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Programs</h6>
                    </div>

                    <div class="form-floating m-3 mb-2 mt-2">

                        <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen;" aria-label="Select a Department">

                            @foreach ($alldepartments as $alldepartment)
                            <option class="p-2" value="{{ $alldepartment }}" {{ $alldepartment == $department ? 'selected' : '' }}>
                                {{ $alldepartment }}
                            </option>
                            @endforeach

                        </select>
                        <label for="year-select" style="color:darkgreen;">
                            <h6><strong>Department Programs for:</strong></h6>
                        </label>
                    </div>
                    @if ($userRole == 'Admin')
                    <div class="btn-group mt-1 ms-3 mb-2 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addProgram" data-bs-toggle="modal" data-bs-target="#createProgramModal">
                            <b class="small">Create New Program</b>
                        </button>
                    </div>
                    @endif
                </div>

                <div class="basiccont p-3 rounded shadow">
                    <div class="flexmid"><strong>PROGRAM DETAILS</strong></div>
                    @livewire('program-details', [ 'indexprogram' => $indexprogram, 'members' => $members ])
                    <div class="btn-group dropdown mt-3 shadow">
                        <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <b class="small"> <i class="bi bi-list"></i> Menu</b>
                        </button>
                        <div class="dropdown-menu border-warning">

                            <a class="dropdown-item small hrefnav border-bottom" href="{{ route('programs.display', ['programid' => $indexprogram->id, 'department' => $indexprogram->department ]) }}">
                                <b class="small">Projects</b>
                            </a>
                            <a class="dropdown-item small bg-warning border-bottom">
                                <b class="small">Members And Leaders</b>
                            </a>

                            @If(Auth::user()->role == "Admin")
                            <a class="dropdown-item small hrefnav border-bottom" id="editIndexProgram">
                                <b class="small">Edit Details</b>
                            </a>
                            @endif
                            @If(Auth::user()->role == "Admin" || Auth::user()->role == "Coordinator")
                            <a class="dropdown-item small hrefnav border-bottom" href="">
                                <b class="small">Close Program</b>
                            </a>
                            @endif
                            @If(Auth::user()->role == "Admin")
                            <a class="dropdown-item small hrefnavDelete border-bottom">
                                <b class="small">Delete Program</b>
                            </a>
                            @endif



                        </div>
                    </div>


                </div>
                <div class="basiccont rounded shadow pb-3">

                    <div class="border-bottom ps-3 pt-2 bggreen pe-2">
                        <h6 class="fw-bold small" style="color:darkgreen;">Members</h6>
                    </div>
                    @livewire('program-members', ['indexprogram' => $indexprogram, 'department' => $department ])


                </div>


            </div>

            <div class="col-lg-2">
                @livewire('ongoing-program', ['department' => $department, 'programid' => $indexprogram->id, 'xOngoingPrograms' => 1])
                @livewire('upcoming-program', ['department' => $department, 'programid' => $indexprogram->id, 'yUpcomingPrograms' => 1])
                @livewire('overdue-program', ['department' => $department, 'programid' => $indexprogram->id, 'zOverduePrograms' => 0])
                @livewire('completed-program', ['department' => $department, 'programid' => $indexprogram->id, 'xCompletedPrograms' => 0])
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
                <h5 class="modal-title" id="newproject">Create Project within program <i>"{{ $indexprogram->programName }}"</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true" disabled>Project Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false" disabled>Project Objectives</button>
                    </li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <!-- Form for tab 1 -->
                        <form id="form1" data-url="{{ route('programs.storeProject') }}">
                            @csrf
                            <input type="text" class="d-none" name="department" id="department" value="{{ $department }}">
                            <input type="number" class="d-none" id="memberindex" name="memberindex">
                            <input type="number" class="d-none" id="programindex" name="programindex" value="{{ $indexprogram->id }}">
                            <input type="number" class="d-none" id="objectiveindex" name="objectiveindex">
                            <label for="projectdetails" class="form-label mt-2">Input all the details of the project</label>



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

                                <label for="projectobjectives" class="form-label mt-2">List all objectives of the project</label>
                                <div class="container-fluid objectiveSetContainer mb-2 p-2" data-value="0">
                                    <div>
                                        <div class="input-group mb-2 objectiveName-input">

                                            <textarea class="form-control" aria-label="With textarea" name="objectiveName[]" placeholder="Write objective here.."></textarea>

                                            <input type="number" name="objectiveSetNumber[]" class="objectiveSetNumber d-none" value="0">
                                            <button type="button" class="btn btn-sm btn-outline-danger removeObjectiveName-btn"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    </div>
                                    <button type="button" class="addObjective-btn btn btn-sm btn-outline-success">
                                        <b class="small">Add Objective</b>
                                    </button>
                                    <button type="button" class="removeObjectiveSet-btn btn btn-sm btn-outline-danger px-5 d-block mx-auto">
                                        <b class="small">Remove Objective Set</b>
                                    </button>


                                </div>
                            </form>
                            <button type="button" class="btn btn-outline-primary w-100" id="addObjectiveSet-btn">
                                <b class="small">Add Objective Set</b>
                            </button>
                            <span class="text-danger small fw-bold" id="objectiveInput-error">Please ensure that there is objective in every input.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="text-danger" id="createprojectError">
                    <strong></strong>
                </span>
                <span class="ms-2 small loadingMessage" id="loadingSpan" style="display: none;">Sending Email..</span>
                <button type="button" class="btn shadow rounded border border-1 btn-light" data-bs-dismiss="modal"><b class="small">Close</b></button>
                <button type="button" class="btn shadow rounded btn-outline-primary try" id="prevproject">
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

<div class="modal fade" id="createProgramModal" tabindex="-1" aria-labelledby="createProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProgramModalLabel">Create New Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for creating a new program -->
                <form id="programform1" data-url="{{ route('programs.create') }}">
                    @csrf
                    <input type="text" class="d-none" id="department" name="department" value="{{ $department }}">
                    <div class="mb-3">
                        <label for="programtitle" class="form-label">Program Title </label>
                        <input type="text" class="form-control autocapital" id="programtitle-1" name="programtitle-1">

                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="container mb-3 p-0">
                        <label for="programleader" class="form-label">Program Leader</label>
                        <select class="selectpicker w-100 border programleader" name="programleader-1[]" id="programleader-1" multiple aria-label="Select Program Leaders" data-live-search="true">
                            <option value="0" disabled>Select Program Leader</option>
                            @foreach ($members as $member)
                            @if ($member->role === 'Admin')
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

                    <div class="mb-3">
                        <label for="programstartdate" class="form-label">Program Start Date</label>

                        <div class="input-group date" id="programstartDatePicker">
                            <input type="text" class="form-control" id="programstartdate-1" name="programstartdate-1" placeholder="mm/dd/yyyy" />

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
                        <label for="programenddate" class="form-label">Program End Date</label>

                        <div class="input-group date" id="programendDatePicker">
                            <input type="text" class="form-control" id="programenddate-1" name="programenddate-1" placeholder="mm/dd/yyyy" />
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

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="text-danger" id="createProgramError">
                    <strong></strong>
                </span>
                <span class="ms-2 small loadingMessage" id="programloadingSpan" style="display: none;">Sending Email..</span>
                <button type="button" class="btn shadow rounded border border-1 btn-light" data-bs-dismiss="modal"><b class="small">Close</b></button>

                <button type="button" class="btn shadow rounded btn-primary" id="createProgram">
                    <b class="small">Create Program</b>
                </button>

            </div>
        </div>
    </div>
</div>
@endif
<div class="modal" id="programmailNotSent" tabindex="-1" aria-labelledby="mailNotSentLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal content goes here -->
                <h4>Program Created, but Email Not Sent Due to Internet Issue!</h4>
                <p>Redirecting in <span id="programcountdown">5</span> seconds...</p>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="mailNotSent" tabindex="-1" aria-labelledby="mailNotSentLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal content goes here -->
                <h4>Program Created, but Email Not Sent Due to Internet Issue!</h4>
                <p>Redirecting in <span id="countdown">5</span> seconds...</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
    var projecturl = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';
    var baseUrl = "{{ route('programs.select', ['department' => ':department']) }}";
    $(document).ready(function() {
        $('#editIndexProgram').click(function() {
            $('#editProgramModal').modal('show');
        });
        $('#currentprogramstartDatePicker').datepicker();

        $('#currentprogramstartDatePicker').datepicker().on('change', function(e) {
            $('#currentprogramstartDatePicker').datepicker('hide');
        });
        $('#currentprogramendDatePicker').datepicker();

        $('#currentprogramendDatePicker').datepicker().on('change', function(e) {
            $('#currentprogramendDatePicker').datepicker('hide');
        });
        $('#programstartDatePicker').datepicker();

        $('#programstartDatePicker').datepicker().on('change', function(e) {
            $('#programstartDatePicker').datepicker('hide');
        });
        $('#programendDatePicker').datepicker();

        $('#programendDatePicker').datepicker().on('change', function(e) {
            $('#programendDatePicker').datepicker('hide');
        });
        $('#startDatePicker').datepicker();

        $('#startDatePicker').datepicker().on('change', function(e) {
            $('#startDatePicker').datepicker('hide');
        });
        $('#endDatePicker').datepicker();

        $('#endDatePicker').datepicker().on('change', function(e) {
            $('#endDatePicker').datepicker('hide');
        });
        $('.step span').each(function() {
            var $span = $(this);
            if ($span.text().length > 14) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 14) + '...'); // Truncate and add ellipsis
            }
        });
        $('.programDiv').click(function() {
            var department = $(this).attr('data-dept');
            var programId = $(this).attr('data-value');
            var url = '{{ route("programs.display", ["programid" => ":programid", "department" => ":department" ]) }}';
            url = url.replace(':department', encodeURIComponent(department));
            url = url.replace(':programid', programId);
            window.location.href = url;
        });
        $('#createProgram').click(function() {
            event.preventDefault();
            var department = $('#department').val();
            // var hasError = handleError();
            var programurl = '{{ route("programs.display", ["programid" => ":programid", "department" => ":department" ]) }}';
            programurl = programurl.replace(':department', encodeURIComponent(department));
            //   if (!hasError) {
            $(this).prop('disabled', true);


            var dataurl = $('#programform1').attr('data-url');
            var data1 = $('#programform1').serialize();

            $('#programloadingSpan').css('display', 'block');

            // send data via AJAX
            $.ajax({
                url: dataurl,
                type: 'POST',
                data: data1,
                success: function(response) {
                    var programId = response.programid;
                    programurl = programurl.replace(':programid', programId);
                    window.location.href = programurl;

                    $('#programloadingSpan').css('display', 'none');

                    if (response.isMailSent == 0) {
                        $('#createProgramModal').modal('hide');
                        $('#programmailNotSent').modal('show');

                        // Set the initial countdown value
                        let countdownValue = 5;

                        // Function to update the countdown value and redirect
                        function updateCountdown() {
                            countdownValue -= 1;
                            $('#programcountdown').text(countdownValue);

                            if (countdownValue <= 0) {
                                // Redirect to your desired URL
                                window.location.href = programurl; // Replace with your URL
                            } else {
                                // Call the function recursively after 1 second (1000 milliseconds)
                                setTimeout(updateCountdown, 1000);
                            }
                        }

                        // Start the countdown
                        updateCountdown();
                    } else {

                        window.location.href = programurl;
                    }

                },
                error: function(xhr, status, error) {
                    //$('#createprojectError').text(xhr.responseText);

                    $('#createprogramError').text("There is a problem with server. Contact Administrator!");
                    $('#programloadingSpan').css('display', 'none');


                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);


                }
            });
            // }
        });
    });
</script>
<script src="{{ asset('js/project-create.js') }}"></script>

@endsection