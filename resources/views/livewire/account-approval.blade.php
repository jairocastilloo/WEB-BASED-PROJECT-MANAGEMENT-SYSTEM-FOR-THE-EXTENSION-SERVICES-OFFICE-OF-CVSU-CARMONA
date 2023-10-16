<div>
    <div class="mb-2" style="width:345px;">
        <input type="text" class="form-control border-success" id="searchAccount" placeholder="Search name ...">
        <input type="text" class="form-control border-success" id="searchEmail" placeholder="Search email ...">
    </div>
    <h4 id="error" class="text-center text-danger">No Pending Registration.</h4>
    <table class="accounttable">
        <thead>
            <tr id="objheader">
                <th class="p-2 text-center bg-light name">First Name</th>
                <th class="p-2 text-center bg-light name">Middle Name</th>
                <th class="p-2 text-center bg-light name">Last Name</th>
                <th class="p-2 text-center bg-light">Email</th>
                <th class="p-2 text-center bg-light department">Department</th>
                <th class="p-2 text-center bg-light actions">Actions</th>
                <th class="p-2 text-center bg-light cancel"></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pendingusers as $pendinguser)
            <tr class="accountRow" data-name="{{ $pendinguser->name . ' ' . $pendinguser->middle_name . ' ' . $pendinguser->last_name }}" data-email="{{ $pendinguser->email }}">
                <td class="p-1 name">{{ $pendinguser->name }}</td>
                <td class="p-1 name">{{ $pendinguser->middle_name }}</td>
                <td class="p-1 name">{{ $pendinguser->last_name }}</td>
                <td class="p-1">{{ $pendinguser->email }}</td>
                <td class="p-1 department">{{ $pendinguser->department }}</td>
                <td class="p-1 actions">
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
                <td class="p-1 cancel text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger border" wire:click="decline('{{ $pendinguser->id }}')">
                        <i class="bi bi-trash fs-5"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $pendingusers->links('default') }}
</div>