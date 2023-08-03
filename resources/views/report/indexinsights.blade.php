@extends('layouts.app')

@section('content')
<div class="maincontainer">
    <input id="department" class="d-none" type="text" value="{{ Auth::user()->department }}">
    <div class="mainnav mb-2">

        <div class="col-6 p-2 pt-3 border-end text-center position-triangle ">
            <h6><b>Project Insights</b></h6>
        </div>
        <div class="col-6 p-2 pt-3 text-center mainnavpassive">
            <h6><b>Financial Report</b></h6>
        </div>
    </div>
    <div class="container">
        <div class="basiccont m-2 mt-4 mb-4 p-3 rounded shadow">

            <div class="form-floating">
                <select id="project-select" class="form-select" style="border: 1px solid darkgreen;" aria-label="Select an option">
                    <option value="" selected disabled>Select Project</option>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $project->id == $projectid ? 'selected' : '' }}>
                        {{ $project->projecttitle }}
                    </option>
                    @endforeach

                </select>
                <label for="project-select" style="color:darkgreen;"><strong>Project Insights of:</strong></label>
            </div>


        </div>
        <div class="row">


            <div class="col">
                <div class="basiccont rounded m-2 mb-4 mt-0 p-2 shadow">
                    <div class="border-bottom">
                        <h6 class="fw-bold small text-secondary text-center">Total Activities</h6>
                    </div>
                    <h1 class="text-center">
                        @php
                        $activityCount = count($activities);
                        @endphp

                        {{ $activityCount }}

                    </h1>
                </div>

                <div class="basiccont rounded m-2 mb-4 mt-0 p-2 shadow">
                    <div class="border-bottom">
                        <h6 class="fw-bold small text-secondary text-center">Scheduled Activities</h6>
                    </div>
                    <h1 class="text-center">
                        @php
                        $count = 0;
                        foreach ($activities as $activity) {
                        if ($activity['actremark'] == 'Scheduled') {
                        $count++;
                        }
                        }
                        @endphp

                        {{ $count }}

                    </h1>
                </div>


            </div>
            <div class="col">
                <div class="basiccont rounded m-2 mb-4 mt-0 p-2 shadow">
                    <div class="border-bottom">
                        <h6 class="fw-bold small text-secondary text-center">In Progress Activities</h6>
                    </div>
                    <h1 class="text-center">
                        @php
                        $count = 0;
                        foreach ($activities as $activity) {
                        if ($activity['actremark'] == 'In Progress') {
                        $count++;
                        }
                        }
                        @endphp

                        {{ $count }}

                    </h1>
                </div>
                <div class="basiccont rounded m-2 mb-4 mt-0 p-2 shadow">
                    <div class="border-bottom">
                        <h6 class="fw-bold small text-secondary text-center">Overdue Activities</h6>
                    </div>
                    <h1 class="text-center">
                        @php
                        $count = 0;
                        foreach ($activities as $activity) {
                        if ($activity['actremark'] == 'Overdue') {
                        $count++;
                        }
                        }
                        @endphp

                        {{ $count }}

                    </h1>
                </div>

            </div>
            <div class="col">
                <div class="basiccont rounded m-2 mb-4 mt-0 p-2 shadow">
                    <div class="border-bottom">
                        <h6 class="fw-bold small text-secondary text-center">Pending Activities</h6>
                    </div>
                    <h1 class="text-center">
                        @php
                        $count = 0;
                        foreach ($activities as $activity) {
                        if ($activity['actremark'] == 'Pending') {
                        $count++;
                        }
                        }
                        @endphp

                        {{ $count }}

                    </h1>
                </div>

                <div class="basiccont rounded m-2 mb-4 mt-0 p-2 shadow">
                    <div class="border-bottom">
                        <h6 class="fw-bold small text-secondary text-center">Completed Activities</h6>
                    </div>
                    <h1 class="text-center">
                        @php
                        $count = 0;
                        foreach ($activities as $activity) {
                        if ($activity['actremark'] == 'Completed') {
                        $count++;
                        }
                        }
                        @endphp

                        {{ $count }}

                    </h1>
                </div>
            </div>
        </div>

    </div>


</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {

        $('#navbarDropdown').click(function(event) {
            // Add your function here
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
        });

        $('#project-select').change(function() {
            // Get the currently selected option

            var selectedOption = $(this).find(':selected');
            var projectid = selectedOption.val();
            var department = $('#department').val();
            var projectname = selectedOption.text()

            url = '{{ route("insights.index", ["projectid" => ":projectid", "department" => ":department","projectname" => ":projectname"]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', department);
            url = url.replace(':projectname', projectname);
            window.location.href = url;

        });
    });
</script>
@endsection