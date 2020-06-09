@extends('layouts.master')

@section('body')
    <div id="app" class="bg-page h-screen antialiased leading-none">
        <x-navbar dark="true" dropdownButtonClass="button-dropdown-dark"/>

        <div class="mx-auto py-4 px-8 container">
            @yield('content')
        </div>

        <x-footer styles="absolute py-6" dark="true"/>
    </div>
@endsection
