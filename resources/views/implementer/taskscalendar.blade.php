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
                    title: subtaskArray.subtask_name,
                    start: subtaskArray.subduedate,
                    allDay: true,
                    backgroundColor: 'green' // Set to-do date color
                };
            });

            // Add due date events with red color
            scheduledSubtasksArray.forEach(function(scheduledSubtaskArray) {
                if (scheduledSubtaskArray.subduedate) {
                    eventsArray.push({
                        title: scheduledSubtaskArray.subduedate + ' (Due Date)',
                        start: scheduledSubtaskArray.scheduledDate,
                        allDay: true,
                        backgroundColor: 'red' // Set due date color
                    });
                }
            });

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',

                dateClick: function(info) {
                    alert('Clicked on: ' + info.dateStr);
                },

                eventClick: function(info) {
                    alert(info.event.title);
                },

                eventRender: function(info) {
                    // Customize event rendering here if needed
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