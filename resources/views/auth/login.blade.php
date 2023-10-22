@extends('layouts.app')

@section('content')
<main class="container-fluid p-0">
    <img class="bg-carmona" src="{{ asset('images/cvsu-carmona-japanese.jpg')}}" alt="Extension service">
<section class="">
    
    <div class="container">
        <div class="row g-0 border rowjonel">
            <div class="col-lg-6 forMarginTop-1 p-0">
                <div id="myCarousel" class="carousel slide d-flex w-100 h-100 borderRadius-1" data-ride="carousel">
                        
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>

                        <div class="carousel-inner d-flex w-100 h-100 borderRadius-1">
                            <div class="carousel-item active">
                                <img class="w-100 h-100" src="{{ asset('images/Slider4.png')}}" alt="Slide 1">
                            </div>
                            <div class="carousel-item">
                                <img class="w-100 h-100" src="{{ asset('images/Slider2.png')}}" alt="Slide 2">
                            </div>
                            <div class="carousel-item">
                                <img class="w-100 h-100" src="{{ asset('images/Slider3.png')}}" alt="Slide 3">
                            </div>
                        </div>

                            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                </div>
            </div>
            
            <div class="col-lg-6 borderRadius-2 bg-white">
                <h1 class="text-center p-5">Login</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="container">
                        <div class="form-group inputlg">
                            <div class="offset-1 col-lg-10 main-slider">
                                <label class="bold-label fw-bold py-2" for="Username1">Username:</label>
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group inputlg">
                            <div class="offset-1 col-lg-10">
                                <label class="bold-label fw-bold py-2" for="Password1">Password:</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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

                        <div class="container p-3">
                            <div class="form-group text-center">
                                <div class="offset-1">
                                    <button type="submit" class="loginbutton1">
                                        {{ __('Login') }}
                                    </button>
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link text-dark" href="{{ route('password.request') }}">
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
                <div class="form-group text-center mb-5 registerdiv">
                    <div class="offset-1 col-lg-10 registerclass">
                        <a href="{{ route('register') }}" class="registerbutton1">Register</a>
                    </div>
                </div>




            </div>


        </div>
    </div>
</section>
</main>
@endsection