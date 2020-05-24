@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center">
            <div class="w-full max-w-sm">
                <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

                    <div class="font-semibold text-accent text-xl text-center py-3 px-6 mt-1 border-b-2 border-accent-light mx-6">
                        {{ __('Confirm Password') }}
                    </div>

                    <form class="w-full p-6" method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <p class="leading-normal">
                            {{ __('Please confirm your password before continuing.') }}
                        </p>

                        <div class="flex flex-wrap my-6">
                            <label for="password" class="block text-muted text-sm font-bold mb-2">
                                {{ __('Password') }}:
                            </label>

                            <input id="password" type="password" class="form-input w-full bg-page @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center">
                            <button type="submit" class="button w-full">
                                {{ __('Confirm Password') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-accent whitespace-no-wrap no-underline ml-auto" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
