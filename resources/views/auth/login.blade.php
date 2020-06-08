@extends('layouts.auth')

@section('form')
    <x-auth._login/>
@endsection

@section('bg-image')
    {{ asset("storage/images/bg_lines_4.jpg") }}
@endsection
