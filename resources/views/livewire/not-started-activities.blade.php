<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-kanban"></i>
                Not Started

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($xNotStartedActivities==0)style="display: none;" @endif>
            <input type="text" class="form-control border border-2 mb-2" id="inputSearchNotStartedActivities" placeholder="Enter title...">
            <button type="button" class="btn btn-sm btn-outline-success px-3" id="btnSearchNotStartedActivities">Search Activity</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
                Please enter a activity title.
            </span>
        </div>
        <div class="text-center m-1" @if ($xNotStartedActivities==0)style="display: none;" @endif>
            <button wire:click="refreshDataNotStartedActivities" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        @if ($xNotStartedActivities == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showNotStartedActivities(1)">
                <b class="small">Show Activities</b>
            </button>

        </div>
        @else
        @if ($NotStartedActivities->isEmpty())
        <div class="p-2">
            <h6 class="fw-bold small">No Activities found.</h6>
        </div>
        @else



        <div class="container p-0">

            @foreach ($NotStartedActivities as $activity)
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

                    @if ($currentPageNotStartedActivities === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageNotStartedActivities({{ $currentPageNotStartedActivities - 1 }})" rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center">
                        <h6 class="fw-bold my-0 mt-2 small">{{ $currentPageNotStartedActivities . ' of ' . $totalPagesNotStartedActivities }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageNotStartedActivities === $totalPagesNotStartedActivities)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageNotStartedActivities({{ $currentPageNotStartedActivities + 1 }})"><i class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>
            <div class="text-center p-2 border border-bottom-2">
                <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showNotStartedActivities(0)">
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
            const btnSearchNotStartedActivities = document.getElementById('btnSearchNotStartedActivities');
            const inputSearchNotStartedActivities = document.getElementById('inputSearchNotStartedActivities');
            btnSearchNotStartedActivities.addEventListener('click', function() {

                var searchInputNotStartedActivities = inputSearchNotStartedActivities.value;
                if (searchInputNotStartedActivities != "") {
                    inputSearchNotStartedActivities.classList.remove('is-invalid');

                    Livewire.emit('findNotStartedActivities', searchInputNotStartedActivities, 2);

                } else {
                    inputSearchNotStartedActivities.classList.add('is-invalid');
                }
            });

            inputSearchNotStartedActivities.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
                    var searchInputNotStartedActivities = inputSearchNotStartedActivities.value;
                    if (searchInputNotStartedActivities != "") {
                        inputSearch.classList.remove('is-invalid');

                        Livewire.emit('findNotStartedActivities', searchNotStartedActivities, 2);

                    } else {
                        inputSearchNotStartedActivities.classList.add('is-invalid');
                    }
                }
            });
        });
    </script>
</div>