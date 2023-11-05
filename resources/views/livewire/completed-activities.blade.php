<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-activity"></i>
                Completed

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($xCompletedActivities==0)style="display: none;" @endif>
            <input type="text" class="form-control border border-2 mb-2" id="inputSearchCompletedActivities" placeholder="Enter title...">
            <button type="button" class="btn btn-sm btn-outline-success px-3" id="btnSearchCompletedActivities">Search Activity</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
                Please enter a activity title.
            </span>
        </div>
        <div class="text-center m-1" @if ($xCompletedActivities==0)style="display: none;" @endif>
            <button wire:click="refreshDataCompletedActivities" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        @if ($xCompletedActivities == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showCompletedActivities(1)">
                <b class="small">Show Activities</b>
            </button>

        </div>
        @else
        @if ($CompletedActivities->isEmpty())
        <div class="p-2">
            <h6 class="fw-bold small">No Activities found.</h6>
        </div>
        @else



        <div class="container p-0">

            @foreach ($CompletedActivities as $activity)
            <div class="border-bottom ps-3 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}" data-name="{{ $activity['actname'] }}">

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
                <ul class="pagination justify-content-center m-1 mt-0">

                    @if ($currentPageCompletedActivities === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageCompletedActivities({{ $currentPageCompletedActivities - 1 }})" rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center">
                        <h6 class="fw-bold my-0 mt-2 small">{{ $currentPageCompletedActivities . ' of ' . $totalPagesCompletedActivities }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageCompletedActivities === $totalPagesCompletedActivities)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageCompletedActivities({{ $currentPageCompletedActivities + 1 }})"><i class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>
            <div class="text-center p-2 border border-bottom-2">
                <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showCompletedActivities(0)">
                    <b class="small">Hide Activities</b>
                </button>

            </div>

        </div>

        @endif
        @endif

    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <script>
        document.addEventListener('livewire:load', function() {
            const btnSearchCompletedActivities = document.getElementById('btnSearchCompletedActivities');
            const inputSearchCompletedActivities = document.getElementById('inputSearchCompletedActivities');
            btnSearchCompletedActivities.addEventListener('click', function() {

                var searchInputCompletedActivities = inputSearchCompletedActivities.value;
                if (searchInputCompletedActivities != "") {
                    inputSearchCompletedActivities.classList.remove('is-invalid');

                    Livewire.emit('findCompletedActivities', searchInputCompletedActivities, 2);

                } else {
                    inputSearchCompletedActivities.classList.add('is-invalid');
                }
            });

            inputSearchCompletedActivities.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
                    var searchInputCompletedActivities = inputSearchCompletedActivities.value;
                    if (searchInputCompletedActivities != "") {
                        inputSearchCompletedActivities.classList.remove('is-invalid');

                        Livewire.emit('findCompletedActivities', searchCompletedActivities, 2);

                    } else {
                        inputSearchCompletedActivities.classList.add('is-invalid');
                    }
                }
            });
        });
    </script>
</div>