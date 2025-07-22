<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
</head>
<body>
    <div id="app">
        <nav class="navbar has-background-primary" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item has-text-dark" href="{{ url('/admin') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div id="admin-nav" class="navbar-menu">
                <div class="navbar-start">
                    @guest
                    @else
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link has-text-dark">Pages</a>

                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('pages.index') }}">
                                    {{ __('Page List') }}
                                </a>

                                <a class="navbar-item" href="{{ route('pages.create') }}">
                                    {{ __('Page Create') }}
                                </a>
                            </div>
                        </div>
                        @can('manageUsers', App\User::class)
                            <a href="{{ route('users.index') }}" class="navbar-item has-text-dark">Manage Users</a>
                        @endcan
                    @endguest
                </div>

                <div class="navbar-end">
                    @guest
                        <div class="navbar-item">
                            <div class="buttons">
                                @if (Route::has('login'))
                                    <a class="button is-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @endif

                                @if (Route::has('register'))
                                    <a class="button is-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link has-text-dark">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <footer>
        @vite(['resources/js/app.js'])
    </footer>
</body>
</html>
