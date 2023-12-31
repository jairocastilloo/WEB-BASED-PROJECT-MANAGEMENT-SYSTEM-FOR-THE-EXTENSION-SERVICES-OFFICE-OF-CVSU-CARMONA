@extends('layouts.app')
@section('content')

<button id="removeContent" type="button"> Remove</button>
<div class="pdfReport">
    <div class="print-page">
        <div class="headerSection downloadableTable-1 headerSection-1">
            <div class="header">
                <p>Republic of the Philippines</p>
                <p><b>CAVITE STATE UNIVERSITY</b></p>
                <p><b>Carmona Campus</b></p>
                <p>Market Road, Carmona, Cavite</p>
                <p><i>(046) 487-6328/cvsucarmona@cvsu.edu.ph</i></p>
                <p>www.cvsu.edu.ph</p>
                <br>
                <br>
                <p><b>EXTENSION SERVICES OFFICE</b></p>
                <br>
                <p><b>ACCOMPLISHMENT REPORT</b></p>
                <br>
                <br>


            </div>
            <div class="deptAndPeriod ms-4">
                <div class="row">
                    <div class="col">
                        <div class="flex-container">
                            <b>Department:</b>
                            <div class="underline-space inline-div ms-3 me-5">
                                &nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="flex-container">
                            <b>Period Covered:</b>
                            <div class="underline-space inline-div ms-3 me-5">
                                &nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                </br>

            </div>
            <table>
                <thead>
                    <tr>
                        <th class="projectTD">PROJECT</th>
                        <th class="activityTD">EXTENSION ACTIVITY</th>
                        <th class="dateTD">DATE CONDUCTED</th>
                        <th class="hoursTD">HOURS RENDERED</th>
                        <th class="involvedTD">EXTENSIONIST INVOLVED</th>
                        <th class="clientTD">NO. OF CLIENTELE/BENEFICIARIES</th>
                        <th class="partnerTD">PARTNER AGENCT</th>
                    </tr>
                </thead>
                <tbody>

                    @for ($i = 1; $i <= 5; $i++) <tr id="reportTableRow[{{ $i }}]" data-value="false">
                        <td class="projectTD">Row {{ $i }}, Cell 1</td>
                        <td class="activityTD">Row {{ $i }}, Cell 2</td>
                        <td class="dateTD">Row {{ $i }}, Cell 3</td>
                        <td class="hoursTD">Row {{ $i }}, Cell 4</td>
                        <td class="involvedTD">Row {{ $i }}, Cell 5</td>
                        <td class="clientTD">Row {{ $i }}, Cell 6</td>
                        <td class="partnerTD">Row {{ $i }}, Cell 7</td>
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>

    </div>
</div>

<button id="downloadAccPDF" class="d-none">Download PDF</button>
<div class="container d-none">

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

                <select id="sem-select" class="form-select fw-bold"
                    style="border: 1px solid darkgreen; color:darkgreen; font-size: 18px;"
                    aria-label="Select an acadamic year and semster">
                    @if ($ayfirstsem)
                    @foreach ($allAY as $ay)
                    <option data-sem="1STSEM" value="{{ $ay['id'] }}"
                        {{ $ay->id == $ayfirstsem->id ? 'selected' : '' }}>
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
                    <option data-sem="2NDSEM" value="{{ $ay['id'] }}"
                        {{ $ay->id == $aysecondsem->id ? 'selected' : '' }}>
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
                    EXTENSION SERVICES RECORDS FOR THE FIRST SEMESTER, AY 2022-2023
                </h5>
            </div>
            <div class="row m-1">
                <div class="col-lg-4">
                    <div class="card card-size">
                        <div class="row">
                            <div class="col-md-4 card-image">
                                <img src="{{ asset('images/default-user-image.png')}}" alt="Image" class="img-fluid p-1"
                                    width="100">
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
                                <img src="{{ asset('images/total-hours-image.png')}}" alt="Image" class="img-fluid p-1"
                                    width="100">
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
                                <img src="{{ asset('images/total-activity-image.png')}}" alt="Image"
                                    class="img-fluid p-1" width="100">
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
            <button class="btn btn-outline-success px-5 m-2" onclick="generatePDF()">Download
                Table(pdf)</button>
        </div>
    </div>

</div>




@endsection
@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
                        -->
