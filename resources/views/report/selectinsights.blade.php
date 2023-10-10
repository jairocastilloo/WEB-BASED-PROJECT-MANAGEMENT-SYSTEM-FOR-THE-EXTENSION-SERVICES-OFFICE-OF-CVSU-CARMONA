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
            $computepercent = ($output->totaloutput_submitted / $output->expectedoutput) * 100;

            @endphp
            @if ($computepercent <= 100) @php array_push($percentoutput, $computepercent); @endphp @else @php array_push($percentoutput, 100); @endphp @endif @else @php array_push($percentoutput, 0); // Push a default value of 0 @endphp @endif @endif @endforeach @if (count($percentoutput)> 0)
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
                @if(count($projectpercents) > 0 )
                @php
                $averageoutputpercentage = array_sum($projectpercents) / count($projectpercents);
                $formattedaverageoutputpercentage = number_format($averageoutputpercentage, 2);
                @endphp
                @else
                @php
                $formattedaverageoutputpercentage = 0;
                @endphp
                @endif
                <div class="basiccont rounded shadow pb-2 mb-3">
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
                <div class="container p-0">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Total Projects</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ count($projects) }}</h1>
                                    <h6 class="text-secondary small">Projects</h6>
                                </div>
                            </div>
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Completed Projects</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $CompletedProjectsCount }}</h1>
                                    <h6 class="text-secondary small">Projects</h6>
                                </div>
                            </div>
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Incomplete Projects</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $InProgressProjectsCount + $NotStartedProjectsCount }}</h1>
                                    <h6 class="text-secondary small">Projects</h6>
                                </div>
                            </div>
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Failed Projects</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $IncompleteProjectsCount }}</h1>
                                    <h6 class="text-secondary small">Projects</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Aggregate Project Outputs</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $formattedaverageoutputpercentage . ' %' }}</h1>
                                    <h6 class="text-secondary small">Average Percentage</h6>
                                </div>
                            </div>
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Total Hours</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $activityHoursRendered + $subtaskHoursRendered }}</h1>
                                    <h6 class="text-secondary small">Hours Rendered</h6>
                                </div>
                            </div>
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Completed Activities</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $completedActivities }}</h1>
                                    <h6 class="text-secondary small">Activities</h6>
                                </div>
                            </div>
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Remaining Activities</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $incompleteActivities }}</h1>
                                    <h6 class="text-secondary small">Activities</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="basiccont rounded shadow">
                                <div class="border-bottom ps-3 pt-2 bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Projects by Progress</h6>
                                </div>
                                <canvas id="ProjectProgressChart" class="p-1"></canvas>
                            </div>
                        </div>



                    </div>
                    <div class="container p-0 mt-3">
                        <div class="basiccont rounded shadow">
                            <div class="border-bottom ps-3 pt-2 bggreen">
                                <h6 class="fw-bold small" style="color:darkgreen;">Outputs Percentage by Project</h6>
                            </div>
                            <canvas id="OutputsByProjectsChart" class="p-1"></canvas>
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


            const ctx2 = document.getElementById('OutputsByProjectsChart');

            // Set the height of the canvas element using inline style
            // Adjust the height value as needed

            const data2 = {
                labels: <?php echo json_encode($projectNames); ?>,
                datasets: [{
                    label: 'Outputs Progress Rate',
                    data: <?php echo json_encode($projectpercents); ?>,
                    backgroundColor: backgroundColors,
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