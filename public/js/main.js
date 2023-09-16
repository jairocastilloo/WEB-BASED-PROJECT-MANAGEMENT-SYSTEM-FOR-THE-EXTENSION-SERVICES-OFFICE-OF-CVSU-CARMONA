document.addEventListener('livewire:load', function () {
    Livewire.on('notificationReceived', function () {
        // Update notification count logic here
        // For example:
        let notificationCount = parseInt(document.getElementById('notification-count').innerText);
        document.getElementById('notification-count').innerText = notificationCount + 1;
    });
});