<script>
document.getElementById('downloadAccPDF').addEventListener('click', function() {

    const jsPDF = window.jsPDF = window.jspdf.jsPDF;

    var pdfContainer = document.querySelector('.pdfReport');

    // Use html2canvas to capture the content as an image
    html2canvas(pdfContainer, {
        scale: 2, // You can adjust the scale factor as needed
    }).then(function(canvas) {
        // Create a new jsPDF instance
        var pdf = new jsPDF({
            unit: 'px',
            format: 'a4',
            orientation: 'landscape',

        });

        // Add the captured image to the PDF
        var imgData = canvas.toDataURL('image/jpeg', 1.0);
        var imgWidth = pdf.internal.pageSize.width;
        var imgHeight = (canvas.height * imgWidth) / canvas.width;


        // Initial y position is 0 (top of the first page)
        var yPos = 0;
        // You can adjust the margin value as needed

        // Add the first page with equal margins on all sides
        pdf.addImage(imgData, 'JPEG', 0, yPos, imgWidth, imgHeight);


        // Calculate the remaining height after the first page
        var remainingHeight = imgHeight - pdf.internal.pageSize.height;

        // Continue adding new pages for the remaining content
        while (remainingHeight > 0) {
            pdf.addPage();
            yPos = -remainingHeight; // Move yPos to the top of the new page
            pdf.addImage(imgData, 'JPEG', 0, yPos, imgWidth, imgHeight);
            remainingHeight -= pdf.internal.pageSize.height;
        }

        // Save or download the PDF
        pdf.save('downloaded-document.pdf');

        console.log('PDF generated and downloaded successfully!');
    });

    /**
        html2canvas(printableContent).then(canvas => {
            const pdf = new jsPDF({
                orientation: 'landscape',
                format: 'a4'
            });

            // Calculate the aspect ratio of A4 landscape
            const aspectRatio = pdf.internal.pageSize.getWidth() / pdf.internal.pageSize.getHeight();

            // Adjust canvas dimensions to match the aspect ratio
            const canvasWidth = pdf.internal.pageSize.getWidth();
            const canvasHeight = canvasWidth / aspectRatio;

            pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, canvasWidth, canvasHeight);
            pdf.save('download.pdf');
        });
        */
    // Get the element containing the content you want to convert to PDF
    /**
    var pdfContainer = document.querySelector('.pdfReport');

    // Use html2canvas to capture the content as an image
    html2canvas(pdfContainer, {
        scale: 2, // You can adjust the scale factor as needed
    }).then(function(canvas) {
        // Create a new jsPDF instance
        var pdf = new jsPDF({
            unit: 'px',
            format: 'a4',
            orientation: 'portrait'
        });

        // Add the captured image to the PDF
        pdf.addImage(canvas.toDataURL('image/jpeg', 1.0), 'JPEG', 0, 0, pdf.internal.pageSize.width, pdf
            .internal.pageSize.height);

        // Save or download the PDF
        pdf.save('downloaded-document.pdf');

        console.log('PDF generated and downloaded successfully!');
    });
    */
});

/*
document.getElementById('downloadAccPDF').addEventListener('click', function() {
    try {
        // Use html2pdf to add the content to the PDF with custom styles
        html2pdf(document.querySelector('.pdfReport'), {
            margin: {
                top: 60,
                right: 67.2,
                bottom: 60,
                left: 67.2
            },
            filename: 'downloaded-document.pdf',
            jsPDF: {
                unit: 'px',
                format: 'a4',
                orientation: 'portrait'
            },
            page: {
                margin: 0
            }, // Reset the page margin since it's set globally
            font: {
                size: 11,
                family: 'calibri'
            }
        }).then(() => {
            console.log('PDF generated and downloaded successfully!');
        });
    } catch (error) {
        console.log('Error generating PDF:', error);
    }
});
*/
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

        // Adjust canvas dimensions to match the aspect ratio
        const canvasWidth = pdf.internal.pageSize.getWidth();
        const canvasHeight = canvasWidth / aspectRatio;

        pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, canvasWidth, canvasHeight);
        pdf.save('download.pdf');
    });
}


*/

$(document).ready(function() {
    const content = $('.pdfReport');
    const contentHeight = content.height();

    const halfHeight = contentHeight / 2;

    // First page
    const firstPage = $('<div class="print-page"></div>');
    content.after(firstPage);

    const firstPageContent = content.clone();
    firstPageContent.css('height', halfHeight + 'px');
    firstPageContent.removeClass('nonContent');
    firstPage.append(firstPageContent);

    // Second page
    const secondPage = $('<div class="print-page"></div>');
    content.after(secondPage);

    const secondPageContent = content.clone();
    secondPageContent.css({
        'height': halfHeight + 'px',
        'margin-top': '-' + halfHeight + 'px' // Adjust the negative margin
    });
    secondPageContent.removeClass('nonContent');
    secondPage.append(secondPageContent);

    $('#removeContent').on('click', function() {
        $('.pdfReport div:first').hide();

    });
    /*
    $('#downloadAccPDF').on('click', function() {
        // Create a new jsPDF instance
        try {
            // Use html2pdf to add the content to the PDF with custom styles
            html2pdf($('.pdfReport')[0], {
                margin: {
                    top: 60,
                    right: 67.2,
                    bottom: 60,
                    left: 67.2
                },
                filename: 'downloaded-document.pdf',
                jsPDF: {
                    unit: 'px',
                    format: 'a4',
                    orientation: 'portrait'
                },
                page: {
                    margin: 0
                }, // Reset the page margin since it's set globally
                font: {
                    size: 11,
                    family: 'calibri'
                }
            }).then(() => {
                console.log('PDF generated and downloaded successfully!');
            });
        } catch (error) {
            console.log('Error generating PDF:', error);
        }
    });
    */
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
