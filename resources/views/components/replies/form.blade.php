<div class="mt-6 mb-2">
    {!! Form::open(['url' => route('threads.replies.store', $thread)]) !!}
    <div class="border border-gray-300 rounded-lg p-4">
        {!! Form::textarea('body', '', ['class' => 'w-full', 'placeholder' => 'Enter your comment...', 'rows' => '3']) !!}
    </div>
    {!! Form::button('Submit', ['type' => 'submit', 'class' => 'bg-blue-500 hover:bg-blue-300 text-white font-bold py-2 px-4 rounded mt-2']) !!}
    {!! Form::close() !!}
</div>
