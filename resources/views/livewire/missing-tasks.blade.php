<div>
    @php
    $currentDate = strtotime('today');
    $formattedCurrentDate = date('Y-m-d', $currentDate);
    @endphp

    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-list-task"></i>
                Missing

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($xMissingTasks==0)style="display: none;" @endif>
            <input type="text" class="form-control border border-2 mb-2" id="inputSearchMissingTasks" placeholder="Enter name...">
            <button type="button" class="btn btn-sm btn-outline-success px-3" id="btnSearchMissingTasks">Search Task</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
                Please enter a subtask name.
            </span>
        </div>
        <div class="text-center m-1" @if ($xMissingTasks==0)style="display: none;" @endif>
            <button wire:click="refreshDataMissingTasks" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        @if ($xMissingTasks == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showMissingTasks(1)">
                <b class="small">Show Tasks</b>
            </button>

        </div>
        @else
        @if ($MissingTasks->isEmpty())
        <div class="p-2 text-center">
            <h6 class="fw-bold small">No Missing Tasks</h6>
        </div>
        @else



        <div class="container p-0">
            @foreach($MissingTasks as $subtask)

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
                <h6 class="ps-2 text-success fw-bold small">{{ 'Due Today, ' . date('M d Y', $subduedate) }}</h6>
                @elseif (date('Y-m-d', strtotime('+1 day', $currentDate)) === $formattedSubduedate)
                <h6 class="ps-2 text-success fw-bold small">{{ 'Due Tomorrow, ' . date('M d Y', $subduedate) }}</h6>
                @else
                <h6 class="ps-2 text-success fw-bold small">{{ 'Due ' . date('D, M d Y', $subduedate) }}</h6>
                @endif

            </div>

            @endforeach

            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1 mt-0">

                    @if ($currentPageMissingTasks === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageMissingTasks({{ $currentPageMissingTasks - 1 }})" rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center">
                        <h6 class="fw-bold my-0 mt-2 small">{{ $currentPageMissingTasks . ' of ' . $totalPagesMissingTasks }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageMissingTasks === $totalPagesMissingTasks)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageMissingTasks({{ $currentPageMissingTasks + 1 }})"><i class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>
            <div class="text-center p-2 border border-bottom-2">
                <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showMissingTasks(0)">
                    <b class="small">Hide Tasks</b>
                </button>

            </div>

        </div>

        @endif
        @endif

    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <script>
        document.addEventListener('livewire:load', function() {
            const btnSearchMissingTasks = document.getElementById('btnSearchMissingTasks');
            const inputSearchMissingTasks = document.getElementById('inputSearchMissingTasks');
            btnSearchMissingTasks.addEventListener('click', function() {

                var searchInputMissingTasks = inputSearchMissingTasks.value;
                if (searchInputMissingTasks != "") {
                    inputSearchMissingTasks.classList.remove('is-invalid');

                    Livewire.emit('findMissingTasks', searchInputMissingTasks, 2);

                } else {
                    inputSearchMissingTasks.classList.add('is-invalid');
                }
            });

            inputSearchMissingTasks.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
                    var searchInputMissingTasks = inputSearchMissingTasks.value;
                    if (searchInputMissingTasks != "") {
                        inputSearchMissingTasks.classList.remove('is-invalid');

                        Livewire.emit('findMissingTasks', searchInputMissingTasks, 2);

                    } else {
                        inputSearchMissingTasks.classList.add('is-invalid');
                    }
                }
            });
        });
    </script>
</div>