<div class="basiccont shadow p-2 mt-4 ms-2 mb-4">
    <div class="border-bottom ps-2 bggreen">
        <h6 class="fw-bold small" style="color:darkgreen;">Assignees</h6>
    </div>
    @php $count = 0; @endphp
    <form id="unassignassigneeform" data-url="{{ route('unassign.assignee') }}">
        @csrf
        <input type="number" id="unassignassigneeid" name="unassignassigneeid" class="d-none">
        <input type="number" id="unassignactivityid" name="unassignactivityid" class="d-none" value="{{ $activity['id'] }}">
    </form>
    @foreach ($assignees as $key=> $assignee)
    @if ($count % 2 == 0)
    <div class="row p-1">
        @endif
        <div class="col border-bottom p-1 divhover checkassignee hoverassignee" value="{{ $assignee->id }}">

            <p class="m-2 ms-3">{{ $assignee->name . ' ' . $assignee->last_name }}</p>
        </div>
        @if ($count % 2 == 1 || $loop->last)
    </div>
    @endif
    @php $count++; @endphp
    @endforeach
    <div class="btn-group ms-2 mt-2 mb-2 shadow">
        <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow addassignees-btn">
            <b class="small">Add Assignees</b>
        </button>
    </div>
    <script>
    </script>
</div>