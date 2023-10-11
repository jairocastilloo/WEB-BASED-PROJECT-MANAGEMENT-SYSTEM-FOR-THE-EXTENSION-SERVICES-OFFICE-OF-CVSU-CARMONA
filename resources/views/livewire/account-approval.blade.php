<div>
    @foreach ($pendingusers as $pendinguser)

    <tr>
        <td>{{ $pendinguser->name }}</td>
        <td>{{ $pendinguser->middle_name }}</td>
        <td>{{ $pendinguser->last_name }}</td>
        <td>{{ $pendinguser->email }}</td>
        <td>{{ $pendinguser->department }}</td>
        <td>{{ $pendinguser->role }}</td>
        <td>

            <button type="button" class="btn btn-primary edit-account">
                Edit
            </button>
            <button type="submit" class="btn btn-outline-danger">
                Delete
            </button>

        </td>

    </tr>

    @endforeach
</div>