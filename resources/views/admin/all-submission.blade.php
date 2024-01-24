@extends('layouts.app')

@section('content')
<div class="maincontainer border border-start border-end border-bottom border-top-0">

    @if(Auth::user()->role === 'Admin')
    <div class="container mt-3">

        <input type="text" class="d-none" id="username" value="{{ Auth::user()->username }}">
        <div class="row">
            <div class="col-lg-4">
                <label class="ms-3 small form-label text-secondary fw-bold">
                   Projects Submission
                </label>
                @livewire('projects-submission')

            </div>
            <div class="col-lg-4">
                <label class="ms-3 small form-label text-secondary fw-bold">
                    Activities Submission
                </label>
                @livewire('activities-submission')

            </div>
            <div class="col-lg-4">
                <label class="ms-3 small form-label text-secondary fw-bold">
                   Subtasks Submission
                </label>
                @livewire('subtasks-submission')


            </div>





        </div>

    </div>


    @else

    <h1>Sorry, this is exclusive for admin. <a href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}">Go back</a></h1>

    @endif
</div>
@endsection
@section('scripts')

<script>
    $(document).ready(function() {


    });
</script>


@endsection
