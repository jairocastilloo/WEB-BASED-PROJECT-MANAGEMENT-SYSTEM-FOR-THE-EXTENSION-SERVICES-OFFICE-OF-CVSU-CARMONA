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
                            href="{{ route('project.show', ['department' => Auth::user()->department]) }}" role="button"
                            aria-haspopup="true" aria-expanded="false" v-pre>
                            Projects
                        </a>
                        <a class="nav-link border border-1 p-2 px-4 currentdiv fw-bold small">
                            Programs
                        </a>



                    </ul>
                </div>
            </nav>
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
                            <h6><strong>Department Programs for:</strong></h6>
                        </label>
                    </div>
                    @if ($userRole == 'Admin')
                    <div class="btn-group mt-1 ms-3 mb-2 shadow">
                        <button type="button" class="btn btn-sm rounded btn-gold shadow" id="addProgram"
                            data-bs-toggle="modal" data-bs-target="#createProgramModal">
                            <b class="small">Create New Program</b>
                        </button>
                    </div>
                    @endif
                </div>
                @livewire('ongoing-program', ['department' => $department, 'programid' => null, 'xOngoingPrograms' =>
                1])



            </div>

            <div class="col-lg-2">
                @livewire('upcoming-program', ['department' => $department, 'programid' => null, 'yUpcomingPrograms' =>
                1])
                @livewire('overdue-program', ['department' => $department, 'programid' => null, 'zOverduePrograms' =>
                0])
                @livewire('completed-program', ['department' => $department, 'programid' => null, 'xCompletedPrograms'
                => 0])
            </div>

        </div>
    </div>
</div>

<!-- New Program -->
@if ($userRole == 'Admin')
<div class="modal fade" id="createProgramModal" tabindex="-1" aria-labelledby="createProgramModalLabel"
    aria-hidden="true">
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
                        <select class="selectpicker w-100 border programleader-1" id="programleader-1" name="programleader-1[]"
                            id="programleader-1" multiple aria-label="Select Program Leaders" data-live-search="true">
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
                            <input type="text" class="form-control" id="programstartdate-1" name="programstartdate-1"
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

                        <!--<input type="date" class="form-control" id="projectstartdate" name="projectstartdate">-->


                    </div>

                    <div class="mb-3">
                        <label for="programenddate" class="form-label">Program End Date</label>

                        <div class="input-group date" id="programendDatePicker">
                            <input type="text" class="form-control" id="programenddate-1" name="programenddate-1"
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

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="text-danger" id="createProgramError">
                    <strong></strong>
                </span>
                <span class="ms-2 small loadingMessage" id="programloadingSpan" style="display: none;">Sending
                    Email..</span>
                <button type="button" class="btn btn-md rounded border border-1 btn-light shadow"
                    data-bs-dismiss="modal"><b class="small">Close</b></button>

                <button type="button" class="btn btn-md rounded btn-gold shadow" id="createProgram">
                    <b class="small">Create Program</b>
                </button>

            </div>
        </div>
    </div>
</div>
@endif
<div class="modal" id="programmailNotSent" tabindex="-1" aria-labelledby="mailNotSentLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
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
$(document).ready(function() {
    var baseUrl = "{{ route('programs.select', ['department' => ':department']) }}";
    var selectElement = $('#year-select');
    $('#programstartDatePicker').datepicker();

    $('#programstartDatePicker').datepicker().on('change', function(e) {
        $('#programstartDatePicker').datepicker('hide');
    });
    $('#programendDatePicker').datepicker();

    $('#programendDatePicker').datepicker().on('change', function(e) {
        $('#programendDatePicker').datepicker('hide');
    });
    selectElement.change(function() {
        var selectedOption = $(this).find(':selected');
        var department = selectedOption.val();


        baseUrl = baseUrl.replace(':department', encodeURIComponent(department))

        window.location.href = baseUrl;
    });

    $('.programDiv').click(function() {
        var department = $(this).attr('data-dept');
        var programId = $(this).attr('data-value');
        var url =
            '{{ route("programs.display", ["programid" => ":programid", "department" => ":department" ]) }}';
        url = url.replace(':department', encodeURIComponent(department));
        url = url.replace(':programid', programId);
        window.location.href = url;
    });
    $('#createProgram').click(function() {
        event.preventDefault();
        var hasError = handleProgramError();
        if(!hasError){
        $(this).prop('disabled', true);
        var department = $('#department').val();
        // var hasError = handleError();
        var programurl =
            '{{ route("programs.display", ["programid" => ":programid", "department" => ":department" ]) }}';
        programurl = programurl.replace(':department', encodeURIComponent(department));
        //   if (!hasError) {



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

                $('#createprogramError').text(
                    "There is a problem with server. Contact Administrator!");
                $('#programloadingSpan').css('display', 'none');


                console.log(xhr.responseText);
                console.log(status);
                console.log(error);


            }
        });
    }
        // }
    });
    function handleProgramError() {

            var hasErrors = false;

            $(".invalid-feedback strong").text("");
            $(".is-invalid").removeClass("is-invalid");

            var programtitle = $("#programtitle-1").val();
            var programstartdate = $("#programstartdate-1").val();
            var programenddate = $("#programenddate-1").val();



            // Validation for Project Title
            if (programtitle.trim() === "") {
                $("#programtitle-1").addClass("is-invalid");
                $("#programtitle-1")
                    .next(".invalid-feedback")
                    .find("strong")
                    .text("Program Title is required.");
                hasErrors = true;
            }

            // Validation for Project Leader
            if ($(".programleader-1 option:selected").length === 0) {
                $(".programleader-1").addClass("is-invalid");
                $(".programleader-1")
                    .next(".invalid-feedback")
                    .find("strong")
                    .text("Program Leader is required.");
                hasErrors = true;
            }

            if ($("#programstartdate-1").val() == "") {
                $("#programstartdate-1").parent().addClass("is-invalid");
                $("#programstartdate-1")
                    .parent()
                    .next(".invalid-feedback")
                    .find("strong")
                    .text("Program Start Date is required.");
                hasErrors = true;
            }
            if ($("#programenddate-1").val() == "") {
                $("#programenddate-1").parent().addClass("is-invalid");
                $("#programenddate-1")
                    .parent()
                    .next(".invalid-feedback")
                    .find("strong")
                    .text("Program End Date is required.");
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

    }
});
</script>


@endsection
