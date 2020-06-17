<section class="relative w-1/2 m-8 mt-0 hidden" id="user-actions">
    {!! Form::open(['url' => route('profiles.show', $user), 'method' => 'GET', 'class' => 'my-2']) !!}
    <div class="flex inline-flex ml-2">
        <div
            class="border border-r-0 border-gray-300 text-gray-700 bg-page font-bold p-2 rounded rounded-r-none leading-tight cursor-not-allowed">
            Filter by day
        </div>
        {{ Form::date('filter[created_at]', request()->query('filter')['created_at'],
        ['class' => 'border border-gray-300 text-gray-700 py-2 bg-gray-200 px-4 rounded rounded-l-none leading-tight focus:shadow-outline',
        'onChange' => "this.form.submit()"]) }}
    </div>
    {!! Form::close() !!}

    <ul class="border-l-2 border-gray-500 border-dotted">
        @foreach ($actions as $action)
            <li class="{{ $loop->last ? '' : 'mb-2' }} py-2" style="margin-left: -9px">
                @include("includes.activities.$action->subject_type")
            </li>
        @endforeach
    </ul>

    {{ $actions->links() }}
</section>
