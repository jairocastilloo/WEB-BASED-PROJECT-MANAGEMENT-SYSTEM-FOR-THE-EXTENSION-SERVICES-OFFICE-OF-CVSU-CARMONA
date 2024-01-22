<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover ">
            <h6 class="fw-bold small" style="color:darkgreen;">

                Overdue

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($zOverduePrograms==0)style="display: none;" @endif>
            @if(Auth::user()->role == "Admin")
            <div class="mb-1 d-flex justify-content-start small">

                <div class="form-check">
                    <input class="form-check-input small" type="checkbox" wire:click="toggleSelectionOverduePrograms($event.target.checked)" @if($showOnlyMyOverduePrograms==1) checked @endif>
                    <label class="form-check-label d-block small" for="showOnlyMyOverduePrograms">
                        Show only the ones I'm involved in.
                    </label>
                </div>

            </div>
            @endif
            <input type="text" class="form-control border border-2 mb-1" id="inputSearchOverduePrograms" placeholder="Enter title...">
            <button type="button" class="btn btn-sm btn-outline-success px-3" id="btnSearchOverduePrograms">Search Program</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccountOverduePrograms">
                Please enter a program title.
            </span>
        </div>
        <div class="text-center m-1" @if ($zOverduePrograms==0)style="display: none;" @endif>
            <button wire:click="refreshDataOverduePrograms" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        @if ($zOverduePrograms == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showOverduePrograms(1)">
                <b class="small">Show Programs</b>
            </button>

        </div>
        @else
        @if ($overduePrograms->isEmpty())
        <div class="p-2 text-center">
            <h6 class="fw-bold small">No Overdue Programs</h6>
        </div>
        @else



        <div class="container p-0">




            @foreach ($overduePrograms as $program)
            <div class="border-bottom ps-3 p-2 divhover programDiv" data-value="{{ $program['id'] }}" data-name="{{ $program['programName'] }}" data-dept="{{ $program['department'] }}">

                <h6 class="fw-bold small" style="color: #4A4A4A;">

                    {{ $program['programName'] }}
                </h6>

                @php
                $startDate = date('M d, Y', strtotime($program['startDate']));
                $endDate = date('M d, Y', strtotime($program['endDate']));

                @endphp
                <h6 class="text-secondary small">{{ 'Created ' . date('M d Y', strtotime($program['created_at'])) }}</h6>
                <h6 class="ps-2 text-success fw-bold small"> {{ $startDate }} - {{ $endDate }}</h6>



            </div>

            @endforeach
            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1">

                    @if ($currentPageOverduePrograms === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageOverduePrograms({{ $currentPageOverduePrograms - 1 }})" rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center mx-2">
                        <h6 class="fw-bold my-0 mt-2 small">{{ $currentPageOverduePrograms . ' of ' . $totalPagesOverduePrograms }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageOverduePrograms === $totalPagesOverduePrograms)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageOverduePrograms({{ $currentPageOverduePrograms + 1 }})"><i class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>


        </div>

        @endif
        <div class="text-center p-2 border border-bottom-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showOverduePrograms(0)">
                <b class="small">Hide Programs</b>
            </button>

        </div>
        @endif

    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <script>
        document.addEventListener('livewire:load', function() {
            const btnSearchOverduePrograms = document.getElementById('btnSearchOverduePrograms');
            const inputSearchOverduePrograms = document.getElementById('inputSearchOverduePrograms');
            btnSearchOverduePrograms.addEventListener('click', function() {

                var searchInputOverduePrograms = inputSearchOverduePrograms.value;
                if (searchInputOverduePrograms != "") {
                    inputSearchOverduePrograms.classList.remove('is-invalid');

                    Livewire.emit('findOverduePrograms', searchInputOverduePrograms, 2);

                } else {
                    inputSearchOverduePrograms.classList.add('is-invalid');
                }
            });
            inputSearchOverduePrograms.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
                    var searchInputOverduePrograms = inputSearchOverduePrograms.value;
                    if (searchInputOverduePrograms != "") {
                        inputSearchOverduePrograms.classList.remove('is-invalid');

                        Livewire.emit('findOverduePrograms', searchInputOverduePrograms, 2);

                    } else {
                        inputSearchOverduePrograms.classList.add('is-invalid');
                    }
                }
            });
        });
    </script>
</div>