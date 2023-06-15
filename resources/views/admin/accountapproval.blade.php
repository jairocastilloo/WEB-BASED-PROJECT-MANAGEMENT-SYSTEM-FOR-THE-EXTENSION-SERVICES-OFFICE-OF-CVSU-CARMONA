@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allusers as $alluser)
            @if ($alluser->role !== 'Admin' && $alluser->approval !== 1)
            <tr>
                <td>{{ $alluser->name . " " . $alluser->middle_name . " " . $alluser->last_name }}</td>
                <td>{{ $alluser->email }}</td>

                <td>
                    <form id="myForm" action="{{ route('admin.accept') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $alluser->id }}">
                        <input type="hidden" name="user_role" value="Coordinator">
                        <input type="number" name="currentid" value="{{ Auth::user()->id }}" hidden>
                        <button type="submit" class="btn btn-outline-primary rounded shadow m-2">Approve as Coordinator</button>
                    </form>
                    <form id="myForm" action="{{ route('admin.accept') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $alluser->id }}">
                        <input type="hidden" name="user_role" value="Implementer">
                        <input type="number" name="currentid" value="{{ Auth::user()->id }}" hidden>
                        <button type="submit" class="btn btn-outline-primary m-2">Approve as Implementer</button>
                    </form>
                </td>
                <td>
                    <form id="myForm" action="{{ route('admin.decline') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $alluser->id }}">
                        <input type="number" name="currentid" value="{{ Auth::user()->id }}" hidden>
                        <button type="submit" class="btn btn-outline-danger">Decline</button>
                    </form>
                </td>
            </tr>
            @endif
            @endforeach

        </tbody>
    </table>
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