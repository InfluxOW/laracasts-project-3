<div class="flex items-center mb-1">
    <div class="bg-pink-600 rounded-full h-4 w-4 z-10"></div>
    <div class="flex-1 ml-4 font-bold">
        {{ $action->created_at->format('M d, g:i a') }}
    </div>
</div>
<div class="ml-12">
    @if (isset($action->subject))
        {{ ucwords($user->name) }} {{ $action->description }} reply <a href="{{ $action->subject->getLink() }}" class="text-blue-500 hover:text-blue-300 italic">{{ $action->subject->body }}</a>.
    @else
        {{ ucwords($user->name) }} {{ $action->description }} reply <span class="italic">"{{ json_decode($action->changes, true)['attributes']['body'] }}"</span>.
    @endif
</div>
