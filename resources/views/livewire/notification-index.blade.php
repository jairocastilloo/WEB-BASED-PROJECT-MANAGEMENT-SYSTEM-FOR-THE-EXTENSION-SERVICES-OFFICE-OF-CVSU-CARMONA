<div class="basiccont word-wrap shadow">
    <div class="border-bottom ps-3 pt-2 bggreen pe-2">
        <h6 class="fw-bold small" style="color:darkgreen;">Notifications</h6>
    </div>
    @php
    $notificationcount = count($notifications);
    function timeAgo($timestamp) {
    $now = new DateTime();
    $time = new DateTime($timestamp);
    $interval = $now->diff($time);

    $units = [
    "y" => "year",
    "m" => "month",
    "d" => "day",
    "h" => "hour",
    "i" => "minute",
    "s" => "second",
    ];

    foreach ($units as $key => $value) {
    if ($interval->$key > 0) {
    $suffix = ($interval->$key > 1) ? "s" : "";
    return $interval->$key . " " . $value . $suffix . " ago";
    }
    }

    return "just now";
    }
    @endphp
    @foreach ($notifications as $notification)
    <div class="p-3 border-bottom divhover taskdiv @if($notification->clicked_at == null) text-dark @else text-secondary @endif" data-notificationid="{{ $notification->id }}" data-taskid="{{ $notification->task_id }}" data-tasktype="{{ $notification->task_type }}" data-taskname="{{ $notification->task_name }}">
        {{ $notification->message }}
        <span class="text-end @if($notification->clicked_at == null) text-primary @else text-secondary @endif small">{{ timeAgo($notification->created_at) }}</span>
    </div>
    @endforeach
    <div class="py-2 text-center">
        <button wire:click="showMore({{ $notificationcount }})" type="button" class="btn btn-outline-secondary">Load more</button>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('taskdiv')) {
                    event.preventDefault();
                    var notificationid = event.target.getAttribute('data-notificationid');
                    var taskid = event.target.getAttribute('data-taskid');
                    var tasktype = event.target.getAttribute('data-tasktype');
                    var taskname = event.target.getAttribute('data-taskname');
                    Livewire.emit('showTask', notificationid, taskid, tasktype, taskname);
                }
            });

        });
    </script>


</div>