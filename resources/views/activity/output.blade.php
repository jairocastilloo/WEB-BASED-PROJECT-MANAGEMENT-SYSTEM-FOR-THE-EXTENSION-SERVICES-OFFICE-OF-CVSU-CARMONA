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
                <div class="basiccont p-2" data-value="{{ $outputtype }}">
                    <div class="border-bottom ps-1">
                        <h6 class="fw-bold small">Output Submitted</h6>
                    </div>
                    <h5>{{ $outputtype }}</h5>
                    @foreach ($currentoutputtype as $currentoutput)
                    {{ $currentoutput['output_name'] . ': ' . $currentoutput['output_submitted' ]}}</br>
                    @endforeach
                    <button type="button" class="btn btn-outline-secondary" id="editoutput-btn">Edit</button>
                    <button type="button" class="btn btn-outline-secondary" id="submitoutput-btn">Submit Output</button>
                </div>
                <div class="basiccont p-2">
                    <div class="border-bottom ps-1">
                        <h6 class="fw-bold small">Unevaluated Output</h6>
                    </div>


                </div>
            </div>
            <div class="col-4">
                <div class="basiccont">
                    <div class="border-bottom ps-2 pt-2">
                        <h6 class="fw-bold small">Other Outputs</h6>
                    </div>

                    @foreach ($alloutputtypes as $index => $alloutputtype)
                    @if ($index % 2 == 0)
                    <div class="sidecont1 divhover selectoutputdiv p-2" data-value="{{ $alloutputtype }}">{{ $alloutputtype }}</div>
                    @else
                    <div class="sidecont2 divhover selectoutputdiv p-2" data-value="{{ $alloutputtype }}">{{ $alloutputtype }}</div>
                    @endif
                    @endforeach


                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        $('#projectdiv').click(function(event) {
            event.preventDefault();
            var projectid = $(this).attr('data-value');

            url = '{{ route("get.objectives", ["id" => Auth::user()->id, "projectid" => ":projectid"]) }}';
            url = url.replace(':projectid', projectid);
            window.location.href = url;
        });

        $(document).on('click', '.selectoutputdiv', function() {
            var outputtype = $(this).attr('data-value');
            var actid = $('#actid').val();

            var url = '{{ route("get.output", ["id" => Auth::user()->id, "activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);
            window.location.href = url;
        });
        $('#submitoutput-btn').click(function(event) {
            event.preventDefault();
            var outputtype = $(this).parent().attr('data-value');
            var actid = $('#actid').val();

            var url = '{{ route("comply.output", ["id" => Auth::user()->id, "activityid" => ":activityid", "outputtype" => ":outputtype"]) }}';
            url = url.replace(':activityid', actid);
            url = url.replace(':outputtype', outputtype);
            window.location.href = url;
        });
        $('#activitydiv').click(function(event) {

            event.preventDefault();

            var activityid = $('#actid').val();

            var url = '{{ route("get.activity", ["id" => Auth::user()->id, "activityid" => ":activityid"]) }}';
            url = url.replace(':activityid', activityid);
            window.location.href = url;
        });

    });
</script>
@endsection