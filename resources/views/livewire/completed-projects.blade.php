<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover ">
            <h6 class="fw-bold small" style="color:darkgreen;">
                @if(in_array(Route::currentRouteName(), ['reports.show', 'reports.display']))
                <i class="bi bi-bar-chart-line-fill"></i>
                @else
                <i class="bi bi-kanban"></i>
                @endif
                Completed

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($xCompletedProjects==0)style="display: none;" @endif>
            @if(Auth::user()->role == "Admin")
            <div class="mb-1 d-flex justify-content-start small">

                <div class="form-check">
                    <input class="form-check-input small" type="checkbox"
                        wire:click="toggleSelectionCompletedProjects($event.target.checked)"
                        @if($showOnlyMyCompletedProjects==1) checked @endif>
                    <label class="form-check-label d-block small" for="showOnlyMyCompletedProjects">
                        Show only the ones I'm involved in.
                    </label>
                </div>

            </div>
            @endif
            <div class="input-group">
                <input type="text" class="form-control border border-2 mb-2" id="inputSearchCompletedProjects"
                    placeholder="Enter title...">
                <div class="iconCustom">
                    <button type="button" class="btn btn-no-animation" id="btnRefreshInput">
                        <i wire:click="refreshDataCompletedProjects" type="button" class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-green px-3" id="btnSearchCompletedProjects">Search
                Project</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
                Please enter a project title.
            </span>
        </div>
        <!--<div class="text-center m-1" @if ($xCompletedProjects==0)style="display: none;" @endif>
            <button wire:click="refreshDataCompletedProjects" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>-->
        @if ($xCompletedProjects == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm rounded btn-gold shadow" wire:click="showCompletedProjects(1)">
                <b class="small">Show Projects</b>
            </button>

        </div>
        @else
        @if ($CompletedProjects->isEmpty())
        <div class="p-2 text-center">
            <h6 class="fw-bold small">No Completed Projects</h6>
        </div>
        @else



        <div class="container p-0">

            @foreach ($CompletedProjects as $project)
            <div class="border-bottom ps-3 p-2 pb-0 divhover projectdiv reportdiv" data-value="{{ $project['id'] }}"
                data-name="{{ $project['projecttitle'] }}" data-dept="{{ $project['department'] }}">

                <h6 class="fw-bold small" style="color: #4A4A4A;">
                    @if(in_array(Route::currentRouteName(), ['reports.show', 'reports.display']))
                    <i class="bi bi-bar-chart-line-fill"></i>
                    @else
                    <i class="bi bi-kanban"></i>
                    @endif
                    {{ $project['projecttitle'] }}
                </h6>

                @php
                $startDate = date('M d, Y', strtotime($project['projectstartdate']));
                $endDate = date('M d, Y', strtotime($project['projectenddate']));

                @endphp
                <h6 class="text-secondary small">{{ 'Created ' . date('M d Y', strtotime($project['created_at'])) }}
                </h6>
                <h6 class="ps-2 text-success fw-bold small"> {{ $startDate }} - {{ $endDate }}</h6>



            </div>

            @endforeach
            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1">

                    @if ($currentPageCompletedProjects === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link"
                            wire:click="changePageCompletedProjects({{ $currentPageCompletedProjects - 1 }})"
                            rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center mx-2">
                        <h6 class="fw-bold my-0 mt-2 small">
                            {{ $currentPageCompletedProjects . ' of ' . $totalPagesCompletedProjects }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageCompletedProjects === $totalPagesCompletedProjects)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link"
                            wire:click="changePageCompletedProjects({{ $currentPageCompletedProjects + 1 }})"><i
                                class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>


        </div>

        @endif
        <div class="text-center p-2 border border-bottom-2">
            <button type="button" class="btn btn-sm rounded btn-gold shadow" wire:click="showCompletedProjects(0)">
                <b class="small">Hide Projects</b>
            </button>

        </div>
        @endif

    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <script>
    document.addEventListener('livewire:load', function() {
        const btnSearchCompletedProjects = document.getElementById('btnSearchCompletedProjects');
        const inputSearchCompletedProjects = document.getElementById('inputSearchCompletedProjects');
        btnSearch.addEventListener('click', function() {

            var searchInputCompletedProjects = inputSearchCompletedProjects.value;
            if (searchInputCompletedProjects != "") {
                inputSearchCompletedProjects.classList.remove('is-invalid');

                Livewire.emit('findCompletedProjects', searchInputCompletedProjects, 2);

            } else {
                inputSearchCompletedProjects.classList.add('is-invalid');
            }
        });

        inputSearchCompletedProjects.addEventListener('keydown', function(event) {
            // Check if the pressed key is "Enter" (key code 13)
            if (event.keyCode === 13) {
                var searchInputCompletedProjects = inputSearchCompletedProjects.value;
                if (searchInputCompletedProjects != "") {
                    inputSearchCompletedProjects.classList.remove('is-invalid');

                    Livewire.emit('findCompletedProjects', searchInputCompletedProjects, 2);

                } else {
                    inputSearchCompletedProjects.classList.add('is-invalid');
                }
            }
        });
    });
    </script>
</div>
