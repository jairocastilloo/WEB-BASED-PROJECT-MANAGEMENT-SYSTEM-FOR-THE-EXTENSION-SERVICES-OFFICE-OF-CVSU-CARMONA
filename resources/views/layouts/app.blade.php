<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Extension Services Office Project Manager') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.default.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}"></script>


</head>

<body style="background-color: #323132; font-family: sans-serif;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-success shadow-sm ">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    <b>{{ config('app.name', 'Extension Services Office Project Manager') }}</b>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else

                        <a class="nav-link text-white" href="{{ route('user.show', ['id' => Auth::user()->id]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Monitoring
                        </a>
                        <a class="nav-link text-white" href="{{ route('project.show', ['id' => Auth::user()->id]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Project
                        </a>
                        <a class="nav-link text-white" href="{{ route('project.show', ['id' => Auth::user()->id]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Reports
                        </a>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>

                        </li>

                        @endguest
                    </ul>

                </div>
            </div>
        </nav>

        <main class="py-4">

            @yield('content')
            <script src="{{ mix('js/app.js') }}"></script>
            @yield('scripts')

        </main>

    </div>

</body>

</html>