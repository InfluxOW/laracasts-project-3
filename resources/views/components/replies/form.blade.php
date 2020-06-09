<div class="mt-6 mb-2">
    {!! Form::open(['url' => route('threads.replies.store', [$thread->channel, $thread])]) !!}
    <div class="border border-gray-300 rounded-lg p-4">
        {!! Form::textarea('body', '', ['class' => 'w-full', 'placeholder' => 'Enter your comment...', 'rows' => '3']) !!}
    </div>
    <x-error name="body" classes="mt-4 mb-2"/>

    {!! Form::button('Submit', ['type' => 'submit', 'class' => 'button-new mt-2']) !!}
    {!! Form::close() !!}
</div>
