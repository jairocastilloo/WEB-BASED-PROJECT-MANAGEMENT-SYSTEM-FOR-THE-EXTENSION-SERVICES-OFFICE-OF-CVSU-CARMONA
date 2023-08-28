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
        <div class="col-4 p-2 pt-3 border-end text-center">
            <h6><b>Subtask: {{ $subtask['subtask_name'] }}</b></h6>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="basiccont word-wrap shadow ms-2 mt-4" data-id="{{ $contribution->id }}" data-approval="{{ $contribution->approval }}">
                    <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">{{ $nameofsubmission }}</h6>
                    </div>

                    <div class="p-2 pb-1">
                        <p class="ps-4 lh-1 pt-2"><b>Subtask Name: {{ $subtask['subtask_name'] }}</b></p>
                        <p class="lh-1 ps-5"> Submitted Hours Rendered: {{ $contribution->hours_rendered }}</p>
                        <p class="lh-1 ps-5"> Rendered Date: {{ \Carbon\Carbon::parse($contribution->date)->format('F d, Y') }} </p>
                        <p class="lh-1 ps-5"> Submitted in: {{ \Carbon\Carbon::parse($contribution->created_at)->format('F d, Y') }} </p>
                        <div class="card ms-5">
                            <div class="card-body">
                                <p class="card-title">File Display</p>
                                <p class="card-text">Click the link below to view the file.</p>
                                <ul>
                                    @foreach ($uploadedFiles as $file)
                                    {{ basename($file) }}
                                    <li><a href="{{ route('download.file', ['contributionid' => $contribution->id, 'filename' => basename($file)]) }}">{{ basename($file) }}</a></li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-4">


            </div>

        </div>
    </div>
</div>

@endsection