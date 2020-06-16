<div class="flex items-center mb-1">
    <div class="bg-teal-600 rounded-full h-4 w-4 z-10"></div>
    <div class="flex-1 ml-4 font-bold">
        {{ $action->created_at->format('M d, g:i a') }}
    </div>
</div>
<div class="ml-12">
        {{ ucwords($user->name) }} {{ $action->description }} his profile.
</div>
