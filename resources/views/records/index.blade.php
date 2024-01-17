@extends('layouts.app')
@section('content')





<div class="container">

    <div class="maincontainer shadow">
        &nbsp;

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

        <div class="basiccont shadow" id="printableContent">
            <div class="text-center shadow text-white p-2 pt-3 imbentobg">
                <h5 class="fw-bold">
                    @if ($ayfirstsem)
                    @foreach ($allAY as $ay)
                    @if( $ay->id == $ayfirstsem->id )
                    {{ 'EXTENSION SERVICES RECORD FOR THE FIRST SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    @break
                    @endif

                    @endforeach
                    @elseif ($aysecondsem)
                    @foreach ($allAY as $ay)
                    @if($ay->id == $aysecondsem->id)

                    {{ 'EXTENSION SERVICES RECORD FOR THE SECOND SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    @break
                    @endif
                    @endforeach
                    @elseif ($latestAy)
                    @foreach ($allAY as $ay)
                    @if( $ay->id == $latestAy->id )
                    {{ 'FIRST SEMESTER, AY ' . \Carbon\Carbon::parse($ay->acadstartdate)->format('Y') . '-' . \Carbon\Carbon::parse($ay->acadenddate)->format('Y') }}
                    @break
                    @endif

                    @endforeach
                    @endif
                </h5>
            </div>
            <div class="row m-1">
                <div class="col-lg-4">
                    <div class="card card-size">
                        <div class="row">
                            <div class="col-md-4 card-image">
                                <img src="{{ asset('images/default-user-image.png')}}" alt="Image" class="img-fluid p-1" width="100">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
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

                <div class="col-lg-4">
                    <div class="card card-size">
                        <div class="row">
                            <div class="col-md-4 card-image">
                                <img src="{{ asset('images/total-hours-image.png')}}" alt="Image" class="img-fluid p-1" width="100">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <h6 class="card-title fw-bold">
                                        Total Hours Rendered:
                                    </h6>
                                    <p class="card-text">
                                        <em>{{ $totalhoursrendered }}</em>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-size">
                        <div class="row">
                            <div class="col-md-4 card-image">
                                <img src="{{ asset('images/total-activity-image.png')}}" alt="Image" class="img-fluid p-1" width="100">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <h6 class="card-title fw-bold">
                                        Total Number of Activities Conducted:
                                    </h6>
                                    <p class="card-text">
                                        <em>{{ count($allactivities) }}</em>
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
                                <th class="p-1 text-center role">
                                    ROLE
                                </th>
                                <th class="p-1 text-center majority">
                                    RELATED PROGRAM/S (if any)
                                </th>
                                <th class="p-1 text-center num">
                                    TOTAL NUMBERS OF HOURS
                                </th>
                                <th class="p-1 text-center num">
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
                                <td class="majority p-1">
                                    {{ $proj->projecttitle }}
                                </td>
                                <td class="extension p-1">
                                    {{ 'Activity: ' . $activity->actname }}
                                    @if ($filteredActContriCount != 0)
                                    {{ " (" . $filteredActContriCount . ")" }}
                                    @endif
                                </td>
                                <td class="num p-1">
                                    {{ date('M d, Y', strtotime($filteredActContri->startdate)) }}
                                    to

                                    {{ date('M d, Y', strtotime($filteredActContri->enddate)) }}


                                </td>
                                <td class="p-1 role">
                                    {{ $proj->role }}
                                </td>
                                <td class="majority p-1">
                                    @if($filteredActContri->relatedPrograms)
                                    {{ $filteredActContri->relatedPrograms }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="num p-1">
                                    {{ $filteredActContri->hours_rendered }}
                                </td>
                                <td class="num p-1">
                                    @if($filteredActContri->clientNumbers)
                                    {{ $filteredActContri->clientNumbers }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="majority p-1">
                                    @if($filteredActContri->agency)
                                    {{ $filteredActContri->agency }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="majority p-1">
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
                                <td class="majority p-1">
                                    {{ $proj->projecttitle }}
                                </td>
                                <td class="extension p-1">
                                    {{ 'Subtask: ' . $subtask->subtask_name }}
                                    @if ($filteredContriCount != 0)
                                    {{ " (" . $filteredContriCount . ")" }}
                                    @endif
                                </td>
                                <td class="num p-1">
                                    {{ date('M d, Y', strtotime($filteredContri->date)) }}
                                    to

                                    {{ date('M d, Y', strtotime($filteredContri->enddate)) }}


                                </td>
                                <td class="p-1 role">
                                    {{ $proj->role }}
                                </td>
                                <td class="majority p-1">
                                    @if($filteredContri->relatedPrograms)
                                    {{ $filteredContri->relatedPrograms }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="num p-1">
                                    {{ $filteredContri->hours_rendered }}
                                </td>
                                <td class="num p-1">
                                    @if($filteredContri->clientNumbers)
                                    {{ $filteredContri->clientNumbers }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="majority p-1">
                                    @if($filteredContri->agency)
                                    {{ $filteredContri->agency }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="majority p-1">
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

            </div>

        </div>
        <div class="d-flex justify-content-center align-items-center">
            @if (!$ayid)
            <button type="button" class="btn btn-outline-success px-5 m-2" id="generatePdf">
                Download Table(pdf)</button>
            @else
            <button type="button" class="btn btn-outline-success px-5 m-2" id="generateSelectedPdf" data-ayid="{{ $ayid }}" data-semester="{{ $semester }}">
                Download Table(pdf)</button>
            @endif
        </div>
    </div>

</div>




@endsection
@section('scripts')
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script> -->
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
                        -->
<script>
    /*
    function generatePDF() {
        const jsPDF = window.jsPDF = window.jspdf.jsPDF;
        const printableContent = document.getElementById('printableContent');

        html2canvas(printableContent).then(canvas => {
            const pdf = new jsPDF({
                orientation: 'landscape',
                format: 'a4'
            });

            // Calculate the aspect ratio of A4 landscape
            const aspectRatio = pdf.internal.pageSize.getWidth() / pdf.internal.pageSize.getHeight();

            // Set margins (adjust these values as needed)
            const marginLeft = 10;
            const marginRight = 10;
            const marginTop = 10;
            const marginBottom = 10;

            // Adjust canvas dimensions to match the aspect ratio and include margins
            const canvasWidth = pdf.internal.pageSize.getWidth() - marginLeft - marginRight;
            const canvasHeight = canvasWidth / aspectRatio;

            // Add image to PDF with margins
            pdf.addImage(canvas.toDataURL('image/png'), 'PNG', marginLeft, marginTop, canvasWidth, canvasHeight);

            pdf.save('download.pdf');
        });
    }



*/
    $(document).ready(function() {


        $('#generatePdf').click(function() {
            var randomNumber = Math.floor(Math.random() * (1000000 - 1 + 1)) + 1;
            var url = "{{ route('pdf.generate', ['username' => Auth::user()->username, 'random' => 'randomNumber' ]) }}";

            // Replace 'randomNumber' in the URL with the actual random number
            url = url.replace('randomNumber', randomNumber);

            // Use window.location.href to navigate to the generated URL
            window.location.href = url;
        });
        $('#generateSelectedPdf').click(function() {

            var randomNumber = Math.floor(Math.random() * (1000000 - 1 + 1)) + 1;
            var url = "{{ route('selectedPdf.generate', ['username' => Auth::user()->username, 'ayid' => ':ayid', 'semester' => ':semester', 'random' => 'randomNumber' ]) }}";

            // Replace 'randomNumber' in the URL with the actual random number
            url = url.replace('randomNumber', randomNumber);
            url = url.replace(':ayid', $(this).attr('data-ayid'));
            url = url.replace(':semester', $(this).attr('data-semester'));
            // Use window.location.href to navigate to the generated URL
            window.location.href = url;
        });

        $('#sem-select').change(function() {
            var selectedOption = $(this).find(':selected');
            var selecteday = selectedOption.val();
            var selectedsem = selectedOption.attr('data-sem');

            var baseUrl =
                "{{ route('records.select', ['username' => Auth::user()->username, 'ayid' => ':selecteday', 'semester' => ':selectedsem']) }}";
            var url = baseUrl.replace(':selecteday', selecteday)
                .replace(':selectedsem', selectedsem);

            window.location.href = url;
        });
    });
</script>

@endsection