@extends('layouts.app')

@section('content')
    <section class="absolute w-full h-full">
        <div class="container mx-auto px-4 h-full">
            <div class="flex content-center items-center justify-center h-full">
                <div class="w-full lg:w-4/12 px-4">
                    <div class="flex flex-wrap justify-center">
                        <div class="w-full max-w-md">
                            @if (session('resent'))
                                <div class="fixed bottom-0 right-0 mb-20 mr-5 alert-success shadow-lg" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <div class="flex flex-col break-words bg-card border border-2 rounded-lg shadow-xl">
                                <div class="font-semibold font-header text-accent text-xl text-center py-3 px-6 mt-1 mb-2 text-gray-800 mx-6">
                                    {{ __('Verify Your Email Address') }}
                                </div>

                                <div class="w-full flex flex-wrap p-6">
                                    <p class="leading-normal">
                                        {{ __('Before proceeding, please check your email for a verification link.') }}
                                    </p>

                                    <p class="leading-normal mt-6">
                                        {{ __('If you did not receive the email') }}, <a class="text-accent no-underline hover:text-opacity-75 cursor-pointer" onclick="event.preventDefault(); document.getElementById('resend-verification-form').submit();">{{ __('click here to request another') }}</a>.
                                    </p>

                                    <form id="resend-verification-form" method="POST" action="{{ route('verification.resend') }}" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('navbar')
    <x-navbar navStyles="top-0 absolute z-50" dark="true" background="bg-white bg-opacity-25" dropdownButtonClass="button-dropdown-dark"/>
@endsection

@section('footer')
    <x-footer styles="absolute bottom-0 py-4" background="bg-white bg-opacity-25" dark="true"/>
@endsection
