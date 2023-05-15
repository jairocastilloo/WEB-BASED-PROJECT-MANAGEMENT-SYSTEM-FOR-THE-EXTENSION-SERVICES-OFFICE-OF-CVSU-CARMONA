@extends('layouts.app')

@section('content')

@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        url = '{{ route("user.show", ["id" => Auth::user()->id]) }}';

        window.location.href = url;
    });
</script>

@endsection