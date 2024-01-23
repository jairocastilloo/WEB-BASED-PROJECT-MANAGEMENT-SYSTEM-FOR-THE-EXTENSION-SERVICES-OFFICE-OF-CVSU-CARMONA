@extends('layouts.app')

@section('content')


<div class="container rounded border shadow p-3">
    <!-- Content goes here -->

    <h3 class="ms-2">
        @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
        @endif
        @if(Auth::user()->email_verified_at == null)
        {{ __('Good day,') }}
        {{ Auth::user()->name }}{{ __('! Please verify your email address before the administrator can approve your account. ') }}
        @elseif (Auth::user()->approval == 0)
        {{ __('Good day,') }}
        {{ Auth::user()->name }}{{ __('! Contact the administrator for the approval of your account.') }}

        @endif
    </h3>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf

    </form>
    <button class="btn btn-primary" id="goBackBtn">Go Back</button>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $("#goBackBtn").click(function() {
            // Submit the form when the button is clicked
            $("#logout-form").submit();
        });

    });
</script>

@endsection
