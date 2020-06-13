<div class="p-4 lg:w-1/3">
    <div
        class="{{ $classes ?? '' }} h-full bg-gray-200 rounded-lg overflow-hidden text-center relative transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
        <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">
            <img class="lg:h-48 md:h-36 w-full" src="{{ $thread->getImage() }}" alt="blog">
        </a>
        <div class="px-8 pb-16 pt-8">
            <h2 class="tracking-widest text-xs font-medium text-gray-500 mb-1 uppercase">
                <a href="{{ route('threads.filter', $thread->channel) }}">{{ $thread->channel->name }}</a>
            </h2>
            <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">
                <h1 class="sm:text-2xl text-xl font-medium text-gray-900 mb-3">{{ $thread->title }}</h1>
            </a>
            <p class="leading-relaxed mb-3">{{ Str::limit($thread->body, 200) }}</p>
                <div class="text-center mt-2 leading-none flex justify-center absolute bottom-0 left-0 w-full pb-8">
                    <span
                        class="text-gray-600 mr-3 inline-flex items-center leading-none text-sm pr-3 border-r-2 border-gray-300">
                        <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                             stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        {{ $thread->views_count }}
                    </span>
                    <span class="text-gray-600 mr-3 inline-flex items-center leading-none text-sm pr-3 border-r-2 border-gray-300">
                        <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                             stroke-linejoin="round" viewBox="0 0 24 24">
                            <path
                                d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                        </svg>
                        {{ $thread->replies_count }}
                    </span>
                    {!! Form::open(['url' => route('favorites.store', ['thread', $thread->id])]) !!}
                        <button type="submit" class="outline-none focus:outline-none">
                            <span class="inline-flex items-center leading-none text-sm">
                                <svg class="w-4 h-4 mr-1 {{ (Auth::check() && $thread->isFavoritedBy(Auth::user())) ? 'favorited' : 'unfavorited' }}" stroke-width="50" stroke-linecap="round"
                                     stroke-linejoin="round" viewBox="0 -10 540 540" >
                                    <path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0"/></svg>
                                {{ $thread->favorites_count }}
                            </span>
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
    </div>
</div>
