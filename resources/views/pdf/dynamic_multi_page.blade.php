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
            text-align: left;
            vertical-align: top;
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


            @if ($ayfirstsem)
            @foreach ($allAY as $ay)
            @if( $ay->id == $ayfirstsem->id )
            <p><b>EXTENSION SERVICES RECORD</b></p>
            <p>
                {{ 'FIRST SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
            </p>
            @break
            @endif

            @endforeach
            @elseif ($aysecondsem)
            @foreach ($allAY as $ay)
            @if($ay->id == $aysecondsem->id)

            <p><b>EXTENSION SERVICES RECORD</b></p>
            <p>
                {{ 'SECOND SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
            </p>

            @break
            @endif
            @endforeach
            @elseif ($latestAy)
            @foreach ($allAY as $ay)
            @if( $ay->id == $latestAy->id )
            <p><b>EXTENSION SERVICES RECORD</b></p>
            <p>
                {{ 'FIRST SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
            </p>
            @break
            @endif

            @endforeach
            @endif


        </header>


        <table class="detailsTable">
            <tr>
                <td class="recordDetails"><b>Name: </b>{{ $user->name . ' ' . substr(ucfirst($user->middle_name), 0, 1) . '. ' . $user->last_name }}</td>
                <td class="recordDetails"><b>Department: </b>{{ $user->department }}</td>
            </tr>


            @php
            $semStartDate = \Carbon\Carbon::parse($minSemDate)->format('F d, Y');
            $semEndDate = \Carbon\Carbon::parse($maxSemDate)->format('F d, Y');
            @endphp



            <tr>



                <td class="recordDetails"><b>Total Hours Rendered: </b>{{ $totalhoursrendered }}</td>
                <td class="recordDetails"><b>Semester Start Date: </b>{{ $semStartDate }}</td>
            </tr>
            <tr>



                <td class="recordDetails"><b>Total Number of Activities Conducted: </b>{{ count($allactivities) }}</td>
                <td class="recordDetails"><b>Semester End Date: </b>{{ $semEndDate }}</td>
            </tr>
        </table>

        <table class="mainTable">

            <thead>
                <tr>
                    <th class="projAct">
                        PROJECT
                    </th>
                    <th class="projAct">
                        EXTENSION ACTIVITY
                    </th>
                    <th class="date">
                        DATE
                    </th>
                    <th class="role">
                        ROLE
                    </th>
                    <th class="program">
                        RELATED PROGRAM/S (if any)
                    </th>
                    <th class="hoursClient">
                        TOTAL NUMBERS OF HOURS
                    </th>
                    <th class="hoursClient">
                        NO. OF CLIENTELE/ BENEFICIARIES
                    </th>
                    <th class="agency">
                        AGENCY
                    </th>
                    <th class="department">
                        DEPARTMENT
                    </th>
                </tr>

            </thead>

            <tbody>
                @foreach ($allactivities as $activity)
                @php
                $filteredActContribution = $activityContributions->filter(function ($actcontri) use
                ($activity) {
                return $actcontri->activity_id == $activity->id;
                });
                @endphp



                @php
                $filteredActContriCount = 0;
                @endphp
                @php
                $proj = $allprojects->firstWhere('id', $activity->project_id);
                @endphp
                @foreach ($filteredActContribution as $filteredActContri)

                <tr>
                    <td class="projAct">
                        {{ $proj->projecttitle }}
                    </td>
                    <td class="projAct">
                        {{ 'Activity: ' . $activity->actname }}
                        @if ($filteredActContriCount != 0)
                        {{ " (" . $filteredActContriCount . ")" }}
                        @endif
                    </td>
                    <td class="date">
                        {{ date('M d, Y', strtotime($filteredActContri->startdate)) }}
                        to

                        {{ date('M d, Y', strtotime($filteredActContri->enddate)) }}


                    </td>
                    <td class="role">
                        {{ $proj->role }}
                    </td>
                    <td class="program">
                        @if($filteredActContri->relatedPrograms)
                        {{ $filteredActContri->relatedPrograms }}
                        @else
                        -
                        @endif
                    </td>
                    <td class="hoursClient">
                        {{ $filteredActContri->hours_rendered }}
                    </td>
                    <td class="hoursClient">
                        @if($filteredActContri->clientNumbers)
                        {{ $filteredActContri->clientNumbers }}
                        @else
                        -
                        @endif
                    </td>
                    <td class="agency">
                        @if($filteredActContri->agency)
                        {{ $filteredActContri->agency }}
                        @else
                        -
                        @endif
                    </td>
                    <td class="department">
                        {{ $proj->department }}
                    </td>



                    @php
                    $filteredActContriCount++;
                    @endphp
                </tr>

                @endforeach



                @if (in_array($activity->id, $otheractivities))

                @foreach ($subtasks as $key => $subtask)


                @if ($activity->id === $subtask->activity_id)

                @php
                $filteredContribution = $subtaskcontributions->filter(function ($contri) use ($subtask)
                {
                return $contri->subtask_id == $subtask->id;
                });
                @endphp



                @php
                $filteredContriCount = 0;
                @endphp
                @foreach ($filteredContribution as $filteredContri)

                <tr>
                    <td>
                        {{ $proj->projecttitle }}
                    </td>
                    <td>
                        {{ 'Subtask: ' . $subtask->subtask_name }}
                        @if ($filteredContriCount != 0)
                        {{ " (" . $filteredContriCount . ")" }}
                        @endif
                    </td>
                    <td>
                        {{ date('M d, Y', strtotime($filteredContri->date)) }}
                        to

                        {{ date('M d, Y', strtotime($filteredContri->enddate)) }}


                    </td>
                    <td>
                        {{ $proj->role }}
                    </td>
                    <td>
                        @if($filteredContri->relatedPrograms)
                        {{ $filteredContri->relatedPrograms }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        {{ $filteredContri->hours_rendered }}
                    </td>
                    <td>
                        @if($filteredContri->clientNumbers)
                        {{ $filteredContri->clientNumbers }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if($filteredContri->agency)
                        {{ $filteredContri->agency }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        {{ $proj->department }}
                    </td>



                    @php
                    $filteredContriCount++;
                    @endphp
                </tr>

                @endforeach
                @php


                unset($subtasks[$key]); // Remove the processed contribution
                @endphp


                @endif

                @endforeach

                @endif


                @endforeach


            </tbody>

        </table>
    </div>
    <script>

    </script>

</body>

</html>