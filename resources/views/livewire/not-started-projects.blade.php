<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover ">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-kanban"></i>
                Not Started

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($y==0)style="display: none;" @endif>
            <input type="text" class="form-control border border-2 mb-1" id="notstartedinputSearch" placeholder="Enter title...">
            <button type="button" class="btn btn-sm btn-outline-success w-100" id="notstartedbtnSearch">Search Project</button>
            <span class="invalid-feedback small fw-bold text-end" id="notstartederrorAccount">
                Please enter a project title.
            </span>
        </div>
        <div class="text-center m-1" @if ($y==0)style="display: none;" @endif>
            <button wire:click="notstartedrefreshData" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        @if ($y == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="notstartedshow(1)">
                <b class="small">Show Projects</b>
            </button>

        </div>
        @else
        @if ($notstartedprojects->isEmpty())
        <div class="p-2 border border-bottom-2">
            <h6 class="fw-bold small">No Projects found.</h6>
        </div>
        <div class="text-center p-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="notstartedshow(0)">
                <b class="small">Hide Projects</b>
            </button>

        </div>
        @else



        <div class="container p-0">




            @foreach ($notstartedprojects as $project)
            <div class="border-bottom ps-3 p-2 pb-0 divhover projectdiv" data-value="{{ $project['id'] }}" data-name="{{ $project['projecttitle'] }}" data-dept="{{ $project['department'] }}">

                <h6 class="fw-bold small">{{ $project['projecttitle'] }}</h6>

                @php
                $startDate = date('M d Y', strtotime($project['projectstartdate']));
                $endDate = date('M d Y', strtotime($project['projectenddate']));

                @endphp

                <h6 class="small"> {{ $startDate }} - {{ $endDate }}</h6>

                <h6 class="small text-success fw-bold text-end">{{ $project['projectremark'] }}</h6>

            </div>

            @endforeach
            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1 mt-0">

                    @if ($notstartedcurrentPage === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="notstartedchangePage({{ $notstartedcurrentPage - 1 }})" rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center">
                        <h6 class="fw-bold my-0 mt-2 small">{{ $notstartedcurrentPage . ' of ' . $notstartedtotalPages }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($notstartedcurrentPage === $notstartedtotalPages)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="notstartedchangePage({{ $notstartedcurrentPage + 1 }})"><i class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>
            <div class="text-center p-2 border border-bottom-2">
                <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="notstartedshow(0)">
                    <b class="small">Hide Projects</b>
                </button>

            </div>

        </div>

        @endif
        @endif
    </div>

    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <script>
        document.addEventListener('livewire:load', function() {
            const notstartedbtnSearch = document.getElementById('notstartedbtnSearch');
            const notstartedinputSearch = document.getElementById('notstartedinputSearch');
            notstartedbtnSearch.addEventListener('click', function() {

                var notstartedsearchInput = notstartedinputSearch.value;
                if (searchInput != "") {
                    notstartedinputSearch.classList.remove('is-invalid');

                    Livewire.emit('notstartedfindProject', notstartedsearchInput, 2);

                } else {
                    notstartedinputSearch.classList.add('is-invalid');
                }
            });
            notstartedinputSearch.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
                    var notstartedsearchInput = notstartedinputSearch.value;
                    if (notstartedsearchInput != "") {
                        notstartedinputSearch.classList.remove('is-invalid');

                        Livewire.emit('notstartedfindProject', notstartedsearchInput, 2);

                    } else {
                        notstartedinputSearch.classList.add('is-invalid');
                    }
                }
            });
        });
    </script>
</div>