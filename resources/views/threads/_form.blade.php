<div class="container mx-auto">
    <div class="flex flex-wrap justify-center">
        <div class="w-full max-w-md border border-gray-300 p-4 rounded-lg">
            <div class="text-center text-2xl text-blue-500 mb-4 border-b border-gray-300 -m-4 p-2 bg-gray-100 rounded-lg rounded-b-none tracking-wider">
                Create a New Thread
            </div>

            {!! Form::label('title', 'Title', ['class' => 'text-gray-400 font-semibold text-md']) !!}
            {!! Form::text('title', $thread->title ?? '', ['class' => 'border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full']) !!}

            {!! Form::label('body', 'Body', ['class' => 'text-gray-400 font-semibold text-md']) !!}
            {!! Form::textarea('body', $thread->body ?? '', ['class' => 'border border-gray-300 rounded-lg p-4 mt-2 text-gray-700 rounded text-sm focus:shadow-outline w-full', 'rows' => '3']) !!}

            {!! Form::button('Submit', ['type' => 'submit', 'class' => 'button-new mt-4 w-full']) !!}
        </div>
    </div>
</div>

