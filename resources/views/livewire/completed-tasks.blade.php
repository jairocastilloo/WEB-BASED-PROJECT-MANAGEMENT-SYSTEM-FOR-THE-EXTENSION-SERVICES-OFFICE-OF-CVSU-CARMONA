<div>
    @php
    $currentDate = strtotime('today');
    $formattedCurrentDate = date('Y-m-d', $currentDate);
    @endphp

    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-list-task"></i>
                Completed

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($xCompletedTasks==0)style="display: none;" @endif>
            @if(Auth::user()->role == "Admin")
            <div class="mb-1 d-flex justify-content-start small">

                <div class="form-check">
                    <input class="form-check-input small" type="checkbox"
                        wire:click="toggleSelectionCompleted($event.target.checked)" @if($showOnlyMyCompletedTasks==1)
                        checked @endif>
                    <label class="form-check-label d-block small" for="showOnlyMyCompletedTasks">
                        Show only the ones I'm involved in.
                    </label>
                </div>

            </div>
            @endif
            <div class="input-group">
                <input type="text" class="form-control border border-2 mb-2" id="inputSearchCompletedTasks"
                    placeholder="Enter name...">
                <div class="iconCustom">
                    <button type="button" class="btn btn-no-animation" id="btnRefreshInput">
                        <i wire:click="refreshDataCompletedTasks" type="button" class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
            <span class="invalid-feedback small fw-bold text-end" id="errorCompletedAccount">
                Please enter a subtask name.
            </span>
            <button type="button" class="btn btn-sm btn-green px-3" id="btnSearchCompletedTasks">Search Task</button>

        </div>
        <!--<div class="text-center m-1" @if ($xCompletedTasks==0)style="display: none;" @endif>
            <button wire:click="refreshDataCompletedTasks" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>-->
        @if ($xCompletedTasks == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm rounded btn-gold shadow" wire:click="showCompletedTasks(1)">
                <b class="small">Show Tasks</b>
            </button>

        </div>
        @else
        @if ($CompletedTasks->isEmpty())
        <div class="p-2 text-center">
            <h6 class="fw-bold small">No Finished Tasks</h6>
        </div>
        @else



        <div class="container p-0">
            @foreach($CompletedTasks as $subtask)

            <div class="border-bottom ps-3 p-2 divhover subtaskdiv" data-value="{{ $subtask['id'] }}">
                @php
                $subduedate = strtotime($subtask['subduedate']);
                $subcreatedat = strtotime($subtask['created_at']);

                $formattedSubduedate = date('Y-m-d', $subduedate);
                $formattedSubcreatedat = date('Y-m-d', $subcreatedat);
                @endphp

                <h6 class="small" style="color: #4A4A4A;"><b>{{ $subtask['subtask_name'] }}</b></h6>

                @if ($formattedSubcreatedat === $formattedCurrentDate)
                <h6 class="text-secondary small">{{ 'Created Today, ' . date('M d Y', $subcreatedat) }}</h6>
                @elseif (date('Y-m-d', strtotime('-1 day', $currentDate)) === $formattedSubcreatedat)
                <h6 class="text-secondary small">{{ 'Created Yesterday, ' . date('M d Y', $subcreatedat) }}</h6>
                @else
                <h6 class="text-secondary small">{{ 'Created ' . date('D, M d Y', $subcreatedat) }}</h6>
                @endif




                @if ($formattedSubduedate === $formattedCurrentDate)
                <h6 class="ps-2 text-success fw-bold small lh-1">{{ 'Due Today, ' . date('M d Y', $subduedate) }}</h6>
                @elseif (date('Y-m-d', strtotime('+1 day', $currentDate)) === $formattedSubduedate)
                <h6 class="ps-2 text-success fw-bold small lh-1">{{ 'Due Tomorrow, ' . date('M d Y', $subduedate) }}
                </h6>
                @else
                <h6 class="ps-2 text-success fw-bold small lh-1">{{ 'Due ' . date('D, M d Y', $subduedate) }}</h6>
                @endif

            </div>

            @endforeach

            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1">

                    @if ($currentPageCompletedTasks === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageCompletedTasks({{ $currentPageCompletedTasks - 1 }})"
                            rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center mx-2">
                        <h6 class="fw-bold my-0 mt-2 small">
                            {{ $currentPageCompletedTasks . ' of ' . $totalPagesCompletedTasks }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageCompletedTasks === $totalPagesCompletedTasks)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link"
                            wire:click="changePageCompletedTasks({{ $currentPageCompletedTasks + 1 }})"><i
                                class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>


        </div>

        @endif
        <div class="text-center p-2 border border-bottom-2">
            <button type="button" class="btn btn-sm rounded btn-gold shadow" wire:click="showCompletedTasks(0)">
                <b class="small">Hide Tasks</b>
            </button>

        </div>
        @endif

    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <script>
    document.addEventListener('livewire:load', function() {
        const btnSearchCompletedTasks = document.getElementById('btnSearchCompletedTasks');
        const inputSearchMissingTasks = document.getElementById('inputSearchCompletedTasks');
        btnSearchCompletedTasks.addEventListener('click', function() {

            var searchInputCompletedTasks = inputSearchCompletedTasks.value;
            if (searchInputCompletedTasks != "") {
                inputSearchCompletedTasks.classList.remove('is-invalid');

                Livewire.emit('findCompletedTasks', searchInputCompletedTasks, 2);

            } else {
                inputSearchCompletedTasks.classList.add('is-invalid');
            }
        });

        inputSearchCompletedTasks.addEventListener('keydown', function(event) {
            // Check if the pressed key is "Enter" (key code 13)
            if (event.keyCode === 13) {
                var searchInputCompletedTasks = inputSearchCompletedTasks.value;
                if (searchInputCompletedTasks != "") {
                    inputSearchCompletedTasks.classList.remove('is-invalid');

                    Livewire.emit('findCompletedTasks', searchInputCompletedTasks, 2);

                } else {
                    inputSearchCompletedTasks.classList.add('is-invalid');
                }
            }
        });
    });
    </script>
</div>
