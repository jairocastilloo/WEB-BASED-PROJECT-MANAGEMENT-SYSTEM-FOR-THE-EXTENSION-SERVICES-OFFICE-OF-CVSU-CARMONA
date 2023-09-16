@extends('layouts.app')

@section('content')


<div class="container rounded border shadow p-3">
    <!-- Content goes here -->
<<<<<<< HEAD
    <input type="text" class="d-none" value="{{ Auth::user()->role }}" id="userrole">
    <input type="text" class="d-none" value="{{ Auth::user()->approval }}" id="userapproval">
=======

>>>>>>> origin/main
    <h3 class="ms-2">
        @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
        @endif

        {{ __('Good day,') }} {{ Auth::user()->name }}{{ __('! Contact the administrator for the approval of your account.') }}
    </h3>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <button class="btn btn-primary" id="goBackBtn">Go Back</button>
</div>
<<<<<<< HEAD
@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        var role = $('#userrole').val();
        var approval = $('#userapproval').val();
        $('#goBackBtn').on('click', function() {
            $('#logout-form').submit();

        });
        if (approval === '1') {
            if (role === 'Coordinator') {
                url = '{{ route("tasks.show", ["username" => Auth::user()->username]) }}';

                window.location.href = url;
            } else if (role === 'Implementer') {
                url = '{{ route("tasks.show", ["username" => Auth::user()->username]) }}';

                window.location.href = url;

            } else if (role === 'Admin') {
                url = '{{ route("tasks.show", ["username" => Auth::user()->username]) }}';

                window.location.href = url;
            }
        }
    });
</script>

=======
>>>>>>> origin/main
@endsection