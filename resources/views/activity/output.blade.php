@extends('layouts.app')

@section('content')

<div class="maincontainer">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Output</b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="basiccont">
                    <h5>{{ $outputtype }}</h5>
                    @foreach ($outputs as $output)
                    {{ $output['output_name'] . ': ' . $output['output_submitted' ]}}</br>
                    @endforeach

                </div>
            </div>
            <div class="col">
                <div class="basiccont">
                    asdasdas
                </div>
            </div>

        </div>

    </div>
</div>
@endsection