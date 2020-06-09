<div class="p-4 lg:w-1/3">
    <div
        class="h-full bg-gray-200 rounded-lg overflow-hidden text-center relative border-2 border-transparent border-opacity-25 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
        <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">
            <img class="lg:h-48 md:h-36 w-full" src="{{ $thread->getImage() }}" alt="blog">
            <div class="px-8 pb-16 pt-8">
                <h2 class="tracking-widest text-xs font-medium text-gray-500 mb-1 uppercase">
                    <a href="{{ route('threads.filter', $thread->channel) }}">{{ $thread->channel->name }}</a>
                </h2>
                <h1 class="sm:text-2xl text-xl font-medium text-gray-900 mb-3">{{ $thread->title }}</h1>
                <p class="leading-relaxed mb-3">{{ $thread->body }}</p>
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
                    <span class="text-gray-600 inline-flex items-center leading-none text-sm">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                         stroke-linejoin="round" viewBox="0 0 24 24">
                        <path
                            d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                    </svg>
                    {{ $thread->replies_count }}
                    </span>
                </div>
            </div>
        </a>
    </div>
</div>
