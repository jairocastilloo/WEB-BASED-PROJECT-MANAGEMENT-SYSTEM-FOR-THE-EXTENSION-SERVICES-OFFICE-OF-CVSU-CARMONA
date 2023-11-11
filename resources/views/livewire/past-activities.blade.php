<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-activity"></i>
                Overdue

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($xPastActivities==0)style="display: none;" @endif>
            <input type="text" class="form-control border border-2 mb-2" id="inputSearchPastActivities" placeholder="Enter title...">
            <button type="button" class="btn btn-sm btn-outline-success px-3" id="btnSearchPastActivities">Search Activity</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
                Please enter a activity title.
            </span>
        </div>
        <div class="text-center m-1" @if ($xPastActivities==0)style="display: none;" @endif>
            <button wire:click="refreshDataPastActivities" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        @if ($xPastActivities == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showPastActivities(1)">
                <b class="small">Show Activities</b>
            </button>

        </div>
        @else
        @if ($PastActivities->isEmpty())
        <div class="p-2 text-center">
            <h6 class="fw-bold small">No Overdue Activities</h6>
        </div>
        @else



        <div class="container p-0">

            @foreach ($PastActivities as $activity)
            <div class="border-bottom ps-3 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}" data-name="{{ $activity['actname'] }}" style="position: relative;">

                <h6 class="fw-bold small" style="color: #4A4A4A;">{{ $activity['actname'] }}</h6>

                @php
                $startDate = date('M d, Y', strtotime($activity['actstartdate']));
                $endDate = date('M d, Y', strtotime($activity['actenddate']));
                @endphp
                <h6 class="text-secondary small">{{ 'Created ' . date('M d, Y', strtotime($activity['created_at'])) }}</h6>
                <h6 class="ps-2 text-success fw-bold small"> {{ $startDate }} - {{ $endDate }}</h6>

            </div>

            @endforeach
            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1">

                    @if ($currentPagePastActivities === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePagePastActivities({{ $currentPagePastActivities - 1 }})" rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center mx-2">
                        <h6 class="fw-bold my-0 mt-2 small">{{ $currentPagePastActivities . ' of ' . $totalPagesPastActivities }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPagePastActivities === $totalPagesPastActivities)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePagePastActivities({{ $currentPagePastActivities + 1 }})"><i class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>

        </div>

        @endif
        <div class="text-center p-2 border border-bottom-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showPastActivities(0)">
                <b class="small">Hide Activities</b>
            </button>

        </div>

        @endif

    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <script>
        document.addEventListener('livewire:load', function() {
            const btnSearchPastActivities = document.getElementById('btnSearchPastActivities');
            const inputSearchPastActivities = document.getElementById('inputSearchPastActivities');
            btnSearchPastActivities.addEventListener('click', function() {

                var searchInputPastActivities = inputSearchPastActivities.value;
                if (searchInputPastActivities != "") {
                    inputSearchPastActivities.classList.remove('is-invalid');

                    Livewire.emit('findPastActivities', searchInputPastActivities, 2);

                } else {
                    inputSearchPastActivities.classList.add('is-invalid');
                }
            });

            inputSearchPastActivities.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
                    var searchInputPastActivities = inputSearchPastActivities.value;
                    if (searchInputPastActivities != "") {
                        inputSearchPastActivities.classList.remove('is-invalid');

                        Livewire.emit('findPastActivities', searchPastActivities, 2);

                    } else {
                        inputSearchPastActivities.classList.add('is-invalid');
                    }
                }
            });
        });
    </script>
</div>