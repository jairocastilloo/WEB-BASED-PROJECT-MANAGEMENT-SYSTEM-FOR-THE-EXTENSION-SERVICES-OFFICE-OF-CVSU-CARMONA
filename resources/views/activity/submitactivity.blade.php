@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper">
            <div class="step divhover" id="projectdiv" data-value="{{ $project['id'] }}" data-dept="{{ $project->department }}">
                <span class="fw-bold">Project: {{ $project->projecttitle }}</span>
                <div class="message-box text-white">
                    {{ $project->projecttitle }}
                </div>
            </div>


        </div>
        <div class="step-wrapper divhover" id="activitydiv" data-value="{{ $activity->id }}" data-name="{{ $activity->actname }}">
            <div class="step">
                <span class="fw-bold">Activity: {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    {{ $activity['actname'] }}
                </div>
            </div>


        </div>
        <div class="step-wrapper containerhover" id="activityhours-btn" data-value="{{ $activity->id }}" data-name="{{ $activity->actname }}">
            <div class="step">
                <span class="fw-bold">Participation Hours for {{ $activity['actname'] }}</span>
                <div class="message-box text-white">
                    Participation Hours for {{ $activity['actname'] }}
                </div>
            </div>


        </div>

        <div class="step-wrapper">
            <div class="steps highlight" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                <span class="fw-bold">Submitting Report for {{ $activity['actname'] }}</span>
                <div class="message-box">
                    Submitting Report for {{ $activity['actname'] }}
                </div>
            </div>


        </div>
    </div>


    <div class="container">
        <form id="addtoactivityform" data-url="{{ route('addto.activity') }}">
            @csrf
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <div class="basiccont word-wrap shadow">
                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;"><b>Submit Hours Rendered</b>
                        <span class="text-dark">({{ $activity['actname'] }})</span>
                    </h6>


                    <input type="number" class="d-none" id="contributornumber" name="contributornumber">
                    <input type="number" class="d-none" id="activity-contributor-0" name="activity-contributor[0]">

                    <div class="m-2 ms-4 me-4">
                        <label class="form-label">Hours Rendered:</label>
                        <input type="number" class="d-none" id="activity-id" name="activity-id" value="{{ $activity['id'] }}">
                        <input type="text" class="d-none" id="activity-name" name="activity-name" value="{{ $activity['actname'] }}">
                        <input type="number" class="form-control" id="hours-rendered" name="hours-rendered" placeholder="Enter hours rendered" min="0" step="1">
                    </div>

                    <div class="m-2 ms-4 me-4">
                        <label class="form-label">Start Date:</label>
                        <input type="date" class="form-control" id="start-date" name="start-date">
                    </div>

                    <div class="m-2 ms-4 me-4">
                        <label class="form-label">End Date:</label>
                        <input type="date" class="form-control" id="end-date" name="end-date">
                    </div>
                </div>
                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;"><b>Contributor</b>

                    </h6>


                    <div class="row m-1 contributor-name">

                    </div>
                    <div class="btn-group ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addcontributor-btn">
                            <b class="small">Add Contributor</b>
                        </button>
                    </div>
                </div>

                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;"><b>Supporting Documents</b>

                    </h6>

                    <div class="mt-2 ms-4 me-4">
                        <label class="form-label" for="customFile">Submit Accomplishment Report:</label>

                        <input type="file" class="form-control" id="customFile" accept=".docx" name="activitydocs">
                    </div>

                    <div class="d-grid gap-2 p-4">
                        <button type="button" class="btn btn-primary fw-bold" id="submitreport-btn">Submit Report</button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="addcontributor-confirm">Confirm</button>
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


        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');
            var department = $(this).attr('data-dept');



            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));
            window.location.href = url;
        });

        $('#activitydiv').click(function(event) {

            event.preventDefault();
            var actid = $(this).attr('data-value');
            var activityname = $(this).attr('data-name');

            var url = '{{ route("activities.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':activityname', activityname);
            window.location.href = url;
        });

        $('#activityhours-btn').click(function(event) {
            event.preventDefault();
            var activityid = $(this).attr('data-value');
            var activityname = $(this).attr('data-name');


            var url = '{{ route("hours.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':activityname', activityname);


            window.location.href = url;
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
            var contributordiv = `<div class="col-6 divhover p-2">
                            ${contributorname}
                            <button type="button" class="btn btn-outline-danger btn-sm float-end"> x </button>
                        </div>`

            $('.contributor-name').append(contributordiv);

            var contributorid = parseInt($('#contributorselect').val());

            if (contributorindex === 0) {
                $(`#activity-contributor-${contributorindex}`).val(contributorid);

            } else {
                var activitycontributordiv = `<input type="number" class="d-none" id="activity-contributor-${contributorindex}" name="activity-contributor[${contributorindex}]">`;
                $('#addtoactivityform').append(activitycontributordiv);
                $(`#activity-contributor-${contributorindex}`).val(contributorid);

            }

            contributorindex++;

            currentassignees = currentassignees.filter(function(assignee) {
                return assignee.id !== parseInt($('#contributorselect').val());
            });
            $('#contributorModal').modal('hide');
        });


        $('#submitreport-btn').click(function(event) {
            event.preventDefault();

            var activityid = $('#activity-id').val();
            var activityname = $('#activity-name').val();

            var department = $('#department').val();

            var url = '{{ route("hours.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':activityname', activityname);

            $("#contributornumber").val($('input[name^="activity-contributor["][name$="]"]').length);

            var dataurl = $('#addtoactivityform').attr('data-url');
            var formData = new FormData($("#addtoactivityform")[0]);

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



    });
</script>
@endsection