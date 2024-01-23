@extends('layouts.app')

@section('content')

<input class="d-none" type="date" value="{{ $activity['actstartdate'] }}" id="actsavestartdate">
<input class="d-none" type="date" value="{{ $activity['actenddate'] }}" id="actsaveenddate">

<div class="maincontainer border border-start border-end border-bottom border-top-0">

    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper">
            <div class="step divhover" id="projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}" data-dept="{{ $project['department'] }}">
                <span class="fw-bold">Project: {{ $project['projecttitle'] }}</span>
                <div class="message-box text-white">
                    {{ $project['projecttitle'] }}
                </div>
            </div>
        </div>
        <div class="step-wrapper">
            <div class="step highlight" data-hover="{{ $activity['actname'] }}">
                <span class="fw-bold">Activity: {{ $activity['actname'] }}</span>
                <div class="message-box">
                    {{ $activity['actname'] }}
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="basiccont word-wrap shadow">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Activity</h6>
                    </div>
                    @livewire('activity-details', [ 'activity' => $activity, 'objectives' => $objectives ])
                </div>
                @livewire('activity-output', [ 'outputTypes' => $outputTypes, 'outputs' => $outputs, 'activityid' =>
                $activity['id'] ])
                @livewire('activity-assignees', ['activity' => $activity, 'projectName' => $project['projecttitle'] ])
            </div>


            <div class="col-lg-3">

                <div class="row mb-2">
                    <div class="col-6">
                        <label class="ms-3 small form-label text-secondary fw-bold">Subtasks</label>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-sm rounded btn-outline-secondary addsubtask-btn me-2">
                            <b class="small"><i class="bi bi-plus-lg"></i> Add Subtask</b>
                        </button>
                    </div>
                </div>

                <!--
                                <div class="col-auto mb-1">
                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#nohoursmodal"><i class="bi bi-x-lg"></i></button>
                                </div>
-->

                @livewire('ongoing-tasks', ['activityid' => $activity->id, 'subtaskid' => null, 'xOngoingTasks' => 1])
                @livewire('missing-tasks', ['activityid' => $activity->id, 'subtaskid' => null, 'xMissingTasks' => 1])
                @livewire('completed-tasks', ['activityid' => $activity->id, 'subtaskid' => null, 'xCompletedTasks' =>
                0])
                @livewire('check-output')
            </div>



            <div class="col-lg-3">

                <label class="ms-3 small form-label text-secondary fw-bold">Other Activities</label>
                @livewire('in-progress-activities', ['projectid' => $project['id'], 'activityid' => $activity['id'],
                'xInProgressActivities' => 1])
                @livewire('not-started-activities', ['projectid' => $project['id'], 'activityid' => $activity['id'],
                'xNotStartedActivities' => 1])
                @livewire('past-activities', ['projectid' => $project['id'], 'activityid' => $activity['id'],
                'xPastActivities' => 0])
                @livewire('completed-activities', ['projectid' => $project['id'], 'activityid' => $activity['id'],
                'xCompletedActivities' => 0])
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="deleteActivityModal" tabindex="-1" aria-labelledby="deleteActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteActivitytModalLabel">Delete Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this activity?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="deleteActivityForm" method="get" action="{{ route('activity.delete', $activity['id']) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete Activity</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- add subtask -->
<div class="modal" id="subtask-modal" tabindex="-1" aria-labelledby="new-subtask-modal-label" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="new-subtask-modal-label">New Subtask</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="d-none" value='{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}' id="subtaskurl">
                <form id="subtaskform" data-url="{{ route('add.subtask') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="subtask-name" class="form-label">Subtask Name</label>
                        <input type="number" class="d-none" name="activitynumber" id="actid" value="{{ $activity['id'] }}">
                        <input type="text" class="form-control" id="subtaskname" name="subtaskname" placeholder="Enter Subtask">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="subtask-duedate" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="subtaskduedate" name="subtaskduedate" placeholder="Enter Due Date">
                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md rounded border border-1 btn-light shadow" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md rounded btn-gold shadow" id="createsubtask-btn">Add
                    Subtask</button>
            </div>


        </div>
    </div>
</div>

<!-- add output -->

