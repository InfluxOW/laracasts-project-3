@extends('layouts.app')

@section('content')
    <div class="mb-2">
        {!! Form::open(['url' => route('threads.store')]) !!}

        @include('threads._form')

        {!! Form::close() !!}
    </div>
@endsection
