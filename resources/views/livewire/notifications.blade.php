<div class="dropdown" id="notificationList">

    <a wire:click="updateNotifications" class="nav-link text-dark position-relative me-2 dropdown-toggle" role="button" id="notificationBarHide" aria-haspopup="true" aria-expanded="false" v-pre>

        Notifications
        @if($unreadnotificationscount)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $unreadnotificationscount }}
        </span>
        @endif
    </a>

    <a class="nav-link text-dark position-relative me-2 dropdown-toggle" role="button" id="notificationBar" style="display:none">
        Notifications
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
            const dropdownToggleHide = document.querySelector('#notificationBarHide');


            Livewire.on('updateNotifications', function() {

                // Remove the 'shows' class from the notificationBar span
                if (document.querySelector('#notificationBar span')) {
                    document.querySelector('#notificationBar span').remove();
                }
                dropdownToggleHide.style.display = 'none';
                dropdownToggle.style.display = 'block';
                dropdownMenu.classList.add('shows');


            });
            dropdownToggle.addEventListener('click', function() {
                if (dropdownMenu.classList.contains('shows')) {
                    dropdownMenu.classList.remove('shows');
                } else {
                    dropdownMenu.classList.add('shows');
                }
            });

        });
    </script>
</div>