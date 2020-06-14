<div class="flex flex-wrap justify-center">
    <div class="w-full max-w-md border border-gray-300 p-4 rounded-lg shadow-xl bg-page">
        <div
            class="font-header text-center text-xl text-gray-800 mb-4 border-b border-gray-300 -m-4 p-2 bg-gray-100 rounded-lg rounded-b-none tracking-widest">
            Create a New Thread
        </div>

        {!! Form::label('title', 'Title', ['class' => 'text-default font-light text-xs opacity-75']) !!}
        {!! Form::text('title', $thread->title ?? '', ['class' => 'border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full']) !!}
        <x-error name="title" classes="mb-4"/>

        {!! Form::label('body', 'Body', ['class' => 'text-default font-light text-xs opacity-75']) !!}
        {!! Form::textarea('body', $thread->body ?? '', ['class' => 'border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full', 'rows' => '3']) !!}
        <x-error name="body" classes="mb-4"/>

        {!! Form::label('channel_id', 'Channel', ['class' => 'text-default font-light text-xs opacity-75']) !!}
        <div class="relative">
            {!! Form::select('channel_id',
                $channels->pluck('slug', 'id'),
                $thread->channel->id ?? null,
                ['class' => 'mt-2 block appearance-none w-full border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:shadow-outline',
                'placeholder' => 'Choose a channel...',
                'required'])
            !!}
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        <x-error name="channel_id" classes="mt-4 mb-2"/>

        {!! Form::button('Submit', ['type' => 'submit', 'class' => 'button-dropdown-gray mt-4 w-full']) !!}
    </div>
</div>
