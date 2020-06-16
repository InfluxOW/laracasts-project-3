@foreach ($replies as $reply)
    <div class="font-sans py-2 {{ $loop->last ? '' : 'mb-2' }} bg-white rounded-lg border border-gray-300" id="reply-{{ $reply->id }}">
        <div class="flex py-2">
            <div class="w-1/8">
                <img src="{{ $reply->user->getAvatar() }}" alt="" class="h-12 w-12 rounded-full mx-2">
            </div>
            <div class="w-full">
                <div class="flex justify-between items-center">
                        <div>
                            <span class="font-bold"><a href="{{ route('profiles.show', $reply->user) }}" class="text-black hover:text-opacity-50">{{ $reply->user->name }}</a></span>
                            <span class="text-gray-700"> {{ "@{$reply->user->username}" }}</span>
                            <span class="text-gray-700">·</span>
                            <span class="text-gray-700">{{ $reply->created_at->format('M d') }}</span>
                            <span class="text-gray-700">·</span>
                            <span class="text-gray-700"><a href="{{ $reply->getLink() }}" class="text-black hover:text-opacity-50">#</a></span>
                        </div>
                        <div class="mr-2">
                            {!! Form::open(['url' => route('favorites.store', ['reply', $reply->id])]) !!}
                            <button type="submit" class="outline-none focus:outline-none">
                                <span class="text-gray-600 inline-flex items-center leading-none text-sm">
                                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="50" fill="{{ (Auth::check() && $reply->isFavoritedBy(Auth::user())) ? '#ffc107' : 'none' }}" stroke-linecap="round"
                                         stroke-linejoin="round" viewBox="0 -10 511.98685 511" >
                                        <path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0"/></svg>
                                    {{ $reply->favorites_count }}
                                </span>
                            </button>
                            {!! Form::close() !!}
                        </div>
                </div>
                <div>
                    <p class="text-sm my-2">{{ $reply->body }}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="mt-2">
    {{ $replies->links() }}
</div>
