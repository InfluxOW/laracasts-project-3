@foreach (session('flash_notification', collect())->toArray() as $message)
    <div class="{{ "alert-{$message['level']}" }} mr-2 mb-2 shadow-lg" role="alert" id="alert">
        <div class="block">{{ $message['message'] }}</div>
        @if ($message['important'])
            <button type="button" class="close ml-2" data-dismiss="alert" aria-label="Close" onclick="$(this).parent().remove();">
                <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </button>
        @endif
    </div>
@endforeach

{{ session()->forget('flash_notification') }}