<!--assignees details-->
<div class="modal fade" id="assigneedetails" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong></p>
                <p id="assigneename"> John Doe</p>
                <p><strong>Email:</strong></p>
                <p id="assigneeemail"> johndoe@example.com</p>
                <p><strong>Role:</strong> </p>
                <p id="assigneerole">Developer</p>
                <input type="hidden" id="assigneedataid" name="assigneedataid">
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" id="unassignassignee-dismiss" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- mark as completed -->
<div class="modal fade" id="completeactivitymodal" tabindex="-1" aria-labelledby="completeactivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completeactivityModalLabel">Complete Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="markcompleteform" data-url="{{ route('activity.markcomplete') }}">
                    @csrf
                    <input type="number" class="d-none" name="actid" value="{{ $activity['id'] }}">
                    <p> Are you sure you want to mark the Activity: "{{ $activity['actname'] }}" as completed?
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md rounded border border-1 btn-light shadow" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md rounded btn-gold shadow" id="markcomplete-btn">Mark as
                    Completed</button>
            </div>
        </div>
    </div>
</div>


<!-- no subtasks -->
<div class="modal fade" id="nohoursmodal" tabindex="-1" aria-labelledby="nohoursmodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitHoursModalLabel">Remove subtasks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove subtask panel for this activity?</p>
                <p><em>Note: Removing this panel will declare the activity as one without any subtask.</em></p>
                <form id="nosubtaskform" data-url="{{ route('set.nosubtask') }}">
                    @csrf
                    <input class="d-none" type="number" name="act-id" value="{{ $activity['id'] }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="setnosubtask-btn">Yes</button>
            </div>
        </div>
    </div>
</div>



<input class="d-none" type="number" id="actid-hrs" value="{{ $activity['id'] }}">
<input class="d-none" type="text" id="actname-hrs" value="{{ $activity['actname'] }}">

</div>
@endsection

@section('scripts')

