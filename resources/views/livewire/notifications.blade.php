<div>
    @if(in_array(Route::currentRouteName(), ['notification.index']))
    <a class="nav-link border border-1 p-2 px-4 currentdiv fw-bold small">
        My Notifications

    </a>
    @else
    <a wire:click="update" class="nav-link border border-1 p-2 px-4 divhover fw-bold small" role="button" aria-haspopup="true" aria-expanded="false" v-pre>

        My Notifications
        @if($unreadnotificationscount)
        <span class="position-absolute top-20 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $unreadnotificationscount }}
        </span>
        @endif

    </a>
    @endif

</div>