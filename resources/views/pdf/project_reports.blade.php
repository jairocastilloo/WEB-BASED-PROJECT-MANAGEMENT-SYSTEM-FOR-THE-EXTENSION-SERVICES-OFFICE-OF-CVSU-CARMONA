<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .parent {
            width: 100%;
            /* Adjust the percentage as needed */
            margin: 0 auto;
            line-height: 1;
            /* Center the content */
        }

        .parent header {
            text-align: center;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            /* Adjust as needed */
        }

        .detailsTable td {

            padding: 2px;
            /* Add padding for spacing if needed */
            box-sizing: border-box;
            text-align: left;
            vertical-align: top;


        }

        .mainTable th {
            background-color: #e2efd9;
            border: 1px solid black;
            padding: 4px;
            /* Add padding for spacing if needed */
            box-sizing: border-box;
            text-align: center;
            overflow-wrap: break-word;
            word-wrap: break-word;

        }

        .mainTable td {
            border: 1px solid black;
            padding: 4px;
            /* Add padding for spacing if needed */
            box-sizing: border-box;

            overflow-wrap: break-word;
            word-wrap: break-word;

        }

        .recordDetails {

            width: 298;
        }

        .projAct {
            min-width: 96.22px;
            max-width: 96.22px;
        }

        .date {
            min-width: 66.22px;
            max-width: 66.22px;

        }

        .role {
            min-width: 96.22px;
            max-width: 96.22px;

        }

        .program {
            min-width: 96.22px;
            max-width: 96.22px;
        }

        .hoursClient {
            min-width: 110px;
            max-width: 110px;
        }

        .agency {
            min-width: 96.22px;
            max-width: 96.22px;
        }

        .department {
            min-width: 96.22px;
            max-width: 96.22px;
        }
    </style>
    <title>Dynamic Multi-Page PDF</title>
</head>

<body>
    <div class="parent">
        <header>



            <p><b>PROJECT REPORT</b></p>
            <p><b>Project Details</b></p>


        </header>


        <table class="detailsTable">
            <tr>
                <td class="recordDetails"><b>Project Title: </b>{{ $projecttitle }}</td>
                <td class="recordDetails"><b>Program Title: </b>{{ $indexproject->programtitle }}</td>
            </tr>
            @php
            $projectStartDate = \Carbon\Carbon::parse($indexproject->projectstartdate)->format('F d, Y');
            $projectEndDate = \Carbon\Carbon::parse($indexproject->projectenddate)->format('F d, Y');
            @endphp
            <tr>
                <td class="recordDetails">
                    <b>Project Leader:</b>
                    {{ implode(', ', $projectLeaders->map(function ($leader) {
            return $leader->name . ' ' . substr(ucfirst($leader->middle_name), 0, 1) . '. ' . $leader->last_name;
        })->toArray()) }}
                </td>
                <td class="recordDetails">
                    <b>Program Leader: </b>
                    {{ implode(', ', $programLeaders->map(function ($leader) {
            return $leader->name . ' ' . substr(ucfirst($leader->middle_name), 0, 1) . '. ' . $leader->last_name;
        })->toArray()) }}
                </td>
            </tr>

            <tr>
                <td class="recordDetails"><b>Project Start Date: </b>{{ $projectStartDate }}</td>
                <td class="recordDetails"><b>Project End Date: </b>{{ $projectEndDate }}</b></td>
            </tr>

        </table>
        <header>



            <p><b>Project Overview</b></p>



        </header>
        @php
        $completedActivitiesCount = $activities->where('actremark', 'Completed')->count();

        $overdueActivitiesCount = $activities->where('actremark', 'Incomplete')
        ->where('actenddate', '<', now()) ->count();

            $upcomingActivitiesCount = $activities->where('actremark', 'Incomplete')
            ->where('actstartdate', '>', now())
            ->count();

            $ongoingActivitiesCount = $activities->where('actremark', 'Incomplete')
            ->where('actstartdate', '<=', now()) ->where('actenddate', '>=', now())
                ->count();

                $totalActivitiesCount = $activities->count();
                @endphp
                <table class="detailsTable">

                    <tr>
                        <td class="recordDetails"><b>Project Status: </b>{{ $status }}</td>
                        <td class="recordDetails"><b>Ongoing Activities: </b>{{ $ongoingActivitiesCount }}</td>
                    </tr>
                    <tr>
                        <td class="recordDetails"><b>Total Activities: </b>{{ $totalActivitiesCount }}</td>
                        <td class="recordDetails"><b>Upcoming Activities: </b>{{ $upcomingActivitiesCount }}</td>
                    </tr>
                    <tr>
                        <td class="recordDetails"><b>Completed Activities: </b>{{ $completedActivitiesCount }}</td>
                        <td class="recordDetails"><b>Overdue Activities: </b>{{ $overdueActivitiesCount }}</td>
                    </tr>


                </table>

                <header>


                    <p><b>PROJECT'S ACTIVITIES REPORT</b></p>
                    <p><b>Project's Activities Data Table</b></p>



                </header>
                <table class="mainTable">
                    <thead>
                        <tr>
                            <th>ACTIVITY</th>
                            <th style="max-width: 88px; min-width: 88px;">START DATE</th>
                            <th style="max-width: 88px; min-width: 88px;">END DATE</th>
                            <th>OUTPUT PROGRESS</th>
                            <th>TASKS COUNT</th>
                            <th>ACTIVE TASKS</th>
                            <th>OVERDUE TASKS</th>
                            <th>COMPLETED TASKS</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                        @php
                        $totalTasksCount = $activity->additionalData['activeTasks'] +
                        $activity->additionalData['missingTasks'] +
                        $activity->additionalData['completedTasks'];
                        @endphp
                        <tr>
                            <td>{{ $activity->actname }}</td>
                            <td>
                                {{ date('M d, Y', strtotime($activity['actstartdate'])) }}
                            </td>
                            <td>
                                {{ date('M d, Y', strtotime($activity['actenddate'])) }}
                            </td>
                            <td style="text-align:center;">
                                {{ $activity->additionalData['outputPercent'] }}%

                            </td>
                            <td style="text-align:center;">
                                {{ $totalTasksCount }}
                            </td>
                            <td style="text-align:center;">
                                {{ $activity->additionalData['activeTasks'] }}
                            </td>
                            <td style="text-align:center;">
                                {{ $activity->additionalData['missingTasks'] }}
                            </td>
                            <td style="text-align:center;">
                                {{ $activity->additionalData['completedTasks'] }}
                            </td>


                        </tr>

                        @endforeach

                    </tbody>
                </table>
    </div>


</body>

</html>