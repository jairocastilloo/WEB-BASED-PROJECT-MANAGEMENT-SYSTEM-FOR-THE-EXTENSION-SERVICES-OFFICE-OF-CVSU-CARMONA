@extends('layouts.app')
@section('content')

<div class="maincontainer">
    &nbsp;
    <div class="container">
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
                                </th>
                            </tr>

                        </thead>

                        <tbody>
                            <tr>
                                <td class="majority p-2">
                                    asdasdas
                                </td>
                                <td class="extension p-2">
                                    asdasdas
                                </td>
                                <td class="num p-2">
                                    asdasdas
                                </td>
                                <td class="majority p-2">
                                    asdasdas
                                </td>
                                <td class="num p-2">
                                    asdasdas
                                </td>
                                <td class="majority p-2">
                                    asdasdas
                                </td>
                                <td class="majority p-2">
                                    asdasdas
                                </td>
                                <td class="majority p-2">
                                    asdasdas
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