<section class="relative w-1/2 m-8 mt-0 hidden" id="user-actions">
    <ul class="border-l-2 border-gray-500 border-dotted">
        @foreach ($actions as $action)
            <li class="{{ $loop->last ? '' : 'mb-2' }} py-2" style="margin-left: -9px">
                @include("includes.activities.$action->subject_type")
            </li>
        @endforeach
    </ul>

    {{ $actions->links() }}
</section>
