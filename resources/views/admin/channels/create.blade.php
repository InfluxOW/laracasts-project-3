@extends('admin.app')

@section('administration-content')
    <div class="flex flex-wrap justify-center">
        <div class="w-full border border-gray-300 p-4 rounded-lg shadow-xl bg-page">
            {!! Form::open(['url' => route('admin.channels.store')]) !!}
            <div
                class="font-header text-center text-xl text-gray-800 mb-4 py-4 border-b border-gray-300 -m-4 p-2 bg-gray-100 rounded-lg rounded-b-none tracking-widest">
                Create a New Channel
            </div>
            @honeypot

            {!! Form::label('name', 'Name', ['class' => 'text-default font-light text-xs opacity-75']) !!}
            {!! Form::text('name', null, ['class' => 'border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full']) !!}
            <x-error name="name" classes="mb-4"/>

            {!! Form::label('description', 'Description', ['class' => 'text-default font-light text-xs opacity-75']) !!}
            {!! Form::textarea('description', null, ['class' => 'border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full']) !!}
            <x-error name="description" classes="mb-4 mt-2"/>

            {!! Form::button('Submit', ['type' => 'submit', 'class' => 'button-dropdown-gray mt-4 w-full']) !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection
