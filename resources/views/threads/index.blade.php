@extends('layouts.app')

@section('content')
    <div class="py-4 px-8 container">
        <section class="text-gray-700">
            <div class="container py-4 mx-auto">
                <x-threads.filtration/>

                <div class="flex flex-wrap -m-4">
                    @forelse ($threads as $thread)
                        <x-threads.card :thread="$thread"/>
                    @empty
                        <p class="text-2xl p-4 bg-white rounded-lg">No threads has been found :(</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{ $threads->links() }}
    </div>
@endsection

@section('navbar')
    <x-navbar dark="true" background="bg-white bg-opacity-25" dropdownButtonClass="button-dropdown-dark"/>
@endsection

@section('footer')
    <x-footer styles="{{ count($threads->items()) <=3 ? 'bottom-0' : '' }} py-4" background="bg-white bg-opacity-25" dark="true"/>
@endsection


