@extends('layouts.app')
@section('content')

<div class="maincontainer">
    &nbsp;
    <div class="container">
<<<<<<< HEAD
=======

        <div class="basiccont mt-0 mb-4 m-2 pb-2 rounded shadow">
            <div class="border-bottom ps-3 pt-2 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Browse My Records</h6>
            </div>
            @if (!$inCurrentYear)
            <span class="small ms-2"><em>
                    Note: Not the current Semester and AY.
                </em></span>
            @endif
            <div class="form-floating m-3 mb-2 mt-3">

                <select id="sem-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen; font-size: 18px;" aria-label="Select an acadamic year and semster">
                    @if ($ayfirstsem)
                    @foreach ($allAY as $ay)
                    <option data-sem="1STSEM" value="{{ $ay['id'] }}" {{ $ay->id == $ayfirstsem->id ? 'selected' : '' }}>
                        {{ 'FIRST SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    <option data-sem="2NDSEM" value="{{ $ay['id'] }}">
                        {{ 'SECOND SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    @endforeach
                    @elseif ($aysecondsem)
                    @foreach ($allAY as $ay)
                    <option data-sem="1STSEM" value="{{ $ay['id'] }}">
                        {{ 'FIRST SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    <option data-sem="2NDSEM" value="{{ $ay['id'] }}" {{ $ay->id == $aysecondsem->id ? 'selected' : '' }}>
                        {{ 'SECOND SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    @endforeach
                    @elseif ($latestAy)
                    @foreach ($allAY as $ay)
                    <option data-sem="1STSEM" value="{{ $ay['id'] }}" {{ $ay->id == $latestAy->id ? 'selected' : '' }}>
                        {{ 'FIRST SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    <option data-sem="2NDSEM" value="{{ $ay['id'] }}">
                        {{ 'SECOND SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    @endforeach
                    @endif
                </select>
                <label for="ay-select" style="color:darkgreen;">
                    <h6><strong>SEMESTER and AY:</strong></h6>
                </label>
            </div>

        </div>
>>>>>>> origin/main
        <div class="basiccont shadow">
            <div class="text-center shadow bg-success text-white p-2 pt-3">
                <h5 class="fw-bold">
                    EXTENSION SERVICES RECORDS FOR THE FIRST SEMESTER, AY 2022-2023
                </h5>
            </div>
            <div class="row ps-3 pe-3 pt-2 pb-2">

                <div class="col m-2 me-0">

                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="image.jpg" alt="Image" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">
                                        {{ ucfirst(Auth::user()->name) . ' ' . (Auth::user()->middle_name ? ucfirst(Auth::user()->middle_name[0]) . '.' : '') . ' ' . ucfirst(Auth::user()->last_name) }}
                                    </h6>
                                    <p class="card-text">
                                        <em>{{ Auth::user()->department }}</em>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col m-2 ms-0 me-0">

                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="image.jpg" alt="Image" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">
                                        Total Hours Rendered:
                                    </h6>
                                    <p class="card-text">
<<<<<<< HEAD
                                        <em>37 million</em>
=======
                                        <em>{{ $totalhoursrendered }}</em>
>>>>>>> origin/main
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col m-2 ms-0">

                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="image.jpg" alt="Image" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">
                                        Total Number of Activities Conducted:
                                    </h6>
                                    <p class="card-text">
<<<<<<< HEAD
                                        <em>1 million</em>
=======
                                        <em>{{ count($allactivities) }}</em>
>>>>>>> origin/main
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="container ps-0 pe-2">
                <div class="tablecontainer">
                    <table class="recordtable small">

                        <thead>
<<<<<<< HEAD
                            <tr id="actheader">
                                <th class="p-2 text-center majority">
                                    <strong>PROJECT</strong>
                                </th>
                                <th class="p-2 text-center extension">
                                    <strong>EXTENSION ACTIVITY</strong>
                                </th>
                                <th class="p-2 text-center num">
                                    <strong>DATE</strong>
                                </th>
                                <th class="p-2 text-center majority">
                                    <strong>RELATED PROGRAM/S (if any)</strong>
                                </th>
                                <th class="p-2 text-center num">
                                    <strong>TOTAL NUMBERS OF HOURS</strong>
                                </th>
                                <th class="p-2 text-center majority">
                                    <strong>NO. OF CLIENTELE/BENEFICIARIES</strong>
                                </th>
                                <th class="p-2 text-center majority">
                                    <strong>AGENCY</strong>
                                </th>
                                <th class="p-2 text-center majority">
                                    <strong>DEPARTMENT</strong>
=======
                            <tr class="actheader recordth">
                                <th class="p-1 text-center majority">
                                    PROJECT
                                </th>
                                <th class="p-1 text-center extension">
                                    EXTENSION ACTIVITY
                                </th>
                                <th class="p-1 text-center num">
                                    DATE
                                </th>
                                <th class="p-1 text-center majority">
                                    RELATED PROGRAM/S (if any)
                                </th>
                                <th class="p-1 text-center num">
                                    TOTAL NUMBERS OF HOURS
                                </th>
                                <th class="p-1 text-center majority">
                                    NO. OF CLIENTELE/BENEFICIARIES
                                </th>
                                <th class="p-1 text-center majority">
                                    AGENCY
                                </th>
                                <th class="p-1 text-center majority">
                                    DEPARTMENT
>>>>>>> origin/main
                                </th>
                            </tr>

                        </thead>
                        @php
                        use App\Models\Project;
<<<<<<< HEAD
                        use App\Models\SubtaskContributor;
                        @endphp
                        <tbody>
                            @foreach ($allactivities as $allactivity)
                            @if (in_array($allactivity->id, $onlyactivitiesid))
                            <tr>
                                <td class="majority p-2">
                                    @php
                                    $projectname = Project::where('id', $allactivity['project_id'])->first(['projecttitle']);
                                    $projectdept = Project::where('id', $allactivity['project_id'])->first(['department']);
                                    @endphp
                                    {{ $projectname->projecttitle }}
                                </td>
                                <td class="extension p-2">
                                    {{ $allactivity->actname }}
                                </td>
                                <td class="num p-2">
                                    {{ $allactivity->actstartdate . ' - ' . $allactivity->actenddate}}
                                </td>
                                <td class="majority p-2">
                                    N/A
                                </td>
                                <td class="num p-2">
                                    @php
                                    $hoursrendered = SubtaskContributor::where('activity_id', $allactivity['id'])
                                    ->where('approval', 1)
                                    ->where('subtask_id', null)
                                    ->where('user_id', Auth::user()->id)
                                    ->pluck('hours_rendered');
                                    $totalhours = $hoursrendered->sum();
                                    @endphp
                                    {{ $totalhours }}
                                </td>
                                <td class="majority p-2">
                                    -
                                </td>
                                <td class="majority p-2">
                                    -
                                </td>
                                <td class="majority p-2">
                                    {{ $projectdept->department }}
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td class="majority p-2">
                                    @php
                                    $projectname = Project::where('id', $allactivity['project_id'])->first(['projecttitle']);
                                    $projectdept = Project::where('id', $allactivity['project_id'])->first(['department']);
                                    @endphp
                                    {{ $projectname->projecttitle }}
                                </td>
                                <td class="extension p-2">
                                    {{ $allactivity->actname }}
                                </td>
                                <td class="num p-2">
                                    {{ $allactivity->actstartdate . ' - ' . $allactivity->actenddate}}
                                </td>
                                <td class="majority p-2">
                                    N/A
                                </td>
                                <td class="num p-2">
                                    -
                                </td>
                                <td class="majority p-2">
                                    -
                                </td>
                                <td class="majority p-2">
                                    -
                                </td>
                                <td class="majority p-2">
                                    {{ $projectdept->department }}
                                </td>
                            </tr>
                            @foreach ($allsubtasks as $allsubtask)
                            @php
                            $inActivity = false;
                            if ($allsubtask->activity_id == $allactivity->id) {
                            $inActivity = true;
                            }
                            @endphp
                            @if ($inActivity)
                            <tr>
                                <td class="majority p-2">
                                    &nbsp;
                                </td>
                                <td class="extension p-2">
                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $allsubtask->subtask_name }}
                                </td>
                                <td class="num p-2">
                                    {{ $allsubtask->substartdate . ' - ' . $allsubtask->subenddate  }}
                                </td>
                                <td class="majority p-2">
                                    N/A
                                </td>
                                <td class="num p-2">
                                    @php
                                    $hoursrendered = SubtaskContributor::where('subtask_id', $allsubtask['id'])
                                    ->where('approval', 1)
                                    ->where('activity_id', null)
                                    ->where('user_id', Auth::user()->id)
                                    ->pluck('hours_rendered');
                                    $totalhours = $hoursrendered->sum();
                                    @endphp
                                    {{ $totalhours }}
                                </td>
                                <td class="majority p-2">
                                    -
                                </td>
                                <td class="majority p-2">
                                    -
                                </td>
                                <td class="majority p-2">
                                    {{ $projectdept->department }}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                            @endforeach

=======
                        @endphp
                        <tbody>
                            @foreach ($allactivities as $activity)
                            @php
                            $actcontristartdate = null;
                            $actcontrienddate = null;
                            $actcontrihours = null;
                            @endphp

                            @foreach ($activityContributions as $key => $actcontribution)
                            @if ($activity->id === $actcontribution->activity_id)
                            @php
                            $actcontristartdate = $actcontribution->startdate;
                            $actcontrienddate = $actcontribution->enddate;
                            $actcontrihours = $actcontribution->hours_rendered;
                            unset($activityContributions[$key]); // Remove the processed contribution
                            @endphp

                            @break
                            @endif
                            @endforeach

                            <tr>
                                <td class="majority p-1">
                                    @php
                                    $proj = Project::where('id', $activity['project_id'])->first(['projecttitle', 'department']);
                                    $projectdept = Project::where('id', $activity['project_id'])->first(['department']);
                                    @endphp
                                    {{ $proj->projecttitle }}
                                </td>
                                <td class="extension p-1">
                                    {{ $activity->actname }}
                                </td>
                                <td class="num p-1">
                                    {{ $actcontristartdate . ' - ' . $actcontrienddate }}

                                </td>
                                <td class="majority p-1">
                                    N/A
                                </td>
                                <td class="num p-1">
                                    {{ $actcontrihours }}
                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">
                                    {{ $proj->department }}
                                </td>
                            </tr>

                            @if (in_array($activity->id, $otheractivities))

                            @foreach ($subtasks as $key => $subtask)


                            @if ($activity->id === $subtask->activity_id)


                            @foreach ($subtaskcontributions as $key => $subcontribution)
                            @if ($subtask->id === $subcontribution->subtask_id)
                            @php
                            $subdate = $subcontribution->date;
                            $subcontrihours = $subcontribution->hours_rendered;
                            unset($subtaskcontributions[$key]); // Remove the processed contribution
                            @endphp

                            @break
                            @endif
                            @endforeach


                            <tr>
                                <td class="majority p-1">

                                </td>
                                <td class="extension p-1">
                                    {{ $subtask->subtask_name }}
                                </td>
                                <td class="num p-1">
                                    {{ $subdate }}

                                </td>
                                <td class="majority p-1">
                                    N/A
                                </td>
                                <td class="num p-1">
                                    {{ $subcontrihours }}
                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">
                                    {{ $proj->department }}
                                </td>
                            </tr>


                            @php

                            unset($subtasks[$key]); // Remove the processed contribution
                            @endphp


                            @endif

                            @endforeach

                            @endif


                            @endforeach


>>>>>>> origin/main
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
<<<<<<< HEAD

@section('scripts')
<script>
    $(document).ready(function(){
        $('#navbarDropdown').click(function() {
      // Add your function here
      $('#account .dropdown-menu').toggleClass('shows');
  });
=======
@section('scripts')
<script>
    $(document).ready(function() {

        $('#navbarDropdown').click(function(event) {
            // Add your function here
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
        });

        $('#sem-select').change(function() {
            var selectedOption = $(this).find(':selected');
            var selecteday = selectedOption.val();
            var selectedsem = selectedOption.attr('data-sem');

            var baseUrl = "{{ route('records.select', ['username' => Auth::user()->username, 'ayid' => ':selecteday', 'semester' => ':selectedsem']) }}";
            var url = baseUrl.replace(':selecteday', selecteday)
                .replace(':selectedsem', selectedsem);

            window.location.href = url;
        });
>>>>>>> origin/main
    });
</script>

@endsection