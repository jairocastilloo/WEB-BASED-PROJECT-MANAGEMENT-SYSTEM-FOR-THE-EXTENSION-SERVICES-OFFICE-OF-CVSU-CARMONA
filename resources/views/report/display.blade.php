@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-top-0">

    <div class="container pt-3">
        <div class="row">
            <div class="col-lg-10">

                <div class="basiccont rounded shadow pb-2">
                    <div class="border-bottom ps-3 pt-2 bggreen">
                        <h6 class="fw-bold small" style="color:darkgreen;">Browse Reports</h6>
                    </div>

                    <div class="form-floating m-3 mb-2 mt-2">

                        <select id="year-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen;" aria-label="Select a Department">

                            @foreach ($alldepartments as $alldepartment)
                            <option class="p-2" value="{{ $alldepartment }}" {{ $alldepartment == $department ? 'selected' : '' }}>
                                {{ $alldepartment }}
                            </option>
                            @endforeach

                        </select>
                        <label for="year-select" style="color:darkgreen;">
                            <h6><strong>Choose Department:</strong></h6>
                        </label>
                    </div>

                </div>

                <div class="container p-0">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Status</h6>
                                </div>
                                <div class="p-2 py-4 text-center">
                                    <h2>{{ $status }}</h2>

                                </div>
                            </div>
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Total Activities</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $totalActivitiesCount }}</h1>
                                    <h6 class="text-secondary small">Activities</h6>
                                </div>
                            </div>

                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Completed Activities</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $completedActivitiesCount }}</h1>
                                    <h6 class="text-secondary small">Activities</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Ongoing Activities</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $ongoingActivitiesCount }}</h1>
                                    <h6 class="text-secondary small">Activities</h6>
                                </div>
                            </div>
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Upcoming Activities</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $upcomingActivitiesCount }}</h1>
                                    <h6 class="text-secondary small">Activities</h6>
                                </div>
                            </div>
                            <div class="basiccont rounded shadow mb-3">
                                <div class="border-bottom pt-2 text-center bggreen">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Overdue Activities</h6>
                                </div>
                                <div class="p-2 text-center">
                                    <h1>{{ $overdueActivitiesCount }}</h1>
                                    <h6 class="text-secondary small">Activities</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="basiccont rounded shadow">
                                <div class="border-bottom ps-3 pt-2 bggreen text-center">
                                    <h6 class="fw-bold small" style="color:darkgreen;">Project Activities Overview</h6>
                                </div>
                                <canvas id="ProjectActivitiesOverview" class="p-1"></canvas>
                            </div>
                        </div>



                    </div>

                </div>


            </div>

            <div class="col-lg-2">
                @livewire('more-projects', ['department' => $department, 'projectid' => null, 'x' => 1])
                @livewire('not-started-projects', ['department' => $department, 'projectid' => null, 'y' => 1])
                @livewire('past-projects', ['department' => $department, 'projectid' => null, 'z' => 0])

            </div>

        </div>
    </div>
</div>



@endsection
@section('scripts')
<!--<script src="{{ asset('js/selectize.min.js') }}"></script>-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var selectElement = $('#year-select');
    var url = "";

    var completedActivitiesCount = <?php echo $completedActivitiesCount; ?>;
    var ongoingActivitiesCount = <?php echo $ongoingActivitiesCount; ?>;
    var upcomingActivitiesCount = <?php echo $upcomingActivitiesCount; ?>;
    var overdueActivitiesCount = <?php echo $overdueActivitiesCount; ?>;


    const ctx = document.getElementById('ProjectActivitiesOverview');
    const data = {
        labels: [
            'Completed',
            'Ongoing',
            'Upcoming',
            'Overdue',
        ],
        datasets: [{
            label: 'Number of Activities',
            data: [completedActivitiesCount, ongoingActivitiesCount, upcomingActivitiesCount, overdueActivitiesCount],
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
        options: {
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 16 // Set the desired font size for legend labels
                        }
                    }
                },
                tooltip: {
                    bodyFont: {
                        size: 16 // Set the desired font size for dataset labels
                    }
                }
            }
        }
    });
    $(document).ready(function() {



        // Add an event listener to the select element
        selectElement.change(function() {
            var selectedOption = $(this).find(':selected');
            var department = selectedOption.val();

            var baseUrl = "{{ route('reports.show', ['department' => ':department']) }}";
            var url = baseUrl.replace(':department', encodeURIComponent(department))

            window.location.href = url;
        });
        $(document).on('click', '.reportdiv', function(event) {
            event.preventDefault();
            var department = $(this).attr('data-dept');
            var projectid = $(this).attr('data-value');


            var url = '{{ route("reports.display", ["projectid" => ":projectid", "department" => ":department" ]) }}';
            url = url.replace(':projectid', projectid);
            url = url.replace(':department', encodeURIComponent(department));

            window.location.href = url;
        });

    });
</script>
@endsection