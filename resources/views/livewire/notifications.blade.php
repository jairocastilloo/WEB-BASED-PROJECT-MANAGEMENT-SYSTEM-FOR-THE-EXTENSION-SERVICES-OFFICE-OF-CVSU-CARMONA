<div>

    <a wire:click="update" class="nav-link border border-1 p-2 px-3 divhover fw-bold small" role="button" aria-haspopup="true" aria-expanded="false" v-pre>

        My Notifications
        @if($unreadnotificationscount)
        <span class="position-absolute top-20 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $unreadnotificationscount }}
        </span>
        @endif

    </a>

</div>