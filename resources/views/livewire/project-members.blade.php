<div class="container">
    @php $count = 0; @endphp
    @foreach ($members as $key=> $member)
    @if ($count % 2 == 0)
    <div class="row">
        @endif
        <div class="col-md border-end border-bottom p-1 divhover checkassignee hoverassignee" data-name="{{ $member->name . ' ' . $member->last_name }}" data-email="{{ $member->email }}" data-role="{{ $member->role }}" data-id="{{ $member->id }}">

            <p class="m-2 ms-3">{{ $member->name . ' ' . $member->last_name }}</p>
        </div>
        @if ($count % 2 == 1 || $loop->last)
    </div>
    @endif
    @php $count++; @endphp
    @endforeach
</div>