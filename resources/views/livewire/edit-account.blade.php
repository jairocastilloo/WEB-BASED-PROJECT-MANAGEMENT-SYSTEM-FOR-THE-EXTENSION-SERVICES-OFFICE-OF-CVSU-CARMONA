<table class="accounttable">
    <thead>
        <tr id="objheader">
            <th class="p-2 text-center bg-light name">First Name</th>
            <th class="p-2 text-center bg-light name">Middle Name</th>
            <th class="p-2 text-center bg-light name">Last Name</th>
            <th class="p-2 text-center bg-light username">Username</th>
            <th class="p-2 text-center bg-light dept">Department</th>
            <th class="p-2 text-center bg-light role">Role</th>
            <th class="p-2 text-center bg-light edit">Actions</th>
            <th class="p-2 text-center bg-light cancel"></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($allusers as $alluser)

        <tr data-value="{{ $alluser->id }}">
            <td class="p-1 name firstname">{{ $alluser->name }}</td>
            <td class="p-1 name middlename">{{ $alluser->middle_name }}</td>
            <td class="p-1 name lastname">{{ $alluser->last_name }}</td>
            <td class="p-1 username">{{ $alluser->username }}</td>
            <td class="p-1 dept">{{ $alluser->department }}</td>
            <td class="p-1 role text-center">{{ $alluser->role }}</td>
            <td class="p-1 edit">
                <div class="text-center">

                    <button type="button" class="btn btn-sm btn-outline-primary border editdetails">
                        <b class="small">Edit Details</b>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="confirmEdit">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            const confirmEdit = document.getElementById('confirmEdit');
            confirmEdit.addEventListener('click', function() {
                var data = {
                    'id': document.getElementById('userid').value,
                    'firstname': document.getElementById('firstname').value,
                    'middlename': document.getElementById('middlename').value,
                    'lastname': document.getElementById('lastname').value,
                    'username': document.getElementById('username').value,
                    'department': document.getElementById('department').value,
                    'role': document.getElementById('role').value,
                };
                Livewire.emit('updateData', data);
            });
        });
    </script>
</table>