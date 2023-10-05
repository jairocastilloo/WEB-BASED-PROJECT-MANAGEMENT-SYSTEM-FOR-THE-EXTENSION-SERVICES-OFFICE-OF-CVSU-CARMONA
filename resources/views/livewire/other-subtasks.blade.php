<div>
    <div class="input-container m-2">
        <input type="text" class="form-control" wire:model="search" placeholder="Search subtasks...">
    </div>
    @foreach ($subtasks as $subtask)

    <div class="divhover p-2 ps-4 subtaskdiv border-bottom word-wrap" data-value="{{ $subtask->id }}" data-name="{{ $subtask->subtask_name }}">
        <h6 class="lh-1 small"><strong>{{ $subtask->subtask_name }} - <span class="text-success">{{ $subtask->status }}</span> </strong></h6>
        <h6 class="lh-1 small">Due {{ date('M d, Y', strtotime($subtask->subduedate)) }}</h6>
    </div>

    @endforeach
</div>