@extends('layouts.app')

@section('content')

<div class="maincontainer border border-start border-end border-top-0">
    <div class="container p-0">

        <div class="mainnav mb-3 border-1 border-bottom shadow-sm px-2 small">
            <nav class="navbar navbar-expand-sm p-0">
                <button class="navbar-toggler btn btn-sm m-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMonitoring" aria-controls="navbarMonitoring" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMonitoring">
                    <ul class="navbar-nav me-auto">

                        <a class="nav-link border border-1 p-2 px-4 divhover fw-bold small" href="{{ route('tasks.show', [ 'username' => Auth::user()->username ]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            My Duties
                        </a>

                        <a class="nav-link border border-1 p-2 px-4 currentdiv fw-bold small">
                            My Tasks Calendar
                        </a>

                        @livewire('notifications')


                    </ul>
                </div>
            </nav>

        </div>
    </div>
    <div class="container">
        <div class="basiccont rounded shadow">

            <div class="border-bottom ps-3 pt-2 bggreen">
                <h6 class="fw-bold small" style="color:darkgreen;">My Tasks Calendar</h6>
            </div>
            <div id="legend">
                <div class="legend-item" style="background-color: blue"></div>
                <span>To Do Date</span>
                <div class="legend-item" style="background-color: red"></div>
                <span>Due Date</span>



            </div>
            <div class="p-2" id="calendar"></div>


        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/fullcalendar.global.min.js') }}"></script>
<script src="{{ asset('js/fullcalendarbootstrap5.global.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#toggleButton', function(event) {
            $(this).next().slideToggle("fast");
        });

        $('#navbarDropdown').click(function(event) {
            event.preventDefault();
            $('#account .dropdown-menu').toggleClass('shows');
        });

        try {
            var subtasksArray = <?php echo json_encode($subtasksArray); ?>;
            var scheduledSubtasksArray = <?php echo json_encode($scheduledSubtasksArray); ?>;
            if (!Array.isArray(subtasksArray)) {
                throw new Error('Invalid subtasks data');
            }

            var eventsArray = subtasksArray.map(function(subtaskArray) {
                return {
                    id: subtaskArray.id,
                    title: subtaskArray.subtask_name + ' (Due)',
                    start: subtaskArray.subduedate,
                    allDay: true,
                    backgroundColor: '#dc3545' // Set to-do date color
                };
            });

            // Add due date events with red color
            scheduledSubtasksArray.forEach(function(scheduledSubtaskArray) {
                if (scheduledSubtaskArray.subduedate) {
                    eventsArray.push({
                        id: scheduledSubtaskArray.id,
                        title: scheduledSubtaskArray.subtask_name + ' (To Do)',
                        start: scheduledSubtaskArray.scheduledDate,
                        allDay: true,
                        backgroundColor: '#0d6efd' // Set due date color
                    });
                }
            });

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',
                /*
                                dateClick: function(info) {
                                    alert('Clicked on: ' + info.dateStr);
                                },
                */
                eventClick: function(info) {
                    var url = '{{ route("subtasks.display", ["subtaskid" => ":subtaskid", "subtaskname" => ":subtaskname"]) }}';
                    url = url.replace(':subtaskid', info.event.id);
                    url = url.replace(':subtaskname', info.event.title);
                    window.location.href = url;
                },

                eventContent: function(arg) {
                    var maxTitleLength = 17; // Adjust the maximum length as needed
                    var truncatedTitle = arg.event.title.length > maxTitleLength ? arg.event.title.substring(0, maxTitleLength) + '...' : arg.event.title;

                    return {
                        html: '<div class="event-content fcnavhoverr" style="color: white;" title="' + arg.event.title + '">' + truncatedTitle + '</div>'
                    };
                },

                events: eventsArray
            });

            calendar.render();
        } catch (error) {
            console.error(error);
        }

    });
</script>
@endsection
