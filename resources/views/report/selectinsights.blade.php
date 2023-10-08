@extends('layouts.app')

@section('content')

@php

$CompletedProjects = $projects->filter(function ($project) {
return $project->projectstatus === 'Completed';
});

$InProgressProjects = $projects->filter(function ($project) {
return $project->projectstatus === 'Incomplete' &&
$project->projectstartdate <= now() && $project->projectenddate >= now();});

    $NotStartedProjects = $projects->filter(function ($project) {
    return $project->projectstatus === 'Incomplete' &&
    $project->projectstartdate > now();
    });

    $IncompleteProjects = $projects->filter(function ($project) {

    return $project->projectstatus === 'Incomplete' &&
    $project->projectenddate < now(); }); @endphp <div class="maincontainer border border-start border-end">
        <input type="text" class="d-none" name="department" id="department" value="{{ Auth::user()->department }}">
        <div class="container pt-3">

            @php
            $CompletedProjectsCount = count($CompletedProjects);
            $InProgressProjectsCount = count($InProgressProjects);
            $NotStartedProjectsCount = count($NotStartedProjects);
            $IncompleteProjectsCount = count($IncompleteProjects);
            @endphp

            @php
            $projectpercents = [];
            @endphp

            @foreach($projects as $project)
            @php
            $percentactivity = [];
            @endphp

            @foreach($activities as $activity)
            @php
            $percentoutput = [];
            @endphp

            @if($activity->project_id == $project->id)
            @foreach ($outputs as $output)
            @if ($output->activity_id == $activity->id)

            @if ($output->expectedoutput != 0)
            @php

            array_push($percentoutput, ($output->totaloutput_submitted / $output->expectedoutput) * 100);
            @endphp
            @else
            @php

            array_push($percentoutput, 0); // Push a default value of 0
            @endphp
            @endif

            @endif
            @endforeach

            @if (count($percentoutput) > 0)
            @php

            array_push($percentactivity, array_sum($percentoutput) / count($percentoutput));
            @endphp
            @endif
            @endif
            @endforeach

            @if(count($percentactivity) > 0)
            @php
            $averagePercentage = array_sum($percentactivity) / count($percentactivity);
            $formattedPercentage = number_format($averagePercentage, 2);
            array_push($projectpercents, $formattedPercentage);
            @endphp
            @else
            @php
            array_push($projectpercents, 0);
            @endphp
            @endif

            @endforeach


            @php
            $projectNames = [];
            @endphp
            @foreach ($projects as $project)
            @php
            array_push($projectNames, $project->projecttitle);
            @endphp
            @endforeach
            <div class="basiccont rounded shadow pb-2">
                <div class="border-bottom ps-3 pt-2 bggreen">
                    <h6 class="fw-bold small" style="color:darkgreen;">Browse Reports</h6>
                </div>
                @if (!$inCurrentYear)
                <span class="small ms-2"><em>
                        Note: Not the Current Year.
                    </em></span>
                @endif
                <div class="form-floating m-3 mb-2 mt-2">

                    <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen; font-size: 19px;" aria-label="Select an calendar year">

                        @foreach ($calendaryears as $calendaryear)
                        <option value="{{ $calendaryear }}" {{ $calendaryear == $currentyear ? 'selected' : '' }}>
                            &nbsp;&nbsp;&nbsp;{{ $calendaryear }}
                        </option>
                        @endforeach

                    </select>
                    <label for="year-select" style="color:darkgreen;">
                        <h5><strong>Calendar Year:</strong></h5>
                    </label>
                </div>
                @if (Auth::user()->role === 'Admin')
                <div class="btn-group mt-1 ms-3 mb-2 shadow">
                    <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="addproj">
                        <b class="small">Create Project</b>
                    </button>
                </div>
                @endif
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="basiccont rounded shadow">
                            <div class="border-bottom ps-2 pt-2 bggreen">
                                <h6 class="fw-bold small" style="color:darkgreen;">Projects</h6>
                            </div>
                            <div class="p-1 text-center">
                                <h3>{{ count($projects) }}</h3>
                            </div>
                        </div>
                        <div class="basiccont rounded shadow">
                            <div class="border-bottom ps-2 pt-2 bggreen">
                                <h6 class="fw-bold small" style="color:darkgreen;">Hours Rendered</h6>
                            </div>
                            <div class="p-1 text-center">
                                <h3>{{ $activityHoursRendered + $subtaskHoursRendered }}</h3>
                                <h6 class="text-secondary small">Hours</h6>
                            </div>
                        </div>
                        <div class="basiccont rounded shadow">
                            <div class="border-bottom ps-2 pt-2 bggreen">
                                <h6 class="fw-bold small" style="color:darkgreen;">Completed Activities</h6>
                            </div>
                            <div class="p-1 text-center">
                                <h3>{{ $completedActivities }}</h3>
                                <h6 class="text-secondary small">Activities</h6>
                            </div>
                        </div>
                        <div class="basiccont rounded shadow">
                            <div class="border-bottom ps-2 pt-2 bggreen">
                                <h6 class="fw-bold small" style="color:darkgreen;">Remaining Activities</h6>
                            </div>
                            <div class="p-1 text-center">
                                <h3>{{ $incompleteActivities }}</h3>
                                <h6 class="text-secondary small">Activities</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="basiccont rounded shadow">
                            <div class="border-bottom ps-2 pt-2 bggreen">
                                <h6 class="fw-bold small" style="color:darkgreen;">Projects by Progress</h6>
                            </div>
                            <canvas id="ProjectProgressChart" class="p-2"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="basiccont rounded shadow">
                            <div class="border-bottom ps-2 pt-2 bggreen">
                                <h6 class="fw-bold small" style="color:darkgreen;">Outputs by Project</h6>
                            </div>
                            <canvas id="OutputsByProjectsChart" class="p-2"></canvas>
                        </div>
                    </div>


                </div>
            </div>






        </div>
        </div>



        @endsection

        @section('scripts')
        <!--<script src="{{ asset('js/selectize.min.js') }}"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var CompletedProjectsCount = <?php echo $CompletedProjectsCount; ?>;
            var InProgressProjectsCount = <?php echo $InProgressProjectsCount; ?>;
            var NotStartedProjectsCount = <?php echo $NotStartedProjectsCount; ?>;
            var IncompleteProjectsCount = <?php echo $IncompleteProjectsCount; ?>;


            const ctx = document.getElementById('ProjectProgressChart');
            const data = {
                labels: [
                    'Completed',
                    'In Progress',
                    'Not Started',
                    'Failed',
                ],
                datasets: [{
                    label: 'Number of Projects',
                    data: [CompletedProjectsCount, InProgressProjectsCount, NotStartedProjectsCount, IncompleteProjectsCount],
                    backgroundColor: [
                        'rgb(255, 215, 0)',
                        'rgb(50, 205, 50)',
                        'rgb(152, 251, 152)',
                        'rgb(85, 107, 47)',
                    ],
                    hoverOffset: 4
                }]
            };
            new Chart(ctx, {
                type: 'doughnut',
                data: data,

            });


            function getRandomColor() {
                var r = Math.floor(Math.random() * 256);
                var g = Math.floor(Math.random() * 256);
                var b = Math.floor(Math.random() * 256);
                return `rgb(${r}, ${g}, ${b})`;
            }

            // Generate random background colors and border colors
            const backgroundColors = Array.from({
                length: <?php echo count($projects); ?>
            }, () => getRandomColor());
            const borderColors = Array.from({
                length: <?php echo count($projects); ?>
            }, () => getRandomColor());


            const ctx2 = document.getElementById('OutputsByProjectsChart');



            const data2 = {
                labels: <?php echo json_encode($projectNames); ?>,
                datasets: [{
                    label: 'Outputs',
                    data: <?php echo json_encode($projectpercents); ?>,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            };

            new Chart(ctx2, {
                type: 'bar',
                data: data2,

                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100, // Set the maximum value of the y-axis to 100%
                            ticks: {
                                callback: function(value) {
                                    return value + '%'; // Add '%' suffix to y-axis labels
                                }
                            }
                        }
                    }
                }
            });





            var selectElement = $('#year-select');
            var url = "";


            $(document).ready(function() {

                $('#navbarDropdown').click(function() {
                    // Add your function here
                    $('#account .dropdown-menu').toggleClass('shows');
                });

                // Add an event listener to the select element
                selectElement.change(function() {
                    var selectedOption = $(this).find(':selected');
                    var currentyear = selectedOption.val();

                    var department = $('#department').val();

                    var baseUrl = "{{ route('yearinsights.show', ['department' => ':department', 'currentyear' => ':currentyear']) }}";
                    var url = baseUrl.replace(':department', department)
                        .replace(':currentyear', currentyear);

                    window.location.href = url;
                });



            });
        </script>
        @endsection