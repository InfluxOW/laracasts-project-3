@extends('layouts.app')

@section('content')
    <div class="border border-gray-300 rounded-lg mb-6">
            <article>
                <div class="text-lg border-b border-gray-300 px-4 py-2">
                    <a href="" class="hover:text-blue-300 text-blue-500 border-r pr-2">{{ $thread->user->name }}</a>
                    {{ $thread->title }}
                </div>
                <div class="text-sm p-4">{{ $thread->body }}</div>
            </article>
    </div>

    <x-replies.card :replies="$thread->replies"/>

    @auth
        <x-replies.form :thread="$thread" />
    @endauth
@endsection
