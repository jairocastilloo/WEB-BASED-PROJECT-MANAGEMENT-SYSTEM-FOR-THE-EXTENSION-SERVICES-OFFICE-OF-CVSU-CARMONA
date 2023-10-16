<div>
    <div class="mb-2" style="width:345px;">
        <input type="text" class="form-control border-success" id="searchAccount" placeholder="Search name ...">
        <input type="text" class="form-control border-success" id="searchEmail" placeholder="Search email ...">
    </div>
    {{ $pendingusers->links('default') }}
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
                @foreach ($pendingusers as $pendinguser)
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
</div>