@extends('layouts.app')

@section('content')
    <div class="py-4 px-8 container">
        <section class="text-gray-700">
            <div class="container py-4 mx-auto">
                <instant-search></instant-search>
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



