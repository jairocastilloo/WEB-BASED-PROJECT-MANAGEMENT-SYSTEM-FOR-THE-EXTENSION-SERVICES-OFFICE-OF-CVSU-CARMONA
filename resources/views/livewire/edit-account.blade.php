<div>

    <div class="m-2 p-2 border" style="width:345px;">
        <div class="text-end">
            <button wire:click="refreshData" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
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

    <nav class="navbar navbar-expand-lg">
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
                    <th class="p-2 text-center bg-light editname">LAST NAME</th>
                    <th class="p-2 text-center bg-light editname">FIRST NAME</th>
                    <th class="p-2 text-center bg-light editname">MIDDLE NAME</th>
                    <th class="p-2 text-center bg-light name">USERNAME</th>
                    <th class="p-2 text-center bg-light email">EMAIL</th>
                    <th class="p-2 text-center bg-light department">DEPARTMENT</th>
                    <th class="p-2 text-center bg-light editrole datecreated">ROLE</th>
                    <th class="p-2 text-center bg-light editactions">ACTIONS</th>
                    <th class="p-2 text-center bg-light cancel"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($allusers as $alluser)
                <tr data-value="{{ $alluser->id }}">
                    <td class="p-2 editname lastname">{{ $alluser->last_name }}</td>
                    <td class="p-2 editname firstname">{{ $alluser->name }}</td>
                    <td class="p-2 editname middlename">{{ $alluser->middle_name }}</td>
                    <td class="p-2 name username">{{ $alluser->username }}</td>
                    <td class="p-2 email">{{ $alluser->email }}</td>
                    <td class="p-2 dept department">{{ $alluser->department }}</td>
                    <td class="p-2 editrole role">{{ $alluser->role }}</td>
                    <td class="p-2 editactions">
                        <div class="text-center">

                            <button type="button" class="btn btn-sm btn-outline-primary border editdetails">
                                <b class="small">Edit Details</b>
                            </button>

                        </div>
                    </td>
                    <td class="p-2 cancel text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger border" wire:click="decline('{{ $alluser->id }}')">
                            <i class="bi bi-trash fs-5"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationModalLabel">Edit Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Registration form -->

                    <input type="hidden" id="userid" name="userid">
                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname">
                    </div>

                    <!-- Middle Name -->
                    <div class="mb-3">
                        <label for="middlename" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename">
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname">
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <!-- Department (Select Input) -->
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-select" id="department" name="department">
                            <option value="" disabled selected>Select your Department</option>
                            <option value="Department of Management">Department of Management</option>
                            <option value="Department of Industrial and Information Technology">Department of Industrial and Information Technology</option>
                            <option value="Department of Teacher Education">Department of Teacher Education</option>
                            <option value="Department of Arts and Science">Department of Arts and Science</option>
                        </select>
                    </div>

                    <!-- Role (Select Input) -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="" disabled selected>Select your Role</option>
                            <option value="Coordinator">Coordinator</option>
                            <option value="Implementer">Implementer</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeEdit">Close</button>
                    <button type="submit" class="btn btn-primary" id="confirmEdit">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            const confirmEdit = document.getElementById('confirmEdit');
            const btnSearch = document.getElementById('btnSearch');
            const inputSearch = document.getElementById('inputSearch');
            confirmEdit.addEventListener('click', function() {
                var data = {
                    'id': document.getElementById('userid').value,
                    'firstname': document.getElementById('firstname').value,
                    'middlename': document.getElementById('middlename').value,
                    'lastname': document.getElementById('lastname').value,
                    'username': document.getElementById('username').value,
                    'email': document.getElementById('email').value,
                    'department': document.getElementById('department').value,
                    'role': document.getElementById('role').value,
                };
                Livewire.emit('updateData', data);
            });
            Livewire.on('afterUpdateData', function() {
                document.getElementById('closeEdit').click();
            });

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
            inputSearch.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
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
                }
            });
        });
    </script>
</div>