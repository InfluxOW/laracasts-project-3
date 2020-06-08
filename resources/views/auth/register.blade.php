@extends('layouts.auth')

@section('form')
    <x-auth._register/>
@endsection

@section('bg-image')
    {{ asset("storage/images/bg_lines_5.jpg") }}
@endsection
