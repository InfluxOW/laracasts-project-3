@extends('layouts.auth-master')

@section('form')
    <x-auth.login-form/>
@endsection

@section('bg-image')
    {{ asset("storage/images/bg_lines_4.jpg") }}
@endsection
