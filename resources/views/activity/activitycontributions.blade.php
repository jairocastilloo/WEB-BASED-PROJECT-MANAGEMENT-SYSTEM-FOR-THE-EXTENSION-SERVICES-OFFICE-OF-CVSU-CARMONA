@extends('layouts.app')

@section('content')

<div class="maincontainer">
    <div class="mainnav mb-2 shadow">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv" data-name="{{ $activity['actname'] }}" data-value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Participation Hours </b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-8">
                <div class="basiccont word-wrap shadow ms-2 mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofactsubmission }}</h6>
                    </div>

                    <div class="p-2 pb-0 border-bottom">
                        <p class="lh-1 ps-4">{{ $activity->actname }}</p>
                        <p class="lh-1 ps-5">Hours Rendered: {{ $actcontribution->hours_rendered }}</p>
                        <p class="lh-1 ps-5">Rendered Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $actcontribution->startdate)->format('F d') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $actcontribution->enddate)->format('F d') }}</p>
                        <p class="lh-1 ps-5">Submitted In: {{ \Carbon\Carbon::parse($actcontribution->created_at)->format('F d, Y') }}</p>
                        <p class="lh-1 ps-5">Submitted By: {{ $submitter[0]->name . ' ' . $submitter[0]->last_name }}</p>
                        <p class="lh-1 ps-5"> Contributors:
                            @foreach($actcontributors as $actcontributor)
                            {{ $actcontributor->name . ' ' . $actcontributor->last_name . ' | ' }}
                            @endforeach
                        </p>
                        <p class="lh-1 ps-5">Submission Attachment:</p>
                        <div class="mb-2 text-center">
                            <a href="{{ route('downloadactivity.file', ['actcontributionid' => $actcontribution->id, 'filename' => basename($uploadedFiles[0])]) }}" class="btn btn-outline-success shadow rounded w-50">
                                <i class="bi bi-file-earmark-arrow-down-fill me-2 fs-3"></i><b>{{ basename($uploadedFiles[0]) }}</b>

                            </a>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-4">
                @php

                $unevaluatedSubmission = $otheractcontribution->filter(function ($contri) {
                return $contri['approval'] === null;
                });
                $acceptedSubmission = $otheractcontribution->filter(function ($contri) {
                return $contri['approval'] === 1;
                });
                $rejectedSubmission = $otheractcontribution->filter(function ($contri) {
                return $contri['approval'] === 0;
                });

                @endphp
                @if($otheractcontribution->isEmpty())
                <div class="basiccont word-wrap shadow mt-4">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Other Submission</h6>
                    </div>
                    <div class="text-center p-4">
                        <h4><em>No Other Submission Yet.</em></h4>
                    </div>
                </div>
                @endif

                @if (count($unevaluatedSubmission) > 0)

                <div class="basiccont word-wrap shadow mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Submission</h6>
                    </div>
                    @foreach ($unevaluatedSubmission as $submission)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom actsubmission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
                        <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-4"> Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>

                    </div>

                    @endforeach
                </div>
                @endif
                @if (count($acceptedSubmission) > 0)

                <div class="basiccont word-wrap shadow mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Accepted Submission</h6>
                    </div>
                    @foreach ($acceptedSubmission as $submission)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom actsubmission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
                        <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-4"> Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }} </p>

                    </div>
                    @endforeach
                </div>
                @endif
                @if (count($rejectedSubmission) > 0)

                <div class="basiccont word-wrap shadow mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Rejected Submission</h6>
                    </div>
                    @foreach ($rejectedSubmission as $submission)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom actsubmission-div" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">

                        <p class="lh-1 fw-bold"> Submitted Hours Rendered: {{ $submission->hours_rendered }}</p>
                        <p class="lh-1 ps-4"> Rendered Date: {{ \Carbon\Carbon::parse($submission->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }} </p>
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
        $(document).on('click', '.actsubmission-div', function() {
            event.preventDefault();

            var actsubmissionid = $(this).attr("data-id");
            var actapproval = $(this).attr("data-approval");
            var actsubmission;

            if (actapproval === "") {
                actsubmission = "Unevaluated-Submission";
            } else if (actapproval == 0) {
                actsubmission = "Rejected-Submission";
            } else if (actapproval == 1) {
                actsubmission = "Accepted-Submission";
            }


            var url = '{{ route("actsubmission.display", ["actsubmissionid" => ":actsubmissionid", "actsubmissionname" => ":actsubmissionname"]) }}';
            url = url.replace(':actsubmissionid', actsubmissionid);
            url = url.replace(':actsubmissionname', actsubmission);
            window.location.href = url;
        });

    });
</script>

@endsection