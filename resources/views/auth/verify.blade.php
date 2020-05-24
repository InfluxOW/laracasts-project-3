@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center">
            <div class="w-full max-w-sm">

                @if (session('resent'))
                    <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100  px-3 py-4 mb-4" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <div class="flex flex-col break-words bg-card border border-2 rounded shadow-md">
                    <div class="font-semibold text-accent text-xl text-center py-3 px-6 mt-1 border-b-2 border-accent-light mx-6">
                        {{ __('Verify Your Email Address') }}
                    </div>

                    <div class="w-full flex flex-wrap p-6">
                        <p class="leading-normal">
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                        </p>

                        <p class="leading-normal mt-6">
                            {{ __('If you did not receive the email') }}, <a class="text-accent no-underline" onclick="event.preventDefault(); document.getElementById('resend-verification-form').submit();">{{ __('click here to request another') }}</a>.
                        </p>

                        <form id="resend-verification-form" method="POST" action="{{ route('verification.resend') }}" class="hidden">
                            @csrf
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
