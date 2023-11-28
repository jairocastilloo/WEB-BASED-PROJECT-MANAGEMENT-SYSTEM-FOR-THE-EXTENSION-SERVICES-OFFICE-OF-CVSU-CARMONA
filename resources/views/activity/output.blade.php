@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-bottom border-top-0">
    <div class="mainnav border-bottom mb-3 shadow-sm">
        <div class="step-wrapper divhover" id="projectdiv" data-value="{{ $project->id }}" data-name="{{ $project->projecttitle }}" data-dept="{{ $project->department }}">
            <div class="step">
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
        <div class="step-wrapper">
            <div class="step highlight">
                <span class="fw-bold">Output: {{ $outputtype }}</span>
                <div class="message-box">
                    {{ $outputtype }}
                </div>
            </div>


        </div>
    </div>

    <div class="container">
        <div class="row">
            @if(count($alloutputtypes) > 0)
            <div class="col-lg-9">
                @else
                <div class="col-lg-12">
                    @endif


                    @php
                    $countAccepted = 0;

                    $submittedoutput = $submittedoutput->map(function ($contri) use (&$countAccepted) {
                    if ($contri['approval'] === null) {
                    $contri['submission_remark'] = 'For Approval';
                    } elseif ($contri['approval'] === 1) {
                    $countAccepted++;
                    $contri['submission_remark'] = 'Accepted';
                    } elseif ($contri['approval'] === 0) {
                    $contri['submission_remark'] = 'For Revision';
                    } else {
                    $contri['submission_remark'] = 'Unknown'; // Handle other cases if needed
                    }

                    return $contri;
                    });

                    $groupedSubmittedOutput = $submittedoutput->groupBy(function ($item) {
                    return $item['created_at']->format('Y-m-d H:i:s');
                    });
                    @endphp

                    <div class="basiccont word-wrap shadow" id="typeofOutput" data-value="{{ $outputtype }}">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Output</h6>
                        </div>

                        <div class="p-2">

                            <p class="lh-base fw-bold ps-3">{{ $outputtype }}</p>
                            @foreach ($currentoutputtype as $currentoutput)
                            <p class="lh-1 ps-5">{{ $currentoutput['output_name'] . ': ' . $currentoutput['totaloutput_submitted' ]}}</p>
                            @endforeach
                        </div>
                        @if ($countAccepted == 0)
                        <div class="btn-group ms-3 mb-3 shadow">
                            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" data-bs-toggle="modal" data-bs-target="#outputModal">
                                <b class="small">Submit Output</b>
                            </button>
                        </div>
                        @endif

                    </div>
                    @if (count($groupedSubmittedOutput) > 0)

                    <div class="basiccont word-wrap shadow">
                        <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">{{ $outputtype }}'s Reports</h6>
                        </div>
                        @foreach ($groupedSubmittedOutput as $date => $group)
                        <div class="p-2 pb-1 ps-3 small divhover border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="{{ $group[0]->approval }}">

                            <p class="lh-1 fw-bold @if($group[0]->submission_remark == 'For Approval') text-success @elseif($group[0]->submission_remark == 'For Revision') text-danger @else text-primary @endif"><em>
                                    {{ $group[0]->submission_remark  }}
                                </em></p>
                            @foreach ($group as $index => $item)
                            <p class="lh-1">&nbsp;&nbsp;&nbsp;{{ $outputNames[$index] . ': ' . $item['output_submitted'] }}</p>
                            <!-- Display other attributes as needed -->
                            @endforeach
                            @if ( $group[0]->notes != null)
                            <p class="lh-1"> &nbsp;&nbsp;&nbsp;<em>Notes: {{ $group[0]->notes }} </em></p>
                            @endif
                            <p class="lh-1">&nbsp;&nbsp;&nbsp;Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>
                        </div>
                        @endforeach

                    </div>
                    @endif



                </div>
                @if(count($alloutputtypes) > 0)
                <div class="col-lg-3">
                    <div class="basiccont word-wrap shadow">
                        <div class="border-bottom ps-3 pt-2 bggreen">
                            <h6 class="fw-bold small" style="color:darkgreen;">Other Outputs</h6>
                        </div>

                        @foreach ($alloutputtypes as $alloutputtype)

                        <div class="divhover selectoutputdiv p-2 ps-4" data-value="{{ $alloutputtype }}">
                            <b class="small">{{ $alloutputtype }}</b>
                        </div>

                        @endforeach

                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="outputModal" tabindex="-1" aria-labelledby="outputModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="outputModalLabel">Output Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addtooutputform" data-url="{{ route('addto.output') }}">
                    @csrf
                    <!-- Modal Body -->
                    <div class="modal-body">


                        <input type="number" class="d-none" id="outputnumber" name="outputnumber">
                        <input type="number" class="d-none" id="facilitatornumber" name="facilitatornumber">
                        <input type="number" class="d-none" id="output-facilitator-0" name="output-facilitator[0]">
                        @foreach ($currentoutputtype as $currentoutput)
                        <div class="mb-3">
                            <label class="form-label">{{ $currentoutput['output_name'] }}:</label>
                            <input type="number" class="d-none" id="output-id" name="output-id[]" value="{{ $currentoutput['id'] }}">
                            <input type="number" class="form-control" id="output-quantity" name="output-quantity[]" placeholder="Enter the quantity" min="0" step="1">
                        </div>
                        @endforeach

                        <!--
                <div class="border-bottom pt-2 ps-4 pe-4">
                    <h6 class="small" style="color:darkgreen;">
                        <b>Facilitator Involved</b>

                    </h6>
                    <div class="row p-1 assignees-name">

                    </div>
                    <div class="btn-group ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addfacilitator-btn">
                            <b class="small">Add Facilitator</b>
                        </button>
                    </div>

                </div> -->
                        <div class="mb-3">



                            <label class="form-label" for="customFile">Submit Activity Report:</label>
                            <!-- <form method="POST" action="{{ route('upload.file') }}" enctype="multipart/form-data" id="addtooutputform2">
                        @csrf-->
                            <input type="file" class="form-control" id="customFile" accept=".docx" name="outputdocs">

                            <!--  <button type="button" class="btn btn-outline-primary mt-2" id="submitreport2">Submit Report</button> -->


                        </div>


                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <!-- Close button -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- Submit button -->
                        <button type="button" class="btn btn-primary fw-bold" id="submitreport-btn" data-value="{{ $outputtype }}">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection

    @section('scripts')
    <script>
        var url = "";
        $(document).ready(function() {
            $('.step span').each(function() {
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

            $('.step span').each(function() {
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

            $(document).on('click', '.outputsubmitteddiv', function() {
                var submittedoutputid = $(this).attr('data-value');
                var approval = $(this).attr('data-approval');
                var outputtype = $('#typeofOutput').attr('data-value');

                var submission;

                if (approval === "") {
                    submission = "For Approval";
                } else if (approval == 0) {
                    submission = "For Revision";
                } else if (approval == 1) {
                    submission = "Accepted";
                }

                outputtype = outputtype.replace(' ', '-');
                var url = '{{ route("submittedoutput.display", ["submittedoutputid" => ":submittedoutputid", "outputtype" => ":outputtype", "submissionname" => ":approval"]) }}';
                url = url.replace(':submittedoutputid', submittedoutputid);
                url = url.replace(':outputtype', outputtype);
                url = url.replace(':approval', submission);
                window.location.href = url;
            });
            $(document).on('click', '.selectoutputdiv', function() {
                var outputtype = $(this).attr('data-value');
                var actid = $('#activitydiv').attr('data-value')

                var url = '{{ route("get.output", ["activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
                url = url.replace(':activityid', actid);
                url = url.replace(':outputtype', outputtype);
                window.location.href = url;
            });
            $('#submitoutput-btn').click(function(event) {
                event.preventDefault();
                var outputtype = $(this).closest('[data-value]').attr('data-value');

                var actid = $('#activitydiv').attr('data-value')

                var url = '{{ route("comply.output", ["activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
                url = url.replace(':activityid', actid);
                url = url.replace(':outputtype', outputtype);
                window.location.href = url;
            });

            $('#submitreport-btn').click(function(event) {
                event.preventDefault();
                var outputtype = $(this).attr('data-value');
                var actid = $('#activitydiv').attr('data-value');

                var url = '{{ route("submittedoutput.display", ["submittedoutputid" => ":submittedoutputid", "outputtype" => ":outputtype", "submissionname" => "For Evaluation"]) }}';

                url = url.replace(':outputtype', outputtype);


                $("#outputnumber").val($('input[name="output-quantity[]"]').length);
                //$("#facilitatornumber").val($('input[name^="output-facilitator["][name$="]"]').length);
                $('input[name="output-id[]"]').each(function(index) {
                    $(this).attr('name', 'output-id[' + index + ']');
                });
                $('input[name="output-quantity[]"]').each(function(index) {
                    $(this).attr('name', 'output-quantity[' + index + ']');
                });
                var dataurl = $('#addtooutputform').attr('data-url');
                var formData = new FormData($("#addtooutputform")[0]);
                // Serialize the input data
                /**  
                 var data1 = $('#addtooutputform').serialize();
                 var formData = new FormData($("#myForm")[0]);*/
                // Create FormData object for file data


                // Append file data to the serialized form data


                // Send data via AJAX


                $.ajax({
                    url: dataurl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        url = url.replace(':submittedoutputid', response.redirectId);
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