<div>


    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-kanban"></i>
                {{ $status }}
            </h6>
        </div>
        @if ($x == 0)
        <div class="text-center p-2">
            <button type="button" class="btn btn-sm w-100 btn-outline-success" wire:click="show(1)">Show Projects</button>
        </div>
        @else
        @if ($moreprojects->isEmpty())
        <div class="p-2">
            <h6 class="fw-bold small">No {{ $status }} Projects Yet.</h6>
        </div>
        @else

        <nav>
            <ul class="pagination justify-content-center m-1">

                @if ($currentPage === 1)
                <li class="page-item disabled small">
                    <span class="page-link small" aria-hidden="true"><i class="bi bi-chevron-compact-left"></i></span>
                </li>
                @else
                <li class="page-item small">
                    <a class="page-link small" wire:click="changePage({{ $currentPage - 1 }})" rel="prev"><i class="bi bi-chevron-compact-left "></i></a>
                </li>
                @endif


                <h6 class="fw-bold m-1 mt-2">{{ $currentPage . ' of ' . $totalPages }}</h6>

                @if ($currentPage === $totalPages)
                <li class="page-item disabled small">
                    <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-compact-right"></i></span>
                </li>
                @else
                <li class="page-item small">
                    <a class="page-link" wire:click="changePage({{ $currentPage + 1 }})"><i class="bi bi-chevron-compact-right"></i></a>
                </li>
                @endif

            </ul>
        </nav>

        <div class="container p-0">

            @foreach ($moreprojects as $project)
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

            <div class="text-center p-2">
                <button type="button" class="btn btn-sm w-100 btn-outline-success" wire:click="show(0)">Hide Projects</button>
            </div>

        </div>

        @endif
        @endif


        {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    </div>