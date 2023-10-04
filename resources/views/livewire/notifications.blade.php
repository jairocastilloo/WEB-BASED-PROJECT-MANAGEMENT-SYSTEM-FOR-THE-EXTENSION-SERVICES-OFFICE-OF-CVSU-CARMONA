<div>

    <a wire:click="update" class="nav-link text-white position-relative me-2 navtohover mx-2" role="button" aria-haspopup="true" aria-expanded="false" v-pre>

        Notifications
        @if($unreadnotificationscount)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $unreadnotificationscount }}
        </span>
        @endif

    </a>

</div>