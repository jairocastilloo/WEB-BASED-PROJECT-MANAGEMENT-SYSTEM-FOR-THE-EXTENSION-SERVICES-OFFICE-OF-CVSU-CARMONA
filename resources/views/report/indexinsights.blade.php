@extends('layouts.app')

@section('content')

@php

$PendingActivities = $activities->filter(function ($activity) {
return $activity->actremark === 'Pending';
});
$InProgressActivities = $activities->filter(function ($activity) {
return $activity->actremark === 'Incomplete' &&
$activity->actstartdate <= now() && $activity->actenddate >= now();
    });
    $CompletedActivities = $activities->filter(function ($activity) {
    return $activity->actremark === 'Completed';
    });

    $UpcomingActivities = $activities->filter(function ($activity) {

    $actStartDate = \Carbon\Carbon::parse($activity->actstartdate);

    // Clone the $actStartDate to avoid modifying the original date
    $threeDaysBeforeAct = $actStartDate->copy()->subDays(3);

    return $activity->actremark === 'Incomplete' &&
    $threeDaysBeforeAct <= now() && $actStartDate> now();
        });

        $ScheduledActivities = $activities->filter(function ($activity) {


        return $activity->actremark === 'Incomplete' &&
        $activity->actstartdate > now();
        });

        $OverdueActivities = $activities->filter(function ($activity) {


        return $activity->actremark === 'Incomplete' &&
        $activity->actenddate < now(); }); $pending=count($PendingActivities); $upcoming=count($UpcomingActivities); $scheduled=count($ScheduledActivities);$inprogress=count($InProgressActivities);$overdue=count($OverdueActivities);$completed=count($CompletedActivities);@endphp <input id="department" class="d-none" type="text" value="{{ Auth::user()->department }}">


            <div class="maincontainer border border-start border-end border-bottom">


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
                    <div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3>Project Progress Chart</h3>
                                    <canvas id="projectProgressChart"></canvas>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>


            </div>

            @endsection
            @section('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var pending = <?php echo $scheduled; ?>;
                var scheduled = <?php echo $scheduled; ?>;
                var upcoming = <?php echo $upcoming; ?>;
                var completed = <?php echo $completed; ?>;
                var inprogress = <?php echo $inprogress; ?>;
                var overdue = <?php echo $overdue; ?>;
                const ctx = document.getElementById('projectProgressChart');
                const data = {
                    labels: [
                        'Pending',
                        'Scheduled',
                        'Upcoming',
                        'Completed ',
                        'In Progress',
                        'Overdue'
                    ],
                    datasets: [{
                        label: 'Number of Activities',
                        data: [pending, scheduled, upcoming, completed, inprogress, overdue],
                        backgroundColor: [
                            'rgb(255, 165, 0',
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(0, 128, 0)',
                            'rgb(255, 192, 203)'
                        ],
                        hoverOffset: 4
                    }]
                };
                new Chart(ctx, {
                    type: 'doughnut',
                    data: data,

                });

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