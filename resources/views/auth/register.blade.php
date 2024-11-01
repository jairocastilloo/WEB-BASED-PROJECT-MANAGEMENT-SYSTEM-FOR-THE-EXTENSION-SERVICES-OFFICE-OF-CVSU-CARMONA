@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 borderRadius-3 bg-white text-center d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column gap-4 align-items-center justify-content-center">
                    <div class="logos"><img src="{{ asset('images/Picture1.png')}}" alt="Extension Service Office" width="350px"></div>
                    <div>
                        <h6 class="fw-bold">Cavite States University - Carmona</h6>
                        <h2 class="fw-bold text-uppercase">Extension Service Office</h2>
                    </div>
                </div>
            </div>



            <div class="col-lg-6 borderRadius-2 bg-white">
                <h1 class="text-center p-5">Register

                </h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="container p-3">

                        <div class="form-group inputlg">

                            <div class="offset-1 col-lg-10">
                                <p class="text-secondary fs-6 p-0 m-0"><i>Fields marked with <span class="darkolivegreenfont">*</span> are mandatory. </i></p>
                                <label class="bold-label fw-bold py-1" for="Username1">Username <span class="darkolivegreenfont"><b>*</b></span></label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group inputlg">


                            <div class="offset-1 col-lg-10">
                                <label class="bold-label fw-bold py-1" for="Title1">Abbreviated Title <span class="darkolivegreenfont"><b>*</b></span></label>
                                <select name="title" id="title" class="form-select @error('title') is-invalid @enderror" value="{{ old('title') }}" required autocomplete="title" autofocus>
                                    <option value="" disabled selected>Select Title</option>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Prof.">Prof.</option>
                                    <option value="Dr.">Dr.</option>
                                </select>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group inputlg">
                            <div class="offset-1 col-lg-10">
                                <label class="bold-label fw-bold py-1" for="Lastname1">Last Name <span class="darkolivegreenfont"><b>*</b></span></label>
                                <input id="last_name" type="text" class="form-control autocapital @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group inputlg">
                            <div class="offset-1 col-lg-10">
                                <label class="bold-label fw-bold py-1" for="Firstname1">First Name <span class="darkolivegreenfont"><b>*</b></span></label>

                                <input id="name" type="text" class="form-control autocapital @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group inputlg">
                            <div class="offset-1 col-lg-10">
                                <label class="bold-label fw-bold py-1" for="Middelname1">Middle Name</label>
                                <input id="middle_name" type="text" class="form-control autocapital @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') }}" autocomplete="name" autofocus>

                                @error('middle_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group inputlg">
                            <div class="offset-1 col-lg-10">
                                <label class="bold-label fw-bold py-1" for="Emailaddress1">Email Address <span class="darkolivegreenfont"><b>*</b></span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group inputlg">
                            <div class="offset-1 col-lg-10">
                                <label class="bold-label fw-bold py-1" for="Password1">Password <span class="darkolivegreenfont"><b>*</b></span></label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group inputlg">
                            <div class="offset-1 col-lg-10">
                                <label class="bold-label fw-bold py-1" for="ConfirmPassword1">Confirm Password <span class="darkolivegreenfont"><b>*</b></span></label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group inputlg">


                            <div class="offset-1 col-lg-10">
                                <label class="bold-label fw-bold py-1" for="Department1">Department <span class="darkolivegreenfont"><b>*</b></span></label>
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
                    </div>

                    <div class="container p-3 btn-block mb-3">
                        <div class="form-group text-center">
                            <div class="offset-1 col-lg-10 registerdiv2">
                                <button type="register" class="loginbutton1">Register</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
        <div class="pb-3">&nbsp;</div>
    </div>

</section>
<!--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-white mt-3" style="background-color: #297e56;">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __(' Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                            <div class="col-md-3">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <label for="middle_name" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }}</label>

                            <div class="col-md-3">
                                <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') }}" required autocomplete="name" autofocus>

                                @error('middle_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">

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

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
-->
@endsection
@section ('scripts')
<script>
    $(document).ready(function() {
        $(document).on('input', '.autocapital', function() {
            var inputValue = $(this).val();
            if (inputValue.length > 0) {
                $(this).val(inputValue.charAt(0).toUpperCase() + inputValue.slice(1));
            }
        });
    });
</script>

@endsection
