@extends('layouts.app')

@section('content')
<thread inline-template>
    <div>
        <!--Title-->
        <div class="text-center pt-4 md:pt-8 bg-white bg-opacity-25">
            <p class="text-sm md:text-base text-teal-600 font-bold">{{ $thread->created_at->format('M d, Y') }}
                <span
                    class="text-gray-900 mx-2">/</span>
                <a href="{{ route('profiles.show', $thread->user) }}" class="hover:text-teal-300">
                    {{ $thread->user->name }}
                </a>
            </p>
            <h1 class="font-bold break-normal text-3xl md:text-5xl">{{ $thread->title }}</h1>
        </div>

        <div class="container max-w-6xl flex justify-end">
            @can('delete', $thread)
                <a
                    href="{{ route('threads.destroy', $thread) }}"
                    data-confirm="Are you sure?"
                    data-method="delete"
                    rel="nofollow"
                    class="button-dropdown-red">Delete</a>
            @endcan
        </div>

        <!--image-->
        <div class="container w-full max-w-6xl mx-auto bg-cover my-4 rounded"
             style="background-image:url({{ $thread->getImage() }}); height: 75vh;"></div>

        <!--Container-->
        <div class="container max-w-5xl mx-auto -mt-32 mb-4">
            <div class="mx-0 sm:mx-6">
                <div class="bg-white rounded w-full p-4 md:p-8 text-xl md:text-2xl text-gray-800 leading-normal text-center"
                     style="font-family:Georgia,serif;">

                    <!--Post Content-->
                    <p>{!! nl2br(e($thread->body)) !!}</p>
                </div>
            </div>
        </div>

        @if ($thread->recomendations->count() > 0)
            <div class="bg-blue-200 rounded-lg bg-opacity-25">
                <h2 class="text-2xl text-center py-2 font-bold tracking-wider text-gray-800">It may seem interesting to you...</h2>
                <div class="container px-12">
                    <div class="flex flex-wrap -mx-2">
                        @foreach ($thread->recomendations as $recomendation)
                            <x-threads.card :thread="$recomendation" classes="shadow-lg"/>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="container">
            <replies :data="{{ $thread->replies }}"></replies>
        </div>
    </div>
</thread>
@endsection

@section('navbar')
    <x-navbar dark="true" background="bg-white bg-opacity-25" dropdownButtonClass="button-dropdown-dark"/>
@endsection

@section('footer')
    <x-footer background="bg-white bg-opacity-25" styles="py-6" dark="true"/>
@endsection
