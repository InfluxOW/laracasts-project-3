@extends('layouts.app')

@section('content')
    <section class="text-gray-700">
        <div class="container py-4 mx-auto">
            <div class="flex flex-wrap -m-4">
                @foreach ($threads as $thread)
                    <x-threads.card :thread="$thread"/>
                @endforeach
            </div>
        </div>
    </section>

    {{ $threads->links() }}
@endsection


