@extends('layouts.app')

@section('content')
<div class="maincontainer border border-start border-end border-bottom border-top-0">

    @if(Auth::user()->role === 'Admin')
    <div class="container">
        @livewire('resend-email')
    </div>


    @else

    <h1>Sorry, this is exclusive for admin. <a href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}">Go back</a></h1>

    @endif
</div>
@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        $('#navbarDropdown').click(function() {
            // Add your function here
            $('.dropdown-menu').toggleClass('shows');
        });


        $('.declineAccount').click(function() {
            var userId = $(this).closest('tr').data('id');
            $('#declineId').val(userId);
            $('#myModal').modal('show');
        });



        $('#editAccounts').click(function() {
            window.location.href = "{{ route('admin.editaccount') }}";
        });

    });
</script>


@endsection