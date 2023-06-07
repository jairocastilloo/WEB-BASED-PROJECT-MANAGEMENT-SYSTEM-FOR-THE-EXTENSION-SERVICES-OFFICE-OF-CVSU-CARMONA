@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allusers as $alluser)
            @if ($alluser->role !== 'Admin' && $alluser->approval !== 0)
            <tr>
                <td>{{ $alluser->name . " " . $alluser->middle_name . " " . $alluser->last_name }}</td>
                <td>{{ $alluser->email }}</td>
                <td>{{ $alluser->role }}</td>
            </tr>
            @endif
            @endforeach

        </tbody>
    </table>
</div>


@endsection
@section('scripts')

<script>

</script>

@endsection