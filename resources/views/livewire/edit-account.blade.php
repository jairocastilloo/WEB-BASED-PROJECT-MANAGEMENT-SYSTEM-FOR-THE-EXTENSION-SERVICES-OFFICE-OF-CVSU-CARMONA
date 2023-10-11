<table class="accounttable">
    <thead>
        <tr id="objheader">
            <th class="p-2 text-center bg-light name">First Name</th>
            <th class="p-2 text-center bg-light name">Middle Name</th>
            <th class="p-2 text-center bg-light name">Last Name</th>
            <th class="p-2 text-center bg-light">Email</th>
            <th class="p-2 text-center bg-light department">Department</th>
            <th class="p-2 text-center bg-light actions">Actions</th>
            <th class="p-2 text-center bg-light cancel">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($allusers as $alluser)

        <tr>
            <td class="p-1 name">{{ $alluser->name }}</td>
            <td class="p-1 name">{{ $alluser->middle_name }}</td>
            <td class="p-1 name">{{ $alluser->last_name }}</td>
            <td class="p-1">{{ $alluser->email }}</td>
            <td class="p-1 department">{{ $alluser->department }}</td>
            <td class="p-1 actions">
                <div class="text-center">
                    <div class="mb-1">Approve as:</div>
                    <button type="button" class="btn btn-sm btn-outline-success border" wire:click="approveAsCoordinator('{{ $alluser->id }}')">
                        <b class="small">Coordinator</b>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-success border" wire:click="approveAsImplementer('{{ $alluser->id }}')">
                        <b class="small">Implementer</b>
                    </button>
                </div>


            </td>
            <td class="p-1 cancel text-center">
                <button type="button" class="btn btn-sm btn-outline-danger border" wire:click="decline('{{ $alluser->id }}')">
                    <i class="bi bi-trash fs-5"></i>
                </button>
            </td>

        </tr>

        @endforeach
    </tbody>
</table>