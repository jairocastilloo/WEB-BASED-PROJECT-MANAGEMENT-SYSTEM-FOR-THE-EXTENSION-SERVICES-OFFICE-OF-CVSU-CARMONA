@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-top-0">

    <div class="container pt-3">
        <div class="row">
            <div class="col-lg-10">

                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Projects</h6>
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
                            <h6><strong>Department Projects for:</strong></h6>
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
                @livewire('more-projects', ['department' => $department, 'projectid' => null, 'x' => 1])


            </div>

            <div class="col-lg-2">

                @livewire('not-started-projects', ['department' => $department, 'projectid' => null, 'y' => 1])

                @livewire('past-projects', ['department' => $department, 'projectid' => null, 'z' => 0])
                @livewire('completed-projects', ['department' => $department, 'projectid' => null, 'xCompletedProjects' => 0])
            </div>

        </div>
    </div>
</div>

<!-- New Project -->
@if (Auth::user()->role === 'Admin')
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
                                <label for="programtitle" class="form-label">Program Title <span class="text-secondary">( if applicable )</span></label>
                                <input type="text" class="form-control autocapital" id="programtitle" name="programtitle">

                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="container mb-3 p-0 programleaderdiv" style="display:none;">
                                <label for="programleader" class="form-label">Program Leader</label>
                                <select class="selectpicker w-100 border programleader" name="programleader[]" id="programleader" multiple aria-label="Select Program Leaders" data-live-search="true">
                                    <option value="0" disabled>Select Program Leader</option>
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
@endif
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
<!--<script src="{{ asset('js/selectize.min.js') }}"></script>-->
<script>
    var selectElement = $('#year-select');
    var url = "";


    $(document).ready(function() {

        var currentstep = 0;
        var setcount = 0;
        $('#objectiveInput-error').hide();
        $('#addObjectiveSet-btn').click(function() {
            $('#form2').append(`<div class="container-fluid objectiveSetContainer mb-2 p-2" data-value="0">
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


                                </div>`);
        });
        $(document).on('click', '.addObjective-btn', function() {
            $(this).prev().append(`<div class="input-group mb-2 objectiveName-input">

<textarea class="form-control" aria-label="With textarea" name="objectiveName[]" placeholder="Write objective here.."></textarea>

<input type="number" name="objectiveSetNumber[]" class="objectiveSetNumber d-none" value="0">
<button type="button" class="btn btn-sm btn-outline-danger removeObjectiveName-btn"><i class="bi bi-x-lg"></i></button>
</div>`);
        });
        $(document).on('click', '.removeObjectiveName-btn', function() {
            if ($(this).parent().parent().find('.objectiveName-input').length > 1) {
                $(this).parent().remove();
            }
        });
        $(document).on('click', '.removeObjectiveSet-btn', function() {
            if ($(this).parent().parent().find('.objectiveSetContainer').length > 1) {
                $(this).parent().remove();
            }
        });

        $('#programtitle').on('keyup', function(e) {
            if ($('#programtitle').val() === "") {
                $('.programleaderdiv').css('display', 'none');
            } else {
                $('.programleaderdiv').css('display', 'inline-block');
            }
        });
        $('#startDatePicker').datepicker();

        $('#startDatePicker').datepicker().on('change', function(e) {
            $('#startDatePicker').datepicker('hide');
        });
        $('#endDatePicker').datepicker();

        $('#endDatePicker').datepicker().on('change', function(e) {
            $('#endDatePicker').datepicker('hide');
        });
        $(document).on('input', '.autocapital', function() {
            var inputValue = $(this).val();
            if (inputValue.length > 0) {
                $(this).val(inputValue.charAt(0).toUpperCase() + inputValue.slice(1));
            }
        });

        $(document).on('click', '#toggleButton', function(event) {
            $(this).next().slideToggle("fast");
        });

        $(document).on('click', '.projectdiv', function(event) {
            event.preventDefault();
            var department = $(this).attr('data-dept');
            var projectid = $(this).attr('data-value');


            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));

            window.location.href = url;
        });

        // Add an event listener to the select element
        selectElement.change(function() {
            var selectedOption = $(this).find(':selected');
            var department = selectedOption.val();

            var baseUrl = "{{ route('project.show', ['department' => ':department']) }}";
            var url = baseUrl.replace(':department', encodeURIComponent(department))

            window.location.href = url;
        });

        function updateButtons() {
            if (currentstep == 0) {
                $('#prevproject').hide();
                $('#nextproject').show();
                $('#createproject').hide();
                $('#tab1-tab').attr('disabled', true);
                $('#tab1-tab').tab('show');
            } else if (currentstep == 1) {
                $('#prevproject').show();
                $('#nextproject').hide();
                $('#createproject').show();
                $('#tab1-tab').removeAttr('disabled');
                $('#tab2-tab').tab('show');
            }

        }
        $('#tab1-tab').click((event) => {

            event.preventDefault();

            currentstep--;
            updateButtons();
        });
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
                $(this).prop('disabled', true);
                var department = $('#department').val();

                var projecturl = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';

                projecturl = projecturl.replace(':department', encodeURIComponent(department));

                $('#objectiveindex').val($('textarea[name="objectiveName[]"]').length);

                $('div.objectiveSetContainer').each(function(index) {
                    $(this).attr("data-value", index);

                });

                $('textarea[name="objectiveName[]"]').each(function(index) {
                    $(this).attr('name', 'objectiveName[' + index + ']');

                });
                $('input[name="objectiveSetNumber[]"]').each(function(index) {
                    var id = $(this).parent().parent().parent().attr('data-value');

                    $(this).val(id);
                    $(this).attr('name', 'objectiveSetNumber[' + index + ']');

                });



                /**
                                var objectiveindex = $('input[name="projectobjective[]"]').length;

                                $('input[name="projectobjective[]"]').each(function(index) {
                                    $(this).attr('name', 'projectobjective[' + index + ']');

                                });

                                $('input[name="objectivesetid[]"]').each(function(index) {
                                    $(this).attr('name', 'objectivesetid[' + index + ']');

                                });


                                $('#objectiveindex').val(objectiveindex);
                */
                var dataurl = $('#form1').attr('data-url');
                var data1 = $('#form1').serialize();
                var data2 = $('#form2').serialize();

                // concatenate serialized data into a single string
                var formData = data1 + '&' + data2;
                $('#loadingSpan').css('display', 'block');

                // send data via AJAX
                $.ajax({
                    url: dataurl,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var projectId = response.projectid;
                        projecturl = projecturl.replace(':projectid', projectId);
                        $('#loadingSpan').css('display', 'none');

                        if (response.isMailSent == 0) {
                            $('#newproject').modal('hide');
                            $('#mailNotSent').modal('show');

                            // Set the initial countdown value
                            let countdownValue = 5;

                            // Function to update the countdown value and redirect
                            function updateCountdown() {
                                countdownValue -= 1;
                                $('#countdown').text(countdownValue);

                                if (countdownValue <= 0) {
                                    // Redirect to your desired URL
                                    window.location.href = projecturl; // Replace with your URL
                                } else {
                                    // Call the function recursively after 1 second (1000 milliseconds)
                                    setTimeout(updateCountdown, 1000);
                                }
                            }

                            // Start the countdown
                            updateCountdown();
                        } else {

                            window.location.href = projecturl;
                        }
                    },
                    error: function(xhr, status, error) {
                        //$('#createprojectError').text(xhr.responseText);
                        $('#createprojectError').text("There is a problem with server. Contact Administrator!");
                        $('#loadingSpan').css('display', 'none');
                        /*
                                                console.log(xhr.responseText);
                                                console.log(status);
                                                console.log(error);
                                                */
                    }
                });
            }
        });

        function formatDate(inputDate) {
            // Split the inputDate by the '/' character
            var parts = inputDate.split('/');

            // Rearrange the parts into the "YYYY-MM-DD" format
            var formattedDate = parts[2] + '-' + parts[0] + '-' + parts[1];

            return formattedDate;
        }

        function handleError() {

            if (currentstep === 0) {

                var hasErrors = false;

                $('.invalid-feedback strong').text('');
                $('.is-invalid').removeClass('is-invalid');

                var projectTitle = $('#projecttitle').val();

                var projectLeader = $('#projectleader').val();

                var programTitle = $('#programtitle').val();

                var programLeader = $('#programleader').val();

                var projectStartDate = formatDate($('#projectstartdate').val());
                var projectEndDate = formatDate($('#projectenddate').val());

                // Validation for Project Title
                if (projectTitle.trim() === '') {
                    $('#projecttitle').addClass('is-invalid');
                    $('#projecttitle').next('.invalid-feedback').find('strong').text('Project Title is required.');
                    hasErrors = true;
                }

                // Validation for Project Leader
                if (projectLeader.length === 0) {
                    $('.projectleader').addClass('is-invalid');
                    $('.projectleader').next('.invalid-feedback').find('strong').text('Project Leader is required.');
                    hasErrors = true;
                }
                /** 
                                // Validation for Program Title
                                if (programTitle.trim() === '') {
                                    $('#programtitle').addClass('is-invalid');
                                    $('#programtitle').next('.invalid-feedback').find('strong').text('Program Title is required.');
                                    hasErrors = true;
                                }
                
             
                if (programLeader.length === 0) {
                    $('.programleader').addClass('is-invalid');
                    $('.programleader').next('.invalid-feedback').find('strong').text('Program Leader is required.');
                    hasErrors = true;
                }
                */
                if ($('#projectstartdate').val() == "") {
                    $('#projectstartdate').parent().addClass('is-invalid');
                    $('#projectstartdate').parent().next('.invalid-feedback').find('strong').text('Project Start Date is required.');
                    hasErrors = true;
                }
                if ($('#projectenddate').val() == "") {
                    $('#projectenddate').parent().addClass('is-invalid');
                    $('#projectenddate').parent().next('.invalid-feedback').find('strong').text('Project End Date is required.');
                    hasErrors = true;
                }

                if (projectEndDate <= projectStartDate) {
                    $('#projectenddate').parent().addClass('is-invalid');
                    $('#projectenddate').parent().next('.invalid-feedback').find('strong').text('Project End Date must be after the Start Date.');
                    hasErrors = true;
                }
                /*
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
                */
                return hasErrors;

            } else if (currentstep === 1) {
                var hasErrors = false;

                $('textarea[name="objectiveName[]"]').each(function(index, element) {

                    if ($(element).val() === "") {
                        $('#objectiveInput-error').show();
                        hasErrors = true;
                    }

                });


                /*
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

                }*/
                return hasErrors;
            }

        }


    });
</script>
@endsection