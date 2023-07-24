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

    <!--<link href="{{ mix('css/app.css') }}" rel="stylesheet">-->
    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
    <!--<link href="{{ asset('css/selectize.bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.default.css') }}" rel="stylesheet">-->
    <!--<script src="{{ mix('js/app.js') }}"></script>-->


</head>

<body style="font-family: sans-serif;">
    <div id="app">
        <nav style="background-color: #1b651b;" class="navbar navbar-expand-md navbar-dark shadow-sm p-1">

            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Extension Services Office Project Manager') }}
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
                            <a class="nav-link navtohover" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link navtohover" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        @if (Auth::user()->approval === 1)
                        @if (Auth::user()->role === 'Coordinator')
                        <a class="nav-link navtohover" href="{{ route('tasks.show', ['id' => Auth::user()->id]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Tasks
                        </a>
                        <a class="nav-link navtohover" href="{{ route('project.show', ['id' => Auth::user()->id]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Management
                        </a>
                        <a class="nav-link navtohover" href="{{ route('user.show', ['id' => Auth::user()->id]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Monitoring
                        </a>
                        <a class="nav-link navtohover" href="{{ route('project.show', ['id' => Auth::user()->id]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Reports
                        </a>
                        @endif
                        @if (Auth::user()->role === 'Admin')
                        <a class="nav-link" href="{{ route('admin.manage', ['id' => Auth::user()->id]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Account Management
                        </a>

                        <a class="nav-link" href="{{ route('admin.approve', ['id' => Auth::user()->id]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Account Approval
                        </a>
                        @endif
                        <li class="nav-item dropdown">
                            <div id="account">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button">
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
                            </div>
                        </li>
                        @endif
                        @endguest
                    </ul>

                </div>
            </div>
        </nav>

        <main class="p-0">

            @yield('content')
            <script src="{{ asset('js/jquery.min.js') }}"></script>
            <script src="{{ asset('js/popper.min.js') }}"></script>
            <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

            @yield('scripts')

        </main>

    </div>

</body>

</html>