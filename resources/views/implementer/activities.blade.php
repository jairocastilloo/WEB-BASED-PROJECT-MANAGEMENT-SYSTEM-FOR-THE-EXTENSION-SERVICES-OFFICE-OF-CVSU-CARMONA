@extends('layouts.app')

@section('content')
<div class="maincontainer">
    <input type="number" class="d-none" id="userid" value="{{ Auth::user()->id }}">
    <div class="mainnav mb-2">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive">
            <h6><b>My Projects</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle" id="actdiv">
            <h6><b>My Activities</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive">
            <h6><b>To-do Subtasks</b></h6>
        </div>
    </div>

    <div class="basiccont m-4">
        @foreach($activities as $activity)
        <div class="border-bottom p-2">
            <h5><b>{{ $activity['actname'] }}</b></h5>

        </div>
        @endforeach
    </div>




    &nbsp;
</div>

@endsection