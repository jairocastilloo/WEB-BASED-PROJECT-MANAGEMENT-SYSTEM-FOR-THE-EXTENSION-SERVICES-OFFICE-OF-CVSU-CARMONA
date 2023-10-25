<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-kanban"></i>
                In Progress

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($xInProgressActivities==0)style="display: none;" @endif>
            <input type="text" class="form-control border border-2 mb-2" id="inputSearchInProgressActivitiess" placeholder="Enter title...">
            <button type="button" class="btn btn-sm btn-outline-success px-3" id="btnSearchInProgressActivities">Search Activities</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
                Please enter a activity title.
            </span>
        </div>
        <div class="text-center m-1" @if ($xInProgressActivities==0)style="display: none;" @endif>
            <button wire:click="refreshDataInProgressActivities" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        @if ($xInProgressActivities == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showInProgressActivities(1)">
                <b class="small">Show Activities</b>
            </button>

        </div>
        @else
        @if ($InProgressActivities->isEmpty())
        <div class="p-2">
            <h6 class="fw-bold small">No Activities found.</h6>
        </div>
        @else



        <div class="container p-0">

            @foreach ($InProgressActivities as $activity)
            <div class="border-bottom ps-4 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}" data-name="{{ $activity['actname'] }}">

                <h6 class="fw-bold small">{{ $activity['actname'] }}</h6>

                @php
                $startDate = date('M d', strtotime($activity['actstartdate']));
                $endDate = date('M d', strtotime($activity['actenddate']));
                @endphp

                <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>
            </div>

            @endforeach
            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1 mt-0">

                    @if ($currentPageInProgressActivities === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageInProgressActivities({{ $currentPageInProgressActivities - 1 }})" rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center">
                        <h6 class="fw-bold my-0 mt-2 small">{{ $currentPageInProgressActivities . ' of ' . $totalPagesInProgressActivities }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageInProgressActivities === $totalPagesInProgressActivities)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageInProgressActivities({{ $currentPageInProgressActivities + 1 }})"><i class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>
            <div class="text-center p-2 border border-bottom-2">
                <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showInProgressActivities(0)">
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
            const btnSearchInProgressActivities = document.getElementById('btnSearchInProgressActivities');
            const inputSearchInProgressActivities = document.getElementById('inputSearchInProgressActivities');
            btnSearchInProgressActivities.addEventListener('click', function() {

                var searchInputInProgressActivities = inputSearchInProgressActivities.value;
                if (searchInputInProgressActivities != "") {
                    inputSearchInProgressActivities.classList.remove('is-invalid');

                    Livewire.emit('findInProgressActivities', searchInputInProgressActivities, 2);

                } else {
                    inputSearchInProgressActivities.classList.add('is-invalid');
                }
            });

            inputSearchInProgressActivities.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
                    var searchInputInProgressActivities = inputSearchInProgressActivities.value;
                    if (searchInputInProgressActivities != "") {
                        inputSearch.classList.remove('is-invalid');

                        Livewire.emit('findInProgressActivities', searchInputInProgressActivities, 2);

                    } else {
                        inputSearchInProgressActivities.classList.add('is-invalid');
                    }
                }
            });
        });
    </script>
</div>