<div>
    @php
    // Sort the $activities array by actstartdate in ascending order
    $sortedActivities = $activities->sortBy('actstartdate');
    @endphp
    @foreach ($sortedActivities as $activity)

    <div class="border-bottom ps-4 p-2 divhover actdiv" data-value="{{ $activity['id'] }}">

        <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

        @php
        $startDate = date('M d', strtotime($activity['actstartdate']));
        $endDate = date('M d', strtotime($activity['actenddate']));
        @endphp

        <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
    </div>

    @endforeach
</div>