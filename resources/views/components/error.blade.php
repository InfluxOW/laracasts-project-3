@if ($errors->{$bag ?? 'default'}->has($name))
    @foreach ($errors->{$bag ?? 'default'}->get($name) as $error)
        <div class="text-red-500 text-xs italic {{ $classes ?? '' }}">
            {{ $error }}
        </div>
    @endforeach
@endif
