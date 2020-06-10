@extends('layouts.master')

@section('body')
    <div id="app" class="h-screen antialiased leading-none">
        @yield('navbar')

        <div class="mx-auto py-4 px-8 container">
            @yield('content')
        </div>

        @yield('footer')
    </div>
@endsection
