@extends('layouts.app')

@section('content')
<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv" data-name="{{ $activity['actname'] }}">
            <input type="number" class="d-none" id="actid" value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive">

            <h6><b>Output: {{ $outputs[0]->output_type }}</b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="basiccont word-wrap shadow ms-2 mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofsubmission }}</h6>
                    </div>

                    <div class="p-2">
                        <p class="ps-4 lh-1 pt-2"><b>{{ $outputs[0]->output_type }}</b></p>
                        @foreach ($outputs as $index => $output)
                        <p class="lh-1 ps-5">{{ 'Submitted ' . $output->output_name . ': ' .  $submittedoutputs[$index]->output_submitted }}</p>

                        @endforeach

                        <p class="lh-1 ps-5"> Submitted in: {{ \Carbon\Carbon::parse($submittedoutputs[0]->created_at)->format('F d, Y') }} </p>
                        @if($submitter)
                        <p class="lh-1 ps-5"> Submitted by: {{ $submitter[0]->name . ' ' . $submitter[0]->last_name }} </p>
                        @endif
                        <p class="lh-1 ps-5">Submission Attachment:</p>
                        <div class="mb-2 text-center">
                            <a href="{{ route('downloadoutput.file', ['submittedoutputid' => $submittedoutputs[0]->id, 'filename' => basename($uploadedFiles[0])]) }}" class="btn btn-outline-success shadow rounded w-50">
                                <i class="bi bi-file-earmark-arrow-down-fill me-2 fs-3"></i><b>{{ basename($uploadedFiles[0]) }}</b>

                            </a>

                        </div>

                        @if( $submittedoutputs[0]->approval != 1)
                        <div class="btn-group dropdown ms-3 mb-3 mt-2 shadow">
                            <button type="button" class="btn btn-sm dropdown-toggle shadow rounded border border-1 btn-gold border-warning text-body" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <b class="small">Evaluate Submission</b>
                            </button>
                            <div class="dropdown-menu">
                                <form id="accepthoursform" data-url="{{ route('hours.accept') }}">
                                    @csrf
                                    <input type="text" class="d-none" value="" name="acceptids" id="acceptids">
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

                $unevaluatedSubmittedOutput = $othersubmittedoutput->filter(function ($suboutput) {
                return $suboutput['approval'] === null;
                });
                $acceptedSubmittedOutput = $othersubmittedoutput->filter(function ($suboutput) {
                return $suboutput['approval'] === 1;
                });
                $rejectedSubmittedOutput = $othersubmittedoutput->filter(function ($suboutput) {
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


                @if($othersubmittedoutput->isEmpty())
                <div class="basiccont word-wrap shadow mt-4">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Submitted Output</h6>
                    </div>
                    <div class="text-center p-4">
                        <h4><em>No Submitted Output Yet.</em></h4>
                    </div>
                </div>
                @endif

                @if (count($unevaluatedSubmittedOutput) > 0)

                <div class="basiccont word-wrap shadow mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Unevaluated Submission</h6>
                    </div>
                    @foreach ($groupedUnevaluatedSubmittedOutput as $date => $group)
                    <div class="p-2 pb-1 ps-4 small divhover border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="Unevaluated-Submission">
                        <p class="lh-1 fw-bold">Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>

                        @foreach ($group as $index => $item)
                        <p class="lh-1 ps-4"> {{ 'Submitted ' . $outputs[$index]->output_name . ': ' . $item['output_submitted'] }}</p>
                        <!-- Display other attributes as needed -->
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @endif

                @if (count($acceptedSubmittedOutput) > 0)

                <div class="basiccont word-wrap shadow mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Accepted Submission</h6>
                    </div>
                    @foreach ($groupedAcceptedSubmittedOutput as $date => $group)
                    <div class="p-2 pb-1 ps-4 divhover small border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="Accepted-Submission">
                        <p class="lh-1 fw-bold">Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>

                        @foreach ($group as $index => $item)
                        <p class="lh-1 ps-4"> {{ 'Submitted ' . $outputs[$index]->output_name . ': ' . $item['output_submitted'] }}</p>
                        <!-- Display other attributes as needed -->
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @endif

                @if (count($rejectedSubmittedOutput) > 0)

                <div class="basiccont word-wrap shadow mt-4">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Rejected Submission</h6>
                    </div>
                    @foreach ($groupedRejectedSubmittedOutput as $date => $group)
                    <div class="p-2 pb-1 ps-4 divhover small border-bottom outputsubmitteddiv" data-value="{{ $group[0]->id }}" data-approval="Rejected-Submission">
                        <p class="lh-1 fw-bold">Submitted In: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>

                        @foreach ($group as $index => $item)
                        <p class="lh-1 ps-4"> {{ 'Submitted ' . $outputs[$index]->output_name . ': ' . $item['output_submitted'] }}</p>
                        <!-- Display other attributes as needed -->
                        @endforeach

                    </div>
                    @endforeach

                </div>
                @endif
            </div>

        </div>

    </div>
</div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {



    });
</script>
@endsection