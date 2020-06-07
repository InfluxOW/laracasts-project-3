@extends('layouts.master')

@section('body')
<div id="app" class="bg-page h-screen antialiased leading-none">
    <x-navbar styles="bg-blue-500" dropdownButtonClass="button-dropdown-blue"/>

    <div class="mx-auto py-4 px-8 container">
        @yield('content')
    </div>
</div>
@endsection
