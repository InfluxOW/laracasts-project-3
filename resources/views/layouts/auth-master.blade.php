@extends('layouts.master')

@section('body')
<div id="app">
    <x-navbar styles="top-0 absolute z-50"/>

    <main>
        <section class="absolute w-full h-full">
        <div
            class="absolute top-0 w-full h-full"
            style="background-image: url( @yield('bg-image') ); background-size: 100%; background-repeat: no-repeat;"
        ></div>

        <div class="container mx-auto px-4 h-full">
            <div class="flex content-center items-center justify-center h-full">
                <div class="w-full lg:w-4/12 px-4">

                    @yield('form')

                </div>
            </div>
        </div>

        <x-footer/>

        </section>
    </main>
</div>
@endsection
