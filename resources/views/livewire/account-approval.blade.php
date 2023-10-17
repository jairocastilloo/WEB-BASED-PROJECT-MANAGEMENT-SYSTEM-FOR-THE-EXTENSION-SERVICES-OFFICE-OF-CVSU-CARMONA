<div>

    <div class="m-2 p-2 border" style="width:345px;">
        <label class="ms-2 small form-label text-secondary fw-bold">Find Account</label>
        <input type="text" class="form-control border-success" id="inputSearch">
        <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
            Please enter a search term to find accounts.
        </span>
        <div class="mt-2 text-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input border border-success" type="radio" name="searchCriteria" id="searchByName" value="name" checked>
                <label class="form-check-label" for="searchByName">Name</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input border border-success" type="radio" name="searchCriteria" id="searchByEmail" value="email">
                <label class="form-check-label" for="searchByEmail">Email</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input border border-success" type="radio" name="searchCriteria" id="searchByDepartment" value="department">
                <label class="form-check-label" for="searchByDepartment">Department</label>
            </div>
        </div>
        <div class="text-end">
            <button type="button" class="btn btn-primary" id="btnSearch">Search</button>
        </div>

    </div>

    <div class="pagination">
        <button wire:click="changePage(1)">First</button>
        <button wire:click="changePage({{ $currentPage - 1 }})">Previous</button>

        @for ($i = 1; $i <= $totalPages; $i++) <button wire:click="changePage({{ $i }})" {{ $i == $currentPage ? 'class=active' : '' }}>{{ $i }}</button>
            @endfor

            <button wire:click="changePage({{ $currentPage + 1 }})">Next</button>
            <button wire:click="changePage({{ $totalPages }})">Last</button>
    </div>
    <div class="container-fluid approvalcontainer">
        <table class="approvaltable">
            <thead>
                <tr>
                    <th class="p-2 text-center bg-light name">LAST NAME</th>
                    <th class="p-2 text-center bg-light name">FIRST NAME</th>
                    <th class="p-2 text-center bg-light name">MIDDLE NAME</th>
                    <th class="p-2 text-center bg-light email">EMAIL</th>
                    <th class="p-2 text-center bg-light department">DEPARTMENT</th>
                    <th class="p-2 text-center bg-light datecreated">REGISTRATION DATE</th>
                    <th class="p-2 text-center bg-light actions">ACTIONS</th>
                    <th class="p-2 text-center bg-light cancel"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($pendingusers as $pendinguser)
                <tr class="accountRow" data-name="{{ $pendinguser->name . ' ' . $pendinguser->middle_name . ' ' . $pendinguser->last_name }}" data-email="{{ $pendinguser->email }}">
                    <td class="p-2 name">{{ $pendinguser->last_name }}</td>
                    <td class="p-2 name">{{ $pendinguser->name }}</td>
                    <td class="p-2 name">{{ $pendinguser->middle_name }}</td>
                    <td class="p-2 email">{{ $pendinguser->email }}</td>
                    <td class="p-2 department">{{ $pendinguser->department }}</td>
                    <td class="p-2 datecreated">{{ $pendinguser->created_at->diffForHumans() }}</td>
                    <td class="p-2 actions">
                        <div class="text-center">
                            <div class="mb-1">Approve as:</div>
                            <button type="button" class="btn btn-sm btn-outline-success border shadow-sm" wire:click="approveAsCoordinator('{{ $pendinguser->id }}')">
                                <b class="small">Coordinator</b>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success border shadow-sm" wire:click="approveAsImplementer('{{ $pendinguser->id }}')">
                                <b class="small">Implementer</b>
                            </button>
                        </div>
                    </td>
                    <td class="p-2 cancel text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger border" wire:click="decline('{{ $pendinguser->id }}')">
                            <i class="bi bi-trash fs-5"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            const btnSearch = document.getElementById('btnSearch');
            const inputSearch = document.getElementById('inputSearch');

            btnSearch.addEventListener('click', function() {
                const searchCriteria = document.querySelector('input[name="searchCriteria"]:checked').value;
                var searchInput = inputSearch.value;
                if (searchInput != "") {
                    inputSearch.classList.remove('is-invalid');
                    switch (searchCriteria) {
                        case 'name':
                            Livewire.emit('findAccount', searchInput, 1)
                            break;
                        case 'email':
                            Livewire.emit('findAccount', searchInput, 2)
                            break;
                        case 'department':
                            Livewire.emit('findAccount', searchInput, 3)
                            break;
                        default:
                            // Handle the default case or show an error message
                            break;
                    }
                } else {
                    inputSearch.classList.add('is-invalid');
                }
            });

        });
    </script>
</div>