@extends('layouts.app')

@section('content')

<section class="homeloginpage full-page-container py-5">
    <div class="container">
        <div class="row g-0 border">
            <div class="col-lg-6 text-center d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column gap-4 align-items-center justify-content-center">
                    <div class="logos"><img  src="{{ asset('images/Picture1.png')}}" alt="Extension Service Office" width="350px"></div>
                    <div><h6 class="fw-bold">Cavite States University - Carmona</h6><h2 class="fw-bold text-uppercase">Extension Service Office</h2></div>
                </div> 
            </div>

            <div class="col-lg-6">
                <h1 class="text-center p-5">Welcome Back!</h1>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="container">

                            <div class="form-group">
                                <div class="offset-1 col-lg-10">
                                    <label class="bold-label fw-bold py-4" for="Username1">Username:</label>
                                    <input placeholder="Username" id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="offset-1 col-lg-10">
                                    <label class="bold-label fw-bold py-4" for="Username1">Password:</label>
                                    <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="offset-1 col-lg-10">
                                    <div class="form-check py-4">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="container p-3 ">
                                <div class="form-group text-center">
                                    <div class="offset-1 col-lg-10">
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Login') }}
                                        </button>
                                        @if (Route::has('password.request'))
                                        <a class="btn btn-link text-dark" href="{{ route('password.request') }}" >
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="divider-container">
                                <hr class="divider">
                                <span class="or-text">or</span>
                                <hr class="divider">
                            </div>

                            





                        </div> 
                    </form>
                    <div class="form-group text-center mb-5">
                                <div class="offset-1 col-lg-10">
                                <button type="button" class="btn btn-secondary">
                                    <a href="{{ route('register') }}" class="text-white text-decoration-none">Register</a>
                                </button>

                            
                                </div>
                    </div>



                
            </div>


        </div>
    </div>           
</section>
@endsection