@extends('layouts.app')

@section('content')

<input class="d-none" type="date" value="{{ $activity['actstartdate'] }}" id="actsavestartdate">
<input class="d-none" type="date" value="{{ $activity['actenddate'] }}" id="actsaveenddate">
<div class="maincontainer shadow">
    <div class="mainnav mb-2 shadow">
        <div class="word-wrap col-4 p-2 pt-3 border-end text-center mainnavpassive longword" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <b class="small">Project: {{ $projectName }} </b>
        </div>
        <div class="word-wrap col-4 p-2 pt-3 border-end text-center position-triangle longword">
            <b class="small">Activity: {{ $activity['actname'] }}</b>
        </div>


    </div>
    <div class="container">

        <div class="row">
            @if ($activity['subtask'] == 1)
            <div class="col-lg-6">
                @elseif ($activity['subtask'] == 0)
                <div class="col-lg-10">
                    @endif
                    <div class="basiccont word-wrap shadow mt-2">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Activity</h6>
                        </div>
                        @livewire('activity-details', [ 'activity' => $activity, 'objectives' => $objectives ])

                    </div>


                    <div class="basiccont word-wrap shadow mt-2">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Output</h6>
                        </div>
                        @php
                        $outputarray = ['Capacity Building', 'IEC Material', 'Advisory Services', 'Others'];
                        @endphp
                        @foreach ($outputTypes as $outputType)
                        <div class="border-bottom p-2 divhover selectoutputdiv small" data-value="{{ $outputType }}">
                            @php
                            $outputarray = array_diff($outputarray, [$outputType]);
                            @endphp
                            <p class="lh-base fw-bold ps-3">{{ $outputType }}</p>
                            @foreach ($outputs as $output)
                            @if ($output->output_type === $outputType)
                            <p class="lh-1 ps-5">{{ $output->output_name . ': ' .  $output->totaloutput_submitted }}</p>
                            @endif
                            @endforeach
                        </div>
                        @endforeach

                        <div class="btn-group ms-3 mt-2 mb-3 shadow">
                            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow addoutput-btn">
                                <b class="small">Add Output</b>
                            </button>
                        </div>
                    </div>
                    @livewire('activity-assignees', ['activity' => $activity, 'projectName' => $projectName ])
                </div>
                @if ($activity['subtask'] == 1)

                <div class="col-lg-4">
                    <div class="basiccont word-wrap shadow mt-2">
                        <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                            <div class="row">
                                <div class="col">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Subtasks</h6>
                                </div>
                                @if ($subtasks->count() == 0)
                                <div class="col-auto mb-1">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#nohoursmodal">x</button>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if ($subtasks->count() == 0)



                        <div class="text-center p-4 pb-2">
                            <h4><em>No Added Subtask Yet.</em></h4>
                        </div>

                        @else

                        @foreach ($subtasks as $subtask)

                        <div class="divhover p-3 pe-2 ps-4 subtaskdiv border-bottom" data-value="{{ $subtask->id }}" data-name="{{ $subtask->subtask_name }}">
                            <p class="lh-1">Name: {{ $subtask->subtask_name }}</p>
                            <p class="lh-1">Due Date: {{ $subtask->subduedate }}</p>
                        </div>

                        @endforeach

                        @endif


                        <div class="btn-group ms-3 mt-2 mb-3 shadow">
                            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow addsubtask-btn">
                                <b class="small">Add Subtask</b>
                            </button>
                        </div>
                    </div>

                </div>

                @endif

                <div class="col-lg-2">


                    @php
                    // Sort the $activities array by actstartdate in ascending order
                    $sortedActivities = $activities->sortBy('actstartdate');

                    $inProgressActivities = $sortedActivities->filter(function ($act) {
                    return $act['actremark'] === 'In Progress';
                    });
                    $pendingActivities = $sortedActivities->filter(function ($act) {
                    return $act['actremark'] === 'Pending';
                    });
                    $scheduledActivities = $sortedActivities->filter(function ($act) {
                    return $act['actremark'] === 'Scheduled';
                    });
                    $overdueActivities = $sortedActivities->filter(function ($act) {
                    return $act['actremark'] === 'Overdue';
                    });
                    $completedActivities = $sortedActivities->filter(function ($act) {
                    return $act['actremark'] === 'Completed';
                    });
                    @endphp
                    @if($activities->isEmpty())
                    <div class="basiccont word-wrap shadow mt-2">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Activities</h6>
                        </div>
                        <div class="text-center p-4">
                            <h4><em>No Other Activities Yet.</em></h4>
                        </div>
                    </div>
                    @endif
                    @if ($inProgressActivities && count($inProgressActivities) > 0)

                    <div class="basiccont word-wrap shadow mt-2">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">In Progress Activities</h6>
                        </div>
                        @foreach ($inProgressActivities as $act)
                        <div class="border-bottom ps-4 p-2 divhover actdiv" data-value="{{ $act['id'] }}" data-name="{{ $act->actname }}">

                            <h6 class="fw-bold small">{{ $act['actname'] }}</h6>

                            @php
                            $startDate = date('M d, Y', strtotime($act['actstartdate']));
                            $endDate = date('M d, Y', strtotime($act['actenddate']));
                            @endphp

                            <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if ($pendingActivities && count($pendingActivities) > 0)

                    <div class="basiccont word-wrap shadow mt-2">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Pending Activities</h6>
                        </div>
                        @foreach ($pendingActivities as $act)
                        <div class="border-bottom ps-4 p-2 divhover actdiv" data-value="{{ $act['id'] }}" data-name="{{ $act->actname }}">
                            <h6 class="fw-bold small">{{ $act['actname'] }}</h6>

                            @php
                            $startDate = date('M d, Y', strtotime($act['actstartdate']));
                            $endDate = date('M d, Y', strtotime($act['actenddate']));
                            @endphp

                            <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                        </div>
                        @endforeach
                    </div>

                    @endif
                    @if ($scheduledActivities && count($scheduledActivities) > 0)
                    <div class="basiccont word-wrap shadow mt-2">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Scheduled Activities</h6>
                        </div>
                        @foreach ($scheduledActivities as $act)
                        <div class="border-bottom ps-4 p-2 divhover actdiv" data-value="{{ $act['id'] }}" data-name="{{ $act->actname }}">

                            <h6 class="fw-bold small">{{ $act['actname'] }}</h6>

                            @php
                            $startDate = date('M d, Y', strtotime($act['actstartdate']));
                            $endDate = date('M d, Y', strtotime($act['actenddate']));
                            @endphp

                            <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if ($overdueActivities && count($overdueActivities) > 0)

                    <div class="basiccont word-wrap shadow mt-2">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Overdue Activities</h6>
                        </div>
                        @foreach ($overdueActivities as $act)
                        <div class="border-bottom ps-4 p-2 divhover actdiv" data-value="{{ $act['id'] }}" data-name="{{ $act->actname }}">

                            <h6 class="fw-bold small">{{ $act['actname'] }}</h6>

                            @php
                            $startDate = date('M d, Y', strtotime($act['actstartdate']));
                            $endDate = date('M d, Y', strtotime($act['actenddate']));
                            @endphp

                            <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if ($completedActivities && count($completedActivities) > 0)
                    <div class="basiccont word-wrap shadow mt-2">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Completed Activities</h6>
                        </div>
                        @foreach ($completedActivities as $act)
                        <div class="border-bottom ps-4 p-2 divhover actdiv" data-value="{{ $act['id'] }}" data-name="{{ $act->actname }}">

                            <h6 class="fw-bold small">{{ $act['actname'] }}</h6>

                            @php
                            $startDate = date('M d, Y', strtotime($act['actstartdate']));
                            $endDate = date('M d, Y', strtotime($act['actenddate']));
                            @endphp

                            <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
                        </div>
                        @endforeach
                    </div>
                    @endif

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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="createsubtask-btn">Add Subtask</button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="markcomplete-btn">Mark as Completed</button>
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

    $(document).ready(function() {

        $('#activityhours-btn').click(function(event) {
            event.preventDefault();
            var activityid = $('#actid-hrs').val();
            var activityname = $('#actname-hrs').val();


            var url = '{{ route("hours.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':activityname', activityname);


            window.location.href = url;
        });

        $('#completeactivity-btn').click(function(event) {
            event.preventDefault();
            $('#completeactivitymodal').modal('show');

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
            var projectname = $(this).attr('data-name');
            var department = $('#department').val();


            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department", "projectname" => ":projectname"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));
            url = url.replace(':projectname', encodeURIComponent(projectname));
            window.location.href = url;
        });

        $(document).on('click', '.selectoutputdiv', function() {
            var outputtype = $(this).attr('data-value');
            var actid = $('#actid').val();

            var url = '{{ route("get.output", ["activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);
            window.location.href = url;
        });

        $(document).on('click', '.subtaskdiv', function() {

            event.preventDefault();

            var subtaskname = $(this).attr("data-name");
            var subtaskid = $(this).attr("data-value");

            var url = '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);
            window.location.href = url;
        });

        $(document).on('click', '.actdiv', function() {
            event.preventDefault();

            var activityid = $(this).attr('data-value');
            var activityname = $(this).attr('data-name');
            var department = $('#department').val();



            var url = '{{ route("activities.display", ["activityid" => ":activityid", "department" => ":department", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':department', department);
            url = url.replace(':activityname', activityname);
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
    });
</script>
<script src="{{ asset('js/activityindex.js') }}"></script>
@endsection