<script>
    var url = "";
    var unassignassigneeid;
    var buttonClicked = false;


    $(document).ready(function() {
        $('#navbarDropdown').click(function() {
            // Add your function here
            $('#account .dropdown-menu').toggleClass('shows');
        });
        $(".subtoggle").toggle();
        $(document).on('click', '#toggleButton', function(event) {
            $(this).next().slideToggle("fast");
        });

        $('.step span').each(function() {
            var $span = $(this);
            if ($span.text().length > 16) { // Adjust the character limit as needed
                $span.text($span.text().substring(0, 16) + '...'); // Truncate and add ellipsis
            }
        });
        $('#activitystartDatePicker').datepicker();

        $('#activitystartDatePicker').datepicker().on('change', function(e) {
            $('#activitystartDatePicker').datepicker('hide');
        });
        $('#activityendDatePicker').datepicker();

        $('#activityendDatePicker').datepicker().on('change', function(e) {
            $('#activityendDatePicker').datepicker('hide');
        });
        $('#editOutput').click(function(event) {
            event.preventDefault();
            $('.numberInput').attr('type', 'number');
            $('.expectedoutput').hide();
            $('#saveOutput').removeClass('d-none');
            $('#cancelOutput').removeClass('d-none');
            buttonClicked = true;

            $(this).parent().parent().hide();
        });
        $('#cancelOutput').click(function(event) {
            event.preventDefault();
            $('.numberInput').attr('type', 'hidden');
            $('.expectedoutput').show();
            $('#saveOutput').addClass('d-none');
            $('#cancelOutput').addClass('d-none');
            buttonClicked = false;
            $('#editOutput').parent().parent().show();
        });
        $('#activityhours-btn').click(function(event) {
            event.preventDefault();
            var activityid = $('#actid-hrs').val();
            var activityname = $('#actname-hrs').val();

            var url = '{{ route("hours.display", ["activityid" => ":activityid"]) }}';
            url = url.replace(':activityid', activityid);

            window.location.href = url;
        });

        $('#completeactivity-btn').click(function(event) {
            event.preventDefault();
            $('#completeactivitymodal').modal('show');

        });

        $('#addBudget-btn').click(function() {
            if (!$('#tinipid').hasClass('d-none')) {
                $('#tinipid').addClass('d-none');
            }
            $('#sourceDiv').show();

            $('#budgetContainer').append(` <div class="input-group mb-1 budget-input">
                            <input type="text" class="form-control me-2" name="budgetItem[]" placeholder="Item">
                            <i class="bi bi-dash-lg pt-2"></i>
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                            <input type="number" class="form-control ms-2" min="0" name="budgetPrice[]" placeholder="Price (PhP)">
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-danger removeBudget-btn"><i class="bi bi-x-lg"></i></button>
                        </div>`);
        });
        $(document).on('click', '.removeBudget-btn', function() {
            if ($('.budget-input').length == 1) {
                $('#tinipid').removeClass('d-none');
                $('#source').val("");
                $('#sourceDiv').hide();
            }
            $(this).parent().remove();

        });
        $('#markcomplete-btn').click(function(event) {
            event.preventDefault();

            var dataurl = $('#markcompleteform').attr('data-url');
            // Create a data object with the value you want to send
            var data1 = $('#markcompleteform').serialize();

            $.ajax({
                url: dataurl, // Replace with your actual AJAX endpoint URL
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response);
                    window.location.href = url;
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    console.log(xhr.responseText);
                    console.error(error);
                }
            });
        });

        $('#setnosubtask-btn').click(function(event) {
            event.preventDefault();

            var dataurl = $('#nosubtaskform').attr('data-url');
            // Create a data object with the value you want to send
            var data1 = $('#nosubtaskform').serialize();

            $.ajax({
                url: dataurl, // Replace with your actual AJAX endpoint URL
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response.actid);
                    window.location.href = url;
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    console.log(xhr.responseText);
                    console.error(error);
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
        /*
                $(document).on('click', '.selectoutputdiv', function() {
                    if (buttonClicked) {
                        return; // Skip the handling for .selectoutputdiv
                    }
                    var outputtype = $(this).attr('data-value');
                    var actid = $('#actid').val();

                    var url =
                        '{{ route("get.output", ["activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
                    url = url.replace(':activityid', actid);
                    url = url.replace(':outputtype', outputtype);
                    window.location.href = url;
                });
        */
        $(document).on('click', '.subtaskdiv', function() {

            event.preventDefault();

            var subtaskname = $(this).attr("data-name");
            var subtaskid = $(this).attr("data-value");

            var url =
                '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);
            window.location.href = url;
        });

        $(document).on('click', '.activitydiv', function() {
            event.preventDefault();

            var activityid = $(this).attr('data-value');




            var url = '{{ route("activities.display", ["activityid" => ":activityid"]) }}';
            url = url.replace(':activityid', activityid);
            window.location.href = url;

        });

        $(document).on('click', '.checkassignee', function(event) {


            $('#assigneename').text($(this).attr('data-name'));
            $('#assigneeemail').text($(this).attr('data-email'));
            $('#assigneerole').text($(this).attr('data-role'));
            $('#assigneedataid').val($(this).attr('data-id'));
            // Open the modal or perform other actions
            $('#assigneedetails').modal('show');
        });
        $('#addExpectedOutput-btn').click(function() {

            $('#outputContainer').append(`<div class="input-group mb-1 expectedOutput-input">
                <input type="text" class="form-control" name="expectedoutput[]">
                <span class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
                <button type="button" class="btn btn-sm btn-outline-danger removeExpectedOutput-btn"><i class="bi bi-x-lg"></i></button>
            </div>`);
        });
        $(document).on('click', '.removeExpectedOutput-btn', function() {
            if ($('.expectedOutput-input').length > 1) {
                $(this).parent().remove();
            }


        });


        $(document).on('click', '.activitydiv button', function(event) {
            event.stopPropagation(); // Prevent the click event from propagating to the parent .subtaskdiv
            // Add your button click logic here
        });

        $(document).on('click', '.activitydiv .dropdown-menu', function(event) {
            event.stopPropagation();
        });
        $(document).on('click', '.checkOutput', function(event) {
            $('#checkActId').val($(this).attr('data-id'));
            $('#checkActName').text($(this).attr('data-name'));
            $('#outputCheckModal').modal('show');
        });

    });
</script>
<script src="{{ asset('js/activityindex.js') }}"></script>
@endsection