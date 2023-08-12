@extends('layouts.app')
@section('content')

<div class="maincontainer">
    &nbsp;
    <div class="container">

        <div class="basiccont mt-2 m-4 me-0 rounded shadow">
            <div class="border-bottom ps-3 pt-2 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">Browse My Records</h6>
            </div>

            <div class="form-floating m-3 mb-2 mt-2">
                @if (!$inCurrentYear)
                <span class="small ms-2"><em>
                        Note: Not the current Semester and AY.
                    </em></span>
                @endif
                <select id="ay-select" class="form-select fw-bold" style="border: 1px solid darkgreen; color:darkgreen; font-size: 21px;" aria-label="Select an acadamic year">
                    @if ($ayfirstsem)
                    @foreach ($allAY as $ay)
                    <option value="{{ $ay['id'] }}" {{ $ay->id == $ayfirstsem->id ? 'selected' : '' }}>
                        {{ 'FIRST SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    <option value="{{ $ay['id'] }}">
                        {{ 'SECOND SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    @endforeach
                    @elseif ($aysecondsem)
                    @foreach ($allAY as $ay)
                    <option value="{{ $ay['id'] }}">
                        {{ 'FIRST SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    <option value="{{ $ay['id'] }}" {{ $ay->id == $aysecondsem->id ? 'selected' : '' }}>
                        {{ 'SECOND SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    </option>
                    @endforeach
                    @endif
                </select>
                <label for="ay-select" style="color:darkgreen;">
                    <h5><strong>SEMESTER and AY:</strong></h5>
                </label>
            </div>

        </div>
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
                                        <em>37 million</em>
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
                                        <em>1 million</em>
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
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>
                                <td class="majority p-1">

                                </td>
                                <td class="extension p-1">

                                </td>
                                <td class="num p-1">


                                </td>
                                <td class="majority p-1">
                                    N/A
                                </td>
                                <td class="num p-1">

                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">

                                </td>
                            </tr>

                            <tr>
                                <td class="majority p-1">

                                </td>
                                <td class="extension p-1">

                                </td>
                                <td class="num p-1">

                                </td>
                                <td class="majority p-1">
                                    N/A
                                </td>
                                <td class="num p-1">
                                    -
                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">

                                </td>
                            </tr>

                            <tr>
                                <td class="majority p-1">
                                    &nbsp;
                                </td>
                                <td class="extension p-1">

                                </td>
                                <td class="num p-1">

                                </td>
                                <td class="majority p-1">
                                    N/A
                                </td>
                                <td class="num p-1">

                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">
                                    -
                                </td>
                                <td class="majority p-1">

                                </td>
                            </tr>


                        </tbody>

                    </table>
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
    });
</script>

@endsection