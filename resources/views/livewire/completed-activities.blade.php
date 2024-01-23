<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-activity"></i>
                Completed

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($xCompletedActivities==0)style="display: none;" @endif>
            @if(Auth::user()->role == "Admin")
            <div class="mb-1 d-flex justify-content-start small">

                <div class="form-check">
                    <input class="form-check-input small" type="checkbox"
                        wire:click="toggleSelectionCompletedActivities($event.target.checked)"
                        @if($showOnlyMyCompletedActivities==1) checked @endif>
                    <label class="form-check-label d-block small" for="showOnlyMyCompletedActivities">
                        Show only the ones I'm involved in.
                    </label>
                </div>

            </div>
            @endif
            <div class="input-group">
                <input type="text" class="form-control border border-2 mb-2" id="inputSearchCompletedActivities"
                    placeholder="Enter title...">
                <div class="iconCustom">
                    <button type="button" class="btn btn-no-animation" id="btnRefreshInput">
                        <i wire:click="refreshDataCompletedActivities" type="button" class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-green px-3" id="btnSearchCompletedActivities">Search
                Activity</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
                Please enter a activity title.
            </span>
        </div>
        <!--<div class="text-center m-1" @if ($xCompletedActivities==0)style="display: none;" @endif>
            <button wire:click="refreshDataCompletedActivities" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>-->
        @if ($xCompletedActivities == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm rounded btn-gold shadow" wire:click="showCompletedActivities(1)">
                <b class="small">Show Activities</b>
            </button>

        </div>
        @else
        @if ($CompletedActivities->isEmpty())
        <div class="p-2 text-center">
            <h6 class="fw-bold small">No Completed Activities</h6>
        </div>
        @else



        <div class="container p-0">

            @foreach ($CompletedActivities as $activity)
            <div class="border-bottom ps-3 p-2 divhover activitydiv" data-value="{{ $activity['id'] }}"
                data-name="{{ $activity['actname'] }}" style="position: relative;">

                <h6 class="fw-bold small" style="color: #4A4A4A;">{{ $activity['actname'] }}</h6>

                @php
                $startDate = date('M d, Y', strtotime($activity['actstartdate']));
                $endDate = date('M d, Y', strtotime($activity['actenddate']));
                @endphp
                <h6 class="text-secondary small">{{ 'Created ' . date('M d, Y', strtotime($activity['created_at'])) }}
                </h6>
                <h6 class="ps-2 text-success fw-bold small"> {{ $startDate }} - {{ $endDate }}</h6>
                <div class="btn-group" style="position: absolute; top: 0; right: 0;">
                    <button type="button" class="btn btn-sm btn-outline-success fs-6 px-1 border me-1 mt-1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item small checkOutput" href="#" data-id="{{ $activity['id'] }}"
                                data-name="{{ $activity['actname'] }}">Check Output</a></li>
                        <!-- Add more dropdown items here -->
                    </ul>
                </div>
            </div>

            @endforeach
            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1">

                    @if ($currentPageCompletedActivities === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link"
                            wire:click="changePageCompletedActivities({{ $currentPageCompletedActivities - 1 }})"
                            rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center mx-2">
                        <h6 class="fw-bold my-0 mt-2 small">
                            {{ $currentPageCompletedActivities . ' of ' . $totalPagesCompletedActivities }}</h6>
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
                        <a class="page-link"
                            wire:click="changePageCompletedActivities({{ $currentPageCompletedActivities + 1 }})"><i
                                class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>


        </div>

        @endif
        <div class="text-center p-2 border border-bottom-2">
            <button type="button" class="btn btn-sm rounded btn-gold shadow" wire:click="showCompletedActivities(0)">
                <b class="small">Hide Activities</b>
            </button>

        </div>
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