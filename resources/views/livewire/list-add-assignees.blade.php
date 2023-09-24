<div>
    <div class="form-check ms-1">
        <input class="form-check-input border border-primary" type="checkbox" id="selectAll">
        <label class="form-check-label" for="selectAll">Select All</label>
    </div>
    @foreach($addassignees as $assignee)
    <div class="form-check ms-3">
        <input class="form-check-input border border-primary" type="checkbox" id="assignee_{{ $assignee->id }}" name="assignees[]" value="{{ $assignee->id }}">
        <label class="form-check-label" for="assignee_{{ $assignee->id }}">{{ $assignee->name . ' ' . $assignee->last_name }}</label>
    </div>
    @endforeach
    <button class="d-none" id="updateaddAssigneesdata" wire:click="updateaddAssignees"></button>
    <script>
        document.addEventListener('livewire:load', function() {
            var selectAllCheckbox = document.getElementById('selectAll');
            var assigneeCheckboxes = document.querySelectorAll('input[name="assignees[]"]');
            selectAllCheckbox.addEventListener('change', function() {
                var areAssigneesChecked = areAllAssigneesChecked();

                if (!areAssigneesChecked) {
                    if (this.checked === true) {
                        for (checkbox of assigneeCheckboxes) {
                            if (!checkbox.checked) {
                                checkbox.checked = true;
                            }
                        }
                    }
                } else {
                    if (this.checked === false) {
                        for (checkbox of assigneeCheckboxes) {
                            if (checkbox.checked) {
                                checkbox.checked = false;
                            }
                        }
                    }
                }
            });

            function areAllAssigneesChecked() {
                for (checkbox of assigneeCheckboxes) {
                    if (!checkbox.checked) {
                        return false; // Exit the loop early if any checkbox is unchecked
                    }
                }
                return true;
            }
        });
    </script>
</div>