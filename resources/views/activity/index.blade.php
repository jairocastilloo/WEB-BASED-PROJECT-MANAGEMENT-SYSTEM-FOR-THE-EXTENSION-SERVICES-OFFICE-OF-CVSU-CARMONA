@extends('layouts.app')

@section('content')

<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}">
            <h6><b>Project: {{ $projectName }} </b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Activity</b></h6>
        </div>


    </div>
    <div class="container">

        <div class="row">
            <div class="col-8">

                <div class="basiccont">
                    <div class="border-bottom ps-3">
                        <h6 class="fw-bold small">Activity</h6>
                    </div>
                    <h5><b>{{ $activity['actname'] }}</b></h5>
                    Expected Output: {{ $activity['actoutput'] }} <br>
                    Objectives:
                    @foreach ($objectives as $objective)
                    {{ $objective['name'] }} </br>
                    @endforeach
                    Start Date: {{ $activity['actstartdate'] }} <br>
                    End Date: {{ $activity['actenddate'] }} <br>
                    Budget: {{ $activity['actbudget'] }} <br>
                    Source: {{ $activity['actsource'] }} <br>
                    <div class="border-bottom d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary stretch-button">Edit Activity</button>
                    </div>

                </div>

                <div class="basiccont">
                    <div class="border-bottom ps-3">
                        <h6 class="fw-bold small">Assignees</h6>
                    </div>
                    @php $count = 0; @endphp
                    <form id="unassignassigneeform" data-url="{{ route('unassign.assignee') }}">
                        @csrf
                        <input type="number" id="unassignassigneeid" name="unassignassigneeid" class="d-none">
                        <input type="number" id="unassignactivityid" name="unassignactivityid" class="d-none" value="{{ $activity['id'] }}">
                    </form>
                    @foreach ($assignees as $key=> $assignee)
                    @if ($count % 2 == 0)
                    <div class="row p-0">
                        @endif
                        <div class="col border-bottom m-2 p-2 divhover checkassignee" value="{{ $assignee->id }}">

                            {{ $assignee->name . ' ' . $assignee->last_name }}
                        </div>
                        @if ($count % 2 == 1 || $loop->last)
                    </div>
                    @endif
                    @php $count++; @endphp
                    @endforeach

                    <div class="border-bottom d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary stretch-button addassignees-btn">Add Assignees</button>
                    </div>
                </div>
                <div class="basiccont">
                    <div class="border-bottom ps-3">
                        <h6 class="fw-bold small">Output</h6>
                    </div>
                    @php
                    $outputarray = ['Capacity Building', 'IEC Material', 'Advisory Services', 'Others'];
                    @endphp
                    @foreach ($outputTypes as $outputType)
                    <div class="border-bottom p-2 divhover">
                        @php
                        $outputarray = array_diff($outputarray, [$outputType]);
                        @endphp
                        <h5>{{ $outputType }}:</h5>
                        @foreach ($outputs as $output)
                        @if ($output->output_type === $outputType)
                        {{ $output->output_name }} <br>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                    <div class="border-bottom d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary stretch-button addoutput-btn">Add Output</button>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="basiccont">
                    <div class="border-bottom ps-3">
                        <h6 class="fw-bold small">Subtasks</h6>
                    </div>
                    <ul class="list-unstyled" id="subtask">
                        @foreach ($subtasks as $subtask)
                        <li class="p-2 border-bottom">{{ $subtask->subtask_name }}</li>
                        @endforeach
                    </ul>
                    <div class="border-bottom d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary stretch-button addsubtask-btn">Add Subtask</button>
                    </div>
                </div>

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

                <form id="subtaskform" data-url="{{ route('add.subtask') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="subtask-name" class="form-label">Subtask Name</label>
                        <input type="number" class="d-none" name="activitynumber" id="actid" value="{{ $activity['id'] }}">
                        <input type="text" class="form-control" id="subtaskname" name="subtaskname" placeholder="Enter Subtask">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="createsubtask-btn">Add Subtask</button>
            </div>


        </div>
    </div>
