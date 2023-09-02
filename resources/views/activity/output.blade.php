@extends('layouts.app')

@section('content')

<div class="maincontainer">
    <div class="mainnav mb-2 shadow">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv" data-name="{{ $activity['actname'] }}">
            <input type="number" class="d-none" id="actid" value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Output: {{ $outputtype }} </b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-8">
                @php

                $unevaluatedSubmittedOutput = $submittedoutput->filter(function ($suboutput) {
                return $suboutput['approval'] === null;
                });
                $acceptedSubmittedOutput = $submittedoutput->filter(function ($suboutput) {
                return $suboutput['approval'] === 1;
                });
                $rejectedSubmittedOutput = $submittedoutput->filter(function ($suboutput) {
                return $suboutput['approval'] === 0;
                });

                $groupedUnevaluatedSubmittedOutput = $unevaluatedSubmittedOutput->groupBy(function ($item) {
                return $item['created_at']->format('Y-m-d H:i:s');
                });
                $groupedAcceptedSubmittedOutput = $acceptedSubmittedOutput->groupBy(function ($item) {
                return $item['created_at']->format('Y-m-d H:i:s');
                });
                $groupedRejectedSubmittedOutput = $rejectedSubmittedOutput->groupBy(function ($item) {
                return $item['created_at']->format('Y-m-d H:i:s');
                });

                @endphp
                <div class="basiccont word-wrap shadow ms-2 mt-4" id="typeofOutput" data-value="{{ $outputtype }}">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Output Submitted</h6>
                    </div>

                    <div class="p-2">

                        <p class="lh-base fw-bold ps-3">{{ $outputtype }}</p>
                        @foreach ($currentoutputtype as $currentoutput)
                        <p class="lh-1 ps-5">{{ $currentoutput['output_name'] . ': ' . $currentoutput['totaloutput_submitted' ]}}</p>
                        @endforeach
                    </div>

                    <div class="btn-group ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="editoutput-btn">
                            <b class="small">Edit Details</b>
                        </button>
                    </div>

                    <div class="btn-group ms-3 mb-3 shadow">
                        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="submitoutput-btn">
                            <b class="small">Submit Output</b>
                        </button>
                    </div>

                </div>

                @if($submittedoutput->isEmpty())
                <div class="basiccont word-wrap shadow ms-2 mt-4">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Submitted Output</h6>
                    </div>
                    <div class="text-center p-4">
                        <h4><em>No Submitted Output Yet.</em></h4>
                    </div>
                </div>
                @endif

                @if (count($unevaluatedSubmittedOutput) > 0)

                <div class="basiccont word-wrap shadow ms-2 mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Submission</h6>
                    </div>
                    @foreach ($groupedUnevaluatedSubmittedOutput as $date => $group)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="Unevaluated-Submission">
                        <p class="lh-1 fw-bold">Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>

                        @foreach ($group as $index => $item)
                        <p class="lh-1 ps-4"> {{ $outputNames[$index] . ': ' . $item['output_submitted'] }}</p>
                        <!-- Display other attributes as needed -->
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @endif

                @if (count($acceptedSubmittedOutput) > 0)

                <div class="basiccont word-wrap shadow ms-2 mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Accepted Submission</h6>
                    </div>
                    @foreach ($groupedAcceptedSubmittedOutput as $date => $group)
                    <div class="p-2 pb-1 ps-4 divhover small border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="Accepted-Submission">
                        <p class="lh-1 fw-bold">Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>

                        @foreach ($group as $index => $item)
                        <p class="lh-1 ps-4"> {{ $outputNames[$index] . ': ' . $item['output_submitted'] }}</p>
                        <!-- Display other attributes as needed -->
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @endif

                @if (count($rejectedSubmittedOutput) > 0)

                <div class="basiccont word-wrap shadow ms-2 mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Rejected Submission</h6>
                    </div>
                    @foreach ($groupedRejectedSubmittedOutput as $date => $group)
                    <div class="p-2 pb-1 ps-4 divhover small border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="Rejected-Submission">
                        <p class="lh-1 fw-bold">Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>

                        @foreach ($group as $index => $item)
                        <p class="lh-1 ps-4"> {{ $outputNames[$index] . ': ' . $item['output_submitted'] }}</p>
                        <!-- Display other attributes as needed -->
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @endif
            </div>
            <div class="col-4">
                <div class="basiccont word-wrap shadow mt-4 me-2">
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

        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    var url = "";
    $(document).ready(function() {

        $('#navbarDropdown').click(function(event) {
            // Add your function here
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
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
        $(document).on('click', '.outputsubmitteddiv', function() {
            var submittedoutputid = $(this).attr('data-value');
            var approval = $(this).attr('data-approval');
            var outputtype = $('#typeofOutput').attr('data-value');
            outputtype = outputtype.replace(' ', '-');
            var url = '{{ route("submittedoutput.display", ["submittedoutputid" => ":submittedoutputid", "outputtype" => ":outputtype", "submissionname" => ":approval"]) }}';
            url = url.replace(':submittedoutputid', submittedoutputid);
            url = url.replace(':outputtype', outputtype);
            url = url.replace(':approval', approval);
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
        $('#submitoutput-btn').click(function(event) {
            event.preventDefault();
            var outputtype = $(this).closest('[data-value]').attr('data-value');

            var actid = $('#actid').val();

            var url = '{{ route("comply.output", ["activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);
            window.location.href = url;
        });
        $('#activitydiv').click(function(event) {

            event.preventDefault();

            var actid = $('#actid').val();
            var activityname = $(this).attr('data-name');
            var department = $('#department').val();

            var url = '{{ route("activities.display", ["activityid" => ":activityid", "department" => ":department", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':department', department);
            url = url.replace(':activityname', activityname);
            window.location.href = url;
        });
        $(document).on('click', '.acceptoutput-btn', function() {
            var acceptIdsValue = $(this).prev().val();
            var dataurl = $(this).parent().attr('data-url');
            // Create a data object with the value you want to send
            var data1 = $(this).parent().serialize();

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
    });
</script>
@endsection