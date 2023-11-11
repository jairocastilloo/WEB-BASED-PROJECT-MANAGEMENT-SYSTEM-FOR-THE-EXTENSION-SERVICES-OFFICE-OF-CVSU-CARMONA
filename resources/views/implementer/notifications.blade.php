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

                        <a class="nav-link border border-1 p-2 px-4 divhover fw-bold small" href="{{ route('taskscalendar.show', [ 'username' => Auth::user()->username ]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            My Tasks Calendar
                        </a>

                        @livewire('notifications')


                    </ul>
                </div>
            </nav>

        </div>
    </div>
    <div class="container">
        @livewire('notification-index', [ 'notifications' => $notifications ])
    </div>
</div>



@endsection