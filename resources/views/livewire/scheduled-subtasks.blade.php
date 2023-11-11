<div>
    @php
    $currentDate = strtotime('today');
    $formattedCurrentDate = date('Y-m-d', $currentDate);
    @endphp

    <div class="basiccont word-wrap shadow">
        <div class="border-bottom ps-3 pe-2 pt-2 bggreen pe-2 containerhover">
            <h6 class="fw-bold small" style="color:darkgreen;">
                <i class="bi bi-list-task"></i>
                Scheduled

            </h6>
        </div>

        <div class="m-2 mb-0 text-center" @if ($xScheduledTasks==0)style="display: none;" @endif>
            <input type="text" class="form-control border border-2 mb-2" id="inputSearchScheduledTasks" placeholder="Enter name...">
            <button type="button" class="btn btn-sm btn-outline-success px-3" id="btnSearchScheduledTasks">Search Task</button>
            <span class="invalid-feedback small fw-bold text-end" id="errorAccount">
                Please enter a subtask name.
            </span>
        </div>
        <div class="text-center m-1" @if ($xScheduledTasks==0)style="display: none;" @endif>
            <button wire:click="refreshDataScheduledTasks" type="button" class="btn btn-sm btn-light border small">
                Refresh
            </button>
        </div>
        @if ($xScheduledTasks == 0)
        <div class="shadow text-center p-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showScheduledTasks(1)">
                <b class="small">Show Tasks</b>
            </button>

        </div>
        @else
        @if ($ScheduledTasks->isEmpty())
        <div class="p-2 text-center">
            <h6 class="fw-bold small">No Scheduled Tasks</h6>
        </div>
        @else



        <div class="container p-0">
            @foreach($ScheduledTasks as $subtask)
            <div class="border-bottom ps-3 p-2 divhover subtaskdiv" data-value="{{ $subtask['id'] }}" style="position: relative;">
                @php
                $subduedate = strtotime($subtask['subduedate']);
                $subcreatedat = strtotime($subtask['created_at']);
                $toDoSchedule = strtotime($subtask['scheduledDate']);

                $formattedSubduedate = date('Y-m-d', $subduedate);
                $formattedSubcreatedat = date('Y-m-d', $subcreatedat);
                $formattedtoDoSchedule = date('Y-m-d', $toDoSchedule);
                @endphp

                <h6 class="small" style="color: #4A4A4A;"><b>{{ $subtask['subtask_name'] }}</b></h6>

                @if ($formattedSubcreatedat === $formattedCurrentDate)
                <h6 class="text-secondary small">{{ 'Created Today, ' . date('M d Y', $subcreatedat) }}</h6>
                @elseif (date('Y-m-d', strtotime('-1 day', $currentDate)) === $formattedSubcreatedat)
                <h6 class="text-secondary small">{{ 'Created Yesterday, ' . date('M d Y', $subcreatedat) }}</h6>
                @else
                <h6 class="text-secondary small">{{ 'Created ' . date('D, M d, Y', $subcreatedat) }}</h6>
                @endif

                @if ($formattedSubduedate === $formattedCurrentDate)
                <h6 class="ps-2 text-success fw-bold small">{{ 'Due Today, ' . date('M d Y', $subduedate) }}</h6>
                @elseif (date('Y-m-d', strtotime('+1 day', $currentDate)) === $formattedSubduedate)
                <h6 class="ps-2 text-success fw-bold small">{{ 'Due Tomorrow, ' . date('M d Y', $subduedate) }}</h6>
                @else
                <h6 class="ps-2 text-success fw-bold small">{{ 'Due ' . date('D, M d Y', $subduedate) }}</h6>
                @endif

                @if ($formattedtoDoSchedule === $formattedCurrentDate)
                <h6 class="ps-3 text-primary fw-bold small">{{ 'To Do Today, ' . date('M d Y', $toDoSchedule) }}</h6>
                @elseif (date('Y-m-d', strtotime('+1 day', $currentDate)) === $formattedtoDoSchedule)
                <h6 class="ps-3 text-primary fw-bold small">{{ 'To Do Tomorrow, ' . date('M d Y', $toDoSchedule) }}</h6>
                @else
                <h6 class="ps-3 text-primary fw-bold small">{{ 'To Do ' . date('D, M d Y', $toDoSchedule) }}</h6>
                @endif

            </div>
            @endforeach

            <nav class="border-bottom">
                <ul class="pagination justify-content-center m-1">

                    @if ($currentPageScheduledTasks === 1)
                    <li class="page-item disabled">
                        <span class="page-link small" aria-hidden="true"><i class="bi bi-caret-left-fill"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageScheduledTasks({{ $currentPageScheduledTasks - 1 }})" rel="prev"><i class="bi bi-caret-left-fill"></i></a>
                    </li>
                    @endif

                    <li class="page-item text-center mx-2">
                        <h6 class="fw-bold my-0 mt-2 small">{{ $currentPageScheduledTasks . ' of ' . $totalPagesScheduledTasks }}</h6>
                        <span class="m-0 text-secondary fw-bold" style="font-size: 12px;">Pages</span>
                    </li>


                    @if ($currentPageScheduledTasks === $totalPagesScheduledTasks)
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" wire:click="changePageScheduledTasks({{ $currentPageScheduledTasks + 1 }})"><i class="bi bi-caret-right-fill"></i></i></a>
                    </li>
                    @endif

                </ul>
            </nav>


        </div>

        @endif
        <div class="text-center p-2 border border-bottom-2">
            <button type="button" class="btn btn-sm shadow rounded border border-1 btn-gold border-warning text-body" wire:click="showScheduledTasks(0)">
                <b class="small">Hide Tasks</b>
            </button>

        </div>
        @endif

        <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="scheduleModalLabel">Set A Scheduled Date</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for setting the schedule -->

                        <input type="hidden" id="scheduleSubtaskId">
                        <div class="text-center">
                            <label for="subtaskName" class="form-label fw-bold" id="scheduleSubtaskName"></label>

                        </div>

                        <div class="mb-3">
                            <label for="scheduleDate" class="form-label">Date To Do:</label>
                            <div class="input-group date" id="scheduleDatePicker">
                                <input type="text" class="form-control" id="scheduleDate" name="scheduleDate" placeholder="mm/dd/yyyy" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="bi bi-calendar-event-fill"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closesaveSchedule">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveScheduleBtn">Save Schedule</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <script>
        document.addEventListener('livewire:load', function() {
            const btnSearchScheduledTasks = document.getElementById('btnSearchScheduledTasks');
            const inputSearchScheduledTasks = document.getElementById('inputSearchScheduledTasks');
            const saveScheduleBtn = document.getElementById('saveScheduleBtn');

            saveScheduleBtn.addEventListener('click', function() {
                var toDoDate = document.getElementById('scheduleDate').value;
                var subtaskId = document.getElementById('scheduleSubtaskId').value;

                Livewire.emit('saveScheduledTasks', subtaskId, toDoDate);
            });

            Livewire.on('updatesaveScheduledTasks', function() {
                document.getElementById('closesaveSchedule').click();
            });


            btnSearchScheduledTasks.addEventListener('click', function() {

                var searchInputScheduledTasks = inputSearchScheduledTasks.value;
                if (searchInputScheduledTasks != "") {
                    inputSearchScheduledTasks.classList.remove('is-invalid');

                    Livewire.emit('findScheduledTasks', searchInputScheduledTasks, 2);

                } else {
                    inputSearchScheduledTasks.classList.add('is-invalid');
                }
            });

            inputSearchScheduledTasks.addEventListener('keydown', function(event) {
                // Check if the pressed key is "Enter" (key code 13)
                if (event.keyCode === 13) {
                    var searchInputScheduledTasks = inputSearchScheduledTasks.value;
                    if (searchInputScheduledTasks != "") {
                        inputSearchScheduledasks.classList.remove('is-invalid');

                        Livewire.emit('findScheduledTasks', searchInputScheduledTasks, 2);

                    } else {
                        inputSearchScheduledTasks.classList.add('is-invalid');
                    }
                }
            });
        });
    </script>
</div>