@extends('layouts.app')

@section('content')
<div class="maincontainer">
    &nbsp;
    <div class="row">
        <div class="col-6">
            <div class="basiccont ms-3 rounded">
                <div class="border-bottom ps-3">
                    <h6 class="fw-bold small">Tasks</h6>
                </div>


                @foreach($subtasks as $subtask)
                @php
                $totalhoursrendered = 0;
                @endphp

                @foreach ($contributions as $contribution)
                @if($contribution['subtask_id'] == $subtask['subtask_id'])
                @php
                $totalhoursrendered += $contribution['hours_rendered'];
                @endphp
                @endif
                @endforeach

                <div class="border-bottom p-2 divhover subtaskdiv" data-value="{{ $subtask['id'] }}">
                    <h5><b>{{ $subtask['subtask_name'] }}</b></h5>
                    <h6 class="text-secondary">{{ $totalhoursrendered }} hours rendered</h6>
                </div>
                @endforeach

            </div>
        </div>

        <div class="col-3">
            <div class="basiccont rounded">
                <div class="border-bottom ps-3">
                    <h6 class="fw-bold small">Activities</h6>
                </div>
                @php
                // Sort the $activities array by actstartdate in ascending order
                $sortedActivities = $activities->sortBy('actstartdate');
                @endphp

                @foreach ($sortedActivities as $activity)
                <div class="border-bottom p-2 divhover activitydiv" data-value="{{ $activity['id'] }}">
                    <h5><b>{{ $activity['actname'] }}</b></h5>

                    @php
                    $startDate = date('M d, Y', strtotime($activity['actstartdate']));
                    $endDate = date('M d, Y', strtotime($activity['actenddate']));
                    @endphp

                    <h6 class="text-secondary"> {{ $startDate }} - {{ $endDate }}</h6>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-3">
            <div class="basiccont me-3 rounded">
                <div class="border-bottom ps-3">
                    <h6 class="fw-bold small">Projects</h6>
                </div>
                @php
                // Sort the $activities array by actstartdate in ascending order
                $sortedProjects = $projects->sortBy('projectstartdate');
                @endphp
                @foreach($sortedProjects as $project)
                <div class="border-bottom p-2 divhover projectdiv" data-value="{{ $project['id'] }}">
                    <h5><b>{{ $project['projecttitle'] }}</b></h5>

                    @php
                    $startDate = date('M d, Y', strtotime($project['projectstartdate']));
                    $endDate = date('M d, Y', strtotime($project['projectenddate']));
                    @endphp

                    <h6 class="text-secondary"> {{ $startDate }} - {{ $endDate }}</h6>

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
        $(document).on('click', '.subtaskdiv', function(event) {
            event.preventDefault();

            var subtaskname = $(this).find("h5").text();
            var subtaskid = $(this).attr("data-value");

            var url = '{{ route("display.subtask", ["id" => Auth::user()->id, "subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);
            window.location.href = url;
        });

    });
</script>
@endsection