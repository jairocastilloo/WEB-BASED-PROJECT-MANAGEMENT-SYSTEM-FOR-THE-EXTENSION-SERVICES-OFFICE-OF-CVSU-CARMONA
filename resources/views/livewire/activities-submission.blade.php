<div>
    @php
    $currentDate = strtotime('today');
    $formattedCurrentDate = date('Y-m-d', $currentDate);
    @endphp

    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">

                Accomplishment Reports

            </h6>
        </div>


        @if ($activityContribution->isEmpty())
        <div class="p-2 text-center">
            <h6 class="fw-bold small">No Accomplishment Reports</h6>
        </div>
        @else



        <div class="container p-0">


            @php


            $activityContribution = $activityContribution->map(function ($contri) use (&$countAccepted) {
            if ($contri['approval'] === null) {
            $contri['submission_remark'] = 'For Evaluation';
            } elseif ($contri['approval'] === 1) {
            $countAccepted++;
            $contri['submission_remark'] = 'Accepted';
            } elseif ($contri['approval'] === 0) {
            $contri['submission_remark'] = 'For Revision';
            } else {
            $contri['submission_remark'] = 'Unknown'; // Handle other cases if needed
            }

            return $contri;
            });
            @endphp

@foreach ($activityContribution as $submission)
    <div class="p-2 pb-1 ps-3 divhover border-bottom actsubmission-div small" data-id="{{ $submission->id }}" data-approval="{{ $submission->approval }}">
        <p class="lh-sm fw-bold @if($submission->submission_remark == 'For Approval') text-success @elseif($submission->submission_remark == 'For Revision') text-danger @else text-primary @endif">
            <em>{{ $submission->submission_remark }}</em>
        </p>
        <p class="lh-sm pl-3">Activity Hours: {{ $submission->hours_rendered }}</p>
        <p class="lh-sm pl-3">Actual Duration: {{ \Carbon\Carbon::parse($submission->startdate)->format('F d, Y') . ' to ' . \Carbon\Carbon::parse($submission->enddate)->format('F d, Y') }}</p>
        <p class="lh-sm pl-3">Submitted in: {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }}</p>
        @if ($submission->notes != null)
            <p class="lh-sm pl-3"><em>Notes: {{ $submission->notes }}</em></p>
        @endif
    </div>
@endforeach






            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1">

                    @if ($currentPageActivityContribution === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageActivityContribution({{ $currentPageActivityContribution - 1 }})"
                            rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center mx-2">
                        <h6 class="fw-bold my-0 mt-2 small">
                            {{ $currentPageActivityContribution . ' of ' . $totalPagesActivityContribution }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageActivityContribution=== $totalPagesActivityContribution)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageActivityContribution({{ $currentPageActivityContribution + 1 }})"><i
                                class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>


        </div>

        @endif




    </div>

</div>

