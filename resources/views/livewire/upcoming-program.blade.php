<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover ">
            <h6 class="fw-bold small" style="color:darkgreen;">

                Upcoming

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($yUpcomingPrograms==0)style="display: none;" @endif>
            @if(Auth::user()->role == "Admin")
            <div class="mb-1 d-flex justify-content-start small">

                <div class="form-check">
                    <input class="form-check-input small" type="checkbox"
                        wire:click="toggleSelectionUpcomingPrograms($event.target.checked)"
                        @if($showOnlyMyUpcomingPrograms==1) checked @endif>
                    <label class="form-check-label d-block small" for="showOnlyMyUpcomingPrograms">
                        Show only the ones I'm involved in.
                    </label>
                </div>

            </div>
            @endif
            <div class="input-group">
                <input type="text" class="form-control border border-2 mb-1" id="inputSearchUpcomingPrograms"
                    placeholder="Enter title...">
                <div class="iconCustom">
                    <button type="button" class="btn btn-no-animation" id="btnRefreshInput">
                        <i wire:click="refreshDataUpcomingPrograms" type="button" class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-green px-3" id="btnSearchUpcomingPrograms">Search
                Project</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccountUpcomingPrograms">
                Please enter a program title.
            </span>
        </div>
        <!--<div class="text-center m-1" @if ($yUpcomingPrograms==0)style="display: none;" @endif>
            <button wire:click="refreshDataUpcomingPrograms" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>-->
        @if ($yUpcomingPrograms == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm rounded btn-gold shadow" wire:click="showUpcomingPrograms(1)">
                <b class="small">Show Programs</b>
            </button>

        </div>
        @else
        @if ($upcomingPrograms->isEmpty())
        <div class="p-2 border border-bottom-2 text-center">
            <h6 class="fw-bold small">No Upcoming Programs</h6>
        </div>

        @else



        <div class="container p-0">




            @foreach ($upcomingPrograms as $program)
            <div class="border-bottom ps-3 p-2 divhover programDiv" data-value="{{ $program['id'] }}"
                data-name="{{ $program['programName'] }}" data-dept="{{ $program['department'] }}">

                <h6 class="fw-bold small" style="color: #4A4A4A;">

                    {{ $program['programName'] }}
                </h6>

                @php
                $startDate = date('M d, Y', strtotime($program['startDate']));
                $endDate = date('M d, Y', strtotime($program['endDate']));

                @endphp
                <h6 class="text-secondary small">{{ 'Created ' . date('M d Y', strtotime($program['created_at'])) }}
                </h6>
                <h6 class="ps-2 text-success fw-bold small"> {{ $startDate }} - {{ $endDate }}</h6>



            </div>

            @endforeach
            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1">

                    @if ($currentPageUpcomingPrograms === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link"
                            wire:click="changePageUpcomingPrograms({{ $currentPageUpcomingPrograms - 1 }})"
                            rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center mx-2">
                        <h6 class="fw-bold my-0 mt-2 small">
                            {{ $currentPageUpcomingPrograms . ' of ' . $totalPagesUpcomingPrograms }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageUpcomingPrograms === $totalPagesUpcomingPrograms)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link"
                            wire:click="changePageUpcomingPrograms({{ $currentPageUpcomingPrograms + 1 }})"><i
                                class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>


        </div>

        @endif
        <div class="text-center p-2 border border-bottom-2">
            <button type="button" class="btn btn-sm rounded btn-gold shadow" wire:click="showUpcomingPrograms(0)">
                <b class="small">Hide Programs</b>
            </button>

        </div>
        @endif
    </div>

    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <script>
    document.addEventListener('livewire:load', function() {
        const btnSearchUpcomingPrograms = document.getElementById('btnSearchUpcomingPrograms');
        const inputSearchUpcomingPrograms = document.getElementById('inputSearchUpcomingPrograms');
        btnSearchUpcomingPrograms.addEventListener('click', function() {

            var searchInputUpcomingPrograms = inputSearchUpcomingPrograms.value;
            if (searchInputUpcomingPrograms != "") {
                inputSearchUpcomingPrograms.classList.remove('is-invalid');

                Livewire.emit('findProjectUpcomingPrograms', searchInputUpcomingPrograms, 2);

            } else {
                inputSearchUpcomingPrograms.classList.add('is-invalid');
            }
        });
        inputSearchUpcomingPrograms.addEventListener('keydown', function(event) {
            // Check if the pressed key is "Enter" (key code 13)
            if (event.keyCode === 13) {
                var searchInputUpcomingPrograms = inputSearchUpcomingPrograms.value;
                if (searchInputUpcomingPrograms != "") {
                    inputSearchUpcomingPrograms.classList.remove('is-invalid');

                    Livewire.emit('findProjectUpcomingPrograms', searchInputUpcomingPrograms, 2);

                } else {
                    inputSearchUpcomingPrograms.classList.add('is-invalid');
                }
            }
        });
    });
    </script>
</div>
