@extends('layouts.app')

@section('content')
<div class="maincontainer border border-start border-end border-bottom">
    <div class="mainnav border-bottom mb-3 shadow-sm px-2">
        <div class="border-2 border-start divhover border-end p-2">
            Account Approval
        </div>
        <div class="border-2 border-end p-2 currentdiv">
            Edit Accounts
        </div>



    </div>
    @if(Auth::user()->role === 'Admin')
    <div class="container">

        <div class="basiccont rounded shadow">

            <div class="d-flex justify-content-center align-items-center border small">

                <div class="tablecontainer pb-2">
                    @livewire('edit-account', [ 'allusers' => $allusers ])

                </div>
            </div>
        </div>

    </div>
    @else
    <div class="container p-4 text-center">
        <h1>Sorry, this is exclusive for admin. <a href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}">Go back</a></h1>
    </div>
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
    });
</script>

@endsection