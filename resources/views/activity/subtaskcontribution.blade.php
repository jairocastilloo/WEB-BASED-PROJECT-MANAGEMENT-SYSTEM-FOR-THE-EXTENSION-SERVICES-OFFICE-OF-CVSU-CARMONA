@extends('layouts.app')

@section('content')
<div class="maincontainer shadow">
    <div class="mainnav mb-2 shadow">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv" data-name="{{ $activity['actname'] }}">
            <input type="number" class="d-none" id="actid" value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive">
            <input type="hidden" id="subid" value="{{ $subtask['id'] }}">
            <input type="hidden" id="subname" value="{{ $subtask['subtask_name'] }}">
            <h6><b>Subtask: {{ $subtask['subtask_name'] }}</b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="basiccont word-wrap shadow ms-2 mt-4" data-id="{{ $contribution->id }}" data-approval="{{ $contribution->approval }}">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofsubmission }}</h6>
                    </div>

                    <div class="p-2">
                        <p class="ps-4 lh-1 pt-2"><b>Subtask Name: {{ $subtask['subtask_name'] }}</b></p>
                        <p class="lh-1 ps-4"> <b>Submitted Hours Rendered: {{ $contribution->hours_rendered }}</b></p>
                        <p class="lh-1 ps-5"> Rendered Date: {{ \Carbon\Carbon::parse($contribution->date)->format('F d, Y') }} </p>

                        <p class="lh-1 ps-5"> Contributors:
                            @foreach($contributors as $contributor)
                            {{ $contributor->name . ' ' . $contributor->last_name . ' | ' }}
                            @endforeach
                        </p>
                        <p class="lh-1 ps-5"> Submitted in: {{ \Carbon\Carbon::parse($contribution->created_at)->format('F d, Y') }} </p>
                        @if($submitter)
                        <p class="lh-1 ps-5"> Submitted by: {{ $submitter[0]->name . ' ' . $submitter[0]->last_name }} </p>
                        @endif
                        <p class="lh-1 ps-5">Submission Attachment:</p>
                        <div class="mb-2 text-center">
                            <a href="{{ route('download.file', ['contributionid' => $contribution->id, 'filename' => basename($uploadedFiles[0])]) }}" class="btn btn-outline-success shadow rounded w-50">
                                <i class="bi bi-file-earmark-arrow-down-fill me-2 fs-3"></i><b>{{ basename($uploadedFiles[0]) }}</b>

                            </a>

                        </div>

                        @if( $contribution['approval'] != 1)
                        <div class="btn-group dropdown ms-3 mb-3 mt-2 shadow">
                            <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b class="small">Evaluate Submission</b>
                            </button>
                            <div class="dropdown-menu">
                                <form id="accepthoursform" data-url="{{ route('hours.accept') }}">
                                    @csrf
                                    <input type="text" class="d-none" value="{{ $contribution->id }}" name="acceptids" id="acceptids">
                                    <input type="hidden" name="isApprove" id="isApprove">
                                    <a class="dropdown-item small hrefnav accept-link" href="#"><b class="small">Accept</b></a>
                                    <a class="dropdown-item small hrefnav reject-link" href="#"><b class="small">Reject</b></a>
                                </form>

                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-sm-4">
                @php
                // Sort the $activities array by actstartdate in ascending order


                $unevaluatedSubmission = $othercontribution->filter(function ($contri) {
                return $contri['approval'] === null;
                });
                $acceptedSubmission = $othercontribution->filter(function ($contri) {
                return $contri['approval'] === 1;
                });
                $rejectedSubmission = $othercontribution->filter(function ($contri) {
                return $contri['approval'] === 0;
                });

                @endphp
                @if($othercontribution->isEmpty())
                <div class="basiccont word-wrap shadow mt-4 me-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Other Contribution</h6>
                    </div>
                    <div class="text-center p-4">
                        <h4><em>No Other Submission Yet.</em></h4>
                    </div>
                </div>
                @endif

                @if (count($unevaluatedSubmission) > 0)

                <div class="basiccont word-wrap shadow mt-4 me-2">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Submission</h6>
                    </div>
                    @foreach ($unevaluatedSubmission as $submission)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom submission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
                        <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->date)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-4"> Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>

                    </div>

                    @endforeach
                </div>
                @endif
                @if (count($acceptedSubmission) > 0)

                <div class="basiccont word-wrap shadow mt-4 me-2">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Accepted Submission</h6>
                    </div>
                    @foreach ($acceptedSubmission as $submission)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom submission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
                        <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->date)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-4"> Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>

                    </div>
                    @endforeach
                </div>
                @endif
                @if (count($rejectedSubmission) > 0)

                <div class="basiccont word-wrap shadow mt-4 me-2">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Rejected Submission</h6>
                    </div>
                    @foreach ($rejectedSubmission as $submission)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom submission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
                        <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->date)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-4"> Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>

                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {

        $('.accept-link').on('click', function(event) {
            event.preventDefault();
            $('#isApprove').val('true'); // Set the value for "isApprove" input
            submitForm();
        });

        // Event listener for the "Reject" link
        $('.reject-link').on('click', function(event) {
            event.preventDefault();
            $('#isApprove').val('false'); // Set the value for "isApprove" input
            submitForm();
        });

        function submitForm() {
            var formData = $('#accepthoursform').serialize(); // Serialize form data
            var dataurl = $('#accepthoursform').data('url'); // Get the form data-url attribute
            var subtaskname = $('#subname').val();
            var subtaskid = $('#subid').val();

            var url = '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);


            $.ajax({
                type: 'POST',
                url: dataurl,
                data: formData,
                success: function(response) {
                    window.location.href = url;
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error:', error);
                }
            });
        }


        $(document).on('click', '.submission-div', function() {
            event.preventDefault();

            var submissionid = $(this).attr("data-id");
            var approval = $(this).attr("data-approval");
            var submission;

            if (approval === "") {
                submission = "Unevaluated-Submission";
            } else if (approval == 0) {
                submission = "Rejected-Submission";
            } else if (approval == 1) {
                submission = "Accepted-Submission";
            }


            var url = '{{ route("submission.display", ["submissionid" => ":submissionid", "submissionname" => ":submissionname"]) }}';
            url = url.replace(':submissionid', submissionid);
            url = url.replace(':submissionname', submission);
            window.location.href = url;
        });

    });
</script>
@endsection