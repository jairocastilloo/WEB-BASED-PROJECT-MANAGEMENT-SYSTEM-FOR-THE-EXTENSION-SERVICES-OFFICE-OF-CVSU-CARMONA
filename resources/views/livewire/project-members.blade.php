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

                        <p class="m-2 ms-3">{{ $member->name . ' ' . $member->last_name }}


                        </p>



                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-outline-danger fs-5 border float-end" wire:click="unassignMembers('{{ $member->id }}')">
                            <i class="bi bi-person-dash"></i>
                        </button>
                    </div>
                </div>

            </div>

            @if ($count % 2 == 1 || $loop->last)
        </div>
        @endif
        @php $count++; @endphp
        @endforeach
    </div>

    <div class="btn-group ms-3 mt-2 mb-3 shadow">
        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" data-bs-toggle="modal" data-bs-target="#addAssigneeModal">
            <b class="small">Add Members</b>
        </button>
    </div>

    <div class="modal fade" id="addAssigneeModal" tabindex="-1" aria-labelledby="addAssigneeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAssigneeModalLabel">Add Assignee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ $project->projecttitle . "'s Team Members" }}</label>

                        <div class="form-check ms-1">
                            <input class="form-check-input border border-primary" type="checkbox" id="selectAllMembers">
                            <label class="form-check-label" for="selectAllMembers">Select All</label>
                        </div>
                        @foreach($addmembers as $addmember)
                        <div class="form-check ms-3">
                            <input class="form-check-input border border-primary" type="checkbox" id="addmember_{{ $addmember->id }}" name="addmember[]" value="{{ $addmember->id }}">
                            <label class="form-check-label" for="addmember_{{ $addmember->id }}">{{ $addmember->name . ' ' . $addmember->last_name }}</label>
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="addMembersCloseButton" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="saveMembersButton" class="btn btn-primary">Add Members</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            var selectAllMembers = document.getElementById('selectAllMembers');
            var addMemberCheckboxes = document.querySelectorAll('input[name="addmember[]"]');
            var saveMembersButton = document.getElementById('saveMembersButton');

            saveMembersButton.addEventListener('click', function() {
                var checkedAddMemberCheckboxes = document.querySelectorAll('input[name="addmember[]"]:checked');

                var selectedMembers = Array.from(checkedAddMemberCheckboxes).map(checkedAddMemberCheckbox => checkedAddMemberCheckbox.value);
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