@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Department</th>
                <th scope="col">Role</th>
                <th scope="col">Edit</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($allusers as $alluser)
            @if ($alluser->role !== 'Admin' && $alluser->approval !== 0)
            <tr>
                <td>{{ $alluser->name . " " . $alluser->middle_name . " " . $alluser->last_name }}</td>
                <td>{{ $alluser->email }}</td>
                <td>{{ $alluser->department }}</td>
                <td>{{ $alluser->role }}</td>
                <td>
                    <form action="{{ route('admin.delete') }}" method="POST">
                        @csrf
                        <input type="number" value="{{ $alluser->id }}" name="editid" hidden>
                        <input type="number" name="currentid" value="{{ Auth::user()->id }}" hidden>
                        <button type="button" class="btn btn-primary edit-account">
                            Edit
                        </button>
                        <button type="submit" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </td>

            </tr>
            @endif
            @endforeach

        </tbody>
    </table>
</div>
<button type=" button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Add account
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.add') }}">
                @csrf
                <input type="number" name="currentid" value="{{ Auth::user()->id }}" hidden>

                <div class="modal-body">
                    <!-- Form content goes here -->
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="middle_name" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }}</label>

                        <div class="col-md-6">
                            <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') }}" required autocomplete="name" autofocus>

                            @error('middle_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                        <div class="col-md-6">
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus>

                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="department" class="col-md-4 col-form-label text-md-end">{{ __('Department') }}</label>

                        <div class="col-md-6">

                            <select name="department" id="department" class="form-select @error('department') is-invalid @enderror" value="{{ old('department') }}" required autocomplete="department" autofocus>
                                <option value="" disabled selected>Select your Department</option>
                                <option value="Department of Management">Department of Management</option>
                                <option value="Department of Industrial and Information Technology">Department of Industrial and Information Technology</option>
                                <option value="Department of Teacher Education">Department of Teacher Education</option>
                                <option value="Department of Arts and Science">Department of Arts and Science</option>
                            </select>

                            @error('department')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                        <div class="col-md-6">

                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" value="{{ old('role') }}" required autocomplete="role" autofocus>
                                <option value="" disabled selected>Select Role</option>
                                <option value="Coordinator">Coordinator</option>
                                <option value="Implementer">Implementer</option>
                            </select>

                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Add Account') }}
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('scripts')

<script>
    var alluser = <?php echo json_encode($allusers);
                    ?>;
    $(document).ready(function() {
        $('#navbarDropdown').click(function() {
            // Add your function here
            $('.dropdown-menu').toggleClass('shows');
        });
    });
</script>
<script src="{{ asset('js/admin.js') }}"></script>
@endsection