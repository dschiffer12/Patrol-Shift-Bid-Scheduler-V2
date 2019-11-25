<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
</head>
<body>
    <div class="overlay" id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #e3f2fd;">
            <!-- <div class="container border"> -->
                <a class="navbar-brand ml-3" href="{{ url('/') }}">
                    <img src="/img/badge-transparent.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        @auth
                            @if(Auth::user()->hasAnyRoles(['root', 'admin']))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-danger" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{__('Admin Control')}}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <!-- <a class="dropdown-item" href="/register">Add New User</a> -->
                                        <a class="dropdown-item text-danger" href="/admin/schedules"><h5>{{ __('Schedule Management') }}</h5></a>
                                        <a class="dropdown-item text-danger" href="/admin/users"><h5>{{__('Users Management')}}</h5></a>
                                        <a class="dropdown-item text-danger" href="/admin/specialties"><h5>{{__('Specialties Management')}}</h5></a>
                                        <a class="dropdown-item text-danger" href="/admin/roles"><h5>{{__('Roles Management')}}</h5></a>
                                        <!-- <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a> -->
                                    </div>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <!-- <a  class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        User Management
                                    </a> -->

                                    <a  class="dropdown-item" href="{{ route('user.profile.index') }}">
                                        Profile Management
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            <!-- </div> -->
        </nav>


        <div class="container-fluid">
            <div class="row">
                @guest
                @else
                    <div class="auto col-md-auto menu">

                        <div class="row top15">
                            <div class="col pt-2">
                                <button type="button" class="btn btn-block text-left">
                                    <a class="nav-link" href="{{ route('user.psheet.index') }}"><h5>{{ __('Daily Roster') }}</h5></a>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pt-2">
                                <button type="button" class="btn btn-block text-left">
                                    <a class="nav-link" href="{{ route('user.schedules.view') }}"><h5>{{ __('Bid on Schedule') }}</h5></a>
                                </button>
                            </div>
                        </div>

                        
                    </div>
                @endguest

                <div class="col" >

                    <main class="py-4">
                        @include('partials.alerts')
                        @yield('content')
                    </main>
                </div>  
            </div> 
            @include('layouts.footer')
        </div>
    </div>
        
        <!--JQuery hosted-->
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>

    <script src="{{ asset('js/jquery.rowselector.min.js') }}" defer></script>
    <script src="{{ asset('js/biddingschedule.js') }}" defer></script>

    </body>
</html>
