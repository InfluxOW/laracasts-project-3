<div class="mb-4">
    {{ Form::open(['url' => URL::current(), 'method' => 'GET', 'class' => 'flex inline-flex']) }}
    <div class="relative">
        {{ Form::select('sort', $sorts, $currentSort,
        ['placeholder' => 'Sort...',
        'class' => 'block appearance-none w-full border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:shadow-outline', 'required']) }}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
            </svg>
        </div>
    </div>
    {{ Form::submit(__('Apply'), ['class' => 'button-dropdown-gray ml-4']) }}
    {{ Form::close() }}
</div>
