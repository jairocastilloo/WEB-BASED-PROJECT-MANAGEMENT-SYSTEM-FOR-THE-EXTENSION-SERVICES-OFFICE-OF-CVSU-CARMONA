@extends('layouts.app')

@section('content')
<div class="maincontainer border border-start border-end border-top-0">
    <div class="container pt-3">

        <input type="text" class="d-none" id="username" value="{{ Auth::user()->username }}">
        <div class="row">
            <div class="col-lg-6">
                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Duties</h6>
                    </div>
                    @if (!$inCurrentYear)
                    <span class="small ms-2"><em>
                            Note: Not the Current Year.
                        </em></span>
                    @endif
                    <div class="form-floating m-3 mb-2 mt-2">

                        <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen;" aria-label="Select an fiscal year">

                            @foreach ($fiscalyears as $fiscalyear)
                            <option value="{{ $fiscalyear->id }}" {{ $fiscalyear->id == $currentfiscalyear->id ? 'selected' : '' }}>
                                &nbsp;&nbsp;&nbsp;{{ date('F Y', strtotime($fiscalyear->startdate)) . ' - ' . date('F Y', strtotime($fiscalyear->enddate)) }}
                            </option>
                            @endforeach

                        </select>
                        <label for="year-select" style="color:darkgreen;">
                            <h6><strong>Fiscal Year:</strong></h6>
                        </label>
                    </div>

                </div>

            </div>

            <div class="col-lg-3 p-2 pt-0">
                <label class="ms-3 small form-label text-secondary fw-bold">Activities</label>
                @livewire('in-progress-activities', ['projectid' => null, 'xInProgressActivities' => 1])


            </div>
            <div class="col-lg-3 p-2 pt-0">
                <label class="ms-3 small form-label text-secondary fw-bold">Projects</label>
                @livewire('more-projects', ['department' => null, 'projectid' => null, 'fiscalyearid' => $currentfiscalyear->id, 'x' => 1])
                @livewire('not-started-projects', ['department' => null, 'projectid' => null, 'fiscalyearid' => $currentfiscalyear->id, 'y' => 1])
                @livewire('past-projects', ['department' => null, 'projectid' => null, 'fiscalyearid' => $currentfiscalyear->id, 'z' => 0])
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '#toggleButton', function(event) {
            $(this).next().slideToggle("fast");
        });

        $('#year-select').change(function() {
            var selectedOption = $(this).find(':selected');
            var currentYear = selectedOption.val();

            var username = $('#username').val();

            var baseUrl = "{{ route('acadtasks.show', ['username' => ':username', 'currentYear' => ':currentYear']) }}";
            var url = baseUrl.replace(':username', username)
                .replace(':currentYear', currentYear);

            window.location.href = url;
        });
        $('#navbarDropdown').click(function(event) {
            // Add your function here
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
        });

        $(document).on('click', '.subtaskdiv', function(event) {
            event.preventDefault();

            var subtaskname = $(this).find("h6:first").text();
            var subtaskid = $(this).attr("data-value");

            var url = '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
            url = url.replace(':subtaskid', subtaskid);
            url = url.replace(':subtaskname', subtaskname);
            window.location.href = url;
        });

        $(document).on('click', '.activitydiv', function(event) {
            event.preventDefault();

            var activityname = $(this).find("h6:first").text();
            var activityid = $(this).attr("data-value");

            var url = '{{ route("activities.display", ["activityid" => ":activityid", "activityname" => ":activityname"]) }}';
            url = url.replace(':activityid', activityid);
            url = url.replace(':activityname', activityname);
            window.location.href = url;
        });

        $(document).on('click', '.projectdiv', function(event) {
            event.preventDefault();

            var projectname = $(this).attr("data-name");
            var projectid = $(this).attr("data-value");
            var department = $(this).attr("data-dept");

            var url = '{{ route("projects.display", ["projectid" => ":projectid", "department" => ":department"]) }}';
            url = url.replace(':projectid', projectid)
            url = url.replace(':department', department);
            window.location.href = url;
        });

    });
</script>
@endsection