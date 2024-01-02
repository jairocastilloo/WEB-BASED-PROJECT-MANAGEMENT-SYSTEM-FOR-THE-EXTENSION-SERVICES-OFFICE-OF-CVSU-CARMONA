@extends('layouts.app')
@section('content')


<div class="maincontainer border border-start border-end border-top-0 p-2">

    <!--
<button id="downloadAccPDF">Download PDF</button>
-->
    <div class="container d-flex align-items-center justify-content-center">
        <div class="pdfReport">

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
                <div class="deptAndPeriod ms-2">
                    <div class="row">
                        <div class="col">
                            <div class="flex-container">
                                <b>Department:</b>
                                <div class="underline-space inline-div ms-2 me-1">
                                    &nbsp;&nbsp;{{ $department }}
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="flex-container">
                                <b>Period Covered:</b>
                                <div class="underline-space inline-div ms-2 me-2">
                                    &nbsp;&nbsp;@php
                                    $start = date('F Y', strtotime($startDate));
                                    $end = date('F Y', strtotime($endDate));

                                    $startMonthYear = date('F Y', strtotime($startDate));
                                    $endMonthYear = date('F Y', strtotime($endDate));

                                    if ($startMonthYear == $endMonthYear) {
                                    echo $start;
                                    } else {
                                    echo $start . ' - ' . $end;
                                    }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>

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
                        @foreach ($activityContributions as $activityContribution)
                        <tr>
                            <td class="projectTD">{{ $activityContribution->projecttitle }}</td>
                            <td class="activityTD">{{ $activityContribution->actname }}</td>
                            <td class="dateTD">
                                @php
                                $start = date('F j, Y', strtotime($activityContribution->startdate));
                                $end = date('F j, Y', strtotime($activityContribution->enddate));

                                $startMonthYear = date('F Y', strtotime($activityContribution->startdate));
                                $endMonthYear = date('F Y', strtotime($activityContribution->enddate));

                                if ($startMonthYear == $endMonthYear) {
                                echo $start . ' - ' . $end;
                                } else {
                                echo $start;
                                }
                                @endphp
                            </td>
                            <td class="hoursTD">{{ $activityContribution->hours_rendered }}</td>
                            <td class="involvedTD">
                                @php
                                $users = $activityContribution->users;
                                @endphp
                                <ul class="list-unstyled">
                                    @foreach ($users as $user)
                                    <li>{{ $user }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="clientTD">{{ $activityContribution->clientNumbers }}</td>
                            <td class="partnerTD">{{ $activityContribution->agency }}</td>
                        </tr>
                        @endforeach



                    </tbody>
                </table>


            </div>

        </div>

    </div>
    <div class="p-4 text-center">
        <button type="button" class="btn btn-success px-5" id="downloadAccPDF">Download PDF</button>
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
        const content = $('.pdfReport');
        var contentHeight = content.height();
        const divNumber = Math.ceil(contentHeight / 674);

        // Create a new jsPDF instance
        var pdf = new jsPDF({
            unit: 'px',
            format: 'a4',
            orientation: 'landscape',
        });

        for (let x = 1; x <= divNumber; x++) {
            var pdfContainer = document.querySelector(`.page-${x}`);
            pdfContainer.style.display = 'block';
            // Use html2canvas to capture the content as an image
            html2canvas(pdfContainer, {
                scale: 1, // You can adjust the scale factor as needed
            }).then(function(canvas) {
                // Convert the canvas to an image data URL
                var imgData = canvas.toDataURL('image/jpeg');

                // Add the page with equal margins on all sides
                pdf.addImage(imgData, 'JPEG', 0, 0);

                if (x < divNumber) {
                    // Add a new page for subsequent content
                    pdf.addPage();
                }
                pdfContainer.style.display = 'none';
                if (x === divNumber) {
                    // Save or download the PDF after processing all pages
                    pdf.save('downloaded-document.pdf');
                    console.log('PDF generated and downloaded successfully!');
                }
            });
        }

    });


    $(document).ready(function() {

        const content = $('.pdfReport');
        var contentHeight = content.height();
        const divNumber = Math.ceil(contentHeight / 674);

        for (let x = 1; x <= divNumber; x++) {
            // Your code here

            if (x == 1) {

                // Create a new div with the specified classes
                var newDiv = $(`
            <div class="page-${x} print-page">
                <div class="beforeprint-page beforeprint-page-${x}"></div>
            </div>
        `);

                // Insert the new div after the first .pdfReport div
                newDiv.insertAfter('.pdfReport:first');

                // Clone the .pdfReport div and add a new class to the clone
                var clone = $('.pdfReport:first').clone();
                clone.addClass(`pdfReport-${x}`);



                // Append the clone to the .beforeprint-page div
                $(`.beforeprint-page-${x}`).append(clone);

                // Update contentHeight
                contentHeight -= 674;

            } else {

                // Create a new div with the specified classes
                var newDiv = $(`
            <div class="page-${x} print-page">
                <div class="beforeprint-page beforeprint-page-${x}"></div>
            </div>
        `);

                // Insert the new div after the first .pdfReport div
                newDiv.insertAfter(`.page-${x-1}`);

                // Clone the .pdfReport div and add a new class to the clone
                var clone = $('.pdfReport:first').clone();
                //clone.addClass(`pdfReport-${x}`);

                var marginTop = 674 * (x - 1); // Adjusted to start from 0 for the first page
                clone.css('margin-top', `-${marginTop}px`);

                // Append the clone to the .beforeprint-page div
                $(`.beforeprint-page-${x}`).append(clone);

                // Update contentHeight
                contentHeight -= 674;

            }
            $(`.page-${x}`).css('display', `none`);
        }

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