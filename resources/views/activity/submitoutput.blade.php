@extends('layouts.app')

@section('content')
<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv">
            <input type="number" class="d-none" id="actid" value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Output</b></h6>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-8">

                <div class="basiccont p-2">
                    <div class="border-bottom ps-1">
                        <h6 class="fw-bold small">Output to be Submitted</h6>
                    </div>

                </div>
            </div>
            <div class="col-4">
                <div class="basiccont p-2">
                    <div class="border-bottom ps-1">
                        <h6 class="fw-bold small">Supporting documents</h6>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection