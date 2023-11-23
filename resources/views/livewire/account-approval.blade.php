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
    <nav class='nav-pagelink'>
        <ul class="pagination">
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
            
            @for ($i = 1; $i <= $totalPages; $i++) <li class="page-item {{ $i === $currentPage ? 'active' : 'number-link' }}" aria-current="{{ $i === $currentPage ? 'page' : '' }}">
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
                <tr class="accountRow" data-name="{{ $pendinguser->name . ' ' . $pendinguser->middle_name . ' ' . $pendinguser->last_name }}" data-email="{{ $pendinguser->email }}" data-id="{{ $pendinguser->id }}">
                    <td class="p-2 name">{{ $pendinguser->last_name }}</td>
                    <td class="p-2 name">{{ $pendinguser->name }}</td>
                    <td class="p-2 name">{{ $pendinguser->middle_name }}</td>
                    <td class="p-2 email">{{ $pendinguser->email }}</td>
                    <td class="p-2 department">{{ $pendinguser->department }}</td>
                    <td class="p-2 datecreated">{{ $pendinguser->created_at->format('F j, Y') }}</td>
                    <td class="p-2 actions">
                        <div class="text-center">
                            <div class="mb-1">Approve as:</div>
                            <button type="button" class="btn btn-sm btn-outline-success border shadow-sm" wire:click="approveAsCoordinator('{{ $pendinguser->id }}')">
                                <b class="small">Coordinator</b>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success border shadow-sm" wire:click="approveAsImplementer('{{ $pendinguser->id }}')">
                                <b class="small">Implementer</b>
                            </button>
                            <span class="ms-2 small" id="loadingSpan[{{ $pendinguser->id}}]" style="display: none;">Sending Email..</span>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="emailError[{{ $pendinguser->id}}]" style="display: none;">
                                <!-- Your error message goes here -->
                                <strong>Error:</strong><span id="errorMessage[{{ $pendinguser->id}}]"></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>

                    </td>
                    <td class="p-2 cancel text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger border declineAccount">
                            <i class="bi bi-trash fs-5"></i>
                        </button>
                        <span class="ms-2 small" id="loadingSpanDecline[{{ $pendinguser->id}}]" style="display: none;">Sending Email..</span>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="emailErrorDecline[{{ $pendinguser->id}}]" style="display: none;">
                            <!-- Your error message goes here -->
                            <strong>Error:</strong><span id="errorMessageDecline[{{ $pendinguser->id}}]"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Decline Account Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="declineId">
                    <label class="form-label">Reason:</label>
                    <textarea class="form-control" id="notes" rows="5" placeholder="Input your notes here ..."></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeDecline">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitBtnDecline">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            const btnSearch = document.getElementById('btnSearch');
            const inputSearch = document.getElementById('inputSearch');
            const submitBtnDecline = document.getElementById('submitBtnDecline');

            Livewire.on('updateElements', function(id) {

                document.getElementById('loadingSpan[' + id + ']').style.display = "inline-block";
                Livewire.emit('sendEmail', id);
            });
            Livewire.on('updateLoading', function(id) {
                document.getElementById('loadingSpan[' + id + ']').style.display = "none";
            });
            Livewire.on('updateLoadingFailed', function(id, e) {
                document.getElementById('loadingSpan[' + id + ']').style.display = "none";
                document.getElementById('errorMessage[' + id + ']').textContent = e;
                document.getElementById('emailError[' + id + ']').style.display = "inline-block";

            });

            submitBtnDecline.addEventListener('click', function() {
                var id = document.getElementById('declineId').value;
                var reason = document.getElementById('notes').value;
                document.getElementById('closeDecline').click();
                document.getElementById('loadingSpanDecline[' + id + ']').style.display = "inline-block";
                Livewire.emit('sendEmailDecline', id, reason);
                // Livewire.emit('decline', id);
            });
            /*
            Livewire.on('updateElementsDecline', function(id) {
                var reason = document.getElementById('notes').value;
                document.getElementById('loadingSpanDecline[' + id + ']').style.display = "inline-block";
                Livewire.emit('sendEmailDecline', id, reason);
            });
            */
            Livewire.on('updateLoadingDecline', function(id) {
                document.getElementById('loadingSpanDecline[' + id + ']').style.display = "none";
            });
            Livewire.on('updateLoadingFailedDecline', function(id, e) {
                document.getElementById('loadingSpanDecline[' + id + ']').style.display = "none";
                document.getElementById('errorMessageDecline[' + id + ']').textContent = e;
                document.getElementById('emailErrorDecline[' + id + ']').style.display = "inline-block";

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