</div>
<!--add activity assignees-->
<div class="modal fade" id="addAssigneeModal" tabindex="-1" aria-labelledby="addAssigneeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssigneeModalLabel">Add Assignee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assigneeform" data-url="{{ route('add.assignee') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="assigneeSelect" class="form-label">Assignee</label>
                        <input type="number" class="d-none" name="assigneeactnumber" value="{{ $activity['id'] }}">
                        <select class="form-select" id="assigneeselect" name="assigneeselect">
                            <option value="" selected disabled>Select Assignee</option>
                            @foreach($addassignees as $assignee)

                            <option value="{{ $assignee->id }}">{{ $assignee->name . ' ' . $assignee->last_name }}</option>
                            @endforeach
                        </select>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="addassignee-btn">Add Assignee</button>
            </div>
        </div>
    </div>
</div>
<!-- add output -->
<div class="modal fade" id="addoutputmodal" tabindex="-1" aria-labelledby="addoutputmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssigneeModalLabel">Add Output</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="outputform" data-url="{{ route('add.output') }}">
                    @csrf
                    <input type="number" class="d-none" name="outputactnumber" value="{{ $activity['id'] }}">
                    <input type="number" class="d-none" name="outputindex" id="outputindex">
                    <div class="mb-3">
                        <label for="assigneeSelect" class="form-label">Select the type of output to be submitted.</label>
                        <select class="form-select" id="outputtype-select" name="outputtype">
                            <option value="" selected disabled>Select Output Type</option>
                            @foreach($outputarray as $outputarr)
                            <option value="{{ $outputarr }}">{{ $outputarr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="form-label">Output</label>

                    <div class="divhover pt-2 pb-1 ps-1 outputnamediv d-none">
                        <h6></h6>
                    </div>
                    <div class="row divhover p-2 mt-1 ps-1 outputinputdiv d-none">
                        <div class="col-9">
                            <input type="text" class="form-control w-100" name="newoutput[]" id="output-input">
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-danger btn-sm removeoutput-btn">Remove</button>
                        </div>

                    </div>


                </form>
                <div class="w-60">
                    <button type="button" class="btn btn-success addmoreoutput-btn btn-sm d-none"> Add more Output </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="createoutput-btn">Add Output</button>
            </div>
        </div>
    </div>
</div>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" id="unassignassignee-btn">Unassign</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    var url = "";
    var unassignassigneeid;
    var assignees = <?php echo json_encode($assignees) ?>;
    $(document).ready(function() {

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');

            url = '{{ route("get.objectives", ["id" => Auth::user()->id, "projectid" => ":projectid"]) }}';
            url = url.replace(':projectid', projectid);
            window.location.href = url;
        });

        $(document).on('change', '#outputtype-select', function(event) {
            var selectedOutputType = $(this).val();

            $('.addmoreoutput-btn').removeClass("d-none");
            // Remove existing elements except the first one
            $('#outputform .outputnamediv:not(:first)').remove();
            $('#outputform .outputinputdiv:not(:first)').remove();
            $('.outputnamediv:first').removeClass('d-none');
            $('.outputinputdiv:first').addClass('d-none');
            if (selectedOutputType === "Capacity Building") {
                var divtoadd = `<div class="divhover pt-2 pb-1 ps-1 outputnamediv">
            <h6>Number of Training</h6>
        </div>
        <div class="row divhover p-2 mt-1 ps-1 outputinputdiv d-none">
            <div class="col-9">
                <input type="text" class="form-control w-100" name="newoutput[]" id="output-input">
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-danger btn-sm removeoutput-btn">Remove</button>
            </div>
        </div>`;

                $('.outputnamediv:first h6').text("Number of trainees");
                $('#outputform').append(divtoadd);
            } else if (selectedOutputType === "IEC Material") {
                var divtoadd = `<div class="divhover pt-2 pb-1 ps-1 outputnamediv">
            <h6>Number of IEC Material</h6>   
        </div>
        <div class="row divhover p-2 mt-1 ps-1 outputinputdiv d-none">
            <div class="col-9">
                <input type="text" class="form-control w-100" name="newoutput[]" id="output-input">
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-danger btn-sm" id="removeoutput-btn">Remove</button>
            </div>
        </div>`;

                $('.outputnamediv:first h6').text("Number of Recipients");
                $('#outputform').append(divtoadd);
            } else if (selectedOutputType === "Advisory Services") {
                $('.outputnamediv:first h6').text("Number of Recipients");
            } else if (selectedOutputType === "Others") {
                $('.outputnamediv:first h6').text("Untitled Output");
            }

            $('.outputinputdiv input').each(function() {
                var input = $(this);
                var parentDiv = input.closest('.outputinputdiv');
                var value = parentDiv.prev().find("h6").text();
                input.val(value);
            });
        });

        $(document).on('click', '.outputnamediv', function() {

            $(this).addClass("d-none");
            //$(this).next().find("input").val($(this).find("h6").text());
            $(this).next().removeClass("d-none");
            $(this).next().find("input").focus();
        });

        $(document).on('click', '.removeoutput-btn', function() {
            var parentElement = $(this).parent().parent();
            parentElement.prev().remove();
            parentElement.remove();
        });

        $('.addmoreoutput-btn').click(function(event) {
            event.preventDefault();

            var divtoadd = `<div class="divhover pt-2 pb-1 ps-1 outputnamediv">
      <h6>Untitled Output</h6>
    </div>
    <div class="row divhover p-2 mt-1 ps-1 outputinputdiv d-none">
      <div class="col-9">
        <input type="text" class="form-control w-100" name="newoutput[]" id="output-input">
      </div>
      <div class="col-3">
        <button type="button" class="btn btn-danger btn-sm" id="removeoutput-btn">Remove</button>
      </div>
    </div>`;

            $('#outputform').append(divtoadd);
            $('#outputform').find('.outputnamediv:last').next('.outputinputdiv').find('input').val($('.outputnamediv:last h6').text());
        });

        $(document).on('keydown', '.outputinputdiv input', function(event) {
            if (event.which === 13) {
                event.preventDefault();
                var $outputDiv = $(this).closest('.outputinputdiv').prev();
                $outputDiv.find("h6").text($(this).val());
                $outputDiv.removeClass("d-none");
                $(this).closest('.outputinputdiv').addClass("d-none");
            }
        });
        $(document).on('focus', '.outputinputdiv input', function(event) {
            var isClicked = false;

            $(document).on('click', function() {
                isClicked = true;
            });

            $(this).on('blur', function() {
                if (!isClicked) {
                    event.preventDefault();
                    if ($(this).val() === "") {
                        $(this).val("Untitled Output");
                    }
                    var $outputDiv = $(this).closest('.outputinputdiv').prev();
                    $outputDiv.find("h6").text($(this).val());
                    $outputDiv.removeClass("d-none");
                    $(this).closest('.outputinputdiv').addClass("d-none");
                }
            });
        });
        $(document).on('click select', '.outputinputdiv input', function(event) {
            $(this).focus();
        });

        $(document).on('click', '.checkassignee', function(event) {
            unassignassigneeid = $(this).attr('value');
            var name, email, role;

            // Find the assignee object with the matching ID
            var assignee = assignees.find(function(assignee) {
                return assignee.id == unassignassigneeid;
            });

            // Check if the assignee object exists
            if (assignee) {
                name = assignee.name + " " + assignee.last_name;
                email = assignee.email;
                role = assignee.role;
            }

            $('#assigneename').text(name);
            $('#assigneeemail').text(email);
            $('#assigneerole').text(role);

            // Open the modal or perform other actions
            $('#assigneedetails').modal('show');
        });

        $('.addsubtask-btn').click(function(event) {
            event.preventDefault();
            $('#subtask-modal').modal('show');
        });

        $('.addassignees-btn').click(function(event) {
            event.preventDefault();
            $('#addAssigneeModal').modal('show');
        });
        $('.addoutput-btn').click(function(event) {
            event.preventDefault();
            $('#addoutputmodal').modal('show');
        });
        $('#createsubtask-btn').click(function(event) {
            event.preventDefault();


            var dataurl = $('#subtaskform').attr('data-url');
            var data1 = $('#subtaskform').serialize();


            // send data via AJAX
            $.ajax({
                url: dataurl,
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response);
                    window.location.href = url;

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);

                }
            });
        });
        $('#addassignee-btn').click(function(event) {

            event.preventDefault();


            var dataurl = $('#assigneeform').attr('data-url');
            var data1 = $('#assigneeform').serialize();


            // send data via AJAX
            $.ajax({
                url: dataurl,
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response);
                    window.location.href = url;

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);

                }
            });

        });

        $('#createoutput-btn').click((event) => {
            event.preventDefault();


            var outputindex = $('input[name="newoutput[]"]').length;

            // Iterate over each select element and set its name attribute



            $('input[name="newoutput[]"]').each(function(index) {
                $(this).attr('name', 'newoutput[' + index + ']');
            });

            $('#outputindex').val(outputindex);

            var dataurl = $('#outputform').attr('data-url');
            var data1 = $('#outputform').serialize();

            // send data via AJAX
            $.ajax({
                url: dataurl,
                type: 'POST',
                data: data1,
                success: function(response) {
                    console.log(response);
                    window.location.href = url;

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);

                }
            });

        });
        $('#unassignassignee-btn').click(function(event) {
            event.preventDefault();

            $('#unassignassigneeid').val(unassignassigneeid);
            var dataurl = $('#unassignassigneeform').attr('data-url');
            var data = $('#unassignassigneeform').serialize();

            $.ajax({
                url: dataurl,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    window.location.href = url;
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);
                }
            });
        });

    });
</script>

@endsection