@extends('layouts.app')

@section('content')
<div class="maincontainer">
    <input type="text" class="d-none" id="userid" value="{{ Auth::user()->username }}">
    <div class="mainnav mb-4">
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>My Projects</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="actdiv">
            <h6><b>My Activities</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive">
            <h6><b>To-do Subtasks</b></h6>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="basiccont ms-4 rounded">
                @foreach($projects as $project)
                <div class="border-bottom p-2 divhover" id="projectdiv" data-url="{{ $project['id'] }}">
                    <h5><b>Project Title: {{ $project['projecttitle'] }}</b></h5>

                    <h6 class="text-secondary">Project Leader: {{ $project['projectleader'] }}</h6>

                </div>
                @endforeach
            </div>
        </div>
        <div class="col-4">
            <div class="basiccont me-4 rounded">
                @foreach($projects as $project)
                <div class="border-bottom p-2 divhover" id="projectdiv" data-url="{{ $project['id'] }}">
                    <h5><b>Project Title: {{ $project['projecttitle'] }}</b></h5>

                    <h6 class="text-secondary">Project Leader: {{ $project['projectleader'] }}</h6>

                </div>
                @endforeach
            </div>
        </div>
    </div>





    &nbsp;
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#actdiv').click(function(event) {

            event.preventDefault();
            var userid = $('#userid').val();

            url = '{{ route("activities.show", ["username" => ":userid"]) }}';
            url = url.replace(':userid', userid);
            window.location.href = url;
        });

    });
</script>
@endsection