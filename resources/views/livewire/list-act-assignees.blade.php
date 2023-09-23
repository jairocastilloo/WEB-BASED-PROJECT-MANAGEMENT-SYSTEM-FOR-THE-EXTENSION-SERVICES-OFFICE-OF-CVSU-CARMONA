<div>
    @php $count = 0; @endphp
    @foreach ($assignees as $key=> $assignee)
    @if ($count % 2 == 0)
    <div class="row p-1">
        @endif
        <div class="col-md border-bottom p-1 divhover checkassignee hoverassignee" value="{{ $assignee->id }}">

            <p class="m-2 ms-3">{{ $assignee->name . ' ' . $assignee->last_name }}</p>
        </div>
        @if ($count % 2 == 1 || $loop->last)
    </div>
    @endif
    @php $count++; @endphp
    @endforeach
    <button id="updatedata" wire:click="increment">Increment</button>
</div>