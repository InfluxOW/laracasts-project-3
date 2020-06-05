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
        <nav class="relative flex flex-wrap items-center justify-between">
            <div class="container bg-blue-500 rounded px-4 py-2 mx-auto flex flex-wrap items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start">
                    <div class="text-md font-bold leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap uppercase text-white cursor-pointer">
                        Forum
                    </div>
                </div>

                <div class="lg:flex lg:flex-grow items-center mr-auto">

                    <!-- Left Navbar Side -->
                    <ul class="flex flex-col lg:flex-row list-none">
                        <li>
                            <a class="px-4 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="{{ route('threads.index') }}">
                                Threads
                            </a>
                        </li>

                        <li>
                            <dropdown
                                button_classes="button-dropdown w-full"
                                button_title="Channels"
                            >
                                <template v-slot:items>
                                    @foreach (App\Channel::all() as $channel)
                                        <a href="{{ route('threads.filter', $channel) }}" class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-300">
                                            {{ $channel->slug }}
                                        </a>
                                    @endforeach
                                </template>
                            </dropdown>
                        </li>
                    </ul>

                    <!-- Right Navbar Side -->
                    <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">

                        @auth
                            <li>
                                <dropdown
                                    button_classes="button-dropdown w-full"
                                    button_title="{{ Auth::user()->name }}"
                                >
                                    <template v-slot:items>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                        class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-300">
                                            Logout
                                        </a>
                                        {!! Form::open(['url' => route('logout'), 'id' => 'logout-form', 'class' => 'invisible']) !!}
                                        {!! Form::close() !!}
                                    </template>
                                </dropdown>
                            </li>
                        @else
                            <a class="px-4 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="{{ route('login') }}">{{ __('Login') }}</a>
                            <a class="px-4 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        {{-- <nav class="bg-header border-b-2 border-default mb-4 py-4 flex items-center">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-between ml-4">
                    <div class="mr-2 cursor-default text-gray-500 text-xl">
                        Forum
                    </div>
                    <a href="{{ route('threads.index') }}">
                        Threads
                    </a>

                    <dropdown>
                        <template v-slot:items>
                            @foreach (App\Channel::all() as $channel)
                                <a href="#" class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-300">
                                    {{ $channel->slug }}
                                </a>
                            @endforeach
                        </template>

                    </dropdown>

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

                                {!! Form::open(['url' => route('logout'), 'id' => 'logout-form', 'class' => 'invisible']) !!}
                                {!! Form::close() !!}
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </nav> --}}

        <div class="mx-auto py-4 container">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
