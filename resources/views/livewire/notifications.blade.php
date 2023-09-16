@livewire('notifications')
<div>
    <h2>Notifications</h2>
    <p>Notification Count: <span id="notification-count">{{ $notificationCount }}</span></p>
    <ul>
        @foreach ($notifications as $notification)
        <li>{{ $notification->message }}</li>
        @endforeach
    </ul>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('notificationReceived', function() {
            // Update notification count logic here
            // For example:
            let notificationCount = parseInt(document.getElementById('notification-count').innerText);
            document.getElementById('notification-count').innerText = notificationCount + 1;
        });
    });
</script>
@endpush