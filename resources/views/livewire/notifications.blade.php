<li class="nav-item">
    <div class="dropdown" id="notificationList">
        <a class="nav-link text-dark position-relative me-2 dropdown-toggle" data-url="{{ route('notification.markasread', ['id' => Auth::user()->id]) }}" role="button" id="notificationBar" aria-haspopup="true" aria-expanded="false" v-pre>
            Notifications
            @php
            $countOfUnread = count($notifications->where('read_at', null));
            @endphp
            @if($countOfUnread)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $countOfUnread }}

            </span>
            @endif
        </a>
        <ul class="dropdown-menu">
            @foreach($notifications as $notification)
            <li>
                <a class="dropdown-item">
                    {{ ($notification->message) }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</li>