@extends('layouts.app')

@section('content')
<input type="text" class="d-none" value="{{ Auth::user()->role }}" id="userrole">
<input type="text" class="d-none" value="{{ Auth::user()->approval }}" id="userapproval">
<h3 class="ms-2">
    @if (session('status'))
    <div>
        {{ session('status') }}
    </div>
    @endif

    {{ __('Good day,') }} {{ Auth::user()->name }}{{ __('! Contact the administrator for approval.') }}
</h3>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<button class="btn btn-primary" id="goBackBtn">Go Back</button>
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
                url = '{{ route("user.show", ["id" => Auth::user()->id]) }}';

                window.location.href = url;
            } else if (role === 'Implementer') {
                url = '{{ route("user.show", ["id" => Auth::user()->id]) }}';

                window.location.href = url;

            } else if (role === 'Admin') {
                url = '{{ route("admin.manage", ["id" => Auth::user()->id]) }}';

                window.location.href = url;
            }
        }
    });
</script>

@endsection