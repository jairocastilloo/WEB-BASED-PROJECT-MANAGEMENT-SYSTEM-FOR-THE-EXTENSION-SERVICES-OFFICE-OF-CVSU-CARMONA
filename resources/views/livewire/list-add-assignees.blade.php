<div>
    @foreach($addassignees as $assignee)
    <div class="form-check ms-3">
        <input class="form-check-input border border-primary" type="checkbox" id="assignee_{{ $assignee->id }}" name="assignees[]" value="{{ $assignee->id }}">
        <label class="form-check-label" for="assignee_{{ $assignee->id }}">{{ $assignee->name . ' ' . $assignee->last_name }}</label>
    </div>
    @endforeach
    <button class="d-none" id="updateaddAssigneesdata" wire:click="updateaddAssignees"></button>
</div>