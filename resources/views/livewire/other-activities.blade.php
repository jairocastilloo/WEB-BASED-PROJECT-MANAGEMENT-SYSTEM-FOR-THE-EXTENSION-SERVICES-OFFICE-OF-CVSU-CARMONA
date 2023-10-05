<div>
    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pt-2 bggreen">
            <h6 class="fw-bold small" style="color:darkgreen;">Activities</h6>
        </div>
        <div class="input-container m-2">
            <input type="text" class="form-control" wire:model="search" placeholder="Search activities...">
        </div>
        @foreach ($activities as $act)
        <div class="border-bottom ps-4 p-2 divhover actdiv" data-value="{{ $act['id'] }}" data-name="{{ $act->actname }}">

            <h6 class="fw-bold small">{{ $act['actname'] }} - <span class="text-success">{{ $act['actremark'] }}</span></h6>

            @php
            $startDate = date('M d, Y', strtotime($act['actstartdate']));
            $endDate = date('M d, Y', strtotime($act['actenddate']));
            @endphp

            <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
        </div>
        @endforeach
    </div>
</div>