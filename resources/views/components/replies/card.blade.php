@foreach ($replies as $reply)
    <div class="border border-gray-300 rounded-lg {{ $loop->last ? '' : 'mb-2' }}">
        <div class="border-b border-gray-300 text-xs px-4 py-1 flex justify-between items-center">
            <a href="" class="hover:text-blue-300 text-blue-500">{{ $reply->user->name }}</a>
            <div class="text-muted">{{ $reply->created_at->diffForHumans() }}</div>
        </div>
        <div class="text-sm p-4">
            {{ $reply->body }}
        </div>
    </div>
@endforeach
