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
            <h6><b>Subtask <span class="small">>></span> {{ $subtask['subtask_name'] }}</b></h6>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-1">


            </div>
            <div class="col-10">
                <form id="addtooutputform">
                    <div class="basiccont p-2">
                        <div class="border-bottom ps-1 mb-2">
                            <h6 class="small"><b>Hours rendered </b></h6>
                        </div>

                        @csrf

                        <input type="number" class="d-none" id="executornumber" name="executornumber">
                        <input type="number" class="d-none" id="subtask-executor-0" name="subtask-executor[0]">

                        <div class="mb-3">
                            <label class="form-label">Hours rendered</label>
                            <input type="number" class="d-none" id="subtask-id" name="subtask-id">
                            <input type="number" class="form-control" id="hours-rendered" name="hours-rendered" placeholder="Enter hours rendered" min="0" step="1">
                        </div>


                    </div>
                    <div class="basiccont p-2">
                        <div class="border-bottom ps-1">
                            <h6 class="fw-bold small">Contributor</h6>
                        </div>
                        <div class="row p-1 contributor-name">

                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="addcontributor-btn">Add Contributor</button>
                    </div>
                    <div class="basiccont p-2">
                        <div class="border-bottom ps-1 mb-2">
                            <h6 class="fw-bold small">Supporting documents</h6>
                        </div>

                        <label class="form-label" for="customFile">Submit Subtask Report:</label>

                        <input type="file" class="form-control" id="customFile" accept=".docx" name="subtaskdocs">


                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-primary mt-2" id="submitreport-btn">Submit Report</button>
                        </div>
                </form>
            </div>
        </div>
        <div class="col-1">

        </div>

    </div>

</div>
</div>
@endsection