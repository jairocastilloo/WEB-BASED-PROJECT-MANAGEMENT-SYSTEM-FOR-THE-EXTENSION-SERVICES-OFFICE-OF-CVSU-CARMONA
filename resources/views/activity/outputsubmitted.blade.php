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
                        <p class="lh-1 ps-4"> <b>{{ $output->output_name . ': ' .  $submittedoutputs[$index]->output_submitted }}</b></p>

                        @endforeach

                        <p class="lh-1 ps-5"> Submitted in: {{ \Carbon\Carbon::parse($submittedoutputs[0]->created_at)->format('F d, Y') }} </p>

                        <p class="lh-1 ps-5">Submission Attachment:</p>


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