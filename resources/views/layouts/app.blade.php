<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="theme-light bg-page h-screen antialiased leading-none">
    <div id="app">
        <nav class="bg-header border-b-2 border-default mb-4 py-4">
            <div class="mx-auto px-6 md:px-0">
                <div class="flex items-center justify-between ml-4">
                    <a href="{{ route('welcome') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <div class="flex items-center ml-auto mr-4">
                        @guest
                            <a class="no-underline text-muted text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a class="no-underline text-muted text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else
                            <div class="mr-2">
                                {{ Auth::user()->name }}
                            </div>

                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <span class="text-accent">Logout</span>

                                {{Form::open(['url' => route('logout'), 'method' => 'POST', 'id' => 'logout-form', 'class' => 'invisible'])}}
                                {{Form::close()}}
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto py-4 container">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
