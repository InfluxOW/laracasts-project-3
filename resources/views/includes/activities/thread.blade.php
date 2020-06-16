<div class="flex items-center mb-1">
    <div class="bg-indigo-600 rounded-full h-4 w-4 z-10"></div>
    <div class="flex-1 ml-4 font-bold">
        {{ $action->created_at->format('M d, g:i a') }}
    </div>
</div>
<div class="ml-12">
    @if (isset($action->subject))
        {{ ucwords($user->name) }} {{ $action->description }} thread <a href="{{ route('threads.show', [$action->subject->channel, $action->subject]) }}" class="text-blue-500 hover:text-blue-300 italic">{{ $action->subject->title }}</a>.
    @else
        {{ ucwords($user->name) }} {{ $action->description }} thread <span class="italic">"{{ json_decode($action->changes, true)['attributes']['title'] }}"</span>.
    @endif
</div>
