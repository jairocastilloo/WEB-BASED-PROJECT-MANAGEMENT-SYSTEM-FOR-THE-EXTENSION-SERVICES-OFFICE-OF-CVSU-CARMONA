@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper divhover" id="projectdiv" data-value="{{ $project->id }}"
            data-name="{{ $project->projecttitle }}" data-dept="{{ $project->department }}">
            <div class="step">
                <span class="fw-bold">Project: {{ $project->projecttitle }}</span>
                <div class="message-box text-white">
                    {{ $project->projecttitle }}
                </div>
            </div>


        </div>
        <div class="step-wrapper divhover" id="activitydiv" data-value="{{ $activity->id }}"
            data-name="{{ $activity->actname }}">
            <div class="step">
                <span class="fw-bold">Activity: {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    {{ $activity['actname'] }}
                </div>
            </div>


        </div>
        <div class="step-wrapper divhover" id="subtaskdiv" data-value="{{ $subtask->id }}"
            data-name="{{ $subtask->subtask_name }}">
            <div class="step">
                <span class="fw-bold">Subtask: {{ $subtask['subtask_name'] }}</span>
                <div class="message-box text-white">
                    {{ $subtask['subtask_name'] }}
                </div>
            </div>


        </div>
        <div class="step-wrapper">
            <div class="steps" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                <span class="fw-bold">Evaluating Submission for {{ $subtask['subtask_name'] }}</span>
                <div class="message-box">
                    Evaluating Submission for {{ $subtask['subtask_name'] }}
                </div>
            </div>


        </div>
    </div>


    <div class="container">
        <form id="addtosubtaskform" data-url="{{ route('addto.subtask') }}">
            @csrf
            <div class="basiccont word-wrap shadow">
                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;"><b>Submit Hours Rendered</b>
                        <span class="text-dark">({{ $subtask['subtask_name'] }})</span>
                    </h6>


                    <input type="number" class="d-none" id="contributornumber" name="contributornumber">
                    <input type="number" class="d-none" id="subtask-contributor-0" name="subtask-contributor[0]">

                    <div class="m-2 ms-4 me-4">
                        <label class="form-label">Hours Rendered:</label>
                        <input type="number" class="d-none" id="subtask-id" name="subtask-id"
                            value="{{ $subtask['id'] }}">
                        <input type="text" class="d-none" id="subtask-name" name="subtask-name"
                            value="{{ $subtask['subtask_name'] }}">
                        <input type="number" class="form-control" id="hours-rendered" name="hours-rendered"
                            placeholder="Enter hours rendered" min="0" step="1">
                    </div>

                    <div class="m-2 ms-4 me-4">
                        <label class="form-label">Start Date:</label>
                        <input type="date" class="form-control" id="subtask-date" name="subtask-date">
                    </div>
                    <div class="m-2 ms-4 me-4">
                        <label class="form-label">End Date:</label>
                        <input type="date" class="form-control" id="subtask-enddate" name="subtask-enddate">
                    </div>
                </div>
                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;"><b>Contributor</b>

                    </h6>


                    <div class="row m-1 contributor-name">

                    </div>
                    <div class="btn-group ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow"
                            id="addcontributor-btn">
                            <b class="small">Add Contributor</b>
                        </button>
                    </div>
                </div>

                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;"><b>Supporting Documents</b>

                    </h6>

                    <div class="mt-2 ms-4 me-4">
                        <label class="form-label" for="customFile">Submit Subtask Report:</label>

                        <input type="file" class="form-control" id="customFile" accept=".pdf, .docx" name="subtaskdocs">
                    </div>

                    <div class="d-grid gap-2 p-4">
                        <button type="button" class="btn btn-primary fw-bold" id="submitreport-btn">Submit
                            Report</button>
                    </div>
                </div>
            </div>
        </form>
    </div>



</div>


<div class="modal fade" id="contributorModal" tabindex="-1" aria-labelledby="contributorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contributorModalLabel">Add Contributor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="contributorSelect" class="form-label">Contributor for the task</label>
                    <select class="form-select" id="contributorselect" name="contributorname" required>
                        <option value="" selected disabled>Select Contributor</option>

                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md rounded border border-1 btn-light shadow"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm rounded btn-gold shadow"
                    id="addcontributor-confirm">Confirm</button>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
var currentassignees = <?php echo json_encode($currentassignees);
                            ?>;
var contributorindex = 0;

$(document).ready(function() {
    $('.step span').each(function() {
        var $span = $(this);
        if ($span.text().length > 16) { // Adjust the character limit as needed
            $span.text($span.text().substring(0, 16) + '...'); // Truncate and add ellipsis
        }
    });
    $('.steps span').each(function() {
        var $span = $(this);
        if ($span.text().length > 16) { // Adjust the character limit as needed
            $span.text($span.text().substring(0, 16) + '...'); // Truncate and add ellipsis
        }
    });
    $('#navbarDropdown').click(function(event) {
        // Add your function here
        event.preventDefault();
        $('#account .dropdown-menu').toggleClass('shows');
    });

    $('#addcontributor-btn').click(function() {
        event.preventDefault();
        $('#contributorselect').find("option:not(:first-child)").remove();
        $.each(currentassignees, function(index, item) {

            $('#contributorselect').append($('<option>', {
                value: item.id,
                text: item.name + ' ' + item.last_name,
            }));

        });
        $('#contributorselect').val($('#contributorselect').find("option:first").val());
        $('#contributorModal').modal('show');
    });

    $('#addcontributor-confirm').click(function(event) {
        event.preventDefault();
        var contributorname = $('#contributorselect option:selected').text();
        var contributordiv = `<div class="col-lg-6 divhover p-2">
                            ${contributorname}
                            <button type="button" class="btn btn-outline-danger btn-sm float-end fs-6"><i class="bi bi-person-dash"></i></button>
                        </div>`

        $('.contributor-name').append(contributordiv);

        var contributorid = parseInt($('#contributorselect').val());

        if (contributorindex === 0) {
            $(`#subtask-contributor-${contributorindex}`).val(contributorid);

        } else {
            var subtaskcontributordiv =
                `<input type="number" class="d-none" id="subtask-contributor-${contributorindex}" name="subtask-contributor[${contributorindex}]">`;
            $('#addtosubtaskform').append(subtaskcontributordiv);
            $(`#subtask-contributor-${contributorindex}`).val(contributorid);

        }

        contributorindex++;

        currentassignees = currentassignees.filter(function(assignee) {
            return assignee.id !== parseInt($('#contributorselect').val());
        });
        $('#contributorModal').modal('hide');
    });

    $('#submitreport-btn').click(function(event) {
        event.preventDefault();

        var subtaskid = $('#subtask-id').val();
        var subtaskname = $('#subtask-name').val();


        var url =
            '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
        url = url.replace(':subtaskid', subtaskid);
        url = url.replace(':subtaskname', subtaskname);

        $("#contributornumber").val($('input[name^="subtask-contributor["][name$="]"]').length);

        var dataurl = $('#addtosubtaskform').attr('data-url');
        var formData = new FormData($("#addtosubtaskform")[0]);

        $.ajax({
            url: dataurl,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);

                window.location.href = url;
                // Handle the successful response here
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.error(error);
                // Handle the error here
            }
        });

    });

    $('#projectdiv').click(function(event) {
        event.preventDefault();
        var projectid = $(this).attr('data-value');
        var department = $(this).attr('data-dept');



        var url =
            '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department"]) }}';
        url = url.replace(':projectid', projectid);
        url = url.replace(':department', encodeURIComponent(department));

        window.location.href = url;
    });

    $('#activitydiv').click(function(event) {

        event.preventDefault();
        var actid = $(this).attr('data-value');
        var activityname = $(this).attr('data-name');

        var url =
            '{{ route("activities.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
        url = url.replace(':activityid', actid);
        url = url.replace(':activityname', activityname);
        window.location.href = url;
    });
    $('#subtaskdiv').click(function() {
        event.preventDefault();

        var subtaskname = $(this).attr("data-name");
        var subtaskid = $(this).attr("data-value");

        var url =
            '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
        url = url.replace(':subtaskid', subtaskid);
        url = url.replace(':subtaskname', subtaskname);
        window.location.href = url;
    });

});
</script>
@endsection