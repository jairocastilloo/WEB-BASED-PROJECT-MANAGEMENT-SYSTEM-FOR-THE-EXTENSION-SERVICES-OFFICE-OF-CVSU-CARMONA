<div>
    @foreach ($notifications as $notification)
    <div class="p-2 border-bottom">
        {{ $notification->message }}
    </div>
    @endforeach
</div>