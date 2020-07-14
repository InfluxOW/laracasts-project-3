@extends('admin.app')

@section('administration-content')
    <div class="p-2">
        <div class="px-3 my-2">
            <a href="{{ route('admin.channels.create') }}" class="button-sm-dropdown-pink">Create Channel</a>
        </div>
        <div class="text-gray-900 text-center">
            <div class="px-3 py-4 flex justify-center">
                <table class="w-full text-md bg-white shadow-md rounded mb-4">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Slug</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($channelsIncludingArchived as $channel)
                        <tr class="border-b text-xs {{ $channel->archived ? 'bg-red-500 bg-opacity-25' : 'bg-gray-200' }}">
                            <td class="border px-4 py-2">{{ $channel->id }}</td>
                            <td class="border px-4 py-2">
                                {!! Form::text('name', $channel->name, ['class' => 'border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full', 'form' => "channel-{$channel->id}-form"]) !!}
                                <x-error name="name" classes="mb-4"/>

                            </td>
                            <td class="border px-4 py-2">{{ $channel->slug }}</td>
                            <td class="border px-4 py-2">
                                {!! Form::textarea('description', $channel->description, ['class' => 'border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full', 'rows' => 1, 'form' => "channel-{$channel->id}-form"]) !!}
                                <x-error name="description" classes="mb-4"/>
                            </td>
                            <td class="border px-4 py-2">
                                {!! Form::select('archived', ['0' => 'Active', '1' => 'Archived'] , $channel->status , ['class' => 'border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full', 'form' => "channel-{$channel->id}-form"]) !!}
                                <x-error name="archived" classes="mb-4"/>
                            </td>
                            <td class="border px-4 py-2">
                                <div class="flex flex-col">
                                    {!! Form::submit('Update', ['class' => 'uppercase bg-transparent font-bold text-xs text-blue-600 outline-none focus:outline-none hover:opacity-75 mb-2 cursor-pointer', 'form' => "channel-{$channel->id}-form"]) !!}
                                    <a
                                        href="{{ route('admin.channels.destroy', $channel) }}"
                                        data-confirm="Are you sure?"
                                        data-method="delete"
                                        rel="nofollow"
                                        class="uppercase font-bold text-xs text-red-600 outline-none focus:outline-none hover:opacity-75">Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach($channels as $channel)
        {!! Form::open(['url' => route('admin.channels.update', $channel), 'method' => 'PATCH', 'id' => "channel-{$channel->id}-form"]) !!}
        {!! Form::close() !!}
    @endforeach
@endsection
