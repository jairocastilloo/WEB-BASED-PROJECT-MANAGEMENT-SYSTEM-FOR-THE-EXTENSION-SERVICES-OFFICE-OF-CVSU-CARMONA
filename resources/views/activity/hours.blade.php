@extends('layouts.app')

@section('content')

<div class="maincontainer">
    <div class="mainnav mb-2 shadow">
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="projectdiv" data-value="{{ $projectId }}" data-name="{{ $projectName }}">
            <input class="d-none" type="text" id="department" value="{{ Auth::user()->department }}">
            <h6><b>Project: {{ $projectName }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center mainnavpassive" id="activitydiv" data-name="{{ $activity['actname'] }}" data-value="{{ $activity['id'] }}">
            <h6><b>Activity: {{ $activity['actname'] }}</b></h6>
        </div>
        <div class="col-4 p-2 pt-3 border-end text-center position-triangle">
            <h6><b>Participation Hours </b></h6>
        </div>
    </div>
    <div class="container">
        <div class="basiccont word-wrap shadow ms-2 mt-4">
            <div class="border-bottom ps-3 pt-2 pe-2 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Participation Hours</h6>
            </div>

            <div class="p-2 pb-0 ps-5 border-bottom">
                <p class="lh-1">Activity Name: {{ $activity->actname }}</p>
                <p class="lh-1">Activity Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $activity->actstartdate)->format('F d') . ' to ' . \Carbon\Carbon::createFromFormat('Y-m-d', $activity->actenddate)->format('F d') }}</p>

                <p class="lh-1">Total Hours Rendered: {{ $activity->totalhours_rendered }}</p>
            </div>

            <div class="btn-group ms-3 mb-3 mt-2 shadow">
                <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow submithours-btn">
                    <b class="small">Submit Hours</b>
                </button>
            </div>

        </div>


    </div>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {

        $(document).on('click', '.submithours-btn', function() {
            var activityid = $('#activitydiv').attr("data-value");
            var activityname = $('#activitydiv').attr("data-name");
            var department = $('#department').val();

            var url = '{{ route("comply.activity", ["activityid" => ":activityid", "activityname" => ":activityname", "department" => ":department"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':activityname', activityname);
            url = url.replace(':department', department);

            window.location.href = url;
        });
    });
</script>

@endsection