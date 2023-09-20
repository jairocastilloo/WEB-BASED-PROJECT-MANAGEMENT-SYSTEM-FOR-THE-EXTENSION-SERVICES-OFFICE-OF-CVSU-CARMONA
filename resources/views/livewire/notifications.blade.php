<div class="dropdown" id="notificationList">
    <a wire:click="updateNotifications" class="nav-link text-dark position-relative me-2 dropdown-toggle" role="button" id="notificationBar" aria-haspopup="true" aria-expanded="false" v-pre>
        Notifications
        @if($unreadnotificationscount)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $unreadnotificationscount }}
        </span>
        @endif
    </a>

    <ul class="dropdown-menu">
        @foreach($notifications as $notification)
        <li>
            <a class="dropdown-item">
                {{ $notification->message }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        const dropdownMenu = document.querySelector('#notificationList .dropdown-menu');
        const dropdownToggle = document.querySelector('#notificationBar');
        const notificationBarSpan = document.querySelector('#notificationBar span');

        dropdownToggle.addEventListener('click', function() {
            if (dropdownToggle && dropdownToggle.hasAttribute('wire:click')) {
                Livewire.on('updateNotifications', function() {




                    // Remove the 'shows' class from the notificationBar span

                    if (notificationBarSpan) {
                        notificationBarSpan.remove();
                    }
                    dropdownMenu.classList.add('shows');
                    dropdownToggle.removeAttribute('wire:click');
                });
            } else {

                if (dropdownMenu.classList.contains('shows')) {
                    dropdownMenu.classList.remove('shows');
                } else {
                    dropdownMenu.classList.add('shows');
                }

            }
        });
    });
</script>