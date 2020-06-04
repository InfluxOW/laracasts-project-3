<div class="container mx-auto">
    <div class="flex flex-wrap justify-center">
        <div class="w-full max-w-md border border-gray-300 p-4 rounded-lg">
            <div class="text-center text-2xl text-default mb-6 border-b border-gray-300 -m-4 p-2">
                Create a New Thread
            </div>

            {!! Form::label('title', 'Title', ['class' => 'text-gray-500 font-semibold text-md']) !!}
            <div class="border border-gray-300 rounded-lg p-4 mt-2 mb-4">
                {!! Form::text('title', $thread->title ?? '', ['class' => 'w-full']) !!}
            </div>

            {!! Form::label('body', 'Body', ['class' => 'text-gray-500 font-semibold text-md']) !!}
            <div class="border border-gray-300 rounded-lg p-4 mt-2">
                {!! Form::textarea('body', $thread->body ?? '', ['class' => 'w-full', 'rows' => '3']) !!}
            </div>

            {!! Form::button('Submit', ['type' => 'submit', 'class' => 'bg-blue-500 hover:bg-blue-300 text-white font-bold py-2 px-4 rounded mt-2']) !!}
        </div>
    </div>
</div>

