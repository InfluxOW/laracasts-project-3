@foreach ($replies as $reply)
    <div class="font-sans py-2 {{ $loop->last ? '' : 'mb-2' }} bg-white rounded-lg border border-gray-300">
        <div class="flex py-2">
            <div class="w-1/8">
                <img src="{{ $reply->user->getAvatar() }}" alt="" class="h-12 w-12 rounded-full mx-2">
            </div>
            <div class="w-7/8">
                <div class="flex justify-between">
                    <div>
                        <span class="font-bold"><a href="#" class="text-black">{{ $reply->user->name }}</a></span>
                        <span class="text-gray-700"> {{ "@{$reply->user->username}" }}</span>
                        <span class="text-gray-700">·</span>
                        <span class="text-gray-700">{{ $reply->created_at->format('M d') }}</span>
                    </div>
                    <div>
                        <a href="#" class="text-gray-700 hover:text-black"><i class="fa fa-chevron-down"></i></a>
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
