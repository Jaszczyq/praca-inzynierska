@php use App\Models\Category; @endphp
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://fonts.googleapis.com/css?family=Source Sans Pro' rel='stylesheet'>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="font-family: 'Source Sans Pro';">


<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="--bs-gradient: linear-gradient(180deg,rgba(255,255,255,0.15),rgba(255,255,255,0));">
        <div class="container">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path
                    d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z"/>
            </svg>
            <a class="navbar-brand self-center text-2xl font-semibold whitespace-nowrap" style="margin-left: 10px;"
               href="{{ route('home') }}">

                {{ config('app.name', 'BiletoRadar') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto flex">
                    <li class="nav-item">
                        <a class="{{ request()->routeIs('events.index') ? 'active-tab' : 'nav-link' }} py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 rounded md:p-0"
                           href="{{ route('events.index') }}">{{ __('events.events') }}</a>
                    </li>
                    @can('isOrganizer')
                    <li class="nav-item">
                        <a class="{{ request()->routeIs('seats_creator') ? 'active-tab' : 'nav-link' }} py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 rounded md:p-0"
                           href="{{ route('seats_creator') }}">{{ __('events.seats_creator') }}</a>
                    </li>
                    @endcan
                </ul>


                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown"
                               onclick="document.querySelector('.dropdown-menu.dropdown-menu-end').style.display == 'block' ? document.querySelector('.dropdown-menu.dropdown-menu-end').style.display = 'none' : document.querySelector('.dropdown-menu.dropdown-menu-end').style.display = 'block'"
                               class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="ml-1 fas fa-caret-down"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @can('isOrganizer')
                                <a class="dropdown-item" href="{{ route('events.my_events') }}">
                                    {{ __('events.my_events') }}
                                </a>
                                @endcan
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('auth.logout') }}
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

    <main class="py-4" style="background-color: #F0F0F0; min-height: 100vh;">
        @yield('content')
    </main>

    @php
        $categories = App\Models\EventCategory::all();
    @endphp

<style>
    .active-tab {
        position: relative;
        font-weight: bold; /* Pogrubienie tekstu */
        color: #1D4ED8; /* Tailwind kolor text-blue-700 */
        top: 0; /* Dodane, aby upewnić się, że pozycja w pionie jest niezmieniona */
    }

    .active-tab::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -0.5rem; /* większy odstęp od tekstu */
        height: 2px; /* wysokość kreski */
        background: #1D4ED8; /* Tailwind kolor bg-blue-700 */
        transform: translateY(100%); /* Przesunięcie kreski w dół */
    }
</style>
</div>
</body>
</html>
