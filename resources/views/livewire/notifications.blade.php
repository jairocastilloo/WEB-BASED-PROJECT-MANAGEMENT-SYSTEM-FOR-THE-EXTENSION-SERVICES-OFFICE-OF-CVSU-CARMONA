<div class="dropdown" id="notificationList">
    <a wire:click="updateNotifications" class="nav-link text-dark position-relative me-2 dropdown-toggle" role="button" id="notificationBar" aria-haspopup="true" aria-expanded="false" v-pre>
        Notifications
        @if($unreadnotificationscount)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $unreadnotificationscount }}
        </span>
        @endif
    </a>

    <ul class="dropdown-menu" style="width: 250px; left: -15px; cursor: pointer;">
        @foreach($notifications as $notification)
        <li class="border-bottom">
            <a wire:click="redirectToTask('{{ $notification->id }}', '{{ $notification->task_type }}', '{{ $notification->task_id }}', '{{ $notification->task_name }}')" class="dropdown-item text-wrap">
                {{ $notification->message }}
            </a>
        </li>
        @endforeach
    </ul>
    <script>
        document.addEventListener('livewire:load', function() {
            const dropdownMenu = document.querySelector('#notificationList .dropdown-menu');
            const dropdownToggle = document.querySelector('#notificationBar');


            dropdownToggle.addEventListener('click', function() {
                if (dropdownToggle && dropdownToggle.hasAttribute('wire:click')) {
                    Livewire.on('updateNotifications', function() {


                        // Remove the 'shows' class from the notificationBar span

                        if (document.querySelector('#notificationBar span')) {
                            document.querySelector('#notificationBar span').remove();
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
</div>