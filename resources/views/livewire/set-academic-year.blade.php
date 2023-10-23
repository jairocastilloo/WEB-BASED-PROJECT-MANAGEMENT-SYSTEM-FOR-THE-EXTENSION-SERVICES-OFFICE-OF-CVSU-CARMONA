<div>

    <div class="m-2 p-2 border" style="width:345px;">
        <div class="text-end">
            <button wire:click="refreshData" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        <label class="ms-2 small form-label text-secondary fw-bold">Find Academic Year</label>

        <input type="text" class="form-control border-success" id="inputSearch">
        <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
            Please enter a search term to find academic year.
        </span>
        <div class="mt-2 text-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input border border-success" type="radio" name="searchCriteria" id="searchByAcademicYear" value="academic-year" checked>
                <label class="form-check-label" for="searchByAcademicYear">Academic Year</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input border border-success" type="radio" name="searchCriteria" id="searchByFirstSemester" value="first-semester">
                <label class="form-check-label" for="searchByFirstSemester">First Semester</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input border border-success" type="radio" name="searchCriteria" id="searchBySecondSemester" value="second-semester">
                <label class="form-check-label" for="searchBySecondSemester">Second Semester</label>
            </div>
        </div>
        <div class="text-end">
            <button type="button" class="btn btn-primary" id="btnSearch">Search</button>
        </div>

    </div>
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" wire:click="changePage(1)">First</a>
            </li>
            @if ($currentPage === 1)
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-compact-left"></i></span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" wire:click="changePage({{ $currentPage - 1 }})" rel="prev"><i class="bi bi-chevron-compact-left"></i></a>
            </li>
            @endif

            @for ($i = 1; $i <= $totalPages; $i++) <li class="page-item {{ $i === $currentPage ? 'active disabled' : '' }}" aria-current="{{ $i === $currentPage ? 'page' : '' }}">
                <a class="page-link" wire:click="changePage({{ $i }})">{{ $i }}</a>
                </li>
                @endfor

                @if ($currentPage === $totalPages)
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-compact-right"></i></span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" wire:click="changePage({{ $currentPage + 1 }})"><i class="bi bi-chevron-compact-right"></i></a>
                </li>
                @endif
                <li class="page-item">
                    <a class="page-link" wire:click="changePage({{ $totalPages }})">Last</a>
                </li>
        </ul>
    </nav>


    <div class="container-fluid approvalcontainer">
        <table class="approvaltable">
            <thead>
                <tr>
                    <th class="p-2 text-center bg-light name">ACADEMIC YEAR START DATE</th>
                    <th class="p-2 text-center bg-light name">ACADEMIC YEAR END DATE</th>
                    <th class="p-2 text-center bg-light name">FIRST SEMESTER START DATE</th>
                    <th class="p-2 text-center bg-light email">FIRST SEMESTER END DATE</th>
                    <th class="p-2 text-center bg-light department">SECOND SEMESTER START DATE</th>
                    <th class="p-2 text-center bg-light datecreated">SECOND SEMESTER END DATE</th>
                    <th class="p-2 text-center bg-light actions">ACTIONS</th>
                    <th class="p-2 text-center bg-light cancel"></th>
                </tr>
            </thead>

            <tbody>

            </tbody>
        </table>
    </div>
</div>