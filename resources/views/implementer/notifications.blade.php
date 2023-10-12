@extends('layouts.app')

@section('content')
<div class="maincontainer shadow px-4 pt-4">

    @livewire('notification-index', [ 'notifications' => $notifications ])

</div>


@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#navbarDropdown').click(function() {
            // Add your function here
            $('#account .dropdown-menu').toggleClass('shows');
        });
    });
</script>

@endsection