@extends('layouts.app')

@section('content')
    <div class="py-4 px-8 container">
        <section class="text-gray-700">
            <div class="container py-4 mx-auto">
                <div class="flex">
                    <div class="w-1/5 flex flex-col p-4">
                        <a href="{{ route('admin.dashboard') }}" class="button-dropdown-blue">Dashboard</a>
                        <a href="{{ route('admin.channels.index') }}" class="button-dropdown-blue mt-2">Channels</a>
                    </div>
                    <div class="w-4/5 rounded-lg border border-gray-500 bg-white">
                        @yield('administration-content')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('navbar')
    <x-navbar dark="true" background="bg-white bg-opacity-25" dropdownButtonClass="button-dropdown-dark"/>
@endsection

@section('footer')
    <x-footer styles="py-4" background="bg-white bg-opacity-25" dark="true"/>
@endsection


