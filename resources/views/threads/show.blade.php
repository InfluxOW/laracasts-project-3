@extends('layouts.app')

@section('content')
{{--    <div class="overflow-hidden flex items-center justify-center">
        <main class="z-10">
            <div class="border border-gray-300 rounded-lg mb-6 bg-page">
                <article>
                    <div class="text-lg border-b border-gray-300 px-4 py-2 flex justify-between items-center">
                        <div>
                            <a href=""
                               class="hover:text-blue-300 text-blue-500 border-r pr-2">{{ $thread->user->name }}</a>
                            <span>{{ $thread->title }}</span>
                        </div>
                        <div class="text-muted text-xs">{{ $thread->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="text-sm p-4">{{ $thread->body }}</div>
                </article>
            </div>


            <x-replies.card :replies="$replies"/>

            @auth
                <x-replies.form :thread="$thread"/>
            @endauth
        </main>
    </div>--}}

<!--Title-->
<div class="text-center pt-4 md:pt-8 bg-white bg-opacity-25">
    <p class="text-sm md:text-base text-teal-600 font-bold">{{ $thread->created_at->format('M d Y') }}<span class="text-gray-900 mx-2">/</span><a
            href="#" class="hover:text-teal-300">{{ $thread->user->name }}</a></p>
    <h1 class="font-bold break-normal text-3xl md:text-5xl">{{ $thread->title }}</h1>
</div>

<!--image-->

<div class="container w-full max-w-6xl mx-auto bg-cover mt-8 rounded"
     style="background-image:url({{ $thread->getImage() }}); height: 75vh;"></div>

<!--Container-->
<div class="container max-w-5xl mx-auto -mt-32 mb-4">
    <div class="mx-0 sm:mx-6">
        <div class="bg-white rounded w-full p-4 md:p-8 text-xl md:text-2xl text-gray-800 leading-normal text-center"
             style="font-family:Georgia,serif;">

            <!--Post Content-->
            <p>{{ $thread->body }}</p>
        </div>
    </div>
</div>

<div class="bg-blue-200 rounded-lg bg-opacity-25">
    <div class="container py-4 px-12">
        <div class="flex flex-wrap -mx-2">

            @foreach ($thread->randomThreadsInTheSameChannel() as $thread)
                <x-threads.card :thread="$thread" classes="shadow-lg"/>
            @endforeach

        </div>
    </div>
</div>

@endsection

@section('navbar')
    <x-navbar dark="true" background="bg-white bg-opacity-25" dropdownButtonClass="button-dropdown-dark"/>
@endsection

@section('footer')
    <x-footer background="bg-white bg-opacity-25" dark="true"/>
@endsection
