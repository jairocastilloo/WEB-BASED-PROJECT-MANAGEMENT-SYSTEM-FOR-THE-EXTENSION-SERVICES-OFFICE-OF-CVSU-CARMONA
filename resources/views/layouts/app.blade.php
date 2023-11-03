<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Extension Services Office Project Manager') }}</title>

    <!-- Scripts -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter&family=Roboto&display=swap" rel="stylesheet">

    <!--<link href="{{ mix('css/app.css') }}" rel="stylesheet">-->
    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" type="text/css" rel="stylesheet">
    <!--<link href="{{ asset('css/bootstrap.css.map') }}" type="text/css" rel="stylesheet">-->
    <link href="{{ asset('css/styles.css') }}" type="text/css" rel="stylesheet">
    @if(in_array(Route::currentRouteName(), ['login', 'register']))
    <link href="{{ asset('css/homelogin.css') }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lato&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->

    <!--<link href="{{ asset('css/selectize.bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.default.css') }}" rel="stylesheet">-->
    <!--<script src="{{ mix('js/app.js') }}"></script>-->

    @livewireStyles

</head>

<body @if(in_array(Route::currentRouteName(), ['login', 'register' ])) class="login-register-bg" @endif>
    <div id="app">
        <nav class="navbar navbar-expand-md p-1 @if(in_array(Route::currentRouteName(), ['login', 'register' ])) walangbg @else shadow imbentobg @endif">

            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="CvSU-Carmona Extension Services Office Logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <h6 class="text-white pt-3">@livewire('time')</h6>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link @if(in_array(Route::currentRouteName(), ['login'])) logincurrenthover @endif text-white mx-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link @if(in_array(Route::currentRouteName(), ['register'])) logincurrenthover @endif text-white mx-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        @if (Auth::user()->approval === 1 && Auth::user()->email_verified_at != null)

                        <a class="nav-link @if(in_array(Route::currentRouteName(), ['tasks.show'])) currenthover @else navtohover @endif text-white mx-2" href="{{ route('tasks.show', ['username' => Auth::user()->username]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Home
                        </a>
                        <a class="nav-link @if(in_array(Route::currentRouteName(), ['project.show'])) currenthover @else navtohover @endif text-white mx-2" href="{{ route('project.show', ['department' => Auth::user()->department]) }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Projects
                        </a>
                        <a class="nav-link @if(in_array(Route::currentRouteName(), ['insights.show'])) currenthover @else navtohover @endif text-white mx-2" href="@if (Auth::user()->role === 'Admin') {{ route('admin.choosedepartmentreport') }} @else {{ route('insights.show', ['department' => Auth::user()->department]) }} @endif" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Reports
                        </a>
                        <li class="nav-item">

                            <!-- Enclose Livewire component in a single root element -->
                            @livewire('notifications')

                        </li>



                        <li class="nav-item dropdown">
                            <div id="account">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white mx-2" href="#" role="button">
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
                                        <a class="dropdown-item" href="{{ route('admin.manage') }}">
                                            Account Management
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('fiscalYear.set') }}">
                                            Set School Time Periods
                                        </a>
                                    </li>

                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </ul>
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
            <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
            <!--<script src="{{ asset('vendor/livewire/livewire.js') }}"></script>-->
            <!--<script src="{{ asset('js/main.js') }}"></script>-->

            <!--<script src="{{ asset('js/bootstrap.bundle.min.js.map') }}"></script>-->
            @if(in_array(Route::currentRouteName(), ['login', 'register']))

            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            @endif

            @yield('scripts')

        </main>



    </div>

    @livewireScripts

</body>

</html>