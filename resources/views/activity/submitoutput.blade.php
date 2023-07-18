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
            <h6><b>Output <span class="small">>></span> {{ $outputtype }}</b></h6>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-1">


            </div>
            <div class="col-10">
                <div class="basiccont p-2">
                    <div class="border-bottom ps-1 mb-2">
                        <h6 class="small"><b>Output to be Submitted - </b>{{ $outputtype }}</h6>
                    </div>
                    @foreach ($currentoutputtype as $currentoutput)
                    <div class="mb-3">
                        <label class="form-label">{{ $currentoutput['output_name'] }}:</label>
                        <input type="number" class="form-control" id="hours-rendered-input" placeholder="Enter the quantity" min="0" step="1">

                    </div>
                    @endforeach



                </div>
                <div class="basiccont p-2">
                    <div class="border-bottom ps-1 mb-2">
                        <h6 class="fw-bold small">Facilitator Involved</h6>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="submitreport-btn">Add Facilitator</button>
                </div>
                <div class="basiccont p-2">
                    <div class="border-bottom ps-1 mb-2">
                        <h6 class="fw-bold small">Supporting documents</h6>
                    </div>
                    <label class="form-label" for="customFile">Submit Activity Report:</label>
                    <input type="file" class="form-control" id="customFile" accept=".docx" />
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-outline-primary mt-2" id="submitreport-btn">Submit Report</button>
                    </div>
                </div>
            </div>
            <div class="col-1">

            </div>

        </div>

    </div>
</div>
@endsection