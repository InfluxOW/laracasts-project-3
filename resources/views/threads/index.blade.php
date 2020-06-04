@extends('layouts.app')

@section('content')
        @foreach ($threads as $thread)
            <div class="border border-gray-300 rounded-lg {{ $loop->last ? 'mb-2' : 'mb-4' }} {{ $loop->first ? '' : 'mt-4' }}">
                <article>
                    <div class="text-lg border-b border-gray-300 px-4 py-2">
                        <a href="{{ route('threads.show', [$thread->channel, $thread]) }}" class="hover:text-blue-300 text-blue-500">{{ $thread->title }}</a>
                    </div>
                    <div class="text-sm p-4">{{ $thread->body }}</div>
                </article>
            </div>
        @endforeach

    {{ $threads->links() }}
@endsection
