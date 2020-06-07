@extends('layouts.app')

@section('content')
    <div class="border border-gray-300 rounded-lg mb-6">
        <article>
            <div class="text-lg border-b border-gray-300 px-4 py-2 flex justify-between items-center">
                <div>
                    <a href="" class="hover:text-blue-300 text-blue-500 border-r pr-2">{{ $thread->user->name }}</a>
                    <span>{{ $thread->title }}</span>
                </div>
                <div class="text-muted text-xs">{{ $thread->created_at->diffForHumans() }}</div>
            </div>
            <div class="text-sm p-4">{{ $thread->body }}</div>
        </article>
    </div>

    <x-replies.card :replies="$replies"/>

    @auth
        <x-replies.form :thread="$thread" />
    @endauth
@endsection
