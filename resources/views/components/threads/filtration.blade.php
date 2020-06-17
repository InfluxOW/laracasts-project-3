<div class="mb-4">
    {{ Form::open(['url' => URL::current(), 'method' => 'GET', 'class' => 'flex inline-flex']) }}
    <div class="relative">
        {{ Form::select('sort', $sorts, $currentSort,
        ['placeholder' => 'Sort by...',
        'class' => 'block appearance-none w-full bg-gray-200 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:shadow-outline']) }}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
            </svg>
        </div>
    </div>
    <div class="flex inline-flex ml-2">
        <div
            class="border border-r-0 border-gray-300 text-gray-700 bg-page font-bold p-2 rounded rounded-r-none leading-tight cursor-not-allowed">
            Sort from
        </div>
        {{ Form::date('sort_from_date', $sortFromDate,
        ['class' => 'border border-gray-300 text-gray-700 py-2 bg-gray-200 px-4 rounded rounded-l-none leading-tight focus:shadow-outline']) }}
    </div>
    {{ Form::submit(__('Apply'), ['class' => 'button-dropdown-gray ml-2']) }}
    {{ Form::close() }}
</div>
