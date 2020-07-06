@extends('layouts.master')

@section('body')
    <div id="app" class="h-screen antialiased leading-none">
        <x-navbar dark="true" background="bg-white bg-opacity-25" dropdownButtonClass="button-dropdown-dark" navStyles="top-0 absolute"/>

        <main>
            <section class="absolute w-full h-full">
                <div class="container mx-auto px-4 h-full">
                    <div class="flex content-center items-center justify-center h-full">
                        <div class="w-full px-4 z-50">

                            {!! Form::open(['url' => route('threads.store')]) !!}
                            @honeypot

                            @include('threads._form')

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </section>
        </main>

        <x-footer styles="absolute bottom-0 py-4" background="bg-white bg-opacity-25" dark="true"/>
    </div>
@endsection
