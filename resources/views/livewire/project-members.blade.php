<div>
    <div class="container">
        @php $count = 0; @endphp
        @foreach ($members as $key=> $member)
        @if ($count % 2 == 0)
        <div class="row">
            @endif
            <div class="col-md border-end border-bottom divhover">
                <div class="row">
                    <div class="col-10 checkmember" data-name="{{ $member->name . ' ' . $member->last_name }}" data-email="{{ $member->email }}" data-role="{{ $member->role }}">

                        <p class="m-2 ms-3">
                            {{ $member->last_name . ', ' . $member->name . ' ' . ($member->middle_name ? $member->middle_name[0] : 'N/A') . '.' }}
                        </p>

                    </div>
                    <div class="col-2">
                        @if (Auth::user()->role === 'Admin')
                        <button type="button" class="btn btn-outline-danger fs-5 border float-end" wire:click="unassignMembers('{{ $member->id }}')">
                            <i class="bi bi-person-dash"></i>
                        </button>
                        @endif
                    </div>
                </div>

            </div>

            @if ($count % 2 == 1 || $loop->last)
        </div>
        @endif
        @php $count++; @endphp
        @endforeach
    </div>
    @if (Auth::user()->role === 'Admin')
    <div class="btn-group ms-3 mt-2 mb-2 shadow">
        <button type="button" class="btn btn-sm rounded btn-gold shadow" id="btnAddMember" data-bs-toggle="modal" data-bs-target="#addAssigneeModal">
            <b class="small">Add Members</b>
        </button>

    </div>
    @endif
    <span class="ms-2 small loadingMessage" id="loadingSpan" style="display: none;">Sending Email..</span>
    <div class="alert alert-danger alert-dismissible fade show ms-2 mt-1" role="alert" id="emailError" style="display: none;">
        <!-- Your error message goes here -->
        <strong>Error:</strong><span id="errorMessage">The email has not been sent due to internet issue.</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="modal fade" id="addAssigneeModal" tabindex="-1" aria-labelledby="addAssigneeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAssigneeModalLabel">Add Team Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ $department . "'s Team Members" }}</label>

                        <div class="form-check ms-1" @if($addmembers->isEmpty())style="display:none"@endif>
                            <input class="form-check-input border border-primary" type="checkbox" id="selectAllMembers">
                            <label class="form-check-label" for="selectAllMembers">Select All</label>
                        </div>

                        @if($addmembers->isEmpty())
                        <h5 class="ms-3"><i>Every Members have been added.</i></h5>
                        @endif
                        @foreach($addmembers as $addmember)
                        <div class="form-check ms-3">
                            <input class="form-check-input border border-primary" type="checkbox" id="addmember_{{ $addmember->id }}" name="addmember[]" value="{{ $addmember->id }}">
                            <label class="form-check-label" for="addmember_{{ $addmember->id }}">{{ $addmember->last_name . ', ' . $addmember->name . ' ' . ($addmember->middle_name ? $addmember->middle_name[0] : 'N/A') . '.' }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bt-md rounded border border-1 btn-light shadow" id="addMembersCloseButton" data-bs-dismiss="modal">Cancel</button>

                    <button type="button" id="saveMembersButton" class="btn btn-md rounded btn-gold shadow" @if($addmembers->isEmpty())style="display:none"@endif>Add Members</button>


                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            var selectAllMembers;
            var addMemberCheckboxes;
            var saveMembersButton;
            selectAllMembers = document.getElementById('selectAllMembers');
            addMemberCheckboxes = document.querySelectorAll('input[name="addmember[]"]');
            saveMembersButton = document.getElementById('saveMembersButton');

            Livewire.on('updateElements', function(selectedMembers) {
                selectAllMembers = document.getElementById('selectAllMembers');
                addMemberCheckboxes = document.querySelectorAll('input[name="addmember[]"]');
                saveMembersButton = document.getElementById('saveMembersButton');
                selectAllMembers.checked = false;
                document.getElementById('loadingSpan').style.display = "inline-block";
                document.getElementById('btnAddMember').disabled = true;
                Livewire.emit('sendNotification', selectedMembers);
            });
            Livewire.on('updateLoading', function() {
                document.getElementById('loadingSpan').style.display = "none";
                document.getElementById('btnAddMember').disabled = false;
            });
            Livewire.on('updateLoadingFailed', function(e) {
                document.getElementById('loadingSpan').style.display = "none";
                document.getElementById('btnAddMember').disabled = false;
                document.getElementById('emailError').style.display = "inline-block";

            });
            Livewire.on('updateUnassignElements', function() {
                selectAllMembers = document.getElementById('selectAllMembers');
                addMemberCheckboxes = document.querySelectorAll('input[name="addmember[]"]');
                saveMembersButton = document.getElementById('saveMembersButton');
                selectAllMembers.checked = false;
            });
            saveMembersButton.addEventListener('click', function() {
                var checkedAddMemberCheckboxes = document.querySelectorAll(
                    'input[name="addmember[]"]:checked');

                var selectedMembers = Array.from(checkedAddMemberCheckboxes).map(checkedAddMemberCheckbox =>
                    checkedAddMemberCheckbox.value);
                document.getElementById('addMembersCloseButton').click();
                Livewire.emit('saveMembers', selectedMembers);
            });


            selectAllMembers.addEventListener('change', function() {
                var areAddMemberChecked = areAllAddMemberChecked();

                if (!areAddMemberChecked) {
                    if (this.checked === true) {
                        for (checkbox of addMemberCheckboxes) {
                            if (!checkbox.checked) {
                                checkbox.checked = true;
                            }
                        }
                    }
                } else {
                    if (this.checked === false) {
                        for (checkbox of addMemberCheckboxes) {
                            if (checkbox.checked) {
                                checkbox.checked = false;
                            }
                        }
                    }
                }
            });


            function areAllAddMemberChecked() {
                for (checkbox of addMemberCheckboxes) {
                    if (!checkbox.checked) {
                        return false; // Exit the loop early if any checkbox is unchecked
                    }
                }
                return true;
            }
        });
    </script>
</div>
