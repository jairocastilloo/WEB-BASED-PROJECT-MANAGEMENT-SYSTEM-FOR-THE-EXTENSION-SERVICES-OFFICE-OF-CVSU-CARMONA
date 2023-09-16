<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
<<<<<<< HEAD
    <meta name="viewport" content="width=device-width, initial-scale=1">
=======
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
>>>>>>> origin/main

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Extension Services Office Project Manager') }}</title>

    <!-- Scripts -->

<<<<<<< HEAD

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
   
    <!-- Fonts/jonel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Borel&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Borel&display=swap" rel="stylesheet">

    <!-- mdbootstrap -->
    <link href="{{ asset('public/mdbootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/mdbootstrap/css/mdb.min.css') }}" rel="stylesheet">



    <!--<link href="{{ mix('css/app.css') }}" rel="stylesheet">-->
    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <!--<link href="{{ asset('css/bootstrap.css.map') }}" type="text/css" rel="stylesheet">-->
    <link href="{{ asset('css/bootstrap-icons.css') }}" type="text/css" rel="stylesheet">
    @if (!request()->is('/'))
    <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
    @endif
    <link href="{{ asset('css/homelogin.css') }}" type="text/css" rel="stylesheet">
=======
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <!--<link href="{{ mix('css/app.css') }}" rel="stylesheet">-->
    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">

    <!--<link href="{{ asset('css/bootstrap.css.map') }}" type="text/css" rel="stylesheet">-->

    <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
>>>>>>> origin/main
    <!--<link href="{{ asset('css/selectize.bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.default.css') }}" rel="stylesheet">-->
    <!--<script src="{{ mix('js/app.js') }}"></script>-->


<<<<<<< HEAD
</head>

<body style="font-family: sans-serif;">
    <div id="app">
    @if (request()->Is('/') || Route::is('login') || Route::is('register'))
    
    @else
        <nav style="background-color: #1b651b;" class="navbar navbar-expand-md navbar-dark shadow-sm p-1">

            <div class="container">
            


                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Extension Services Office Project Manager') }}
                </a>
=======

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm p-1">

            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="CvSU-Carmona Extension Services Office Logo">
                </a>

>>>>>>> origin/main
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

<<<<<<< HEAD
              
=======
>>>>>>> origin/main
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
<<<<<<< HEAD
                        <!--
                        <li class="nav-item">
                            <a class="nav-link navtohover" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>-->
                        @endif

                        @if (Route::has('register'))
                        <!--
                        <li class="nav-item">
                            <a class="nav-link navtohover" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>-->
=======
                        <li class="nav-item">
                            <a class="nav-link navtohover" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link navtohover" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
>>>>>>> origin/main
                        @endif
                        @else
                        @if (Auth::user()->approval === 1)
                        @if (Auth::user()->role === 'Coordinator' || Auth::user()->role === 'Admin')
<<<<<<< HEAD
                        <a class="nav-link navtohover" href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Home
                        </a>
                        <a class="nav-link navtohover" href="{{ route('project.show', ['department' => Auth::user()->department]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Projects
                        </a>
                        <a class="nav-link navtohover" href="{{ route('insights.show', ['department' => Auth::user()->department]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
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
                                    <a class="dropdown-item" href="{{ route('records.show', ['username' => Auth::user()->username]) }}">
                                        {{ __('My Records') }}
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
=======
                        <a class="nav-link navtohover text-dark" href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Home
                        </a>
                        <a class="nav-link navtohover text-dark" href="{{ route('project.show', ['department' => Auth::user()->department]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Projects
                        </a>
                        <a class="nav-link navtohover text-dark" href="{{ route('insights.show', ['department' => Auth::user()->department]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Reports
                        </a>
                        @if ($notifications)
                        <a class="nav-link navtohover text-dark position-relative me-2" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Notifications

                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ count($notifications) }}
                                <span class="visually-hidden">unread messages</span>
                            </span>

                        </a>
                        @endif
                        @endif

                        <li class="nav-item dropdown">
                            <div id="account">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button">
                                    {{ Auth::user()->name . ' ' . Auth::user()->last_name }}
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('records.show', ['username' => Auth::user()->username]) }}">
                                            {{ __('My Records') }}
                                        </a>
                                    </li>

                                    @if (Auth::user()->role === 'Admin')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.manage', ['id' => Auth::user()->id]) }}">
                                            Account Management
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.approve', ['id' => Auth::user()->id]) }}">
                                            Account Approval
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('acadyear.set', ['department' => Auth::user()->department]) }}">
                                            Set an Academic Year
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </li>
>>>>>>> origin/main
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

<<<<<<< HEAD
                                </div>
=======
                                </ul>
>>>>>>> origin/main
                            </div>
                        </li>
                        @endif
                        @endguest
                    </ul>

                </div>
<<<<<<< HEAD

            </div>
        </nav>
        @endif
=======
            </div>
        </nav>

>>>>>>> origin/main
        <main class="p-0">

            @yield('content')
            <script src="{{ asset('js/jquery.min.js') }}"></script>
            <script src="{{ asset('js/popper.min.js') }}"></script>
            <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<<<<<<< HEAD
=======
            <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
            <script src="{{ asset('js/main.js') }}"></script>

>>>>>>> origin/main
            <!--<script src="{{ asset('js/bootstrap.bundle.min.js.map') }}"></script>
-->
            @yield('scripts')

        </main>

    </div>

<<<<<<< HEAD


    
    <!--mdbootstrap-->
    <script type="text/javascript" src="{{ asset('public/mdbootstrap/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/mdbootstrap/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/mdbootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/mdbootstrap/js/mdb.min.js') }}"></script>
=======
>>>>>>> origin/main
</body>

</html>