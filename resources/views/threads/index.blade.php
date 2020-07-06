@extends('layouts.app')

@section('content')
    <div class="py-4 px-8 container">
        <section class="text-gray-700">
            <div class="container py-4 mx-auto">
                <div class="flex justify-between">
                    @if (! Request::is('threads/search'))
                        <x-threads.filtration/>
                    @endif

                    {!! Form::open(['url' => route('threads.search'), 'method' => 'GET', 'class' => 'mb-4']) !!}
                        <div class="border border-gray-300 bg-gray-200 p-2 rounded-lg inline-flex items-center">
                            {!! Form::text('q', request()->q ?? null, ['class' => 'bg-gray-200', 'placeholder' => 'Search...']) !!}
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 0 136 136.21852" class="w-4 h-4 text-black fill-current">
                                    <path d="M 93.148438 80.832031 C 109.5 57.742188 104.03125 25.769531 80.941406 9.421875 C 57.851562 -6.925781 25.878906 -1.460938 9.53125 21.632812 C -6.816406 44.722656 -1.351562 76.691406 21.742188 93.039062 C 38.222656 104.707031 60.011719 105.605469 77.394531 95.339844 L 115.164062 132.882812 C 119.242188 137.175781 126.027344 137.347656 130.320312 133.269531 C 134.613281 129.195312 134.785156 122.410156 130.710938 118.117188 C 130.582031 117.980469 130.457031 117.855469 130.320312 117.726562 Z M 51.308594 84.332031 C 33.0625 84.335938 18.269531 69.554688 18.257812 51.308594 C 18.253906 33.0625 33.035156 18.269531 51.285156 18.261719 C 69.507812 18.253906 84.292969 33.011719 84.328125 51.234375 C 84.359375 69.484375 69.585938 84.300781 51.332031 84.332031 C 51.324219 84.332031 51.320312 84.332031 51.308594 84.332031 Z M 51.308594 84.332031"/>
                                </svg>
                            </button>
                        </div>
                    {!! Form::close() !!}
                </div>
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
    <x-footer styles="{{ count($threads->items()) <=3 ? 'absolute bottom-0' : '' }} py-4" background="bg-white bg-opacity-25" dark="true"/>
@endsection


